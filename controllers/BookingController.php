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

        // map giá theo tour
        $giaMap = [];
        foreach ($listTour as $t) {
            $gia = $this->bookingModel->getGiaHienTaiByTour($t['MaTour']);
            $giaMap[$t['MaTour']] = [
                'nl' => (float)($gia['GiaNguoiLon'] ?? 0),
                'te' => (float)($gia['GiaTreEm'] ?? 0),
                'eb' => (float)($gia['GiaEmBe'] ?? 0),
            ];
        }

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
            
            $this->bookingModel->updateTrangThaiDoanBySoKhach($MaDoan);

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

            $oldBooking  = $this->bookingModel->getOneBooking($MaBooking);
            $TrangThaiCu = $oldBooking['TrangThai'] ?? 'cho_coc';
            $oldMaDoan   = $oldBooking['MaDoan'] ?? null; // <-- cần dòng này

            $MaTour       = $_POST['MaTour'] ?: null;
            $MaDoan       = $_POST['MaDoan'] ?: null;
            $MaKhachHang  = $_POST['MaKhachHang'] ?: null;
            $LoaiBooking  = $_POST['LoaiBooking'] ?? 'ca_nhan';

            $TongNguoiLon = (int)($_POST['TongNguoiLon'] ?? 0);
            $TongTreEm    = (int)($_POST['TongTreEm'] ?? 0);
            $TongEmBe     = (int)($_POST['TongEmBe'] ?? 0);

            $TongTien     = (float)($_POST['TongTien'] ?? 0);
            $SoTienDaCoc  = (float)($_POST['SoTienDaCoc'] ?? 0);
            $SoTienDaTra  = (float)($_POST['SoTienDaTra'] ?? 0);
            $SoTienConLai = $TongTien - $SoTienDaTra;

            $YeuCauDacBiet = $_POST['YeuCauDacBiet'] ?? null;
            $TrangThai     = $_POST['TrangThai'] ?? 'cho_coc';

            $data = [
                ':MaBooking'     => $MaBooking,
                ':MaTour'        => $MaTour,
                ':MaDoan'        => $MaDoan,
                ':MaKhachHang'   => $MaKhachHang,
                ':LoaiBooking'   => $LoaiBooking,
                ':TongNguoiLon'  => $TongNguoiLon,
                ':TongTreEm'     => $TongTreEm,
                ':TongEmBe'      => $TongEmBe,
                ':TongTien'      => $TongTien,
                ':SoTienDaCoc'   => $SoTienDaCoc,
                ':SoTienDaTra'   => $SoTienDaTra,
                ':SoTienConLai'  => $SoTienConLai,
                ':YeuCauDacBiet' => $YeuCauDacBiet,
                ':TrangThai'     => $TrangThai,
            ];

            $this->bookingModel->updateBooking($data);

            // Cập nhật trạng thái đoàn cũ & đoàn mới
            if (!empty($oldMaDoan)) {
                $this->bookingModel->updateTrangThaiDoanBySoKhach($oldMaDoan);
            }
            if (!empty($MaDoan) && $MaDoan !== $oldMaDoan) {
                $this->bookingModel->updateTrangThaiDoanBySoKhach($MaDoan);
            }

            // Lưu lịch sử trạng thái nếu có thay đổi
            if ($TrangThaiCu != $TrangThai) {
                $MaNguoiDoi = 1; // TODO: lấy từ session
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
            $bk = $this->bookingModel->getOneBooking($MaBooking); // lấy MaDoan trước khi xóa
            $this->bookingModel->deleteBooking($MaBooking);
            if (!empty($bk['MaDoan'])) {
                $this->bookingModel->updateTrangThaiDoanBySoKhach($bk['MaDoan']);
            }
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

        $booking   = $this->bookingModel->getBookingDetailWithDoan($MaBooking);
        
        // 1. Lấy danh sách khách
        $listKhach = $this->bookingModel->getKhachTrongBooking($MaBooking);
        
        // --- BỔ SUNG LOGIC MA TRẬN ĐIỂM DANH ---
        $MaDoan = $booking['MaDoan'] ?? null;
        $matrixDates = [];
        $matrixData = [];

        if ($MaDoan) {
            // Lấy toàn bộ lịch sử điểm danh của Đoàn (để xem tổng quát)
            $historyRaw = $this->bookingModel->getHistoryDiemDanh($MaDoan);
            
            // Xử lý dữ liệu ma trận (Pivot Data)
            foreach ($historyRaw as $row) {
                // Định dạng ngày ngắn gọn (ví dụ: 12/12)
                $d = date('d/m', strtotime($row['NgayDiemDanh']));
                $matrixDates[$d] = $d;
                $matrixData[$row['MaKhachTrongBooking']][$d] = [
                    'status' => $row['TrangThai'],
                    'note' => $row['GhiChu']
                ];
            }
            ksort($matrixDates); // Sắp xếp ngày theo thứ tự tăng dần
        }
        // --- KẾT THÚC BỔ SUNG ---

        // Nếu cần re-check trạng thái đoàn thì lấy từ $booking
        $this->bookingModel->updateTrangThaiDoanBySoKhach($booking['MaDoan'] ?? null);

        $viewFile = './views/booking/khachTrongBooking.php';
        // Truyền thêm các biến mới vào view
        include './views/layout.php';
    }
    // ====== KHÁCH TRONG BOOKING DÀNH CHO HDV ======
    public function hdvKhachTrongBooking()
    {
        // 1) Nhận MaBooking hoặc MaDoan
        $MaBooking = $_GET['MaBooking'] ?? null;
        $MaDoan = $_GET['MaDoan'] ?? null;

        // 2) Nếu không có MaBooking thì tìm Booking theo MaDoan
        if (!$MaBooking && $MaDoan) {
            $MaBooking = $this->bookingModel->getMaBookingByMaDoan($MaDoan);
        }

        if (!$MaBooking) {
            header("Location: ?act=hdvHome");
            exit();
        }

        // 3) Lấy dữ liệu khách
        $booking = $this->bookingModel->getBookingDetailWithDoan($MaBooking);
        $listKhach = $this->bookingModel->getKhachTrongBooking($MaBooking);

        // 4) View riêng HDV (để không dính quyền admin)
        $viewFile = './views/hdv/khachTrongBooking.php';
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
            
            // cập nhật trạng thái đoàn theo số khách mới
            $bk = $this->bookingModel->getOneBooking($MaBooking);
            $this->bookingModel->updateTrangThaiDoanBySoKhach($bk['MaDoan'] ?? null);


            header("Location: ?act=khachTrongBooking&MaBooking=" . $MaBooking);
            exit();
        }
    }

    public function deleteKhachTrongBooking()
    {
        $MaKhachTrongBooking = $_GET['MaKhachTrongBooking'] ?? null;
        $MaBooking = $_GET['MaBooking'] ?? null;

        if ($MaKhachTrongBooking) {
                        // lấy MaDoan trước khi xóa
            $bk = $this->bookingModel->getBookingByKhachTrongBooking($MaKhachTrongBooking);
            $this->bookingModel->deleteKhachTrongBooking($MaKhachTrongBooking);
        }

        header("Location: ?act=khachTrongBooking&MaBooking=" . $MaBooking);
        exit();
    }

    // ====== ĐIỂM DANH KHÁCH (HDV dùng luôn) ======
    public function diemDanhProcess()
    {
        $MaKhachTrongBooking = $_GET['MaKhachTrongBooking'] ?? null;
        $status = isset($_GET['status']) ? (int)$_GET['status'] : 0;
        $MaBooking = $_GET['MaBooking'] ?? null;

        if ($MaKhachTrongBooking && $MaBooking) {
            $this->bookingModel->updateDiemDanh($MaKhachTrongBooking, $status);
        }

        // ✅ Quay về đúng trang HDV
        header("Location: ?act=hdvKhachTrongBooking&MaBooking=" . $MaBooking);
        exit();
    }
    // ====== HDV: TRANG ĐIỂM DANH RIÊNG THEO ĐOÀN ======
    // File: controllers/BookingController.php
