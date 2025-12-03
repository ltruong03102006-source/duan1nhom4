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

            $MaNhanVien = $_POST['MaNhanVien'] ?? null;
            $TuNgay     = $_POST['TuNgay'] ?? '';
            $DenNgay    = $_POST['DenNgay'] ?? '';
            $TrangThai  = $_POST['TrangThai'] ?? '';
            $MaDoan     = (!empty($_POST['MaDoan'])) ? $_POST['MaDoan'] : null;
            $GhiChu     = $_POST['GhiChu'] ?? null;

            // validate
            if (!$MaNhanVien || !$TuNgay || !$DenNgay || $TuNgay > $DenNgay) {
                header("Location: ?act=listLichLamViec&error=date_range");
                exit();
            }

            $start = new DateTime($TuNgay);
            $end   = new DateTime($DenNgay);
            $end->modify('+1 day'); // include ngày cuối

            $okAll = true;

            for ($d = clone $start; $d < $end; $d->modify('+1 day')) {
                $NgayLamViec = $d->format('Y-m-d');

                // nếu bạn có hàm check trùng thì dùng ở đây (khuyến nghị)
                if (method_exists($this->modelLichLamViec, 'existsLichLamViec')) {
                    if ($this->modelLichLamViec->existsLichLamViec($MaNhanVien, $NgayLamViec)) {
                        continue; // đã có lịch ngày đó thì bỏ qua
                    }
                }

                $ok = $this->modelLichLamViec->addLichLamViec(
                    $MaNhanVien,
                    $NgayLamViec,
                    $TrangThai,
                    $MaDoan,
                    $GhiChu
                );

                if (!$ok) $okAll = false;
            }

            if ($okAll) header("Location: ?act=listLichLamViec&success=add");
            else header("Location: ?act=listLichLamViec&error=add_failed");
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
