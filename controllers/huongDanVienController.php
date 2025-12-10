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
    $maDoan = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    if ($maDoan <= 0) {
        header("Location: ?act=hdvHome"); exit();
    }

    // Lấy đoàn + tour
    $doanDetail = $this->modelHDV->getChiTietDoan($maDoan);
    if (!$doanDetail) {
        header("Location: ?act=hdvHome&error=doan_not_found"); exit();
    }

    // (Khuyến nghị) chặn HDV xem đoàn không phải của mình
    if (!empty($doanDetail['MaHuongDanVien']) && $doanDetail['MaHuongDanVien'] != $this->maNhanVien) {
        header("Location: ?act=hdvHome&error=forbidden"); exit();
    }

    $maTour = (int)$doanDetail['MaTour'];
    $listLichTrinh = $this->modelHDV->getLichTrinhByTourId($maTour);

    // Tạo vài biến để view dùng
    $tourTitle = $doanDetail['TenTour'] ?? '';
    $tourCode  = $doanDetail['MaCodeTour'] ?? '';
    $viewFile = './views/hdv/lichtrinh.php';
    include './views/layout.php';
}


}