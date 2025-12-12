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
        $MaTourMoi = $_POST['MaTour']; // Mã tour người dùng chọn
        
        // --- BẮT ĐẦU ĐOẠN CODE KIỂM TRA LOGIC SỬA TOUR ---
        
        // 1. Lấy thông tin đoàn cũ để biết MaTour cũ
        $doanCu = $this->model->getOneDoan($MaDoan);
        $MaTourCu = $doanCu['MaTour'];

        // 2. Kiểm tra xem đoàn đã có booking hay chưa
        // Hàm checkBookingByDoan trả về true nếu có ít nhất 1 booking
        $daCoBooking = $this->model->checkBookingByDoan($MaDoan); 

        // 3. Nếu đã có booking MÀ người dùng cố tình đổi sang Tour khác -> Chặn lại
        if ($daCoBooking && $MaTourMoi != $MaTourCu) {
            // Chuyển hướng lại trang sửa và báo lỗi
            header("Location: ?act=editDoan&MaDoan=" . urlencode($MaDoan) . "&error=cannot_change_tour_has_booking");
            exit();
        }
        // --- KẾT THÚC ĐOẠN CODE KIỂM TRA ---

        $NgayKhoiHanh = $_POST['NgayKhoiHanh'] ?? null;
        $MaHuongDanVien = $_POST['MaHuongDanVien'] ?? '';
        $MaTaiXe = $_POST['MaTaiXe'] ?? '';

        // Check bận
        $busyIds = $this->model->getBusyNhanVienIdsByDate($NgayKhoiHanh);

        // Nếu nhân viên bận vì đoàn khác -> chặn
        if (!empty($MaHuongDanVien) && in_array((int)$MaHuongDanVien, array_map('intval', $busyIds), true)) {
            header("Location: ?act=editDoan&MaDoan=" . urlencode($MaDoan) . "&error=busy&role=hdv");
            exit();
        }
        if (!empty($MaTaiXe) && in_array((int)$MaTaiXe, array_map('intval', $busyIds), true)) {
            header("Location: ?act=editDoan&MaDoan=" . urlencode($MaDoan) . "&error=busy&role=taixe");
            exit();
        }

        $data = [
            ':MaDoan' => $_POST['MaDoan'],
            ':MaTour' => $_POST['MaTour'],
            ':NgayKhoiHanh' => $_POST['NgayKhoiHanh'],
            ':GioKhoiHanh' => $_POST['GioKhoiHanh'],
            ':NgayVe' => $_POST['NgayVe'],
            ':DiemTapTrung' => $_POST['DiemTapTrung'],
            ':SoChoToiDa' => $_POST['SoChoToiDa'],
            ':SoChoConTrong' => $_POST['SoChoConTrong'], // Lưu ý: logic gốc của bạn đang lấy từ POST, cần đảm bảo tính đúng đắn khi update
            ':MaHuongDanVien' => $_POST['MaHuongDanVien'],
            ':MaTaiXe' => $_POST['MaTaiXe'],
            ':ThongTinXe' => $_POST['ThongTinXe']
        ];

        $this->model->updateDoan($data);
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
