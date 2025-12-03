<?php
class DoanKhoiHanhController
{
    public $model;

    public function __construct()
    {
        $this->model = new DoanKhoiHanhModel();
    }

    public function listDoan()
    {
        $listDoan = $this->model->getAllDoan();
        $viewFile = './views/doan/listDoan.php';
        include './views/layout.php';
    }

    public function addDoan()
    {
        $listTour = $this->model->getListTour();
        $listHDV  = $this->model->getListHDV();
        $listTaiXe = $this->model->getListTaiXe();

        // Lấy ngày khởi hành để check bận (mặc định hôm nay)
        $selectedNgayKhoiHanh = $_GET['NgayKhoiHanh'] ?? date('Y-m-d');

        // Danh sách nhân viên bận trong ngày đó
        $busyIds = $this->model->getBusyNhanVienIdsByDate($selectedNgayKhoiHanh);

        $viewFile = './views/doan/addDoan.php';
        include './views/layout.php';
    }

    public function addDoanProcess()
    {
        $NgayKhoiHanh = $_POST['NgayKhoiHanh'] ?? null;
        $MaHuongDanVien = $_POST['MaHuongDanVien'] ?? '';
        $MaTaiXe = $_POST['MaTaiXe'] ?? '';

        // Check bận theo ngày khởi hành
        $busyIds = $this->model->getBusyNhanVienIdsByDate($NgayKhoiHanh);

        // Nếu chọn HDV/Tài xế mà nằm trong danh sách bận -> chặn
        if (!empty($MaHuongDanVien) && in_array((int)$MaHuongDanVien, array_map('intval', $busyIds), true)) {
            header("Location: ?act=addDoan&error=busy&role=hdv&NgayKhoiHanh=" . urlencode($NgayKhoiHanh));
            exit();
        }
        if (!empty($MaTaiXe) && in_array((int)$MaTaiXe, array_map('intval', $busyIds), true)) {
            header("Location: ?act=addDoan&error=busy&role=taixe&NgayKhoiHanh=" . urlencode($NgayKhoiHanh));
            exit();
        }

        $data = [
            ':MaTour' => $_POST['MaTour'],
            ':NgayKhoiHanh' => $_POST['NgayKhoiHanh'],
            ':GioKhoiHanh' => $_POST['GioKhoiHanh'],
            ':NgayVe' => $_POST['NgayVe'],
            ':DiemTapTrung' => $_POST['DiemTapTrung'],
            ':SoChoToiDa' => $_POST['SoChoToiDa'],
            ':SoChoConTrong' => $_POST['SoChoToiDa'],
            ':MaHuongDanVien' => $_POST['MaHuongDanVien'],
            ':MaTaiXe' => $_POST['MaTaiXe'],
            ':ThongTinXe' => $_POST['ThongTinXe']
        ];

        $this->model->addDoan($data);
        header("Location: ?act=listDoan&success=add");
        exit();
    }

    public function editDoan()
    {
        $id = $_GET['MaDoan'];

        $doan = $this->model->getOneDoan($id);
        $listTour = $this->model->getListTour();
        $listHDV  = $this->model->getListHDV();
        $listTaiXe = $this->model->getListTaiXe();

        // Ngày khởi hành hiện tại để check bận
        $selectedNgayKhoiHanh = $doan['NgayKhoiHanh'] ?? date('Y-m-d');
        $busyIds = $this->model->getBusyNhanVienIdsByDate($selectedNgayKhoiHanh);

        $viewFile = './views/doan/editDoan.php';
        include './views/layout.php';
    }

    public function editDoanProcess()
    {
        $MaDoan = $_POST['MaDoan'];
        $NgayKhoiHanh = $_POST['NgayKhoiHanh'] ?? null;
        $MaHuongDanVien = $_POST['MaHuongDanVien'] ?? '';
        $MaTaiXe = $_POST['MaTaiXe'] ?? '';

        // Check bận
        $busyIds = $this->model->getBusyNhanVienIdsByDate($NgayKhoiHanh);

        // Nếu nhân viên bận vì đoàn khác -> chặn
        // (đơn giản: kiểm tra "bận" theo lịch làm việc; nếu lịch làm việc do chính đoàn này tạo thì bạn cần loại trừ theo MaDoan ở model)
        if (!empty($MaHuongDanVien) && in_array((int)$MaHuongDanVien, array_map('intval', $busyIds), true)) {
            header("Location: ?act=editDoan&MaDoan=" . urlencode($MaDoan) . "&error=busy&role=hdv");
            exit();
        }
        if (!empty($MaTaiXe) && in_array((int)$MaTaiXe, array_map('intval', $busyIds), true)) {
            header("Location: ?act=editDoan&MaDoan=" . urlencode($MaDoan) . "&error=busy&role=taixe");
            exit();
        }

        $data = [
            ':MaDoan' => $_POST['MaDoan'],
            ':MaTour' => $_POST['MaTour'],
            ':NgayKhoiHanh' => $_POST['NgayKhoiHanh'],
            ':GioKhoiHanh' => $_POST['GioKhoiHanh'],
            ':NgayVe' => $_POST['NgayVe'],
            ':DiemTapTrung' => $_POST['DiemTapTrung'],
            ':SoChoToiDa' => $_POST['SoChoToiDa'],
            ':SoChoConTrong' => $_POST['SoChoConTrong'],
            ':MaHuongDanVien' => $_POST['MaHuongDanVien'],
            ':MaTaiXe' => $_POST['MaTaiXe'],
            ':ThongTinXe' => $_POST['ThongTinXe']
        ];

        $this->model->updateDoan($data);
        header("Location: ?act=listDoan&success=update");
        exit();
    }

    public function deleteDoan()
    {
        $id = $_GET['MaDoan'];
        $this->model->deleteDoan($id);
        header("Location: ?act=listDoan&success=delete");
        exit();
    }
}
