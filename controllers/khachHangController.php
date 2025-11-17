// File: vuanh-duan/duan1nhom4/controllers/khachHangController.php
<?php
// Class chứa các function thực thi xử lý logic cho Khách Hàng
class KhachHangController
{
    public $modelKhachHang;

    public function __construct()
    {
        $this->modelKhachHang = new KhachHangModel();
    }

    // 1. Danh sách Khách hàng
    public function listKhachHang()
    {
        $listKhachHang = $this->modelKhachHang->getAllKhachHang();
        $viewFile = './views/khachhang/listKhachHang.php';
        include './views/layout.php';
    }

    // 2. Thêm Khách hàng (Hiển thị form)
    public function addKhachHang()
    {
        $viewFile = './views/khachhang/addKhachHang.php';
        include './views/layout.php';
    }

    // 3. Xử lý Thêm Khách hàng
    public function addKhachHangProcess()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                ':MaCodeKhachHang' => $_POST['MaCodeKhachHang'],
                ':HoTen' => $_POST['HoTen'],
                ':SoDienThoai' => $_POST['SoDienThoai'],
                ':Email' => $_POST['Email'],
                ':DiaChi' => $_POST['DiaChi'],
                ':NgaySinh' => $_POST['NgaySinh'],
                ':GioiTinh' => $_POST['GioiTinh'],
                ':SoGiayTo' => $_POST['SoGiayTo'],
                ':LoaiKhach' => $_POST['LoaiKhach'],
                ':TenCongTy' => $_POST['TenCongTy'] ?? null,
                ':MaSoThue' => $_POST['MaSoThue'] ?? null,
                ':GhiChu' => $_POST['GhiChu']
            ];

            $this->modelKhachHang->addKhachHang($data);
            header("Location: ?act=listKhachHang");
            exit();
        }
    }

    // 4. Sửa Khách hàng (Hiển thị form)
    public function editKhachHang()
    {
        $id = $_GET['id'];
        $khachHang = $this->modelKhachHang->getOneKhachHang($id);
        $viewFile = './views/khachhang/editKhachHang.php';
        include './views/layout.php';
    }

    // 5. Xử lý Sửa Khách hàng
    public function updateKhachHangProcess()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                ':MaKhachHang' => $_POST['MaKhachHang'],
                ':HoTen' => $_POST['HoTen'],
                ':SoDienThoai' => $_POST['SoDienThoai'],
                ':Email' => $_POST['Email'],
                ':DiaChi' => $_POST['DiaChi'],
                ':NgaySinh' => $_POST['NgaySinh'],
                ':GioiTinh' => $_POST['GioiTinh'],
                ':SoGiayTo' => $_POST['SoGiayTo'],
                ':LoaiKhach' => $_POST['LoaiKhach'],
                ':TenCongTy' => $_POST['TenCongTy'] ?? null,
                ':MaSoThue' => $_POST['MaSoThue'] ?? null,
                ':GhiChu' => $_POST['GhiChu']
            ];

            $this->modelKhachHang->updateKhachHang($data);
            header("Location: ?act=listKhachHang");
            exit();
        }
    }

    // 6. Xóa Khách hàng
    public function deleteKhachHang()
    {
        $id = $_GET['id'];
        $this->modelKhachHang->deleteKhachHang($id);
        header("Location: ?act=listKhachHang");
        exit();
    }
}