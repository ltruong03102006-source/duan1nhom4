<?php
// có class chứa các function thực thi xử lý logic 
class ProductController
{
    public $modelProduct;

    public function __construct()
    {
        $this->modelProduct = new ProductModel();
    }

    public function home()
    {
        $viewFile = './views/home.php';
        include './views/layout.php';
    }
}
