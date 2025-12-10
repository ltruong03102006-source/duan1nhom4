<?php
// controllers/ProductController.php (hoặc HomeController nếu bạn đổi tên)

require_once './models/ThongKeModel.php'; // Đảm bảo đã include model

class ProductController
{
    public $thongKeModel;

    public function __construct()
    {
        $this->thongKeModel = new ThongKeModel();
    }

    public function Home()
    {
        // Lấy số liệu thống kê
        $thongKe = $this->thongKeModel->getThongKeTongHop();
        
        // Lấy danh sách booking mới nhất
        $listBookingMoi = $this->thongKeModel->getBookingGanDay(5);
        
        // Lấy dữ liệu cho biểu đồ (nếu cần xử lý JSON cho JS)
        $dataBookingChart = $this->thongKeModel->getTyLeBooking();
        $dataDoanhThuChart = $this->thongKeModel->getDoanhThuTheoThang();

        $viewFile = './views/home.php';
        include './views/layout.php';
    }
}
?>