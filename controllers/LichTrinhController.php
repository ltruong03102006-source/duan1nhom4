<?php

class LichTrinhController {

    private $model;

    public function __construct() {
        $this->model = new LichTrinhModel();
    }

    public function list() {
        $MaTour = $_GET['MaTour'];
        $list = $this->model->getByTour($MaTour);
        require_once './views/lichtrinh/list.php';
    }

    public function add() {
        $MaTour = $_GET['MaTour'];
        require_once './views/lichtrinh/add.php';
    }

    public function addProcess() {
        $data = [
            $_POST['MaTour'],
            $_POST['NgayThu'],
            $_POST['TieuDeNgay'],
            $_POST['ChiTietHoatDong'],
            $_POST['DiaDiemThamQuan'],
            isset($_POST['CoBuaSang']) ? 1 : 0,
            isset($_POST['CoBuaTrua']) ? 1 : 0,
            isset($_POST['CoBuaToi']) ? 1 : 0,
            $_POST['NoiO']
        ];
        $this->model->insert($data);
        header("Location: index.php?act=listLichTrinh&MaTour=".$_POST['MaTour']);
    }

    public function edit() {
        $id = $_GET['id'];
        $lichtrinh = $this->model->getOne($id);
        require_once './views/lichtrinh/edit.php';
    }

    public function editProcess() {
        $id = $_POST['MaLichTrinh'];
        $data = [
            $_POST['NgayThu'],
            $_POST['TieuDeNgay'],
            $_POST['ChiTietHoatDong'],
            $_POST['DiaDiemThamQuan'],
            isset($_POST['CoBuaSang']) ? 1 : 0,
            isset($_POST['CoBuaTrua']) ? 1 : 0,
            isset($_POST['CoBuaToi']) ? 1 : 0,
            $_POST['NoiO'],
        ];

        $this->model->update($id, $data);
        header("Location: index.php?act=listLichTrinh&MaTour=".$_POST['MaTour']);
    }

    public function delete() {
        $id = $_GET['id'];
        $MaTour = $_GET['MaTour'];
        $this->model->delete($id);
        header("Location: index.php?act=listLichTrinh&MaTour=".$MaTour);
    }
}
