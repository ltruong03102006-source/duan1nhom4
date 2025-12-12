<?php
class DoanKhoiHanhController
{
    public $model;

    public function __construct()
    {
        $this->model = new DoanKhoiHanhModel();
    }

    public function listDoan()
    {
        $listDoan = $this->model->getAllDoan();
        $viewFile = './views/doan/listDoan.php';
        include './views/layout.php';
    }

    public function addDoan()
    {
        $listTour = $this->model->getListTour();
        $listHDV  = $this->model->getListHDV();
        $listTaiXe = $this->model->getListTaiXe();

        // Lấy ngày khởi hành để check bận (mặc định hôm nay)
        $selectedNgayKhoiHanh = $_GET['NgayKhoiHanh'] ?? date('Y-m-d');

        // Danh sách nhân viên bận trong ngày đó
        $busyIds = $this->model->getBusyNhanVienIdsByDate($selectedNgayKhoiHanh);

        $viewFile = './views/doan/addDoan.php';
        include './views/layout.php';
    }

    public function addDoanProcess()
    {
        $NgayKhoiHanh = $_POST['NgayKhoiHanh'] ?? null;
        $MaHuongDanVien = $_POST['MaHuongDanVien'] ?? '';
        $MaTaiXe = $_POST['MaTaiXe'] ?? '';

        // Check bận theo ngày khởi hành
        $busyIds = $this->model->getBusyNhanVienIdsByDate($NgayKhoiHanh);

        // Nếu chọn HDV/Tài xế mà nằm trong danh sách bận -> chặn
        if (!empty($MaHuongDanVien) && in_array((int)$MaHuongDanVien, array_map('intval', $busyIds), true)) {
            header("Location: ?act=addDoan&error=busy&role=hdv&NgayKhoiHanh=" . urlencode($NgayKhoiHanh));
            exit();
        }
        if (!empty($MaTaiXe) && in_array((int)$MaTaiXe, array_map('intval', $busyIds), true)) {
            header("Location: ?act=addDoan&error=busy&role=taixe&NgayKhoiHanh=" . urlencode($NgayKhoiHanh));
            exit();
        }

        $data = [
            ':MaTour' => $_POST['MaTour'],
            ':NgayKhoiHanh' => $_POST['NgayKhoiHanh'],
            ':GioKhoiHanh' => $_POST['GioKhoiHanh'],
            ':NgayVe' => $_POST['NgayVe'],
            ':DiemTapTrung' => $_POST['DiemTapTrung'],
            ':SoChoToiDa' => $_POST['SoChoToiDa'],
            ':SoChoConTrong' => $_POST['SoChoToiDa'],
            ':MaHuongDanVien' => $_POST['MaHuongDanVien'],
            ':MaTaiXe' => $_POST['MaTaiXe'],
            ':ThongTinXe' => $_POST['ThongTinXe']
        ];

        $this->model->addDoan($data);
        header("Location: ?act=listDoan&success=add");
        exit();
    }

   public function editDoan()
    {
        $id = $_GET['MaDoan'];

        $doan = $this->model->getOneDoan($id);
        
        // 1. Lấy thông tin sức chứa và số đã đặt
        $capacityInfo = $this->model->getCapacityInfo($id);
        
        // 2. Tính toán và thêm vào $doan
        $daDat = (int)($capacityInfo['DaDat'] ?? 0);
        $soChoToiDa = (int)($doan['SoChoToiDa'] ?? 0);
        $doan['DaDat'] = $daDat; // Thêm số khách đã đặt vào mảng $doan
        $doan['SoChoConTrong'] = max(0, $soChoToiDa - $daDat); // Tính số chỗ còn trống

        $listTour = $this->model->getListTour();
        $listHDV  = $this->model->getListHDV();
        $listTaiXe = $this->model->getListTaiXe();

        // Ngày khởi hành hiện tại để check bận
        $selectedNgayKhoiHanh = $doan['NgayKhoiHanh'] ?? date('Y-m-d');
        $busyIds = $this->model->getBusyNhanVienIdsByDate($selectedNgayKhoiHanh);

        $viewFile = './views/doan/editDoan.php';
        include './views/layout.php';
    }
   public function editDoanProcess()
    {
        $MaDoan = $_POST['MaDoan'];
        $NgayKhoiHanh = $_POST['NgayKhoiHanh'] ?? null;
        $MaHuongDanVien = $_POST['MaHuongDanVien'] ?? '';
        $MaTaiXe = $_POST['MaTaiXe'] ?? '';
        $SoChoToiDa = (int)$_POST['SoChoToiDa']; // Lấy số chỗ tối đa mới

        // Check bận
        $busyIds = $this->model->getBusyNhanVienIdsByDate($NgayKhoiHanh);

        // ... (Logic kiểm tra HDV/Tài xế bận - Giữ nguyên) ...

        // 1. Lấy thông tin số khách đã đặt hiện tại (DaDat)
        $capacityInfo = $this->model->getCapacityInfo($MaDoan);
        $daDat = (int)($capacityInfo['DaDat'] ?? 0);
        
        // 2. Kiểm tra ràng buộc: Số chỗ tối đa không được nhỏ hơn số khách đã đặt
        if ($SoChoToiDa < $daDat) {
             header("Location: ?act=editDoan&MaDoan=" . urlencode($MaDoan) . "&error=capacity_exceeded");
             exit();
        }
        
        // 3. Tính toán lại số chỗ còn trống
        $SoChoConTrong = max(0, $SoChoToiDa - $daDat);


        $data = [
            ':MaDoan' => $MaDoan,
            ':MaTour' => $_POST['MaTour'],
            ':NgayKhoiHanh' => $_POST['NgayKhoiHanh'],
            ':GioKhoiHanh' => $_POST['GioKhoiHanh'],
            ':NgayVe' => $_POST['NgayVe'],
            ':DiemTapTrung' => $_POST['DiemTapTrung'],
            ':SoChoToiDa' => $SoChoToiDa, 
            ':SoChoConTrong' => $SoChoConTrong, // Dùng giá trị tính toán
            ':MaHuongDanVien' => $_POST['MaHuongDanVien'],
            ':MaTaiXe' => $_POST['MaTaiXe'],
            ':ThongTinXe' => $_POST['ThongTinXe']
        ];

        $this->model->updateDoan($data);
        
        // Cập nhật lại trạng thái (con_cho, het_cho, da_huy) sau khi sửa SoChoToiDa
        $bookingModel = new BookingModel();
        $bookingModel->updateTrangThaiDoanBySoKhach($MaDoan);
        
        header("Location: ?act=listDoan&success=update");
        exit();
    }
    public function deleteDoan()
    {
        $id = $_GET['MaDoan'];

        // 1. Kiểm tra ràng buộc nghiệp vụ: Có booking thì không được xóa
        if ($this->model->checkBookingByDoan($id)) {
            // Chuyển hướng về trang danh sách kèm thông báo lỗi
            header("Location: ?act=listDoan&error=cannot_delete_has_booking");
            exit();
        }

        // 2. Nếu không có booking, thực hiện xóa (có thể dùng try-catch để an toàn hơn với các bảng khác như diemdanh, lichlamviec)
        try {
            $this->model->deleteDoan($id);
            header("Location: ?act=listDoan&success=delete");
        } catch (Exception $e) {
            // Bắt lỗi nếu còn ràng buộc ở các bảng khác (ví dụ: điểm danh, lịch làm việc...)
            header("Location: ?act=listDoan&error=system_error");
        }
        exit();
    }
}
