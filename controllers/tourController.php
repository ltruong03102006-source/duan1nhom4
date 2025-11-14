<?php
// có class chứa các function thực thi xử lý logic 
class tourController
{
    public $modelTour;

    public function __construct()
    {
        $this->modelTour = new tourModel();
    }

    public function tour()
    {
        $listTour=$this->modelTour->getAllTour();
        $viewFile = './views/tour.php';
        include './views/layout.php';
    }
    public function addTour()
    {
        $viewFile = './views/addtour.php';
        include './views/layout.php';
    }
}