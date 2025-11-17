<?php
// Require toàn bộ các file khai báo môi trường, thực thi,...(không require view)

// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/ProductController.php';
require_once './controllers/danhMuctourController.php';
require_once './controllers/tourController.php';
require_once './controllers/LichTrinhController.php';
require_once './controllers/GiaTourController.php';
require_once './controllers/DuToanChiPhiController.php';
require_once './controllers/khachHangController.php';

// Require toàn bộ file Models
require_once './models/ProductModel.php';
require_once './models/danhMuctourModel.php';
require_once './models/tourModel.php';
require_once './models/LichTrinhModel.php';
require_once './models/GiaTourModel.php';
require_once './models/DuToanChiPhiModel.php';
require_once './models/khachHangModel.php';

// Route
$act = $_GET['act'] ?? '/';


// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match

match ($act) {
    // Trang chủ
    '/' => (new ProductController())->Home(),

    // Quản lý danh mục tour
    'danhMuctour' => (new danhMuctourController())->homeDanhMucTour(),
    'addDanhMucTour' => (new danhMuctourController())->addDanhMucTour(),
    'addDanhMucTourProcess' => (new danhMuctourController())->addDanhMucTourProcess(),
    'deleteDanhMucTour' => (new danhMuctourController())->deleteDanhMucTour(),
    'editDanhMucTour' => (new danhMuctourController())->editDanhMucTour(),
    'updateDanhMucTour' => (new danhMuctourController())->updateDanhMucTour(),

    // Quản lý tour
    'tour' => (new tourController())->tour(),
    
    'addTour' => (new tourController())->addTour(),
    'addTourProcess' => (new tourController())->addTourProcess(),
    'xemTour' => (new tourController())->viewTour(),
    'editTour' => (new tourController())->editTour(),
    'editTourProcess' => (new tourController())->editTourProcess(),
    'deleteTour' => (new tourController())->deleteTour(),

    //Quản lý lịch trình chi tiết tour
    'lichTour' => (new LichTrinhController())->lichTour(),
    'addLichTrinhProcess' => (new LichTrinhController())->addLichTrinhProcess(),
    'editLichTrinh' => (new LichTrinhController())->editLichTrinh(),
    'editLichTrinhProcess' => (new LichTrinhController())->editLichTrinhProcess(),
    'deleteLichTrinh' => (new LichTrinhController())->deleteLichTrinh(),


    // Quản lý giá tour
    'giaTour' => (new GiaTourController())->giaTour(),
    'addGiaTour' => (new GiaTourController())->addGiaTour(),
    'addGiaTourProcess' => (new GiaTourController())->addGiaTourProcess(),
    'editGiaTour' => (new GiaTourController())->editGiaTour(),
    'editGiaTourProcess' => (new GiaTourController())->editGiaTourProcess(),
    'deleteGiaTour' => (new GiaTourController())->deleteGiaTour(),

     // Quản lý dự toán chi phí
    'duToanChiPhi' => (new DuToanChiPhiController())->duToanChiPhi(),
    'addDuToan' => (new DuToanChiPhiController())->addDuToan(),
    'addDuToanProcess' => (new DuToanChiPhiController())->addDuToanProcess(),
    'editDuToan' => (new DuToanChiPhiController())->editDuToan(),
    'editDuToanProcess' => (new DuToanChiPhiController())->editDuToanProcess(),
    'deleteDuToan' => (new DuToanChiPhiController())->deleteDuToan(),

    // Quản lý Khách Hàng (PHẦN BẠN YÊU CẦU)
    'listKhachHang' => (new KhachHangController())->listKhachHang(),
    'addKhachHang' => (new KhachHangController())->addKhachHang(),
    'addKhachHangProcess' => (new KhachHangController())->addKhachHangProcess(),
    'editKhachHang' => (new KhachHangController())->editKhachHang(),
    'updateKhachHangProcess' => (new KhachHangController())->updateKhachHangProcess(),
    'deleteKhachHang' => (new KhachHangController())->deleteKhachHang(),

    // Mặc định
    default => (new ProductController())->Home()
};
