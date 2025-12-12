<?php
// Class chứa các function thực thi xử lý logic 
class nhaCungCapController
{
    public $modelNCC;

    public function __construct()
    {
        $this->modelNCC = new nhaCungCapModel();
    }

    // 1. Hiển thị danh sách
    public function homeNhaCungCap()
    {
        $listNCC = $this->modelNCC->getAllNhaCungCap();
        $viewFile = './views/nhaCungCap/list.php';
        include './views/layout.php';
    }

    // 2. Hiển thị form thêm
    public function addNhaCungCap()
    {
        $viewFile = './views/nhaCungCap/add.php';
        include './views/layout.php';
    }

    // 3. Xử lý thêm mới
    public function addNhaCungCapProcess()
    {
        $data = $_POST;

        // 1) VALIDATE: Loại NCC (*): bắt buộc chọn ít nhất 1 loại
        if (empty($data['LoaiNhaCungCap']) || !is_array($data['LoaiNhaCungCap'])) {
            header("Location: ?act=addNhaCungCap&error=missing_type");
            exit();
        }
        $data['LoaiNhaCungCap'] = implode(',', $data['LoaiNhaCungCap']);

        // 2) VALIDATE: Ngày hợp đồng (nếu nhập đủ 2 ngày thì end >= start)
        $start = $data['NgayBatDauHopDong'] ?? null;
        $end   = $data['NgayKetThucHopDong'] ?? null;
        if (!empty($start) && !empty($end) && strtotime($end) < strtotime($start)) {
            header("Location: ?act=addNhaCungCap&error=invalid_contract_date");
            exit();
        }

        // 3) CHECK TRÙNG (để báo lỗi đẹp trước khi DB throw)
        if (!empty($data['MaCodeNCC']) && $this->modelNCC->isMaCodeNccExists($data['MaCodeNCC'])) {
            header("Location: ?act=addNhaCungCap&error=duplicate_macode");
            exit();
        }
        
        // Xử lý upload file
        $file = $_FILES['FileHopDong'] ?? null;
        $pathFile = ''; // Đường dẫn file mặc định là rỗng

        if ($file && $file['size'] > 0) {
            // Định nghĩa thư mục lưu file hợp đồng
            $folderToSave = 'uploads/contracts/'; 
            $pathFile = uploadFile($file, $folderToSave);
            
            if ($pathFile === null) {
                // Xử lý lỗi upload
                header("Location: ?act=addNhaCungCap&error=upload_failed");
                exit();
            }
        }
        
        $data['FileHopDong'] = $pathFile;
        // Gán giá trị mặc định nếu không nhập
        $data['DanhGia'] = empty($data['DanhGia']) ? 0.00 : $data['DanhGia'];

        try {
            $this->modelNCC->addNhaCungCap($data);
        } catch (PDOException $e) {
            // Unique/constraint lỗi => báo lỗi thân thiện
            $msg = $e->getMessage();
            if (stripos($msg, 'MaCodeNCC') !== false || stripos($msg, 'Duplicate') !== false) {
                header("Location: ?act=addNhaCungCap&error=duplicate_macode");
                exit();
            }
            header("Location: ?act=addNhaCungCap&error=db_error");
            exit();
        }
        
        header("Location: ?act=listNhaCungCap");
        exit();
    }

    // 4. Hiển thị form sửa
    public function editNhaCungCap()
    {
        $id = $_GET['id'];
        $ncc = $this->modelNCC->getNhaCungCapById($id);

        if (!$ncc) {
            header("Location: ?act=listNhaCungCap&error=not_found");
            exit();
        }

        $viewFile = './views/nhaCungCap/edit.php';
        include './views/layout.php';
    }

