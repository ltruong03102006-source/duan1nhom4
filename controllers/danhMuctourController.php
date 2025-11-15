<?php
// có class chứa các function thực thi xử lý logic 
class danhMuctourController
{
    public $modelDanhmuctour;

    public function __construct()
    {
        $this->modelDanhmuctour = new danhMuctourModel();
    }

    public function homeDanhMucTour()
    {

        $dmTour = $this->modelDanhmuctour->getAlltour();
        $viewFile = './views/tour/danhMuctour.php';
        include './views/layout.php';
    }

    public function addDanhMucTour()
    {
        $viewFile = './views/tour/danhMuctour.php';
        include './views/layout.php';
    }
    public function addDanhMucTourProcess()
    {
        $tenDanhmuc = $_POST['tenDanhMuc'];
        $moTa = $_POST['moTa'];
        $this->modelDanhmuctour->addDanhMucTour($tenDanhmuc, $moTa);
        header("Location: ?act=danhMuctour");
        exit();
    }
    public function deleteDanhMucTour()
    {
        $id = $_GET['id'];
        $this->modelDanhmuctour->deleteDanhMucTour($id);

        header("Location: ?act=danhMuctour");
        exit();
    }
    // TRANG SỬA
    public function editDanhMucTour()
    {
        $id = $_GET['id'];
        $danhmuc = $this->modelDanhmuctour->getDanhMucById($id);

        $viewFile = "./views/tour/suaDanhMucTour.php";
        include "./views/layout.php";
    }

    // XỬ LÝ SỬA
    public function updateDanhMucTour()
    {
        $id = $_POST['id'];
        $tenDanhmuc = $_POST['tenDanhMuc'];
        $moTa = $_POST['moTa'];

        $this->modelDanhmuctour->updateDanhMucTour($id, $tenDanhmuc, $moTa);

        header("Location: ?act=danhMuctour");
        exit();
    }
}
