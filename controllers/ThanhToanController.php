<?php
class ThanhToanController {
    public $model;

    public function __construct() {
        require_once './models/ThanhToanModel.php';
        $this->model = new ThanhToanModel();
    }

    public function listThanhToan() {
        $list = $this->model->getAll();
        $viewFile = './views/thanhToan/listThanhToan.php';
        include './views/layout.php';
    }

    public function addThanhToan() {
        $listBooking = $this->model->getAllBooking();
        $viewFile = './views/thanhToan/addThanhToan.php';
        include './views/layout.php';
    }

    public function addThanhToanProcess() {
        $this->model->insert($_POST);
        header("Location: ?act=listThanhToan");
        exit();
    }

    public function editThanhToan() {
        $id = $_GET['id'];
        $thanhToan = $this->model->getOne($id);
        $listBooking = $this->model->getAllBooking();
        $viewFile = './views/thanhToan/editThanhToan.php';
        include './views/layout.php';
    }

    public function editThanhToanProcess() {
        $this->model->update($_POST);
        header("Location: ?act=listThanhToan");
        exit();
    }

    public function deleteThanhToan() {
        $id = $_GET['id'];
        $this->model->delete($id);
        header("Location: ?act=listThanhToan");
        exit();
    }
}
