<?php
// Controller xử lý logic cho Lịch trình Tour
class LichTrinhController
{
    public $modelLichTrinh;

    public function __construct()
    {
        $this->modelLichTrinh = new LichTrinhModel();
    }

    // Hiển thị trang quản lý lịch trình
    // Hiển thị trang quản lý lịch trình
    public function lichTour()
    {
        $listTours = $this->modelLichTrinh->getAllTours();

        // Nếu không có tour nào, báo lỗi
        if (empty($listTours)) {
            die("Chưa có Tour nào trong hệ thống! Vui lòng thêm Tour trước.");
        }

        // Lấy MaTour từ URL, nếu không có thì lấy tour đầu tiên
        $maTour = isset($_GET['tour_id']) ? $_GET['tour_id'] : $listTours[0]['MaTour'];

        $currentTour = $this->modelLichTrinh->getTourById($maTour);
        $listLichTrinh = $this->modelLichTrinh->getAllLichTrinhByTour($maTour);

        $viewFile = './views/tour/lichTour.php';
        include './views/layout.php';
    }

    // Xử lý thêm lịch trình
    public function addLichTrinhProcess()
    {
        $maTour = $_POST['MaTour'];
        $ngayThu = $_POST['NgayThu'];
        $tieuDeNgay = $_POST['TieuDeNgay'];
        $diaDiemThamQuan = $_POST['DiaDiemThamQuan'];
        $noiO = $_POST['NoiO'];
        $coBuaSang = isset($_POST['CoBuaSang']) ? 1 : 0;
        $coBuaTrua = isset($_POST['CoBuaTrua']) ? 1 : 0;
        $coBuaToi = isset($_POST['CoBuaToi']) ? 1 : 0;
        $chiTietHoatDong = $_POST['ChiTietHoatDong'];

        $this->modelLichTrinh->addLichTrinh(
            $maTour,
            $ngayThu,
            $tieuDeNgay,
            $diaDiemThamQuan,
            $noiO,
            $coBuaSang,
            $coBuaTrua,
            $coBuaToi,
            $chiTietHoatDong
        );

        header("Location: ?act=lichTour&tour_id=" . $maTour);
        exit();
    }

    // Hiển thị form sửa lịch trình
    public function editLichTrinh()
    {
        $id = $_GET['id'];
        $lichTrinh = $this->modelLichTrinh->getLichTrinhById($id);

        $maTour = $lichTrinh['MaTour'];
        $listTours = $this->modelLichTrinh->getAllTours();
        $currentTour = $this->modelLichTrinh->getTourById($maTour);
        $listLichTrinh = $this->modelLichTrinh->getAllLichTrinhByTour($maTour);

        $viewFile = "./views/tour/suaLichTrinh.php";
        include "./views/layout.php";
    }

    // Xử lý cập nhật lịch trình
    public function editLichTrinhProcess()
    {
        $id = $_POST['MaLichTrinh'];
        $maTour = $_POST['MaTour'];
        $ngayThu = $_POST['NgayThu'];
        $tieuDeNgay = $_POST['TieuDeNgay'];
        $diaDiemThamQuan = $_POST['DiaDiemThamQuan'];
        $noiO = $_POST['NoiO'];
        $coBuaSang = isset($_POST['CoBuaSang']) ? 1 : 0;
        $coBuaTrua = isset($_POST['CoBuaTrua']) ? 1 : 0;
        $coBuaToi = isset($_POST['CoBuaToi']) ? 1 : 0;
        $chiTietHoatDong = $_POST['ChiTietHoatDong'];

        $this->modelLichTrinh->updateLichTrinh(
            $id,
            $maTour,
            $ngayThu,
            $tieuDeNgay,
            $diaDiemThamQuan,
            $noiO,
            $coBuaSang,
            $coBuaTrua,
            $coBuaToi,
            $chiTietHoatDong
        );

        header("Location: ?act=lichTour&tour_id=" . $maTour);
        exit();
    }

    // Xóa lịch trình
    public function deleteLichTrinh()
    {
        $id = $_GET['id'];
        $maTour = $_GET['tour_id'];

        $this->modelLichTrinh->deleteLichTrinh($id);

        header("Location: ?act=lichTour&tour_id=" . $maTour);
        exit();
    }
}
