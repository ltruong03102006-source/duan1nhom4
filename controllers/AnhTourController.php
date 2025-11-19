<?php
class AnhTourController
{
    public $modelAnh;
    public $modelTour;

    public function __construct()
    {
        $this->modelAnh = new AnhTourModel();
        $this->modelTour = new tourModel();
    }

    // Danh sách ảnh
    public function anhTour()
    {
        $MaTour = $_GET['MaTour'];
        $tour = $this->modelTour->getOneTour($MaTour);
        $listAnh = $this->modelAnh->getAllAnhByTour($MaTour);

        $viewFile = './views/tour/anhtour.php';
        include './views/layout.php';
    }

    // Form thêm
    public function addAnhTour()
    {
        $MaTour = $_GET['MaTour'];
        $tour = $this->modelTour->getOneTour($MaTour);

        $viewFile = './views/tour/anhtouradd.php';
        include './views/layout.php';
    }

    // Xử lý thêm
    public function addAnhTourProcess()
    {
        $MaTour = $_POST['MaTour'];
        $ChuThichAnh = $_POST['ChuThichAnh'];
        $ThuTu = $_POST['ThuTuHienThi'];

        // Upload file
        $filePath = null;

        if (!empty($_FILES['DuongDanAnh']['name'])) {
            $uploadDir = "uploads/anhtour/";
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $fileName = time() . "_" . basename($_FILES['DuongDanAnh']['name']);
            $filePath = $uploadDir . $fileName;

            move_uploaded_file($_FILES['DuongDanAnh']['tmp_name'], $filePath);
        }

        $this->modelAnh->addAnhTour($MaTour, $filePath, $ChuThichAnh, $ThuTu);

        header("Location: ?act=anhTour&MaTour=$MaTour");
    }

    // Xóa ảnh
    public function deleteAnhTour()
    {
        $MaAnh = $_GET['MaAnh'];
        $anh = $this->modelAnh->getOneAnh($MaAnh);

        // Xóa file vật lý
        if (file_exists($anh['DuongDanAnh'])) {
            unlink($anh['DuongDanAnh']);
        }

        $this->modelAnh->deleteAnh($MaAnh);

        header("Location: ?act=anhTour&MaTour=".$anh['MaTour']);
    }

    // Form sửa
    public function editAnhTour()
    {
        $MaAnh = $_GET['MaAnh'];
        $anh = $this->modelAnh->getOneAnh($MaAnh);

        $viewFile = './views/tour/anhtouredIt.php';
        include './views/layout.php';
    }

    // Xử lý sửa
    public function editAnhTourProcess()
    {
        $MaAnh = $_POST['MaAnh'];
        $MaTour = $_POST['MaTour'];
        $OldAnh = $_POST['OldAnh'];

        $ChuThichAnh = $_POST['ChuThichAnh'];
        $ThuTu = $_POST['ThuTuHienThi'];

        $filePath = $OldAnh;

        if (!empty($_FILES['DuongDanAnh']['name'])) {
            $uploadDir = "uploads/anhtour/";
            $fileName = time() . "_" . basename($_FILES['DuongDanAnh']['name']);
            $filePath = $uploadDir . $fileName;

            // Xóa ảnh cũ
            if (file_exists($OldAnh)) unlink($OldAnh);

            move_uploaded_file($_FILES['DuongDanAnh']['tmp_name'], $filePath);
        }

        $data = [
            ':MaAnh' => $MaAnh,
            ':DuongDanAnh' => $filePath,
            ':ChuThichAnh' => $ChuThichAnh,
            ':ThuTuHienThi' => $ThuTu
        ];

        $this->modelAnh->updateAnh($data);

        header("Location: ?act=anhTour&MaTour=$MaTour");
    }
}
