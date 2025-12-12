<?php
// controllers/DichVuCuaDoanController.php
class DichVuCuaDoanController
{
    public $model;

    public function __construct()
    {
        // Phải đảm bảo DichVuCuaDoanModel đã được require trong index.php
        $this->model = new DichVuCuaDoanModel();
    }

    // 1. Hiển thị danh sách dịch vụ của một đoàn
    public function listDichVu()
    {
        $maDoan = $_GET['maDoan'] ?? null;
        if (!$maDoan) {
            header("Location: ?act=listDoan");
            exit();
        }

        $doan = $this->model->getDoanInfo($maDoan);
        $listDichVu = $this->model->getAllDichVuByDoan($maDoan);
        
        $viewFile = './views/dichvu/listDichVu.php';
        include './views/layout.php';
    }

    // 2. Form thêm dịch vụ
    public function addDichVu()
    {
        $maDoan = $_GET['maDoan'] ?? null;
        if (!$maDoan) {
            header("Location: ?act=listDoan");
            exit();
        }
        
        $doan = $this->model->getDoanInfo($maDoan);
        $listNhaCungCap = $this->model->getListNhaCungCap();
        
        $viewFile = './views/dichvu/addDichVu.php';
        include './views/layout.php';
    }

    // 3. Xử lý thêm dịch vụ
    // 3. Xử lý thêm dịch vụ (Nhiều dòng cùng lúc)
    public function addDichVuProcess()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 1. Lấy thông tin chung
            $maDoan = $_POST['MaDoan'];
            $maNhaCungCap = !empty($_POST['MaNhaCungCap']) ? $_POST['MaNhaCungCap'] : null;
            $ngayDat = !empty($_POST['NgayDat']) ? $_POST['NgayDat'] : null;
            $trangThaiXacNhan = $_POST['TrangThaiXacNhan'];

            // 2. Lấy các mảng dữ liệu chi tiết
            // Lưu ý: Các biến này sẽ là Array do form đặt tên có [] (VD: name="TenDichVu[]")
            $loaiDichVuArr = $_POST['LoaiDichVu']; 
            $tenDichVuArr  = $_POST['TenDichVu'];
            $ngaySuDungArr = $_POST['NgaySuDung'];
            $soLuongArr    = $_POST['SoLuong'];
            $donGiaArr     = $_POST['DonGia'];
            $ghiChuArr     = $_POST['GhiChu'] ?? []; // Có thể null

            // Biến kiểm tra kết quả
            $successCount = 0;
            $totalItems = count($loaiDichVuArr);

            // 3. Vòng lặp duyệt qua từng dòng để insert
            for ($i = 0; $i < $totalItems; $i++) {
                // Tính toán dữ liệu cho dòng thứ $i
                $soLuong = (int)$soLuongArr[$i];
                $donGia = (float)$donGiaArr[$i];
                $tongTien = $soLuong * $donGia;

                $data = [
                    ':MaDoan' => $maDoan,
                    ':LoaiDichVu' => $loaiDichVuArr[$i],
                    ':MaNhaCungCap' => $maNhaCungCap, // Dùng chung
                    ':TenDichVu' => $tenDichVuArr[$i],
                    ':NgayDat' => $ngayDat,           // Dùng chung
                    ':NgaySuDung' => $ngaySuDungArr[$i],
                    ':SoLuong' => $soLuong,
                    ':DonGia' => $donGia,
                    ':TongTien' => $tongTien,
                    ':TrangThaiXacNhan' => $trangThaiXacNhan, // Dùng chung
                    ':GhiChu' => $ghiChuArr[$i] ?? null
                ];

                // Gọi Model để thêm dòng này
                if ($this->model->addDichVu($data)) {
                    $successCount++;
                }
            }

            // 4. Chuyển hướng sau khi xử lý xong
            $location = "?act=listDichVu&maDoan=$maDoan";
            if ($successCount > 0) {
                // Nếu thêm được ít nhất 1 cái thì báo thành công
                header("Location: $location&success=add_multi&count=$successCount");
            } else {
                header("Location: $location&error=add_failed");
            }
            exit();
        }
    }

    // 4. Form sửa dịch vụ
    public function editDichVu()
    {
        $maDichVu = $_GET['id'] ?? null;
        if (!$maDichVu) {
            header("Location: ?act=listDoan");
            exit();
        }

        $dichVu = $this->model->getOneDichVu($maDichVu);
        if (!$dichVu) {
            header("Location: ?act=listDoan&error=not_found");
            exit();
        }
        
        $doan = $this->model->getDoanInfo($dichVu['MaDoan']);
        $listNhaCungCap = $this->model->getListNhaCungCap();
        
        $viewFile = './views/dichvu/editDichVu.php';
        include './views/layout.php';
    }

    // 5. Xử lý sửa dịch vụ
    public function editDichVuProcess()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maDichVu = $_POST['MaDichVu'];
            $maDoan = $_POST['MaDoan'];
            $soLuong = (int)$_POST['SoLuong'];
            $donGia = (float)$_POST['DonGia'];
            $tongTien = $soLuong * $donGia; // Tính lại tổng tiền

            $data = [
                ':MaDichVu' => $maDichVu,
                ':LoaiDichVu' => $_POST['LoaiDichVu'],
                ':MaNhaCungCap' => $_POST['MaNhaCungCap'] ?: null,
                ':TenDichVu' => $_POST['TenDichVu'],
                ':NgayDat' => $_POST['NgayDat'] ?: null,
                ':NgaySuDung' => $_POST['NgaySuDung'],
                ':SoLuong' => $soLuong,
                ':DonGia' => $donGia,
                ':TongTien' => $tongTien,
                ':TrangThaiXacNhan' => $_POST['TrangThaiXacNhan'],
                ':GhiChu' => $_POST['GhiChu'] ?? null
            ];

            $result = $this->model->updateDichVu($data);
            $location = "?act=listDichVu&maDoan=$maDoan";
            if ($result) {
                header("Location: $location&success=update");
            } else {
                header("Location: $location&error=update_failed");
            }
            exit();
        }
    }

    // 6. Xóa dịch vụ
    public function deleteDichVu()
    {
        $maDichVu = $_GET['id'] ?? null;
        $maDoan = $_GET['maDoan'] ?? null;
        
        if (!$maDichVu || !$maDoan) {
            header("Location: ?act=listDoan");
            exit();
        }

        $result = $this->model->deleteDichVu($maDichVu);
        $location = "?act=listDichVu&maDoan=$maDoan";
        
        if ($result) {
            header("Location: $location&success=delete");
        } else {
            header("Location: $location&error=delete_failed");
        }
        exit();
    }
}