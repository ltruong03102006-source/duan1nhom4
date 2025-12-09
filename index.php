<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// ======================================================
// 1️⃣  Require các file môi trường và hàm chung
// ======================================================
require_once './commons/env.php';
require_once './commons/function.php';

// ======================================================
// 2️⃣  Require Controllers
// ======================================================
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
require_once './controllers/nhaCungCapController.php';
require_once './controllers/DichVuCuaDoanController.php';
require_once './controllers/TaiChinhTourController.php';
require_once './controllers/ThanhToanController.php';
require_once './controllers/AuthController.php';
require_once './controllers/NhatKyTourController.php';

// ======================================================
// 3️⃣  Require Models
// ======================================================
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
require_once './models/nhaCungCapModel.php';
require_once './models/DichVuCuaDoanModel.php';
require_once './models/TaiChinhTourModel.php';
require_once './models/ThanhToanModel.php';
require_once './models/NhatKyTourModel.php';

// ======================================================
// 4️⃣  Route xử lý yêu cầu
// ======================================================
$act = $_GET['act'] ?? '/';

// Router chính sử dụng switch
switch ($act) {

    // ====================== PUBLIC ======================
    case '/':
        (new ProductController())->Home();
        break;

    case 'login':
        (new AuthController())->login();
        break;

    case 'loginProcess':
        (new AuthController())->loginProcess();
        break;

    case 'logout':
        (new AuthController())->logout();
        break;


    // ====================== ADMIN ======================

    // ---- DANH MỤC TOUR ----
    case 'danhMuctour':
        onlyAdmin();
        (new danhMuctourController())->homeDanhMucTour();
        break;

    case 'addDanhMucTour':
        onlyAdmin();
        (new danhMuctourController())->addDanhMucTour();
        break;

    case 'addDanhMucTourProcess':
        onlyAdmin();
        (new danhMuctourController())->addDanhMucTourProcess();
        break;

    case 'editDanhMucTour':
        onlyAdmin();
        (new danhMuctourController())->editDanhMucTour();
        break;

    case 'updateDanhMucTour':
        onlyAdmin();
        (new danhMuctourController())->updateDanhMucTour();
        break;

    case 'deleteDanhMucTour':
        onlyAdmin();
        (new danhMuctourController())->deleteDanhMucTour();
        break;


    // ---- TOUR ----
    case 'tour':
        onlyAdmin();
        (new tourController())->tour();
        break;

    case 'addTour':
        onlyAdmin();
        (new tourController())->addTour();
        break;

    case 'addTourProcess':
        onlyAdmin();
        (new tourController())->addTourProcess();
        break;

    case 'xemTour':
        onlyAdmin();
        (new tourController())->viewTour();
        break;

    case 'editTour':
        onlyAdmin();
        (new tourController())->editTour();
        break;

    case 'editTourProcess':
        onlyAdmin();
        (new tourController())->editTourProcess();
        break;

    case 'deleteTour':
        onlyAdmin();
        (new tourController())->deleteTour();
        break;
    
    // ---- LỊCH TRÌNH ----
    case 'lichTour':
        onlyAdmin();
        (new LichTrinhController())->lichTour();
        break;

    case 'addLichTrinhProcess':
        onlyAdmin();
        (new LichTrinhController())->addLichTrinhProcess();
        break;

    case 'editLichTrinh':
        onlyAdmin();
        (new LichTrinhController())->editLichTrinh();
        break;

    case 'editLichTrinhProcess':
        onlyAdmin();
        (new LichTrinhController())->editLichTrinhProcess();
        break;

    case 'deleteLichTrinh':
        onlyAdmin();
        (new LichTrinhController())->deleteLichTrinh();
        break;


    // ---- GIÁ TOUR ----
    case 'giaTour':
        onlyAdmin();
        (new GiaTourController())->giaTour();
        break;

    case 'addGiaTour':
        onlyAdmin();
        (new GiaTourController())->addGiaTour();
        break;

    case 'addGiaTourProcess':
        onlyAdmin();
        (new GiaTourController())->addGiaTourProcess();
        break;

    case 'editGiaTour':
        onlyAdmin();
        (new GiaTourController())->editGiaTour();
        break;

    case 'editGiaTourProcess':
        onlyAdmin();
        (new GiaTourController())->editGiaTourProcess();
        break;

    case 'deleteGiaTour':
        onlyAdmin();
        (new GiaTourController())->deleteGiaTour();
        break;


    // ---- DỰ TOÁN CHI PHÍ ----
    case 'duToanChiPhi':
        onlyAdmin();
        (new DuToanChiPhiController())->duToanChiPhi();
        break;

    case 'addDuToan':
        onlyAdmin();
        (new DuToanChiPhiController())->addDuToan();
        break;

    case 'addDuToanProcess':
        onlyAdmin();
        (new DuToanChiPhiController())->addDuToanProcess();
        break;

    case 'editDuToan':
        onlyAdmin();
        (new DuToanChiPhiController())->editDuToan();
        break;

    case 'editDuToanProcess':
        onlyAdmin();
        (new DuToanChiPhiController())->editDuToanProcess();
        break;

    case 'deleteDuToan':
        onlyAdmin();
        (new DuToanChiPhiController())->deleteDuToan();
        break;


    // ---- KHÁCH HÀNG ----
    case 'listKhachHang':
        onlyAdmin();
        (new KhachHangController())->listKhachHang();
        break;

    case 'addKhachHang':
        onlyAdmin();
        (new KhachHangController())->addKhachHang();
        break;

    case 'addKhachHangProcess':
        onlyAdmin();
        (new KhachHangController())->addKhachHangProcess();
        break;

    case 'editKhachHang':
        onlyAdmin();
        (new KhachHangController())->editKhachHang();
        break;

    case 'updateKhachHangProcess':
        onlyAdmin();
        (new KhachHangController())->updateKhachHangProcess();
        break;

    case 'deleteKhachHang':
        onlyAdmin();
        (new KhachHangController())->deleteKhachHang();
        break;
    case 'addKhachHangGroup':
        onlyAdmin();
        (new KhachHangController())->addKhachHangGroup();
        break;

    case 'addKhachHangGroupProcess':
        onlyAdmin();
        (new KhachHangController())->addKhachHangGroupProcess();
        break;


    // ---- NHÂN VIÊN ----
    case 'listNhanVien':
        onlyAdmin();
        (new NhanVienController())->listNhanVien();
        break;

    case 'addNhanVien':
        onlyAdmin();
        (new NhanVienController())->addNhanVien();
        break;

    case 'addNhanVienProcess':
        onlyAdmin();
        (new NhanVienController())->addNhanVienProcess();
        break;

    case 'editNhanVien':
        onlyAdmin();
        (new NhanVienController())->editNhanVien();
        break;

    case 'updateNhanVienProcess':
        onlyAdmin();
        (new NhanVienController())->updateNhanVienProcess();
        break;

    case 'deleteNhanVien':
        onlyAdmin();
        (new NhanVienController())->deleteNhanVien();
        break;


    // ---- LỊCH LÀM VIỆC ----
    case 'listLichLamViec':
        onlyAdmin();
        (new LichLamViecController())->listLichLamViec();
        break;

    case 'addLichLamViecProcess':
        onlyAdmin();
        (new LichLamViecController())->addLichLamViecProcess();
        break;

    case 'deleteLichLamViec':
        onlyAdmin();
        (new LichLamViecController())->deleteLichLamViec();
        break;


    // ---- ĐOÀN KHỞI HÀNH ----
    case 'listDoan':
        onlyAdmin();
        (new DoanKhoiHanhController())->listDoan();
        break;

    case 'addDoan':
        onlyAdmin();
        (new DoanKhoiHanhController())->addDoan();
        break;

    case 'addDoanProcess':
        onlyAdmin();
        (new DoanKhoiHanhController())->addDoanProcess();
        break;

    case 'editDoan':
        onlyAdmin();
        (new DoanKhoiHanhController())->editDoan();
        break;

    case 'editDoanProcess':
        onlyAdmin();
        (new DoanKhoiHanhController())->editDoanProcess();
        break;

    case 'deleteDoan':
        onlyAdmin();
        (new DoanKhoiHanhController())->deleteDoan();
        break;


    // ---- BOOKING ----
    case 'listBooking':
        onlyAdmin();
        (new BookingController())->listBooking();
        break;

    case 'addBooking':
        onlyAdmin();
        (new BookingController())->addBooking();
        break;

    case 'addBookingProcess':
        onlyAdmin();
        (new BookingController())->addBookingProcess();
        break;

    case 'editBooking':
        onlyAdmin();
        (new BookingController())->editBooking();
        break;

    case 'editBookingProcess':
        onlyAdmin();
        (new BookingController())->editBookingProcess();
        break;

    case 'deleteBooking':
        onlyAdmin();
        (new BookingController())->deleteBooking();
        break;
    case 'khachTrongBooking':
        onlyAdmin();
        (new BookingController())->khachTrongBooking();
        break;
    case 'addKhachTrongBooking':
        onlyAdmin();
        (new BookingController())->addKhachTrongBooking();
        break;
    case 'addKhachTrongBookingProcess':
        onlyAdmin();
        (new BookingController())->addKhachTrongBookingProcess();
        break;
    case 'deleteKhachTrongBooking':
        onlyAdmin();
        (new BookingController())->deleteKhachTrongBooking();
        break;


    // ---- THANH TOÁN ----
    case 'listThanhToan':
        onlyAdmin();
        (new ThanhToanController())->listThanhToan();
        break;

    case 'addThanhToan':
        onlyAdmin();
        (new ThanhToanController())->addThanhToan();
        break;

    case 'addThanhToanProcess':
        onlyAdmin();
        (new ThanhToanController())->addThanhToanProcess();
        break;

    case 'editThanhToan':
        onlyAdmin();
        (new ThanhToanController())->editThanhToan();
        break;

    case 'editThanhToanProcess':
        onlyAdmin();
        (new ThanhToanController())->editThanhToanProcess();
        break;

    case 'deleteThanhToan':
        onlyAdmin();
        (new ThanhToanController())->deleteThanhToan();
        break;


    // ---- NHÀ CUNG CẤP ----
    case 'listNhaCungCap':
        onlyAdmin();
        (new nhaCungCapController())->homeNhaCungCap();
        break;

    case 'addNhaCungCap':
        onlyAdmin();
        (new nhaCungCapController())->addNhaCungCap();
        break;

    case 'addNhaCungCapProcess':
        onlyAdmin();
        (new nhaCungCapController())->addNhaCungCapProcess();
        break;

    case 'editNhaCungCap':
        onlyAdmin();
        (new nhaCungCapController())->editNhaCungCap();
        break;

    case 'updateNhaCungCapProcess':
        onlyAdmin();
        (new nhaCungCapController())->updateNhaCungCapProcess();
        break;

    case 'deleteNhaCungCap':
        onlyAdmin();
        (new nhaCungCapController())->deleteNhaCungCap();
        break;


    // ---- DỊCH VỤ ĐOÀN ----
    case 'listDichVu':
        onlyAdmin();
        (new DichVuCuaDoanController())->listDichVu();
        break;

    case 'addDichVu':
        onlyAdmin();
        (new DichVuCuaDoanController())->addDichVu();
        break;

    case 'addDichVuProcess':
        onlyAdmin();
        (new DichVuCuaDoanController())->addDichVuProcess();
        break;

    case 'editDichVu':
        onlyAdmin();
        (new DichVuCuaDoanController())->editDichVu();
        break;

    case 'editDichVuProcess':
        onlyAdmin();
        (new DichVuCuaDoanController())->editDichVuProcess();
        break;

    case 'deleteDichVu':
        onlyAdmin();
        (new DichVuCuaDoanController())->deleteDichVu();
        break;


    // ---- TÀI CHÍNH TOUR ----
    case 'listTaiChinh':
        onlyAdmin();
        (new TaiChinhTourController())->listTaiChinh();
        break;

    case 'addTaiChinh':
        onlyAdmin();
        (new TaiChinhTourController())->addTaiChinh();
        break;

    case 'addTaiChinhProcess':
        onlyAdmin();
        (new TaiChinhTourController())->addTaiChinhProcess();
        break;

    case 'editTaiChinh':
        onlyAdmin();
        (new TaiChinhTourController())->editTaiChinh();
        break;

    case 'updateTaiChinhProcess':
        onlyAdmin();
        (new TaiChinhTourController())->updateTaiChinhProcess();
        break;

    case 'deleteTaiChinh':
        onlyAdmin();
        (new TaiChinhTourController())->deleteTaiChinh();
        break;

    // ---- TÀI KHOẢN ----
    case 'taiKhoan':
        onlyAdmin();
        (new TaiKhoanController())->homeTaiKhoan();
        break;

    case 'addTaiKhoan':
        onlyAdmin();
        (new TaiKhoanController())->addTaiKhoan();
        break;

    case 'addTaiKhoanProcess':
        onlyAdmin();
        (new TaiKhoanController())->addTaiKhoanProcess();
        break;

    case 'toggleTrangThaiTaiKhoan':
        onlyAdmin();
        (new TaiKhoanController())->toggleTrangThai();
        break;

    case 'editTaiKhoan':
        onlyAdmin();
        (new TaiKhoanController())->editTaiKhoan();
        break;

    case 'updateTaiKhoanProcess':
        onlyAdmin();
        (new TaiKhoanController())->updateTaiKhoanProcess();
        break;


    // ====================== HDV ======================
    case 'hdvHome':
        onlyHDV();
        (new huongDanVienController())->homeHDV();
        break;

    case 'xemTourHDV':
        onlyHDV();
        (new tourController())->xemTourHDV();
        break;

    case 'hdvDoanDetail':
        onlyHDV();
        (new huongDanVienController())->viewDoanDetail();
        break;

    case 'hdvLichTrinh':
        onlyHDV();
        (new huongDanVienController())->viewLichTrinh();
        break;
    case 'hdvDiemDanh':
        onlyHDV();
        (new BookingController())->hdvDiemDanh();
        break;

    case 'hdvDiemDanhProcess':
        onlyHDV();
        (new BookingController())->hdvDiemDanhProcess();
        break;
    // ================== NHẬT KÝ TOUR ==================

    // ADMIN xem toàn bộ nhật ký
    case 'nhatky_admin':
        onlyAdmin();
        (new NhatKyTourController())->adminList();
        break;

    // HDV xem nhật ký đoàn mình
    case 'nhatky_hdv':
        onlyHDV();
        (new NhatKyTourController())->hdvList();
        break;

    // HDV ghi nhật ký
    case 'nhatky_add':
        onlyHDV();
        (new NhatKyTourController())->addProcess();
        break;



    // ====================== DEFAULT ======================
    default:
        (new ProductController())->Home();
        break;
}
