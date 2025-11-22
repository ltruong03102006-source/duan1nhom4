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
        $listHDV = $this->model->getListHDV();
        $listTaiXe = $this->model->getListTaiXe();

        $viewFile = './views/doan/addDoan.php';
        include './views/layout.php';
    }

    public function addDoanProcess()
    {
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
        header("Location: ?act=listDoan");
        exit();
    }

    public function editDoan()
    {
        $id = $_GET['MaDoan'];

        $doan = $this->model->getOneDoan($id);
        $listTour = $this->model->getListTour();
        $listHDV = $this->model->getListHDV();
        $listTaiXe = $this->model->getListTaiXe();

        $viewFile = './views/doan/editDoan.php';
        include './views/layout.php';
    }

    public function editDoanProcess()
    {
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
        header("Location: ?act=listDoan");
        exit();
    }

    public function deleteDoan()
    {
        $id = $_GET['MaDoan'];
        $this->model->deleteDoan($id);
        header("Location: ?act=listDoan");
        exit();
    }
}
