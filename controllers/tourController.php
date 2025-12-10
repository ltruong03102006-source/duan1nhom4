<?php
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
    public function addTour() {
        $listDanhMuc = $this->modelTour->getDanhMucTour();
        // Khởi tạo biến để tránh lỗi Undefined variable ở View
        $errors = [];
        $oldData = [];
        
        $viewFile = './views/tour/addtour.php';
        include './views/layout.php';
    }

    // --- XỬ LÝ FORM THÊM TOUR (PROCESS) ---
    public function addTourProcess()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            // 1. LẤY DỮ LIỆU TỪ FORM
            $post = $_POST;
            $MaCodeTour = trim($post['MaCodeTour'] ?? '');
            $TenTour    = trim($post['TenTour'] ?? '');
            $MaDanhMuc  = $post['MaDanhMuc'] ?? '';
            $SoNgay     = isset($post['SoNgay']) ? intval($post['SoNgay']) : -1; // -1 để check chưa nhập
            $SoDem      = isset($post['SoDem']) ? intval($post['SoDem']) : -1;

            // 2. KIỂM TRA LỖI (VALIDATION)
            $errors = [];

            // --- 2a. Check Mã Tour ---
            if (empty($MaCodeTour)) {
                $errors['MaCodeTour'] = "Vui lòng nhập mã tour.";
            } elseif ($this->modelTour->checkMaTourExists($MaCodeTour)) {
                $errors['MaCodeTour'] = "Mã tour '$MaCodeTour' đã tồn tại. Vui lòng chọn mã khác.";
            }

            // --- 2b. Check Tên & Danh mục ---
            if (empty($TenTour)) {
                $errors['TenTour'] = "Vui lòng nhập tên tour.";
            }
            if (empty($MaDanhMuc)) {
                $errors['MaDanhMuc'] = "Vui lòng chọn danh mục.";
            }

            // --- 2c. Check Ngày / Đêm (Logic nghiệp vụ) ---
            
            // Check số ngày
            if ($SoNgay < 0) {
                $errors['SoNgay'] = "Số ngày không được để trống hoặc âm.";
            }
            
            // Check số đêm
            if ($SoDem < 0) {
                $errors['SoDem'] = "Số đêm không được để trống hoặc âm.";
            }

            // Check logic chênh lệch (nếu đã nhập số dương)
            if ($SoNgay >= 0 && $SoDem >= 0) {
                if ($SoNgay == 0 && $SoDem == 0) {
                     $errors['SoNgay'] = "Thời gian tour phải lớn hơn 0.";
                     $errors['SoDem']  = "Thời gian tour phải lớn hơn 0.";
                } elseif (abs($SoNgay - $SoDem) > 1) {
                    // Ví dụ: 3N1Đ -> |3-1|=2 (Lỗi)
                    $msg = "Lịch trình bất hợp lý ($SoNgay ngày $SoDem đêm).";
                    $errors['SoNgay'] = $msg;
                    $errors['SoDem']  = $msg;
                }
            }

            // 3. NẾU CÓ LỖI -> QUAY LẠI FORM CŨ
            if (!empty($errors)) {
                $oldData = $post; // Giữ lại dữ liệu vừa nhập để điền lại form
                $listDanhMuc = $this->modelTour->getDanhMucTour();
                
                // Include lại view addtour để hiện lỗi
                $viewFile = './views/tour/addtour.php';
                include './views/layout.php';
                return; // Dừng xử lý, không insert db
            }

            // 4. KHÔNG LỖI -> TIẾN HÀNH THÊM VÀO DB
            try {
                // Upload ảnh
                $LinkAnhBia = null;
                if (!empty($_FILES['LinkAnhBia']['name'])) {
                    $uploadDir = "uploads/";
                    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                    $fileName = time() . "_" . basename($_FILES['LinkAnhBia']['name']);
                    move_uploaded_file($_FILES['LinkAnhBia']['tmp_name'], $uploadDir . $fileName);
                    $LinkAnhBia = $uploadDir . $fileName;
                }

                $this->modelTour->conn->beginTransaction();

                $id = $this->modelTour->addTour(
                    $MaCodeTour, $TenTour, $MaDanhMuc, 
                    $SoNgay, $SoDem, $post['DiemKhoiHanh'], $post['MoTa'], 
                    $post['GiaVonDuKien'], $post['GiaBanMacDinh'], 
                    $LinkAnhBia, $post['ChinhSachBaoGom'], $post['ChinhSachKhongBaoGom'], 
                    $post['ChinhSachHuy'], $post['ChinhSachHoanTien'], 
                    $post['DuongDanDatTour'], $post['TrangThai']
                );

                // Thêm giá và dự toán
                $this->modelTour->addGiaTourBulk($id, $post['gia'] ?? []);
                $this->modelTour->addDuToanBulk($id, $post['dutoan'] ?? []);

                $this->modelTour->conn->commit();
                
                header("Location: ?act=tour&success=add");
                exit();

            } catch (Exception $e) {
                if ($this->modelTour->conn->inTransaction()) {
                    $this->modelTour->conn->rollBack();
                }
                $errors['system'] = "Lỗi hệ thống: " . $e->getMessage();
                $oldData = $post;
                $listDanhMuc = $this->modelTour->getDanhMucTour();
                $viewFile = './views/tour/addtour.php';
                include './views/layout.php';
            }
        }
    }

    // Hiển thị form sửa tour
    public function editTour()
    {
        $id = $_GET['id'];
        $tour = $this->modelTour->getOneTourEdit($id);
        $listDanhMuc = $this->modelTour->getDanhMucTour();

        $giaTour = $this->modelTour->getGiaTourByTourId($id);
        $duToan  = $this->modelTour->getDuToanByTourId($id);

        $viewFile = './views/tour/suaTour.php';
        include './views/layout.php';
    }

    // --- SỬA LOGIC NGHIỆP VỤ GIỐNG ADD ---
    public function editTourProcess()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // 1. LẤY DỮ LIỆU TỪ FORM
            $post = $_POST;
            $MaTour = (int)$post['MaTour'];
            $MaCodeTour = trim($post['MaCodeTour'] ?? '');
            $TenTour    = trim($post['TenTour'] ?? '');
            $MaDanhMuc  = $post['MaDanhMuc'] ?? '';
            $SoNgay     = isset($post['SoNgay']) ? intval($post['SoNgay']) : -1;
            $SoDem      = isset($post['SoDem']) ? intval($post['SoDem']) : -1;

            // 2. KIỂM TRA LỖI (VALIDATION) - Lặp lại logic từ addTourProcess
            $errors = [];

            // --- 2a. Check Mã Tour (Kiểm tra trùng NGOẠI TRỪ chính nó) ---
            if (empty($MaCodeTour)) {
                $errors['MaCodeTour'] = "Vui lòng nhập mã tour.";
            } elseif ($this->modelTour->checkMaTourExists($MaCodeTour, $MaTour)) { // Cần cập nhật checkMaTourExists nếu model chưa hỗ trợ exclude ID
                // Hiện tại model không có tham số exclude, nên tôi giả định nó sẽ được sửa trong model
                // Tuy nhiên, vì model không có, ta dùng lại logic cũ và sẽ gặp lỗi nếu người dùng không đổi mã
                // Tạm thời, tôi sẽ chỉ kiểm tra trường hợp Mã rỗng. Logic phức tạp hơn cần update model.
                // Giả định model đã có hàm checkMaTourExists(MaCode, ExcludeId)
                
                // Vì không có ExcludeId trong Model, tôi sẽ dùng checkMaTourExists() 
                // và chấp nhận logic này: nếu mã trùng với bản ghi khác (không phải bản ghi hiện tại), 
                // ta sẽ cần logic phức tạp hơn, nhưng nếu chỉ là mã rỗng/tên rỗng:

                if ($this->modelTour->checkMaTourExists($MaCodeTour)) {
                    // Nếu nó tồn tại, ta cần kiểm tra xem nó có phải của chính tour này không
                    $currentTour = $this->modelTour->getOneTourEdit($MaTour);
                    if ($currentTour['MaCodeTour'] !== $MaCodeTour) {
                        $errors['MaCodeTour'] = "Mã tour '$MaCodeTour' đã tồn tại. Vui lòng chọn mã khác.";
                    }
                }
            }


            // --- 2b. Check Tên & Danh mục ---
            if (empty($TenTour)) {
                $errors['TenTour'] = "Vui lòng nhập tên tour.";
            }
            if (empty($MaDanhMuc)) {
                $errors['MaDanhMuc'] = "Vui lòng chọn danh mục.";
            }

            // --- 2c. Check Ngày / Đêm ---
            if ($SoNgay < 0) {
                $errors['SoNgay'] = "Số ngày không được để trống hoặc âm.";
            }
            if ($SoDem < 0) {
                $errors['SoDem'] = "Số đêm không được để trống hoặc âm.";
            }
            if ($SoNgay >= 0 && $SoDem >= 0) {
                if ($SoNgay == 0 && $SoDem == 0) {
                     $errors['SoNgay'] = "Thời gian tour phải lớn hơn 0.";
                     $errors['SoDem']  = "Thời gian tour phải lớn hơn 0.";
                } elseif (abs($SoNgay - $SoDem) > 1) {
                    $msg = "Lịch trình bất hợp lý ($SoNgay ngày $SoDem đêm).";
                    $errors['SoNgay'] = $msg;
                    $errors['SoDem']  = $msg;
                }
            }

            // 3. NẾU CÓ LỖI -> QUAY LẠI FORM CŨ (CHỈ CẦN SHOW LỖI, KHÔNG CẦN REDIRECT)
            if (!empty($errors)) {
                // Tái tạo lại view để hiển thị lỗi inline
                $tour = $this->modelTour->getOneTourEdit($MaTour);
                $listDanhMuc = $this->modelTour->getDanhMucTour();
                $giaTour = $this->modelTour->getGiaTourByTourId($MaTour);
                $duToan  = $this->modelTour->getDuToanByTourId($MaTour);

                // Ghi đè tour bằng post data để giữ lại các trường nhập liệu
                $tour = array_merge($tour, $post);

                $viewFile = './views/tour/suaTour.php';
                include './views/layout.php';
                return; 
            }

            // 4. KHÔNG LỖI -> TIẾN HÀNH UPDATE VÀO DB
            try {
                // Upload ảnh mới (giữ ảnh cũ nếu không chọn)
                $target_file = $_POST['old_image'] ?? null;
                if (isset($_FILES['LinkAnhBia']) && $_FILES['LinkAnhBia']['error'] == 0) {
                    $dir = "./uploads/";
                    if (!file_exists($dir)) mkdir($dir, 0777, true);
                    $fileName = time() . "_" . basename($_FILES['LinkAnhBia']['name']);
                    $target_file = $dir . $fileName;
                    move_uploaded_file($_FILES['LinkAnhBia']['tmp_name'], $target_file);
                }

                $data = [
                    ':MaTour' => $MaTour,
                    ':MaCodeTour' => $MaCodeTour,
                    ':TenTour' => $TenTour,
                    ':MaDanhMuc' => $MaDanhMuc,
                    ':SoNgay' => $SoNgay,
                    ':SoDem' => $SoDem,
                    ':DiemKhoiHanh' => $_POST['DiemKhoiHanh'] ?? null,
                    ':MoTa' => $_POST['MoTa'] ?? null,
                    ':GiaVonDuKien' => $_POST['GiaVonDuKien'] ?? 0,
                    ':GiaBanMacDinh' => $_POST['GiaBanMacDinh'] ?? 0,
                    ':ChinhSachBaoGom' => $_POST['ChinhSachBaoGom'] ?? null,
                    ':ChinhSachKhongBaoGom' => $_POST['ChinhSachKhongBaoGom'] ?? null,
                    ':ChinhSachHuy' => $_POST['ChinhSachHuy'] ?? null,
                    ':ChinhSachHoanTien' => $_POST['ChinhSachHoanTien'] ?? null,
                    ':DuongDanDatTour' => $_POST['DuongDanDatTour'] ?? null,
                    ':TrangThai' => $_POST['TrangThai'],
                    ':LinkAnhBia' => $target_file
                ];

                // Lấy giá và dự toán từ form
                $listGia = $_POST['gia'] ?? [];
                $listDuToan = $_POST['dutoan'] ?? [];

                $this->modelTour->conn->beginTransaction();

                // 1) update tour
                $ok = $this->modelTour->updateTour($data);
                if (!$ok) throw new Exception("Update tour failed");

                // 2) replace giá
                $this->modelTour->replaceGiaTour($MaTour, $listGia);

                // 3) replace dự toán
                $this->modelTour->replaceDuToan($MaTour, $listDuToan);

                $this->modelTour->conn->commit();

                header("Location: ?act=tour&success=update");
                exit();
            } catch (Throwable $e) {
                if ($this->modelTour->conn->inTransaction()) {
                    $this->modelTour->conn->rollBack();
                }
                
                // Tái tạo lại view để hiển thị lỗi hệ thống
                $errors['system'] = "Lỗi hệ thống: " . $e->getMessage();
                $tour = $this->modelTour->getOneTourEdit($MaTour);
                $listDanhMuc = $this->modelTour->getDanhMucTour();
                $giaTour = $this->modelTour->getGiaTourByTourId($MaTour);
                $duToan  = $this->modelTour->getDuToanByTourId($MaTour);
                $tour = array_merge($tour, $post);
                
                $viewFile = './views/tour/suaTour.php';
                include './views/layout.php';
            }
        }
    }


    // Xóa tour
    public function deleteTour()
    {
        $id = $_GET['id'];
        
        // [BỔ SUNG LOGIC] Kiểm tra ràng buộc Booking/Đoàn trước khi xóa cứng
        if ($this->modelTour->checkIfUsedByBooking($id)) {
            // Nếu có Booking hoặc Đoàn đang sử dụng, redirect với thông báo lỗi
            header("Location: ?act=tour&error=in_use");
            exit();
        }
        
        $this->modelTour->deleteTour($id);
        header("Location: ?act=tour&success=delete");
        exit();
    }

    // Xem tour cho HƯỚNG DẪN VIÊN (xem tổng hợp đầy đủ)
    public function xemTourHDV()
    {
        $id = $_GET['id'];
        $tour = $this->modelTour->getOneTour($id);
        $lichTrinh = $this->modelTour->getLichTrinhByTourId($id);
        $giaTour = $this->modelTour->getGiaTourByTourId($id);
        $duToan = $this->modelTour->getDuToanByTourId($id);

        $viewFile = './views/tour/xemTourHDV.php';
        include './views/layout.php';
    }
}
?>