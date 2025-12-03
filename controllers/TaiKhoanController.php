<?php

class TaiKhoanController
{
    public $modelTaiKhoan;

    public function __construct()
    {
        $this->modelTaiKhoan = new taikhoanModel();
    }

    // 1. Trang danh sách tài khoản (Quản lý)
    public function homeTaiKhoan()
    {
        $listTaiKhoan = $this->modelTaiKhoan->getAllTaiKhoanNhanVien();
        $viewFile = './views/taiKhoan/list.php';
        include './views/layout.php';
    }

    // 2. Trang thêm tài khoản (Hiển thị form)
    public function addTaiKhoan()
    {
        $listNhanVien = $this->modelTaiKhoan->getAllNhanVienChuaCoTaiKhoan();
        $viewFile = './views/taiKhoan/add.php';
        include './views/layout.php';
    }

    // 3. Xử lý thêm tài khoản (Process)
    public function addTaiKhoanProcess()
    {
        $tenDangNhap = $_POST['tenDangNhap'];
        $matKhau = $_POST['matKhau'];
        // Vai trò chỉ còn admin và huong_dan_vien (bỏ dieu_hanh)
        $vaiTro = $_POST['vaiTro']; 
        $maNhanVien = $_POST['maNhanVien'];

        // Kiểm tra dữ liệu (bạn có thể thêm kiểm tra chi tiết hơn ở đây)
        if (empty($tenDangNhap) || empty($matKhau) || empty($vaiTro) || empty($maNhanVien)) {
            // Xử lý lỗi (ví dụ: quay lại form kèm thông báo lỗi)
            header("Location: ?act=addTaiKhoan&error=required_fields");
            exit();
        }
        
        $this->modelTaiKhoan->addTaiKhoanNhanVien($tenDangNhap, $matKhau, $vaiTro, $maNhanVien);

        // Chuyển hướng về trang danh sách sau khi thêm thành công
        header("Location: ?act=taiKhoan");
        exit();
    }

    // 4. Xử lý Khóa / Mở khóa tài khoản
    public function toggleTrangThai()
    {
        $id = $_GET['id'];
        $currentAccount = $this->modelTaiKhoan->getTaiKhoanVaNhanVienById($id);

        if ($currentAccount) {
            // Đảo ngược trạng thái
            $newStatus = ($currentAccount['TrangThai'] == 'hoat_dong') ? 'bi_khoa' : 'hoat_dong';
            
            $this->modelTaiKhoan->updateTrangThai($id, $newStatus);
        }

        header("Location: ?act=taiKhoan");
        exit();
    }
    
    // 5. Trang SỬA TÀI KHOẢN (Hiển thị form Edit)
    public function editTaiKhoan()
    {
        $id = $_GET['id'];
        $taiKhoan = $this->modelTaiKhoan->getTaiKhoanVaNhanVienById($id);

        if (!$taiKhoan) {
            // Xử lý khi không tìm thấy tài khoản (ví dụ: chuyển hướng về 404 hoặc list)
            header("Location: ?act=taiKhoan&error=not_found");
            exit();
        }
        
        $viewFile = './views/taiKhoan/edit.php';
        include './views/layout.php';
    }

    // 6. Xử lý SỬA TÀI KHOẢN (Process Update)
    public function updateTaiKhoanProcess()
    {
        $maTaiKhoan = $_POST['maTaiKhoan'];
        $tenDangNhap = $_POST['tenDangNhap'];
        $vaiTro = $_POST['vaiTro'];
        $matKhauMoi = $_POST['matKhauMoi'] ?? null; // Có thể null nếu không đổi

        // Kiểm tra dữ liệu bắt buộc
        if (empty($maTaiKhoan) || empty($tenDangNhap) || empty($vaiTro)) {
             // Xử lý lỗi
            header("Location: ?act=editTaiKhoan&id=$maTaiKhoan&error=required_fields");
            exit();
        }
        
        $this->modelTaiKhoan->updateTaiKhoan($maTaiKhoan, $tenDangNhap, $vaiTro, $matKhauMoi);
        
        // Chuyển hướng về trang danh sách
        header("Location: ?act=taiKhoan&success=updated");
        exit();
    }

}