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

        // --- XỬ LÝ LOẠI NCC (CHECKBOX) ---
        if (isset($data['LoaiNhaCungCap']) && is_array($data['LoaiNhaCungCap'])) {
            $data['LoaiNhaCungCap'] = implode(',', $data['LoaiNhaCungCap']);
        } else {
            $data['LoaiNhaCungCap'] = ''; // Để trống nếu không chọn gì
        }
        // ---------------------------------
        
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

        $this->modelNCC->addNhaCungCap($data);
        
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

        // --- XỬ LÝ LOẠI NCC (CHECKBOX) ---
        if (isset($data['LoaiNhaCungCap']) && is_array($data['LoaiNhaCungCap'])) {
            $data['LoaiNhaCungCap'] = implode(',', $data['LoaiNhaCungCap']);
        } else {
            $data['LoaiNhaCungCap'] = '';
        }
        // ---------------------------------

        $id = $data['MaNhaCungCap'];
        $pathFile = $data['duongDanFileCu'] ?? ''; // Lấy lại đường dẫn file cũ

        $file = $_FILES['FileHopDong'] ?? null;

        if ($file && $file['size'] > 0) {
            // Upload file mới
            $folderToSave = 'uploads/contracts/'; 
            $pathFile = uploadFile($file, $folderToSave);

            // Xóa file cũ (nếu có)
            if (!empty($data['duongDanFileCu'])) {
                deleteFile($data['duongDanFileCu']);
            }
        }
        
        $data['FileHopDong'] = $pathFile;
        // Gán giá trị mặc định nếu không nhập
        $data['DanhGia'] = empty($data['DanhGia']) ? 0.00 : $data['DanhGia'];
        
        $this->modelNCC->updateNhaCungCap($data);
        
        header("Location: ?act=listNhaCungCap&success=updated");
        exit();
    }

    // 6. Xử lý xóa
    public function deleteNhaCungCap()
    {
        $id = $_GET['id'];
        
        // 1. Lấy thông tin NCC để lấy đường dẫn file
        $ncc = $this->modelNCC->getNhaCungCapById($id);

        if ($ncc && !empty($ncc['FileHopDong'])) {
            // 2. Xóa file vật lý
            deleteFile($ncc['FileHopDong']);
        }

        // 3. Xóa bản ghi trong DB
        $this->modelNCC->deleteNhaCungCap($id);
        
        header("Location: ?act=listNhaCungCap&success=deleted");
        exit();
    }
}