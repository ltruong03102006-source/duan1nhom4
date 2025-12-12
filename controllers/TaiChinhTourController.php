<?php
class TaiChinhTourController {
    public $modelTaiChinh;

    public function __construct() {
        $this->modelTaiChinh = new TaiChinhTourModel();
        if (session_status() === PHP_SESSION_NONE) session_start();
    }

    // Danh sách tài chính của 1 đoàn
    public function listTaiChinh() {
        $MaDoan = $_GET['MaDoan'] ?? null;
        if (!$MaDoan) {
            header("Location: ?act=listDoan");
            exit();
        }

        $listTaiChinh = $this->modelTaiChinh->getAllTaiChinhByDoan($MaDoan);
        $thongKe      = $this->modelTaiChinh->getThongKeTaiChinh($MaDoan);
        $infoDoan     = $this->modelTaiChinh->getInfoDoan($MaDoan);

        $viewFile = './views/taichinh/list.php';
        include './views/layout.php';
    }

    // Form thêm mới
    public function addTaiChinh() {
        $MaDoan = $_GET['MaDoan'] ?? null;
        if (!$MaDoan) {
            header("Location: ?act=listDoan");
            exit();
        }

        $listNCC  = $this->modelTaiChinh->getAllNhaCungCap();
        $infoDoan = $this->modelTaiChinh->getInfoDoan($MaDoan);

        $viewFile = './views/taichinh/add.php';
        include './views/layout.php';
    }

