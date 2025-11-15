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
        $listTour = $this->modelTour->getAllTour();
        $viewFile = './views/tour/tour.php';
        include './views/layout.php';
    }
    public function viewTour()
    {
        $id = $_GET['id'];
        $tour = $this->modelTour->getOneTour($id);  // bạn cần thêm hàm này trong model
        $viewFile = './views/tour/xemTour.php';
        include './views/layout.php';
    }
    public function addTour()
    {
        $listDanhMuc = $this->modelTour->getDanhMucTour();
        $viewFile = './views/tour/addtour.php';
        include './views/layout.php';
    }
    public function addTourProcess()
    {
        $MaCodeTour = $_POST['MaCodeTour'];
        $TenTour = $_POST['TenTour'];
        $MaDanhMuc = $_POST['MaDanhMuc'];
        $SoNgay = $_POST['SoNgay'];
        $SoDem = $_POST['SoDem'];
        $DiemKhoiHanh = $_POST['DiemKhoiHanh'];
        $MoTa = $_POST['MoTa'];
        $GiaVonDuKien = $_POST['GiaVonDuKien'];
        $GiaBanMacDinh = $_POST['GiaBanMacDinh'];
        $LinkAnhBia = null;
        if (!empty($_FILES['LinkAnhBia']['name'])) {

            $uploadDir = "uploads/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = time() . "_" . basename($_FILES['LinkAnhBia']['name']);
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['LinkAnhBia']['tmp_name'], $targetPath)) {
                $LinkAnhBia = $targetPath; // Lưu đường dẫn file vào DB
            }
        }
        $ChinhSachBaoGom = $_POST['ChinhSachBaoGom'];
        $ChinhSachKhongBaoGom = $_POST['ChinhSachKhong'];
        $ChinhSachHuy = $_POST['ChinhSachHuyTour'];
        $TrangThai = $_POST['TrangThai'];
        $this->modelTour->addTour($MaCodeTour, $TenTour, $MaDanhMuc, $SoNgay, $SoDem, $DiemKhoiHanh, $MoTa, $GiaVonDuKien, $GiaBanMacDinh, $LinkAnhBia, $ChinhSachBaoGom, $ChinhSachKhongBaoGom, $ChinhSachHuy, $TrangThai);
        header("Location: ?act=tour");
        exit();
    }
    public function editTour()
    {
        $id = $_GET['id'];
        $tour = $this->modelTour->getOneTourEdit($id);
        $listDanhMuc = $this->modelTour->getDanhMucTour();

        $viewFile = './views/tour/suaTour.php';
        include './views/layout.php';
    }

    public function editTourProcess()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $MaTour = $_POST['MaTour'];

            // Xử lý upload ảnh mới
            $target_file = $_POST['old_image']; // ảnh cũ giữ nguyên

            if (isset($_FILES['LinkAnhBia']) && $_FILES['LinkAnhBia']['error'] == 0) {
                $dir = "./uploads/";
                if (!file_exists($dir)) mkdir($dir);
                $target_file = $dir . time() . "_" . basename($_FILES['LinkAnhBia']['name']);
                move_uploaded_file($_FILES['LinkAnhBia']['tmp_name'], $target_file);
            }

            // Gom dữ liệu
            $data = [
                ':MaTour' => $MaTour,
                ':MaCodeTour' => $_POST['MaCodeTour'],
                ':TenTour' => $_POST['TenTour'],
                ':MaDanhMuc' => $_POST['MaDanhMuc'],
                ':SoNgay' => $_POST['SoNgay'],
                ':SoDem' => $_POST['SoDem'],
                ':DiemKhoiHanh' => $_POST['DiemKhoiHanh'],
                ':MoTa' => $_POST['MoTa'],
                ':GiaVonDuKien' => $_POST['GiaVonDuKien'],
                ':GiaBanMacDinh' => $_POST['GiaBanMacDinh'],
                ':ChinhSachBaoGom' => $_POST['ChinhSachBaoGom'],
                ':ChinhSachKhongBaoGom' => $_POST['ChinhSachKhongBaoGom'],
                ':ChinhSachHuy' => $_POST['ChinhSachHuy'],
                ':TrangThai' => $_POST['TrangThai'],
                ':LinkAnhBia' => $target_file
            ];

            // Cập nhật
            $this->modelTour->updateTour($data);

            // Redirect
            header("Location: ?act=tour");
            exit();
        }
    }
    public function deleteTour()
    {
        $id = $_GET['id'];
        $this->modelTour->deleteTour($id);
        header("Location: ?act=tour");
        exit();
    }
}
