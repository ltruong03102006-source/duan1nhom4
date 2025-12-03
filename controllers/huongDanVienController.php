<?php
// có class chứa các function thực thi xử lý logic dành cho Hướng dẫn viên
class huongDanVienController
{
    public $modelHDV;
    public $maNhanVien; // Mã nhân viên của HDV đang đăng nhập

    public function __construct()
    {
        $this->modelHDV = new huongDanVienModel();
        // Lấy mã nhân viên đang đăng nhập (tạm thời dùng hàm giả lập)
        $this->maNhanVien = $this->modelHDV->getMaNhanVienHienTai(); 
    }

    // 1. Trang Dashboard / Danh sách Đoàn đang phụ trách
    public function homeHDV()
    {
        $listDoan = $this->modelHDV->getListDoanKhoiHanhByHDV($this->maNhanVien);
        
        // Tên file view này sẽ khác với Admin Dashboard
        $viewFile = './views/hdv/home.php'; 
        include './views/layout.php';
    }

    // 2. Xem chi tiết Đoàn Khởi Hành
    public function viewDoanDetail()
    {
        $maDoan = $_GET['id'] ?? null;
        
        if (!$maDoan) {
            header("Location: ?act=hdvHome");
            exit();
        }
        
        $doanDetail = $this->modelHDV->getChiTietDoan($maDoan);
        
        if (!$doanDetail) {
            // Xử lý nếu không tìm thấy đoàn
            header("Location: ?act=hdvHome&error=doan_not_found");
            exit();
        }

        $viewFile = './views/hdv/doan_detail.php';
        include './views/layout.php';
    }
    
    // 3. Xem Lịch trình chi tiết (LichTrinh - cần join)
    public function viewLichTrinh()
    {
        // Logic truy vấn lịch trình (sẽ được thêm sau khi có chức năng quản lý lịch trình)
        $maTour = $_GET['id'] ?? null;
        // $listLichTrinh = $this->modelHDV->getLichTrinhByTourId($maTour);
        
        $viewFile = './views/hdv/lichtrinh.php'; 
        include './views/layout.php';
    }
    
    // 4. (Tương lai) Chức năng cập nhật Nhật ký Tour
    // public function addNhatKyTour() { ... }
}