<?php
class ThanhToanController
{
    public $model;

    public function __construct()
    {
        require_once './models/ThanhToanModel.php';
        $this->model = new ThanhToanModel();
    }

    public function listThanhToan()
    {
        $MaBooking = $_GET['MaBooking'] ?? null;

        $list = $this->model->getAll();              // danh sách thanh toán
        $listBooking = $this->model->getAllBooking(); // list booking để chọn

        // biến để view biết booking nào đang được chọn
        $selectedBooking = $MaBooking;

        $viewFile = './views/thanhToan/listThanhToan.php';
        include './views/layout.php';
    }

    public function addThanhToan()
    {
        $listBooking = $this->model->getAllBooking();
        $selectedBooking = $_GET['MaBooking'] ?? null; // <-- booking được chọn sẵn

        $viewFile = './views/thanhToan/addThanhToan.php';
        include './views/layout.php';
    }


    public function addThanhToanProcess()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Lấy MaBooking từ form thanh toán (bắt buộc form phải có field này)
            $MaBooking = $_POST['MaBooking'] ?? null;

            // Insert thanh toán
            $this->model->insert($_POST);

            // Recalc booking sau khi thanh toán
            if ($MaBooking) {
                require_once './models/BookingModel.php';
                $bm = new BookingModel();
                $bm->recalcPaymentByBooking($MaBooking);
            }

            header("Location: ?act=listThanhToan");
            exit();
        }
    }

    public function editThanhToan()
    {
        $id = $_GET['id'];
        $thanhToan = $this->model->getOne($id);
        $listBooking = $this->model->getAllBooking();
        $viewFile = './views/thanhToan/editThanhToan.php';
        include './views/layout.php';
    }

    public function editThanhToanProcess()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $MaBooking = $_POST['MaBooking'] ?? null;

            // Update thanh toán
            $this->model->update($_POST);

            // Recalc booking
            if ($MaBooking) {
                require_once './models/BookingModel.php';
                $bm = new BookingModel();
                $bm->recalcPaymentByBooking($MaBooking);
            }

            header("Location: ?act=listThanhToan");
            exit();
        }
    }

    public function deleteThanhToan()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: ?act=listThanhToan");
            exit();
        }

        // LẤY MaBooking TRƯỚC KHI XÓA (vì xóa xong là mất)
        $row = $this->model->getOne($id);
        $MaBooking = $row['MaBooking'] ?? null;

        $this->model->delete($id);

        // Recalc booking
        if ($MaBooking) {
            require_once './models/BookingModel.php';
            $bm = new BookingModel();
            $bm->recalcPaymentByBooking($MaBooking);
        }

        header("Location: ?act=listThanhToan");
        exit();
    }
}
