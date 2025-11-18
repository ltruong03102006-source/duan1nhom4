<?php
// Class chứa các function thực thi xử lý logic cho Nhân Viên
class NhanVienController
{
    public $modelNhanVien;

    public function __construct()
    {
        $this->modelNhanVien = new NhanVienModel();
    }

    // 1. Danh sách Nhân viên
    public function listNhanVien()
    {
        $listNhanVien = $this->modelNhanVien->getAllNhanVien();
        $viewFile = './views/nhanvien/listNhanVien.php';
        include './views/layout.php';
    }

    // 2. Thêm Nhân viên (Hiển thị form)
    public function addNhanVien()
    {
        $viewFile = './views/nhanvien/addNhanVien.php';
        include './views/layout.php';
    }

    // 3. Xử lý Thêm Nhân viên
    public function addNhanVienProcess()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $LinkAnhDaiDien = null;
            // Xử lý upload file ảnh đại diện
            if (!empty($_FILES['LinkAnhDaiDien']['name'])) {
                $uploadDir = "uploads/";
                // Hàm uploadFile được định nghĩa trong commons/function.php
                $LinkAnhDaiDien = uploadFile($_FILES['LinkAnhDaiDien'], $uploadDir); 
            }

            $data = [
                ':MaCodeNhanVien' => $_POST['MaCodeNhanVien'],
                ':HoTen' => $_POST['HoTen'],
                ':VaiTro' => $_POST['VaiTro'],
                ':SoDienThoai' => $_POST['SoDienThoai'] ?? null,
                ':Email' => $_POST['Email'] ?? null,
                ':NgaySinh' => $_POST['NgaySinh'] ?? null,
                ':GioiTinh' => $_POST['GioiTinh'] ?? null,
                ':DiaChi' => $_POST['DiaChi'] ?? null,
                ':LinkAnhDaiDien' => $LinkAnhDaiDien,
                ':ChungChi' => $_POST['ChungChi'] ?? null,
                ':NgonNgu' => $_POST['NgonNgu'] ?? null,
                ':SoNamKinhNghiem' => $_POST['SoNamKinhNghiem'] ?? 0,
                ':ChuyenMon' => $_POST['ChuyenMon'] ?? null,
                ':TrangThai' => $_POST['TrangThai'] ?? 'dang_lam'
            ];

            $this->modelNhanVien->addNhanVien($data);
            header("Location: ?act=listNhanVien");
            exit();
        }
    }

    // 4. Sửa Nhân viên (Hiển thị form)
    public function editNhanVien()
    {
        $id = $_GET['id'];
        $nhanVien = $this->modelNhanVien->getOneNhanVien($id);
        
        $viewFile = './views/nhanvien/editNhanVien.php';
        include './views/layout.php';
    }

    // 5. Xử lý Sửa Nhân viên
    public function updateNhanVienProcess()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $MaNhanVien = $_POST['MaNhanVien'];
            $LinkAnhDaiDien = $_POST['OldLinkAnhDaiDien']; 

            // Xử lý upload ảnh mới
            if (isset($_FILES['LinkAnhDaiDien']) && $_FILES['LinkAnhDaiDien']['error'] == 0) {
                // Xóa ảnh cũ 
                if (!empty($LinkAnhDaiDien)) {
                    deleteFile($LinkAnhDaiDien); // Hàm deleteFile trong commons/function.php
                }
                
                // Upload ảnh mới
                $uploadDir = "uploads/";
                $LinkAnhDaiDien = uploadFile($_FILES['LinkAnhDaiDien'], $uploadDir);
            }

            $data = [
                ':MaNhanVien' => $MaNhanVien,
                ':HoTen' => $_POST['HoTen'],
                ':VaiTro' => $_POST['VaiTro'],
                ':SoDienThoai' => $_POST['SoDienThoai'] ?? null,
                ':Email' => $_POST['Email'] ?? null,
                ':NgaySinh' => $_POST['NgaySinh'] ?? null,
                ':GioiTinh' => $_POST['GioiTinh'] ?? null,
                ':DiaChi' => $_POST['DiaChi'] ?? null,
                ':LinkAnhDaiDien' => $LinkAnhDaiDien,
                ':ChungChi' => $_POST['ChungChi'] ?? null,
                ':NgonNgu' => $_POST['NgonNgu'] ?? null,
                ':SoNamKinhNghiem' => $_POST['SoNamKinhNghiem'] ?? 0,
                ':ChuyenMon' => $_POST['ChuyenMon'] ?? null,
                ':TrangThai' => $_POST['TrangThai'] ?? 'dang_lam'
            ];

            $this->modelNhanVien->updateNhanVien($data);
            header("Location: ?act=listNhanVien");
            exit();
        }
    }

    // 6. Xóa Nhân viên
    public function deleteNhanVien()
    {
        $id = $_GET['id'];
        $nhanVien = $this->modelNhanVien->getOneNhanVien($id);
        
        // Xóa file ảnh đại diện nếu có
        if (!empty($nhanVien['LinkAnhDaiDien'])) {
            deleteFile($nhanVien['LinkAnhDaiDien']);
        }
        
        $this->modelNhanVien->deleteNhanVien($id);
        header("Location: ?act=listNhanVien");
        exit();
    }
}