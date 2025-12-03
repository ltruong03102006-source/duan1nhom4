<?php
class NhatKyTourController
{
    private $model;

    public function __construct()
    {
        $this->model = new NhatKyTourModel();
    }

    // ADMIN xem toàn bộ nhật ký tour
    public function adminList()
    {
        onlyAdmin();
        $list = $this->model->getAll();
        $viewFile = "./views/nhatky/admin_list.php";
        include "./views/layout.php";
    }

    // HDV xem nhật ký đoàn mình
    public function hdvList()
    {
        onlyHDV();
        $maDoan = $_GET['MaDoan'];

        $list = $this->model->getByDoan($maDoan);
        $viewFile = "./views/nhatky/hdv_list.php";
        include "./views/layout.php";
    }

    // HDV thêm nhật ký
    public function addProcess()
    {
        onlyHDV();

        $maDoan = $_POST['MaDoan'];
        $noidung = $_POST['NoiDung'];
        $loai = $_POST['LoaiSuCo'] ?? null;

        $linkAnh = null;
        if (!empty($_FILES['LinkAnh']['name'])) {
            $folder = "./uploads/nhatky/";
            if (!is_dir($folder)) mkdir($folder, 0777, true);

            $file = time() . "_" . $_FILES['LinkAnh']['name'];
            $path = $folder . $file;

            if (move_uploaded_file($_FILES['LinkAnh']['tmp_name'], $path)) {
                $linkAnh = $path;
            }
        }

        $data = [
            ':MaDoan' => $maDoan,
            ':NgayGhi' => date("Y-m-d"),
            ':GioGhi' => date("H:i:s"),
            ':NoiDung' => $noidung,
            ':LoaiSuCo' => $loai,
            ':LinkAnh' => $linkAnh,
            ':MaNguoiTao' => $_SESSION['user']['MaNhanVien']
        ];

        $this->model->add($data);

        header("Location: ?act=nhatky_hdv&MaDoan=$maDoan&success=1");
        exit;
    }
}
