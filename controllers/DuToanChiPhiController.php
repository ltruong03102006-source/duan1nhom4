<?php
class DuToanChiPhiController
{
    public $duToanModel;

    public function __construct()
    {
        $this->duToanModel = new DuToanChiPhiModel();
    }

    // Hiển thị danh sách dự toán chi phí
    public function duToanChiPhi()
    {
        $maTour = $_GET['maTour'] ?? null;
        
        if ($maTour) {
            $danhSachDuToan = $this->duToanModel->getDuToanByTourId($maTour);
            $tongDuToan = $this->duToanModel->getTongDuToanByTourId($maTour);
            $tourInfo = $this->duToanModel->getAllTour();
            
            // Lấy tên tour
            $tenTour = '';
            $maCodeTour = '';
            foreach ($tourInfo as $tour) {
                if ($tour['MaTour'] == $maTour) {
                    $tenTour = $tour['TenTour'];
                    $maCodeTour = $tour['MaCodeTour'];
                    break;
                }
            }
            
            $viewFile = './views/tour/duToanchiphi.php';
            include './views/layout.php';
        } else {
            // Nếu không có maTour, redirect về trang tour
            header('Location: ?act=tour');
            exit();
        }
    }

    // Hiển thị form thêm dự toán
    public function addDuToan()
    {
        $maTour = $_GET['maTour'] ?? null;
        
        if (!$maTour) {
            header('Location: ?act=tour');
            exit();
        }
        
        $danhSachTour = $this->duToanModel->getAllTour();
        
        $viewFile = './views/tour/duToanadd.php';
        include './views/layout.php';
    }

    // Xử lý thêm dự toán
    public function addDuToanProcess()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $maTour = $_POST['maTour'];
            $hangMucChi = $_POST['hangMucChi'];
            $soTienDuKien = $_POST['soTienDuKien'];
            $ghiChu = $_POST['ghiChu'] ?? null;

            $result = $this->duToanModel->addDuToan(
                $maTour, 
                $hangMucChi, 
                $soTienDuKien, 
                $ghiChu
            );

            if ($result) {
                header('Location: ?act=duToanChiPhi&maTour=' . $maTour . '&success=add');
            } else {
                header('Location: ?act=addDuToan&maTour=' . $maTour . '&error=add');
            }
            exit();
        }
    }

    // Hiển thị form sửa dự toán
    public function editDuToan()
    {
        $maDuToan = $_GET['id'] ?? null;
        
        if (!$maDuToan) {
            header('Location: ?act=tour');
            exit();
        }
        
        $duToan = $this->duToanModel->getDuToanById($maDuToan);
        
        if (!$duToan) {
            header('Location: ?act=tour');
            exit();
        }
        
        $viewFile = './views/tour/duToanedit.php';
        include './views/layout.php';
    }

    // Xử lý cập nhật dự toán
    public function editDuToanProcess()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $maDuToan = $_POST['maDuToan'];
            $maTour = $_POST['maTour'];
            $hangMucChi = $_POST['hangMucChi'];
            $soTienDuKien = $_POST['soTienDuKien'];
            $ghiChu = $_POST['ghiChu'] ?? null;

            $result = $this->duToanModel->updateDuToan(
                $maDuToan,
                $hangMucChi, 
                $soTienDuKien, 
                $ghiChu
            );

            if ($result) {
                header('Location: ?act=duToanChiPhi&maTour=' . $maTour . '&success=update');
            } else {
                header('Location: ?act=editDuToan&id=' . $maDuToan . '&error=update');
            }
            exit();
        }
    }

    // Xóa dự toán
    public function deleteDuToan()
    {
        $maDuToan = $_GET['id'] ?? null;
        $maTour = $_GET['maTour'] ?? null;
        
        if ($maDuToan) {
            $result = $this->duToanModel->deleteDuToan($maDuToan);
            
            if ($result) {
                header('Location: ?act=duToanChiPhi&maTour=' . $maTour . '&success=delete');
            } else {
                header('Location: ?act=duToanChiPhi&maTour=' . $maTour . '&error=delete');
            }
        } else {
            header('Location: ?act=duToanChiPhi&maTour=' . $maTour);
        }
        exit();
    }
}