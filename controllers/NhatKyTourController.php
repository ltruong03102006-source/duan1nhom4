<?php
class NhatKyTourController
{
    private $model;

    public function __construct()
    {
        $this->model = new NhatKyTourModel();
    }

    // ADMIN: xem toàn bộ
    public function adminList()
    {
        onlyAdmin();
        $list = $this->model->getAll(); // đã join Tour/Đoàn/NV
        $viewFile = "./views/nhatky/admin_list.php";
        include "./views/layout.php";
    }

    // HDV: xem theo đoàn
    public function hdvList()
    {
        onlyHDV();
        $maDoan = isset($_GET['MaDoan']) ? (int)$_GET['MaDoan'] : 0;
        if ($maDoan <= 0) { header("Location: ?act=hdvHome&error=invalid_doan"); exit; }

        // (Khuyến nghị) xác thực đoàn thuộc HDV đang đăng nhập
        $hdvModel = new huongDanVienModel();
        $doan = $hdvModel->getChiTietDoan($maDoan);
        if (!$doan || ($doan['MaHuongDanVien'] ?? null) != $_SESSION['user']['MaNhanVien']) {
            header("Location: ?act=hdvHome&error=forbidden"); exit;
        }

        $list = $this->model->getByDoan($maDoan);
        $MaDoan = $maDoan; // truyền sang view để form sử dụng
        $viewFile = "./views/nhatky/hdv_list.php";
        include "./views/layout.php";
    }

    // HDV: thêm nhật ký
    public function addProcess()
    {
        onlyHDV();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ?act=hdvHome"); exit;
        }

        $maDoan   = isset($_POST['MaDoan']) ? (int)$_POST['MaDoan'] : 0;
        $noiDung  = trim($_POST['NoiDung'] ?? '');
        $loai     = trim($_POST['LoaiSuCo'] ?? '');
        $nvId     = $_SESSION['user']['MaNhanVien'] ?? null;

        if ($maDoan <= 0 || $noiDung === '' || !$nvId) {
            header("Location: ?act=nhatky_hdv&MaDoan=$maDoan&error=validate"); exit;
        }

        // Xác thực quyền sở hữu đoàn
        $hdvModel = new huongDanVienModel();
        $doan = $hdvModel->getChiTietDoan($maDoan);
        if (!$doan || ($doan['MaHuongDanVien'] ?? null) != $nvId) {
            header("Location: ?act=nhatky_hdv&MaDoan=$maDoan&error=forbidden"); exit;
        }

        // Upload ảnh (lưu đường dẫn public)
        $linkAnh = null;
        if (!empty($_FILES['LinkAnh']['name'])) {
            $publicDir = "/uploads/nhatky/";
            $diskDir   = __DIR__ . "/../..".$publicDir; // điều chỉnh theo cấu trúc dự án
            if (!is_dir($diskDir)) { mkdir($diskDir, 0777, true); }

            $basename = time().'_'.preg_replace('/[^A-Za-z0-9._-]/','_', basename($_FILES['LinkAnh']['name']));
            $diskPath = $diskDir.$basename;
            if (move_uploaded_file($_FILES['LinkAnh']['tmp_name'], $diskPath)) {
                $linkAnh = $publicDir.$basename; // path dùng để hiển thị <img>
            }
        }

        // Dữ liệu insert
        $data = [
            ':MaDoan'     => $maDoan,
            ':NgayGhi'    => date("Y-m-d"),
            ':GioGhi'     => date("H:i:s"),
            ':NoiDung'    => $noiDung,
            ':LoaiSuCo'   => ($loai !== '') ? $loai : null,
            ':LinkAnh'    => $linkAnh,
            ':MaNguoiTao' => $nvId
        ];

        try {
            $this->model->add($data);
            header("Location: ?act=nhatky_hdv&MaDoan=$maDoan&success=1"); exit;
        } catch (Throwable $e) {
            error_log("ADD NK FAIL: ".$e->getMessage());
            header("Location: ?act=nhatky_hdv&MaDoan=$maDoan&error=db"); exit;
        }
    }
}
