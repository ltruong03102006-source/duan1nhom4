<?php
class AnhTourController
{
    public $modelAnh;
    public $modelTour;

    public function __construct()
    {
        $this->modelAnh = new AnhTourModel();
        $this->modelTour = new tourModel();
    }

    // Danh sách ảnh
    public function anhTour()
    {
        $MaTour = $_GET['MaTour'];
        $tour = $this->modelTour->getOneTour($MaTour);
        $listAnh = $this->modelAnh->getAllAnhByTour($MaTour);

        $viewFile = './views/tour/anhtour.php';
        include './views/layout.php';
    }

    // Form thêm
    public function addAnhTour()
    {
        $MaTour = $_GET['MaTour'];
        $tour = $this->modelTour->getOneTour($MaTour);

        $viewFile = './views/tour/anhtouradd.php';
        include './views/layout.php';
    }

    // Xử lý thêm
    public function addAnhTourProcess()
{
    // Nếu bạn có phân quyền thì mở dòng này
    // onlyAdmin();

    // 1. Lấy dữ liệu
    $MaTour = $_POST['MaTour'] ?? 0;
    if (!$MaTour) {
        die('Thiếu mã tour');
    }

    // Mảng chú thích theo từng ảnh
    $captions = $_POST['ChuThichAnh'] ?? [];

    // 2. Lấy thứ tự hiển thị lớn nhất hiện tại của tour
    $maxThuTu = $this->modelAnh->getMaxThuTu($MaTour);
    $nextThuTu = $maxThuTu + 1;

    // 3. Kiểm tra có file upload không
    if (
        !isset($_FILES['DuongDanAnh']) ||
        empty($_FILES['DuongDanAnh']['name'][0])
    ) {
        // Không có ảnh → quay lại
        header("Location: ?act=anhTour&MaTour=$MaTour");
        exit;
    }

    // 4. Thư mục upload
    $uploadDir = 'uploads/anhtour/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileNames = $_FILES['DuongDanAnh']['name'];
    $tmpNames  = $_FILES['DuongDanAnh']['tmp_name'];
    $errors    = $_FILES['DuongDanAnh']['error'];
    $sizes     = $_FILES['DuongDanAnh']['size'];

    // 5. Cấu hình validate (khuyến nghị)
    $allowExt = ['jpg', 'jpeg', 'png', 'webp'];
    $maxSize  = 2 * 1024 * 1024; // 2MB

    // 6. Lặp từng ảnh
    for ($i = 0; $i < count($fileNames); $i++) {

        // Bỏ qua file lỗi
        if ($errors[$i] !== UPLOAD_ERR_OK) {
            continue;
        }

        // Validate size
        if ($sizes[$i] > $maxSize) {
            continue;
        }

        // Validate extension
        $ext = strtolower(pathinfo($fileNames[$i], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowExt)) {
            continue;
        }

        // Tạo tên file an toàn
        $newFileName = time() . '_' . uniqid() . '.' . $ext;
        $filePath = $uploadDir . $newFileName;

        // Upload file
        if (move_uploaded_file($tmpNames[$i], $filePath)) {

            // Lấy chú thích đúng index
            $caption = $captions[$i] ?? '';

            // Lưu DB
            $this->modelAnh->addAnhTour(
                $MaTour,
                $filePath,
                $caption,
                $nextThuTu
            );

            // Tăng thứ tự hiển thị
            $nextThuTu++;
        }
    }

    // 7. Quay về trang quản lý ảnh
    header("Location: ?act=anhTour&MaTour=$MaTour");
    exit;
}



    // Xóa ảnh
    public function deleteAnhTour()
{
    $MaAnh = $_GET['MaAnh'];
    $anh = $this->modelAnh->getOneAnh($MaAnh);

    // Xóa file vật lý theo PATH_ROOT
    deleteFile($anh['DuongDanAnh']); // helper của bạn :contentReference[oaicite:17]{index=17}

    $this->modelAnh->deleteAnh($MaAnh);
    header("Location: ?act=anhTour&MaTour=".$anh['MaTour']);
}


    // Form sửa
    public function editAnhTour()
    {
        $MaAnh = $_GET['MaAnh'];
        $anh = $this->modelAnh->getOneAnh($MaAnh);

        $viewFile = './views/tour/anhtouredIt.php';
        include './views/layout.php';
    }

    // Xử lý sửa
    public function editAnhTourProcess()
    {
        $MaAnh = $_POST['MaAnh'];
        $MaTour = $_POST['MaTour'];
        $OldAnh = $_POST['OldAnh'];

        $ChuThichAnh = $_POST['ChuThichAnh'];
        $ThuTu = $_POST['ThuTuHienThi'];

        $filePath = $OldAnh;

        if (!empty($_FILES['DuongDanAnh']['name'])) {
            $uploadDir = "uploads/anhtour/";
            $fileName = time() . "_" . basename($_FILES['DuongDanAnh']['name']);
            $filePath = $uploadDir . $fileName;

            // Xóa ảnh cũ
            if (file_exists($OldAnh)) unlink($OldAnh);

            move_uploaded_file($_FILES['DuongDanAnh']['tmp_name'], $filePath);
        }

        $data = [
            ':MaAnh' => $MaAnh,
            ':DuongDanAnh' => $filePath,
            ':ChuThichAnh' => $ChuThichAnh,
            ':ThuTuHienThi' => $ThuTu
        ];

        $this->modelAnh->updateAnh($data);

        header("Location: ?act=anhTour&MaTour=$MaTour");
    }
}