    // 5. Xử lý cập nhật
    public function updateNhaCungCapProcess()
    {
        $data = $_POST;

        // 1) VALIDATE: Loại NCC (*): bắt buộc chọn ít nhất 1 loại
        if (empty($data['LoaiNhaCungCap']) || !is_array($data['LoaiNhaCungCap'])) {
            header("Location: ?act=editNhaCungCap&id=" . urlencode($data['MaNhaCungCap']) . "&error=missing_type");
            exit();
        }
        $data['LoaiNhaCungCap'] = implode(',', $data['LoaiNhaCungCap']);

        // 2) VALIDATE: Ngày hợp đồng
        $start = $data['NgayBatDauHopDong'] ?? null;
        $end   = $data['NgayKetThucHopDong'] ?? null;
        if (!empty($start) && !empty($end) && strtotime($end) < strtotime($start)) {
            header("Location: ?act=editNhaCungCap&id=" . urlencode($data['MaNhaCungCap']) . "&error=invalid_contract_date");
            exit();
        }

        $id = $data['MaNhaCungCap'];
        $pathFile = $data['duongDanFileCu'] ?? ''; // Lấy lại đường dẫn file cũ

        $file = $_FILES['FileHopDong'] ?? null;

        if ($file && $file['size'] > 0) {
            // Upload file mới
            $folderToSave = 'uploads/contracts/';
            $newPath = uploadFile($file, $folderToSave);
            if ($newPath === null) {
                header("Location: ?act=editNhaCungCap&id=" . urlencode($id) . "&error=upload_failed");
                exit();
            }
            // Chỉ xóa file cũ khi upload mới thành công
            if (!empty($data['duongDanFileCu'])) {
                deleteFile($data['duongDanFileCu']);
            }
            $pathFile = $newPath;
        }
        
        $data['FileHopDong'] = $pathFile;
        // Gán giá trị mặc định nếu không nhập
        $data['DanhGia'] = empty($data['DanhGia']) ? 0.00 : $data['DanhGia'];
        
        // 3) CHECK TRÙNG MaCodeNCC (bỏ qua chính nó)
        if (!empty($data['MaCodeNCC']) && $this->modelNCC->isMaCodeNccExists($data['MaCodeNCC'], $id)) {
            header("Location: ?act=editNhaCungCap&id=" . urlencode($id) . "&error=duplicate_macode");
            exit();
        }

        try {
            $this->modelNCC->updateNhaCungCap($data);
        } catch (PDOException $e) {
            $msg = $e->getMessage();
            if (stripos($msg, 'MaCodeNCC') !== false || stripos($msg, 'Duplicate') !== false) {
                header("Location: ?act=editNhaCungCap&id=" . urlencode($id) . "&error=duplicate_macode");
                exit();
            }
            header("Location: ?act=editNhaCungCap&id=" . urlencode($id) . "&error=db_error");
            exit();
        }
        
        header("Location: ?act=listNhaCungCap&success=updated");
        exit();
    }

    // 6. Xử lý xóa
    public function deleteNhaCungCap()
    {
        $id = $_GET['id'];

        // Chặn xóa nếu NCC đang được sử dụng
        if ($this->modelNCC->isNccInUse($id)) {
            header("Location: ?act=listNhaCungCap&error=in_use");
            exit();
        }
        
        // 1. Lấy thông tin NCC để lấy đường dẫn file
        $ncc = $this->modelNCC->getNhaCungCapById($id);

        // 2. Xóa bản ghi trong DB trước (đảm bảo không lỗi rồi mới xóa file)
        try {
            $this->modelNCC->deleteNhaCungCap($id);
        } catch (PDOException $e) {
            // Nếu vì lý do nào đó vẫn bị FK/constraint
            header("Location: ?act=listNhaCungCap&error=delete_failed");
            exit();
        }

        // 3. Xóa file vật lý sau khi xóa DB thành công
        if ($ncc && !empty($ncc['FileHopDong'])) {
            deleteFile($ncc['FileHopDong']);
        }
        
        header("Location: ?act=listNhaCungCap&success=deleted");
        exit();
    }
}