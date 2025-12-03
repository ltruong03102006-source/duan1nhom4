<?php
// có class chứa các function thực thi xử lý logic 
class tourController
{
    public $modelTour;

    public function __construct()
    {
        $this->modelTour = new tourModel();
    }

    // Hiển thị danh sách tour
    public function tour()
    {
        $listTour = $this->modelTour->getAllTour();
        $viewFile = './views/tour/tour.php';
        include './views/layout.php';
    }

    // Xem chi tiết tour
    public function viewTour()
    {
        $id = $_GET['id'];
        $tour = $this->modelTour->getOneTour($id);
        $viewFile = './views/tour/xemTour.php';
        include './views/layout.php';
    }

    // Hiển thị form thêm tour
    public function addTour()
    {
        $listDanhMuc = $this->modelTour->getDanhMucTour();
        $viewFile = './views/tour/addtour.php';
        include './views/layout.php';
    }

    // Xử lý thêm tour
    public function addTourProcess()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Nhận dữ liệu từ form
            $MaCodeTour = $_POST['MaCodeTour'];
            $TenTour = $_POST['TenTour'];
            $MaDanhMuc = $_POST['MaDanhMuc'];
            $SoNgay = $_POST['SoNgay'];
            $SoDem = $_POST['SoDem'];
            $DiemKhoiHanh = $_POST['DiemKhoiHanh'] ?? null;
            $MoTa = $_POST['MoTa'] ?? null;
            $GiaVonDuKien = $_POST['GiaVonDuKien'] ?? 0;
            $GiaBanMacDinh = $_POST['GiaBanMacDinh'];
            $ChinhSachBaoGom = $_POST['ChinhSachBaoGom'] ?? null;
            $ChinhSachKhongBaoGom = $_POST['ChinhSachKhongBaoGom'] ?? null;
            $ChinhSachHuy = $_POST['ChinhSachHuy'] ?? null;
            $ChinhSachHoanTien = $_POST['ChinhSachHoanTien'] ?? null;
            $DuongDanDatTour = $_POST['DuongDanDatTour'] ?? null;
            $TrangThai = $_POST['TrangThai'];

            // Xử lý upload ảnh
            $LinkAnhBia = null;
            if (!empty($_FILES['LinkAnhBia']['name'])) {
                $uploadDir = "uploads/";
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = time() . "_" . basename($_FILES['LinkAnhBia']['name']);
                $targetPath = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['LinkAnhBia']['tmp_name'], $targetPath)) {
                    $LinkAnhBia = $targetPath;
                }
            }

            // Gọi model để thêm tour
            $this->modelTour->addTour(
                $MaCodeTour,
                $TenTour,
                $MaDanhMuc,
                $SoNgay,
                $SoDem,
                $DiemKhoiHanh,
                $MoTa,
                $GiaVonDuKien,
                $GiaBanMacDinh,
                $LinkAnhBia,
                $ChinhSachBaoGom,
                $ChinhSachKhongBaoGom,
                $ChinhSachHuy,
                $ChinhSachHoanTien,
                $DuongDanDatTour,
                $TrangThai
            );

            header("Location: ?act=tour&success=add");
            exit();
        }
    }

    // Hiển thị form sửa tour
    public function editTour()
    {
        $id = $_GET['id'];
        $tour = $this->modelTour->getOneTourEdit($id);
        $listDanhMuc = $this->modelTour->getDanhMucTour();
        $viewFile = './views/tour/suaTour.php';
        include './views/layout.php';
    }

    // Xử lý cập nhật tour
    public function editTourProcess()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $MaTour = $_POST['MaTour'];

            // Xử lý upload ảnh mới
            $target_file = $_POST['old_image']; // ảnh cũ giữ nguyên

            if (isset($_FILES['LinkAnhBia']) && $_FILES['LinkAnhBia']['error'] == 0) {
                $dir = "./uploads/";
                if (!file_exists($dir)) mkdir($dir, 0777, true);
                $target_file = $dir . time() . "_" . basename($_FILES['LinkAnhBia']['name']);
                move_uploaded_file($_FILES['LinkAnhBia']['tmp_name'], $target_file);
            }

            // Gom dữ liệu đầy đủ
            $data = [
                ':MaTour' => $MaTour,
                ':MaCodeTour' => $_POST['MaCodeTour'],
                ':TenTour' => $_POST['TenTour'],
                ':MaDanhMuc' => $_POST['MaDanhMuc'],
                ':SoNgay' => $_POST['SoNgay'],
                ':SoDem' => $_POST['SoDem'],
                ':DiemKhoiHanh' => $_POST['DiemKhoiHanh'] ?? null,
                ':MoTa' => $_POST['MoTa'] ?? null,
                ':GiaVonDuKien' => $_POST['GiaVonDuKien'] ?? 0,
                ':GiaBanMacDinh' => $_POST['GiaBanMacDinh'],
                ':ChinhSachBaoGom' => $_POST['ChinhSachBaoGom'] ?? null,
                ':ChinhSachKhongBaoGom' => $_POST['ChinhSachKhongBaoGom'] ?? null,
                ':ChinhSachHuy' => $_POST['ChinhSachHuy'] ?? null,
                ':ChinhSachHoanTien' => $_POST['ChinhSachHoanTien'] ?? null,
                ':DuongDanDatTour' => $_POST['DuongDanDatTour'] ?? null,
                ':TrangThai' => $_POST['TrangThai'],
                ':LinkAnhBia' => $target_file
            ];

            // Cập nhật
            $this->modelTour->updateTour($data);

            // Redirect
            header("Location: ?act=tour&success=update");
            exit();
        }
    }

    // Xóa tour
    public function deleteTour()
    {
        $id = $_GET['id'];
        $this->modelTour->deleteTour($id);
        header("Location: ?act=tour&success=delete");
        exit();
    }

    // Xem tour cho HƯỚNG DẪN VIÊN (xem tổng hợp đầy đủ)
    public function xemTourHDV()
    {
        $id = $_GET['id'];
        
        // Lấy thông tin tour
        $tour = $this->modelTour->getOneTour($id);
        
        // Lấy lịch trình
        $lichTrinh = $this->modelTour->getLichTrinhByTourId($id);
        
        // Lấy giá tour
        $giaTour = $this->modelTour->getGiaTourByTourId($id);
        
        // Lấy dự toán chi phí
        $duToan = $this->modelTour->getDuToanByTourId($id);
        
        $viewFile = './views/tour/xemTourHDV.php';
        include './views/layout.php';
    }
}