    // Xử lý thêm mới
    public function addTaiChinhProcess()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: index.php');
        exit;
    }

    // 1) Lấy dữ liệu POST
    $MaDoan       = $_POST['MaDoan'] ?? null;
    $LoaiGiaoDich = $_POST['LoaiGiaoDich'] ?? '';
    $HangMucChi   = trim($_POST['HangMucChi'] ?? '');
    $SoTien       = (float)($_POST['SoTien'] ?? 0);
    $NgayGiaoDich = $_POST['NgayGiaoDich'] ?? date('Y-m-d');
    $MoTa         = trim($_POST['MoTa'] ?? '');
    $PTTT         = trim($_POST['PhuongThucThanhToan'] ?? '');
    $SoHoaDon     = trim($_POST['SoHoaDon'] ?? '');
    $MaNhaCungCap = $_POST['MaNhaCungCap'] ?? null;

    // 2) Chuẩn hoá NCC
    $MaNhaCungCap = empty($MaNhaCungCap) ? null : (int)$MaNhaCungCap;

    // ✅ 3) VALIDATE DUY NHẤT: CHI phải chọn NCC
    if ($LoaiGiaoDich === 'chi' && $MaNhaCungCap === null) {
        $_SESSION['error'] = 'Chi tiền bắt buộc phải chọn Nhà Cung Cấp';
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? "index.php?act=addTaiChinh&MaDoan=$MaDoan"));
        exit;
    }

    // 4) Chuẩn bị data insert
    $data = [
        'MaDoan' => (int)$MaDoan,
        'LoaiGiaoDich' => $LoaiGiaoDich,
        'HangMucChi' => $HangMucChi,
        'SoTien' => $SoTien,
        'NgayGiaoDich' => $NgayGiaoDich,
        'MoTa' => $MoTa,
        'PhuongThucThanhToan' => $PTTT,
        'SoHoaDon' => $SoHoaDon,
        'MaNhaCungCap' => $MaNhaCungCap, // THU có thể null / có thể có, tuỳ bạn
        'MaNguoiTao' => $_SESSION['user']['MaNhanVien'] ?? ($_SESSION['user_id'] ?? 1),
    ];

    // 5) Gọi model (đổi tên hàm theo model bạn đang dùng)
    // Ví dụ: $this->modelTaiChinh->insert($data);
    $ok = $this->modelTaiChinh->addTaiChinh($data);

    if ($ok) {
        $_SESSION['success'] = 'Thêm giao dịch thành công';
        header("Location: index.php?act=listTaiChinh&MaDoan=$MaDoan");
        exit;
    }

    $_SESSION['error'] = 'Thêm giao dịch thất bại';
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? "index.php?act=addTaiChinh&MaDoan=$MaDoan"));
    exit;
}


    // Form sửa
    public function editTaiChinh() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: ?act=listDoan");
            exit();
        }

        $taiChinh = $this->modelTaiChinh->getOneTaiChinh((int)$id);
        if (!$taiChinh) {
            $_SESSION['error'] = "Không tìm thấy giao dịch.";
            header("Location: ?act=listDoan");
            exit();
        }

        $listNCC  = $this->modelTaiChinh->getAllNhaCungCap();
        $MaDoan   = $taiChinh['MaDoan'];
        $infoDoan = $this->modelTaiChinh->getInfoDoan($MaDoan);

        $viewFile = './views/taichinh/edit.php';
        include './views/layout.php';
    }

    // Xử lý sửa
    public function updateTaiChinhProcess()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: index.php');
        exit;
    }

    // 1) Lấy dữ liệu POST
    $MaTaiChinh   = (int)($_POST['MaTaiChinh'] ?? 0);
    $MaDoan       = (int)($_POST['MaDoan'] ?? 0);
    $LoaiGiaoDich = $_POST['LoaiGiaoDich'] ?? '';
    $HangMucChi   = trim($_POST['HangMucChi'] ?? '');
    $SoTien       = (float)($_POST['SoTien'] ?? 0);
    $NgayGiaoDich = $_POST['NgayGiaoDich'] ?? date('Y-m-d');
    $MoTa         = trim($_POST['MoTa'] ?? '');
    $PTTT         = trim($_POST['PhuongThucThanhToan'] ?? '');
    $SoHoaDon     = trim($_POST['SoHoaDon'] ?? '');
    $MaNhaCungCap = $_POST['MaNhaCungCap'] ?? null;

    // 2) Chuẩn hoá NCC
    $MaNhaCungCap = empty($MaNhaCungCap) ? null : (int)$MaNhaCungCap;

    // ✅ 3) VALIDATE DUY NHẤT: CHI phải chọn NCC
    if ($LoaiGiaoDich === 'chi' && $MaNhaCungCap === null) {
        $_SESSION['error'] = 'Chi tiền bắt buộc phải chọn Nhà Cung Cấp';
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? "index.php?act=editTaiChinh&id=$MaTaiChinh"));
        exit;
    }

    // 4) Chuẩn bị data update
    $data = [
        'MaTaiChinh' => $MaTaiChinh,
        'LoaiGiaoDich' => $LoaiGiaoDich,
        'HangMucChi' => $HangMucChi,
        'SoTien' => $SoTien,
        'NgayGiaoDich' => $NgayGiaoDich,
        'MoTa' => $MoTa,
        'PhuongThucThanhToan' => $PTTT,
        'SoHoaDon' => $SoHoaDon,
        'MaNhaCungCap' => $MaNhaCungCap,
    ];

    // 5) Gọi model (đổi tên hàm theo model bạn đang dùng)
    // Ví dụ: $this->modelTaiChinh->update($data);
    $ok = $this->modelTaiChinh->updateTaiChinh($data);

    if ($ok) {
        $_SESSION['success'] = 'Cập nhật giao dịch thành công';
        header("Location: index.php?act=listTaiChinh&MaDoan=$MaDoan");
        exit;
    }

    $_SESSION['error'] = 'Cập nhật giao dịch thất bại';
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? "index.php?act=editTaiChinh&id=$MaTaiChinh"));
    exit;
}


    // Xóa
    public function deleteTaiChinh() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: ?act=listDoan");
            exit();
        }

        $tc = $this->modelTaiChinh->getOneTaiChinh((int)$id);
        $MaDoan = $tc['MaDoan'] ?? null;

        $this->modelTaiChinh->deleteTaiChinh((int)$id);
        $_SESSION['success'] = "Xóa giao dịch thành công.";
        header("Location: ?act=listTaiChinh&MaDoan=$MaDoan");
        exit();
    }
}
