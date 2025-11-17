<?php
class GiaTourController
{
    public $giaTourModel;

    public function __construct()
    {
        $this->giaTourModel = new GiaTourModel();
    }

    // Hiển thị danh sách giá tour
    public function giaTour()
    {
        $maTour = $_GET['maTour'] ?? null;
        
        if ($maTour) {
            $danhSachGia = $this->giaTourModel->getGiaByTourId($maTour);
            $tourInfo = $this->giaTourModel->getAllTour();
            
            // Lấy tên tour
            $tenTour = '';
            foreach ($tourInfo as $tour) {
                if ($tour['MaTour'] == $maTour) {
                    $tenTour = $tour['TenTour'];
                    break;
                }
            }
            
            $viewFile = './views/tour/giatour.php';
            include './views/layout.php';
        } else {
            // Nếu không có maTour, redirect về trang tour
            header('Location: ?act=tour');
            exit();
        }
    }

    // Hiển thị form thêm giá tour
    public function addGiaTour()
    {
        $maTour = $_GET['maTour'] ?? null;
        
        if (!$maTour) {
            header('Location: ?act=tour');
            exit();
        }
        
        $danhSachTour = $this->giaTourModel->getAllTour();
        
        $viewFile = './views/tour/giatouradd.php';
        include './views/layout.php';
    }

    // Xử lý thêm giá tour
    public function addGiaTourProcess()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $maTour = $_POST['maTour'];
            $loaiKhach = $_POST['loaiKhach'];
            $giaTien = $_POST['giaTien'];
            $apDungTuNgay = $_POST['apDungTuNgay'] ?? null;
            $apDungDenNgay = $_POST['apDungDenNgay'] ?? null;
            $loaiMua = $_POST['loaiMua'] ?? 'binh_thuong';
            $tenKhuyenMai = $_POST['tenKhuyenMai'] ?? null;
            $phanTramGiamGia = $_POST['phanTramGiamGia'] ?? 0;

            $result = $this->giaTourModel->addGiaTour(
                $maTour, 
                $loaiKhach, 
                $giaTien, 
                $apDungTuNgay, 
                $apDungDenNgay, 
                $loaiMua, 
                $tenKhuyenMai, 
                $phanTramGiamGia
            );

            if ($result) {
                header('Location: ?act=giaTour&maTour=' . $maTour . '&success=add');
            } else {
                header('Location: ?act=addGiaTour&maTour=' . $maTour . '&error=add');
            }
            exit();
        }
    }

    // Hiển thị form sửa giá tour
    public function editGiaTour()
    {
        $maGia = $_GET['id'] ?? null;
        
        if (!$maGia) {
            header('Location: ?act=tour');
            exit();
        }
        
        $giaTour = $this->giaTourModel->getGiaById($maGia);
        
        if (!$giaTour) {
            header('Location: ?act=tour');
            exit();
        }
        
        $viewFile = './views/tour/giatouredit.php';
        include './views/layout.php';
    }

    // Xử lý cập nhật giá tour
    public function editGiaTourProcess()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $maGia = $_POST['maGia'];
            $maTour = $_POST['maTour'];
            $loaiKhach = $_POST['loaiKhach'];
            $giaTien = $_POST['giaTien'];
            $apDungTuNgay = $_POST['apDungTuNgay'] ?? null;
            $apDungDenNgay = $_POST['apDungDenNgay'] ?? null;
            $loaiMua = $_POST['loaiMua'] ?? 'binh_thuong';
            $tenKhuyenMai = $_POST['tenKhuyenMai'] ?? null;
            $phanTramGiamGia = $_POST['phanTramGiamGia'] ?? 0;

            $result = $this->giaTourModel->updateGiaTour(
                $maGia,
                $loaiKhach, 
                $giaTien, 
                $apDungTuNgay, 
                $apDungDenNgay, 
                $loaiMua, 
                $tenKhuyenMai, 
                $phanTramGiamGia
            );

            if ($result) {
                header('Location: ?act=giaTour&maTour=' . $maTour . '&success=update');
            } else {
                header('Location: ?act=editGiaTour&id=' . $maGia . '&error=update');
            }
            exit();
        }
    }

    // Xóa giá tour
    public function deleteGiaTour()
    {
        $maGia = $_GET['id'] ?? null;
        $maTour = $_GET['maTour'] ?? null;
        
        if ($maGia) {
            $result = $this->giaTourModel->deleteGiaTour($maGia);
            
            if ($result) {
                header('Location: ?act=giaTour&maTour=' . $maTour . '&success=delete');
            } else {
                header('Location: ?act=giaTour&maTour=' . $maTour . '&error=delete');
            }
        } else {
            header('Location: ?act=giaTour&maTour=' . $maTour);
        }
        exit();
    }
}