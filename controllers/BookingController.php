<?php
class BookingController
{
    public $bookingModel;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
    }

    // ====== DANH SÁCH BOOKING ======
    public function listBooking()
    {
        $listBooking = $this->bookingModel->getAllBooking();
        $viewFile = './views/booking/listBooking.php';
        include './views/layout.php';
    }

    // ====== THÊM BOOKING ======
    public function addBooking()
    {
        $listTour = $this->bookingModel->getAllTour();
        $listDoan = $this->bookingModel->getAllDoan();
        $listKhachHang = $this->bookingModel->getAllKhachHang();

        $viewFile = './views/booking/addBooking.php';
        include './views/layout.php';
    }

    public function addBookingProcess()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $MaCodeBooking = $_POST['MaCodeBooking'];
            $MaTour = $_POST['MaTour'] ?: null;
            $MaDoan = $_POST['MaDoan'] ?: null;
            $MaKhachHang = $_POST['MaKhachHang'] ?: null;
            $LoaiBooking = $_POST['LoaiBooking'] ?? 'ca_nhan';

            $TongNguoiLon = (int)($_POST['TongNguoiLon'] ?? 0);
            $TongTreEm = (int)($_POST['TongTreEm'] ?? 0);
            $TongEmBe = (int)($_POST['TongEmBe'] ?? 0);

            $TongTien = (float)($_POST['TongTien'] ?? 0);
            $SoTienDaCoc = (float)($_POST['SoTienDaCoc'] ?? 0);
            $SoTienDaTra = (float)($_POST['SoTienDaTra'] ?? 0);

            // Tạm tính: còn lại = Tổng tiền - Số tiền đã trả
            $SoTienConLai = $TongTien - $SoTienDaTra;

            $YeuCauDacBiet = $_POST['YeuCauDacBiet'] ?? null;

            // Tạm thời fix cứng người tạo = 1 (sau này lấy từ session)
            $MaNguoiTao = 1;

            $data = [
                ':MaCodeBooking' => $MaCodeBooking,
                ':MaTour' => $MaTour,
                ':MaDoan' => $MaDoan,
                ':MaKhachHang' => $MaKhachHang,
                ':LoaiBooking' => $LoaiBooking,
                ':TongNguoiLon' => $TongNguoiLon,
                ':TongTreEm' => $TongTreEm,
                ':TongEmBe' => $TongEmBe,
                ':TongTien' => $TongTien,
                ':SoTienDaCoc' => $SoTienDaCoc,
                ':SoTienDaTra' => $SoTienDaTra,
                ':SoTienConLai' => $SoTienConLai,
                ':YeuCauDacBiet' => $YeuCauDacBiet,
                ':MaNguoiTao' => $MaNguoiTao,
            ];

            $this->bookingModel->addBooking($data);

            header("Location: ?act=listBooking");
            exit();
        }
    }

    // ====== SỬA BOOKING ======
    public function editBooking()
    {
        $MaBooking = $_GET['MaBooking'] ?? null;
        if (!$MaBooking) {
            header("Location: ?act=listBooking");
            exit();
        }

        $booking = $this->bookingModel->getOneBooking($MaBooking);
        $listTour = $this->bookingModel->getAllTour();
        $listDoan = $this->bookingModel->getAllDoan();
        $listKhachHang = $this->bookingModel->getAllKhachHang();

        $viewFile = './views/booking/editBooking.php';
        include './views/layout.php';
    }

    public function editBookingProcess()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $MaBooking = $_POST['MaBooking'];

            $oldBooking = $this->bookingModel->getOneBooking($MaBooking);
            $TrangThaiCu = $oldBooking['TrangThai'] ?? 'cho_coc';

            $MaTour = $_POST['MaTour'] ?: null;
            $MaDoan = $_POST['MaDoan'] ?: null;
            $MaKhachHang = $_POST['MaKhachHang'] ?: null;
            $LoaiBooking = $_POST['LoaiBooking'] ?? 'ca_nhan';

            $TongNguoiLon = (int)($_POST['TongNguoiLon'] ?? 0);
            $TongTreEm = (int)($_POST['TongTreEm'] ?? 0);
            $TongEmBe = (int)($_POST['TongEmBe'] ?? 0);

            $TongTien = (float)($_POST['TongTien'] ?? 0);
            $SoTienDaCoc = (float)($_POST['SoTienDaCoc'] ?? 0);
            $SoTienDaTra = (float)($_POST['SoTienDaTra'] ?? 0);

            $SoTienConLai = $TongTien - $SoTienDaTra;

            $YeuCauDacBiet = $_POST['YeuCauDacBiet'] ?? null;
            $TrangThai = $_POST['TrangThai'] ?? 'cho_coc';

            $data = [
                ':MaBooking' => $MaBooking,
                ':MaTour' => $MaTour,
                ':MaDoan' => $MaDoan,
                ':MaKhachHang' => $MaKhachHang,
                ':LoaiBooking' => $LoaiBooking,
                ':TongNguoiLon' => $TongNguoiLon,
                ':TongTreEm' => $TongTreEm,
                ':TongEmBe' => $TongEmBe,
                ':TongTien' => $TongTien,
                ':SoTienDaCoc' => $SoTienDaCoc,
                ':SoTienDaTra' => $SoTienDaTra,
                ':SoTienConLai' => $SoTienConLai,
                ':YeuCauDacBiet' => $YeuCauDacBiet,
                ':TrangThai' => $TrangThai,
            ];

            $this->bookingModel->updateBooking($data);

            // Nếu trạng thái thay đổi thì lưu lịch sử
            if ($TrangThaiCu != $TrangThai) {
                $MaNguoiDoi = 1; // sau này lấy từ session
                $this->bookingModel->addLichSuTrangThai($MaBooking, $TrangThaiCu, $TrangThai, $MaNguoiDoi, null);
            }

            header("Location: ?act=listBooking");
            exit();
        }
    }

    // ====== XÓA BOOKING ======
    public function deleteBooking()
    {
        $MaBooking = $_GET['MaBooking'] ?? null;
        if ($MaBooking) {
            $this->bookingModel->deleteBooking($MaBooking);
        }
        header("Location: ?act=listBooking");
        exit();
    }

    // ====== KHÁCH TRONG BOOKING ======
    public function khachTrongBooking()
    {
        $MaBooking = $_GET['MaBooking'] ?? null;
        if (!$MaBooking) {
            header("Location: ?act=listBooking");
            exit();
        }

        $booking = $this->bookingModel->getBookingDetailWithDoan($MaBooking);
        $listKhach = $this->bookingModel->getKhachTrongBooking($MaBooking);

        $viewFile = './views/booking/khachTrongBooking.php';
        include './views/layout.php';
    }

    public function addKhachTrongBooking()
    {
        $MaBooking = $_GET['MaBooking'] ?? null;
        if (!$MaBooking) {
            header("Location: ?act=listBooking");
            exit();
        }

        $booking = $this->bookingModel->getBookingDetailWithDoan($MaBooking);
        $viewFile = './views/booking/addKhachTrongBooking.php';
        include './views/layout.php';
    }

    public function addKhachTrongBookingProcess()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $MaBooking = $_POST['MaBooking'];

            $data = [
                ':MaBooking' => $MaBooking,
                ':HoTen' => $_POST['HoTen'],
                ':GioiTinh' => $_POST['GioiTinh'] ?? null,
                ':NgaySinh' => $_POST['NgaySinh'] ?: null,
                ':SoGiayTo' => $_POST['SoGiayTo'] ?? null,
                ':SoDienThoai' => $_POST['SoDienThoai'] ?? null,
                ':GhiChuDacBiet' => $_POST['GhiChuDacBiet'] ?? null,
                ':LoaiPhong' => $_POST['LoaiPhong'] ?? null,
            ];

            $this->bookingModel->addKhachTrongBooking($data);

            header("Location: ?act=khachTrongBooking&MaBooking=" . $MaBooking);
            exit();
        }
    }

    public function deleteKhachTrongBooking()
    {
        $MaKhachTrongBooking = $_GET['MaKhachTrongBooking'] ?? null;
        $MaBooking = $_GET['MaBooking'] ?? null;

        if ($MaKhachTrongBooking) {
            $this->bookingModel->deleteKhachTrongBooking($MaKhachTrongBooking);
        }

        header("Location: ?act=khachTrongBooking&MaBooking=" . $MaBooking);
        exit();
    }

    // ====== ĐIỂM DANH KHÁCH (HDV dùng luôn) ======
    public function diemDanhProcess()
    {
        $MaKhachTrongBooking = $_GET['MaKhachTrongBooking'] ?? null;
        $status = $_GET['status'] ?? 0;
        $MaBooking = $_GET['MaBooking'] ?? null;

        if ($MaKhachTrongBooking && $MaBooking) {
            $this->bookingModel->updateDiemDanh($MaKhachTrongBooking, $status);
        }

        header("Location: ?act=khachTrongBooking&MaBooking=" . $MaBooking);
        exit();
    }
}
