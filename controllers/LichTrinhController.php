<?php
// Controller xử lý logic cho Lịch trình Tour
class LichTrinhController
{
    public $modelLichTrinh;

    public function __construct()
    {
        $this->modelLichTrinh = new LichTrinhModel();
    }

    // Hiển thị trang quản lý lịch trình
    // Hiển thị trang quản lý lịch trình
    public function lichTour()
    {
        $listTours = $this->modelLichTrinh->getAllTours();

        // Nếu không có tour nào, báo lỗi
        if (empty($listTours)) {
            die("Chưa có Tour nào trong hệ thống! Vui lòng thêm Tour trước.");
        }

        // Lấy MaTour từ URL, nếu không có thì lấy tour đầu tiên
        $maTour = isset($_GET['tour_id']) ? $_GET['tour_id'] : $listTours[0]['MaTour'];

        $currentTour = $this->modelLichTrinh->getTourById($maTour);
        $listLichTrinh = $this->modelLichTrinh->getAllLichTrinhByTour($maTour);

        $viewFile = './views/tour/lichTour.php';
        include './views/layout.php';
    }

    // Xử lý thêm lịch trình
    // --- HÀM addLichTrinhProcess ---
public function addLichTrinhProcess()
    {
        // Lấy dữ liệu từ POST và làm sạch
        $maTour = $_POST['MaTour'] ?? null;
        $ngayThu = (int)($_POST['NgayThu'] ?? 0);
        $tieuDeNgay = trim($_POST['TieuDeNgay'] ?? ''); // <-- Đã thêm trim() và định nghĩa
        $diaDiemThamQuan = $_POST['DiaDiemThamQuan'] ?? null;
        $noiO = $_POST['NoiO'] ?? null;
        $coBuaSang = isset($_POST['CoBuaSang']) ? 1 : 0;
        $coBuaTrua = isset($_POST['CoBuaTrua']) ? 1 : 0;
        $coBuaToi = isset($_POST['CoBuaToi']) ? 1 : 0;
        $chiTietHoatDong = $_POST['ChiTietHoatDong'] ?? null;
        
        // --- BƯỚC 1: XỬ LÝ VALIDATION ---
        
        // 1.1 Kiểm tra các trường bắt buộc
        if (empty($tieuDeNgay) || $ngayThu <= 0) {
            header("Location: ?act=lichTour&tour_id=" . $maTour . "&error=validation");
            exit();
        }
        
        // 1.2 [ĐÃ BỎ] Logic kiểm tra NgayThu > SoNgayTour
        
        // 1.3 Kiểm tra trùng lặp ngày thứ (Bây giờ đã chạy được đến đây)
        if ($this->modelLichTrinh->isNgayThuExist($maTour, $ngayThu)) {
            header("Location: ?act=lichTour&tour_id=" . $maTour . "&error=ngay_trung");
            exit();
        }
        // --- KẾT THÚC VALIDATION ---
        
        // BƯỚC 2: GỌI MODEL
        $this->modelLichTrinh->addLichTrinh(
            $maTour, 
            $ngayThu, 
            $tieuDeNgay, 
            $diaDiemThamQuan, 
            $noiO, 
            $coBuaSang, 
            $coBuaTrua, 
            $coBuaToi, 
            $chiTietHoatDong
        );

        header("Location: ?act=lichTour&tour_id=" . $maTour . "&success=add");
        exit();
    }
    // Hiển thị form sửa lịch trình
    // Xử lý cập nhật lịch trình
    // --- HÀM editLichTrinhProcess ---
public function editLichTrinh()
    {
        $id = $_GET['id'];
        $lichTrinh = $this->modelLichTrinh->getLichTrinhById($id);

        $maTour = $lichTrinh['MaTour'];
        $listTours = $this->modelLichTrinh->getAllTours();
        $currentTour = $this->modelLichTrinh->getTourById($maTour);
        $listLichTrinh = $this->modelLichTrinh->getAllLichTrinhByTour($maTour);

        $viewFile = "./views/tour/suaLichTrinh.php";
        include "./views/layout.php";
    }

    // --- XỬ LÝ CẬP NHẬT LỊCH TRÌNH (FIXED) ---
    // File: duan1nhom4/controllers/LichTrinhController.php

// ...

    // --- XỬ LÝ CẬP NHẬT LỊCH TRÌNH (FIXED) ---
    public function editLichTrinhProcess()
    {
        $id = $_POST['MaLichTrinh'];
        $maTour = $_POST['MaTour'];
        $ngayThu = (int)($_POST['NgayThu'] ?? 0);
        $tieuDeNgay = trim($_POST['TieuDeNgay'] ?? ''); // <-- Đã thêm trim()
        $diaDiemThamQuan = $_POST['DiaDiemThamQuan'] ?? null;
        $noiO = $_POST['NoiO'] ?? null;
        $coBuaSang = isset($_POST['CoBuaSang']) ? 1 : 0;
        $coBuaTrua = isset($_POST['CoBuaTrua']) ? 1 : 0;
        $coBuaToi = isset($_POST['CoBuaToi']) ? 1 : 0;
        $chiTietHoatDong = $_POST['ChiTietHoatDong'];
        
        // --- BƯỚC 1: XỬ LÝ VALIDATION ---

        if (empty($tieuDeNgay) || $ngayThu <= 0) {
            header("Location: ?act=editLichTrinh&id=" . $id . "&error=validation");
            exit();
        }
        
        // 1.2 [LOGIC NGHIỆP VỤ ĐÃ BỎ] Kiểm tra NgayThu không vượt quá SoNgay của Tour
        // Dòng này và các biến liên quan đã được xóa khỏi logic
        
        // 1.3 Kiểm tra trùng lặp ngày thứ (loại trừ bản ghi hiện tại)
        if ($this->modelLichTrinh->isNgayThuExist($maTour, $ngayThu, $id)) {
            header("Location: ?act=editLichTrinh&id=" . $id . "&error=ngay_trung");
            exit();
        }
        // --- KẾT THÚC VALIDATION ---
        
        // BƯỚC 2: GỌI MODEL
        $this->modelLichTrinh->updateLichTrinh(
            $id, 
            $maTour, 
            $ngayThu, 
            $tieuDeNgay, 
            $diaDiemThamQuan, 
            $noiO, 
            $coBuaSang, 
            $coBuaTrua, 
            $coBuaToi, 
            $chiTietHoatDong
        );

        header("Location: ?act=lichTour&tour_id=" . $maTour . "&success=update");
        exit();
    }

// ...

    // Xóa lịch trình
    // Xóa lịch trình
    public function deleteLichTrinh()
    {
        $id = $_GET['id'];
        $maTour = $_GET['tour_id'];

        // BƯỚC 1: Lấy NgayThu trước khi xóa để biết vị trí cần sắp xếp lại
        $lichTrinh = $this->modelLichTrinh->getLichTrinhById($id);
        $deletedNgayThu = (int)($lichTrinh['NgayThu'] ?? 0);

        // BƯỚC 2: Xóa lịch trình
        $this->modelLichTrinh->deleteLichTrinh($id);

        // BƯỚC 3: Sắp xếp lại thứ tự NgayThu của các ngày còn lại
        if ($deletedNgayThu > 0) {
            $this->modelLichTrinh->reorderLichTrinh($maTour, $deletedNgayThu);
        }

        header("Location: ?act=lichTour&tour_id=" . $maTour . "&success=delete");
        exit();
    }
}
