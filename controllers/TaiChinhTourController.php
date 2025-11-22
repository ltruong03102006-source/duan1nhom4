<?php
class TaiChinhTourController {
    public $modelTaiChinh;

    public function __construct() {
        $this->modelTaiChinh = new TaiChinhTourModel();
    }

    // Danh sách tài chính của 1 đoàn
    public function listTaiChinh() {
        $MaDoan = $_GET['MaDoan'] ?? null;
        if (!$MaDoan) {
            header("Location: ?act=listDoan"); // Quay lại nếu không có ID đoàn
            exit();
        }

        $listTaiChinh = $this->modelTaiChinh->getAllTaiChinhByDoan($MaDoan);
        $thongKe = $this->modelTaiChinh->getThongKeTaiChinh($MaDoan);
        $infoDoan = $this->modelTaiChinh->getInfoDoan($MaDoan);

        $viewFile = './views/taichinh/list.php';
        include './views/layout.php';
    }

    // Form thêm mới
    public function addTaiChinh() {
        $MaDoan = $_GET['MaDoan'] ?? null;
        $listNCC = $this->modelTaiChinh->getAllNhaCungCap();
        $infoDoan = $this->modelTaiChinh->getInfoDoan($MaDoan);

        $viewFile = './views/taichinh/add.php';
        include './views/layout.php';
    }

    // Xử lý thêm mới
    public function addTaiChinhProcess() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $MaDoan = $_POST['MaDoan'];
            
            // Dữ liệu form
            $data = [
                ':MaDoan' => $MaDoan,
                ':LoaiGiaoDich' => $_POST['LoaiGiaoDich'],
                ':HangMucChi' => $_POST['HangMucChi'],
                ':SoTien' => $_POST['SoTien'],
                ':NgayGiaoDich' => $_POST['NgayGiaoDich'],
                ':MoTa' => $_POST['MoTa'],
                ':PhuongThucThanhToan' => $_POST['PhuongThucThanhToan'],
                ':SoHoaDon' => $_POST['SoHoaDon'],
                ':MaNhaCungCap' => !empty($_POST['MaNhaCungCap']) ? $_POST['MaNhaCungCap'] : null,
                ':MaNguoiTao' => 1 // Tạm thời fix cứng admin, sau này lấy từ session $_SESSION['user']['id']
            ];

            $this->modelTaiChinh->addTaiChinh($data);
            header("Location: ?act=listTaiChinh&MaDoan=$MaDoan");
            exit();
        }
    }

    // Form sửa
    public function editTaiChinh() {
        $id = $_GET['id'];
        $taiChinh = $this->modelTaiChinh->getOneTaiChinh($id);
        $listNCC = $this->modelTaiChinh->getAllNhaCungCap();
        
        // Lấy thông tin đoàn để nút quay lại hoạt động đúng
        $MaDoan = $taiChinh['MaDoan'];
        $infoDoan = $this->modelTaiChinh->getInfoDoan($MaDoan);

        $viewFile = './views/taichinh/edit.php';
        include './views/layout.php';
    }

    // Xử lý sửa
    public function updateTaiChinhProcess() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $MaDoan = $_POST['MaDoan']; // Để redirect về đúng chỗ
            
            $data = [
                ':MaTaiChinh' => $_POST['MaTaiChinh'],
                ':LoaiGiaoDich' => $_POST['LoaiGiaoDich'],
                ':HangMucChi' => $_POST['HangMucChi'],
                ':SoTien' => $_POST['SoTien'],
                ':NgayGiaoDich' => $_POST['NgayGiaoDich'],
                ':MoTa' => $_POST['MoTa'],
                ':PhuongThucThanhToan' => $_POST['PhuongThucThanhToan'],
                ':SoHoaDon' => $_POST['SoHoaDon'],
                ':MaNhaCungCap' => !empty($_POST['MaNhaCungCap']) ? $_POST['MaNhaCungCap'] : null
            ];

            $this->modelTaiChinh->updateTaiChinh($data);
            header("Location: ?act=listTaiChinh&MaDoan=$MaDoan");
            exit();
        }
    }

    // Xóa
    public function deleteTaiChinh() {
        $id = $_GET['id'];
        // Cần lấy MaDoan trước khi xóa để redirect
        $taiChinh = $this->modelTaiChinh->getOneTaiChinh($id);
        $MaDoan = $taiChinh['MaDoan'];

        $this->modelTaiChinh->deleteTaiChinh($id);
        header("Location: ?act=listTaiChinh&MaDoan=$MaDoan");
        exit();
    }
}
?>