// Trong hàm hdvDiemDanh()

public function hdvDiemDanh() {
    onlyHDV();
    $MaDoan = $_GET['MaDoan'] ?? null;
    $NgayDiemDanh = $_GET['date'] ?? date('Y-m-d');

    if ($MaDoan) {
        $doanModel = new DoanKhoiHanhModel();
        $thongTinDoan = $doanModel->getDetail($MaDoan);
        
        // 1. Lấy danh sách check-in cho ngày đang chọn (Code cũ)
        $danhSachKhach = $this->bookingModel->getDanhSachKhachVaDiemDanh($MaDoan, $NgayDiemDanh);

        // 2. [MỚI] Lấy toàn bộ lịch sử để vẽ bảng ma trận
        $historyRaw = $this->bookingModel->getHistoryDiemDanh($MaDoan);
        
        // Xử lý dữ liệu ma trận (Pivot Data)
        $matrixDates = []; // Mảng chứa các ngày đã điểm danh
        $matrixData = [];  // Mảng chứa dữ liệu [MaKhach][Ngay] = Trạng thái

        foreach ($historyRaw as $row) {
            $d = date('d/m', strtotime($row['NgayDiemDanh'])); // Lấy ngày tháng ngắn gọn
            $matrixDates[$d] = $d; // Lưu key để không trùng
            $matrixData[$row['MaKhachTrongBooking']][$d] = [
                'status' => $row['TrangThai'],
                'note' => $row['GhiChu']
            ];
        }
        ksort($matrixDates); // Sắp xếp ngày tăng dần

        require_once 'views/hdv/diemdanh.php';
    } else {
        header("Location: ?act=homeHDV");
    }
}

    public function hdvDiemDanhProcess()
    {
        onlyHDV();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $MaDoan = $_POST['MaDoan'];
            $NgayDiemDanh = $_POST['NgayDiemDanh']; // Ngày được chọn từ form
            
            $statuses = $_POST['status'] ?? []; // Mảng trạng thái [MaKhach => 1/0]
            $notes = $_POST['note'] ?? [];      // Mảng ghi chú [MaKhach => 'text']

            foreach ($statuses as $MaKhach => $TrangThai) {
                $GhiChu = $notes[$MaKhach] ?? '';
                
                // Gọi model để lưu vào bảng diemdanh
                $this->bookingModel->saveDiemDanh($MaDoan, $MaKhach, $NgayDiemDanh, $TrangThai, $GhiChu);
            }

            // Chuyển hướng lại trang điểm danh đúng ngày đó và thông báo thành công
            header("Location: ?act=hdvDiemDanh&MaDoan=$MaDoan&date=$NgayDiemDanh&msg=success");
            exit();
        }
    }
    // Thêm hàm này vào BookingController

public function hdvUpdateInfoKhach() {
    onlyHDV();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $MaDoan = $_POST['MaDoan'];
        $MaKhach = $_POST['MaKhach'];
        $GhiChu = $_POST['GhiChuDacBiet'];
        $LoaiPhong = $_POST['LoaiPhong'];
        $currentDate = $_POST['currentDate'];

        // Gọi Model cập nhật
        $sql = "UPDATE KhachTrongBooking SET GhiChuDacBiet = ?, LoaiPhong = ? WHERE MaKhachTrongBooking = ?";
        $stmt = $this->bookingModel->conn->prepare($sql);
        $stmt->execute([$GhiChu, $LoaiPhong, $MaKhach]);

        // Quay lại trang cũ
        header("Location: ?act=hdvDiemDanh&MaDoan=$MaDoan&date=$currentDate&msg=update_ok");
    }
}
}
