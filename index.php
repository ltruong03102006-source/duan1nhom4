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
require_once './controllers/NhanVienController.php';
require_once './controllers/LichLamViecController.php';
require_once './controllers/AnhTourController.php';
require_once './controllers/DoanKhoiHanhController.php';
require_once './controllers/BookingController.php';

require_once './controllers/TaiKhoanController.php';
require_once './controllers/huongDanVienController.php';
require_once './controllers/nhaCungCapController.php'; // <--- Thêm dòng này


// Require toàn bộ file Models
require_once './models/ProductModel.php';
require_once './models/danhMuctourModel.php';
require_once './models/tourModel.php';

require_once './models/LichTrinhModel.php';
require_once './models/GiaTourModel.php';
require_once './models/DuToanChiPhiModel.php';
require_once './models/khachHangModel.php';
require_once './models/NhanVienModel.php';
require_once './models/LichLamViecModel.php';
require_once './models/AnhTourModel.php';
require_once './models/DoanKhoiHanhModel.php';
require_once './models/BookingModel.php';

require_once './models/taiKhoanModel.php';
require_once './models/huongDanVienModel.php';
require_once './models/nhaCungCapModel.php'; // <--- Thêm dòng này


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

    // QUẢN LÝ ẢNH TOUR
    'anhTour' => (new AnhTourController())->anhTour(),
    'addAnhTour' => (new AnhTourController())->addAnhTour(),
    'addAnhTourProcess' => (new AnhTourController())->addAnhTourProcess(),
    'editAnhTour' => (new AnhTourController())->editAnhTour(),
    'editAnhTourProcess' => (new AnhTourController())->editAnhTourProcess(),
    'deleteAnhTour' => (new AnhTourController())->deleteAnhTour(),


    // Quản lý Khách Hàng (PHẦN BẠN YÊU CẦU)
    'listKhachHang' => (new KhachHangController())->listKhachHang(),
    'addKhachHang' => (new KhachHangController())->addKhachHang(),
    'addKhachHangProcess' => (new KhachHangController())->addKhachHangProcess(),
    'editKhachHang' => (new KhachHangController())->editKhachHang(),
    'updateKhachHangProcess' => (new KhachHangController())->updateKhachHangProcess(),
    'deleteKhachHang' => (new KhachHangController())->deleteKhachHang(),

    // Quản lý Nhân Viên (PHẦN MỚI THÊM)
    'listNhanVien' => (new NhanVienController())->listNhanVien(),
    'addNhanVien' => (new NhanVienController())->addNhanVien(),
    'addNhanVienProcess' => (new NhanVienController())->addNhanVienProcess(),
    'editNhanVien' => (new NhanVienController())->editNhanVien(),
    'updateNhanVienProcess' => (new NhanVienController())->updateNhanVienProcess(),
    'deleteNhanVien' => (new NhanVienController())->deleteNhanVien(),

    // Quản lý Lịch Làm Việc (PHẦN MỚI THÊM)
    'listLichLamViec' => (new LichLamViecController())->listLichLamViec(),
    'addLichLamViecProcess' => (new LichLamViecController())->addLichLamViecProcess(),
    'deleteLichLamViec' => (new LichLamViecController())->deleteLichLamViec(),


    // QUẢN LÝ ĐOÀN KHỞI HÀNH
    'listDoan' => (new DoanKhoiHanhController())->listDoan(),
    'addDoan' => (new DoanKhoiHanhController())->addDoan(),
    'addDoanProcess' => (new DoanKhoiHanhController())->addDoanProcess(),
    'editDoan' => (new DoanKhoiHanhController())->editDoan(),
    'editDoanProcess' => (new DoanKhoiHanhController())->editDoanProcess(),
    'deleteDoan' => (new DoanKhoiHanhController())->deleteDoan(),

    // QUẢN LÝ BOOKING
    'listBooking' => (new BookingController())->listBooking(),
    'addBooking' => (new BookingController())->addBooking(),
    'addBookingProcess' => (new BookingController())->addBookingProcess(),
    'editBooking' => (new BookingController())->editBooking(),
    'editBookingProcess' => (new BookingController())->editBookingProcess(),
    'deleteBooking' => (new BookingController())->deleteBooking(),

    // Quản lý khách trong booking
    'khachTrongBooking' => (new BookingController())->khachTrongBooking(),
    'addKhachTrongBooking' => (new BookingController())->addKhachTrongBooking(),
    'addKhachTrongBookingProcess' => (new BookingController())->addKhachTrongBookingProcess(),
    'deleteKhachTrongBooking' => (new BookingController())->deleteKhachTrongBooking(),

    // Điểm danh khách (HDV)
    'diemDanhProcess' => (new BookingController())->diemDanhProcess(),

    
    // Quản lý Tài khoản (Phần 13: Admin)
    'taiKhoan' => (new TaiKhoanController())->homeTaiKhoan(),
    'addTaiKhoan' => (new TaiKhoanController())->addTaiKhoan(),
    'addTaiKhoanProcess' => (new TaiKhoanController())->addTaiKhoanProcess(),
    'toggleTrangThaiTaiKhoan' => (new TaiKhoanController())->toggleTrangThai(),
    'editTaiKhoan' => (new TaiKhoanController())->editTaiKhoan(), 
    'updateTaiKhoanProcess' => (new TaiKhoanController())->updateTaiKhoanProcess(),

    // Giao diện Hướng dẫn viên (HDV) <--- PHẦN MỚI
    'hdvHome' => (new huongDanVienController())->homeHDV(),
    'hdvDoanDetail' => (new huongDanVienController())->viewDoanDetail(),
    'hdvLichTrinh' => (new huongDanVienController())->viewLichTrinh(),
    
    

   // Quản lý Nhà Cung Cấp (Phần 7: Admin) <--- PHẦN MỚI
    'listNhaCungCap' => (new nhaCungCapController())->homeNhaCungCap(),
    'addNhaCungCap' => (new nhaCungCapController())->addNhaCungCap(),
    'addNhaCungCapProcess' => (new nhaCungCapController())->addNhaCungCapProcess(),
    'editNhaCungCap' => (new nhaCungCapController())->editNhaCungCap(),
    'updateNhaCungCapProcess' => (new nhaCungCapController())->updateNhaCungCapProcess(),
    'deleteNhaCungCap' => (new nhaCungCapController())->deleteNhaCungCap(),

    // Xử lý các case còn lại (nếu có)
    default => (new ProductController())->Home(),
};

