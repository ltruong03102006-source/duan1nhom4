<?php
// Class chứa các function thực thi xử lý logic cho LichLamViec
class LichLamViecController
{
    public $modelLichLamViec;

    public function __construct()
    {
        $this->modelLichLamViec = new LichLamViecModel();
    }

   // Hiển thị trang quản lý lịch làm việc (danh sách và form thêm mới)
    public function listLichLamViec()
    {
        $keyword = $_GET['keyword'] ?? null; // Lấy keyword từ URL
        
        // Truyền keyword vào model để lọc
        $listLichLamViec = $this->modelLichLamViec->getAllLichLamViec($keyword); 
        
        $listNhanVien = $this->modelLichLamViec->getAllNhanVien();
        $listDoan = $this->modelLichLamViec->getAllDoanKhoiHanh();

        $viewFile = './views/nhanvien/lichLamViec.php';
        include './views/layout.php';
    }

    // Xử lý thêm lịch làm việc
// Sửa hàm addLichLamViecProcess
public function addLichLamViecProcess()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $MaNhanVien = $_POST['MaNhanVien'];
        $NgayLamViec = $_POST['NgayLamViec'];
        $TrangThai = $_POST['TrangThai'];
        $MaDoan = $_POST['MaDoan'] ?: null; // MaDoan là null nếu chuỗi rỗng
        $GhiChu = $_POST['GhiChu'] ?? null;

        // Bỏ qua $ThoiGianBatDau vì cột này không tồn tại
        
        $result = $this->modelLichLamViec->addLichLamViec(
            $MaNhanVien,
            $NgayLamViec,
            $TrangThai,
            $MaDoan,
            $GhiChu // Chỉ truyền 5 tham số
        );

        // Thêm logic chuyển hướng để tránh màn hình trắng và báo trạng thái
        if ($result) {
            header("Location: ?act=listLichLamViec&success=add");
        } else {
            // Chuyển hướng về trang danh sách với thông báo lỗi
            header("Location: ?act=listLichLamViec&error=add_failed"); 
        }
        exit();
    }
}

    // Xóa lịch làm việc
    public function deleteLichLamViec()
    {
        $id = $_GET['id'];
        $this->modelLichLamViec->deleteLichLamViec($id);
        header("Location: ?act=listLichLamViec&success=delete");
        exit();
    }
}