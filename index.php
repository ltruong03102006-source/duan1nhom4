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

// Require toàn bộ file Models
require_once './models/ProductModel.php';
require_once './models/danhMuctourModel.php';
require_once './models/tourModel.php';
require_once './models/LichTrinhModel.php';

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
    

};