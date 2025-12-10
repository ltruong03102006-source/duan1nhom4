<?php
class AuthController
{
    private $modelTaiKhoan;

    public function __construct()
    {
        $this->modelTaiKhoan = new TaiKhoanModel();
    }

    // 1. Hiển thị trang đăng nhập
    public function login()
    {
        // Nếu đã đăng nhập rồi thì chuyển hướng luôn (Tránh việc user phải login lại)
        if (isset($_SESSION['user'])) {
            if ($_SESSION['user']['VaiTro'] == 'huong_dan_vien') {
                header("Location: ?act=hdvHome");
            } else {
                header("Location: ?act=/");
            }
            exit();
        }
        require_once './views/login.php';
    }

    // 2. Xử lý đăng nhập
    public function loginProcess()
    {
        // Kiểm tra xem có dữ liệu gửi lên không
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ?act=login");
            exit();
        }

        $tenDangNhap = trim($_POST['tenDangNhap'] ?? '');
        $matKhau = trim($_POST['matKhau'] ?? '');

        // Kiểm tra dữ liệu rỗng
        if (empty($tenDangNhap) || empty($matKhau)) {
            $_SESSION['error'] = 'Vui lòng nhập đầy đủ Tên đăng nhập và Mật khẩu!';
            header("Location: ?act=login");
            exit();
        }

        // Gọi model kiểm tra đăng nhập
        $user = $this->modelTaiKhoan->checkLogin($tenDangNhap, $matKhau);

        if ($user) {
            // --- ĐĂNG NHẬP THÀNH CÔNG ---
            
            // Lưu thông tin vào Session
            $_SESSION['user'] = [
                'MaTaiKhoan' => $user['MaTaiKhoan'],
                'TenDangNhap' => $user['TenDangNhap'],
                'VaiTro' => $user['VaiTro'],
                'MaNhanVien' => $user['MaNhanVien']
            ];

            // Cập nhật thời gian đăng nhập lần cuối
            $this->updateLastLogin($user['MaTaiKhoan']);

            // Điều hướng dựa trên vai trò
            if ($user['VaiTro'] == 'admin') {
                header("Location: ?act=/");
            } elseif ($user['VaiTro'] == 'huong_dan_vien') {
                header("Location: ?act=hdvHome");
            } else {
                // Các vai trò khác (như điều hành, khách hàng...)
                header("Location: ?act=/");
            }
            exit();

        } else {
            // --- ĐĂNG NHẬP THẤT BẠI ---
            
            // Lưu thông báo lỗi vào Session để hiển thị ra View
            $_SESSION['error'] = 'Tài khoản hoặc mật khẩu không chính xác!';
            header("Location: ?act=login");
            exit();
        }
    }

    // Hàm phụ: Cập nhật lần đăng nhập cuối
    private function updateLastLogin($maTaiKhoan)
    {
        // Lưu ý: Cần đảm bảo biến $this->modelTaiKhoan->conn tồn tại và kết nối được
        $sql = "UPDATE taikhoan SET LanDangNhapCuoi = NOW() WHERE MaTaiKhoan = :id";
        $stmt = $this->modelTaiKhoan->conn->prepare($sql);
        $stmt->execute([':id' => $maTaiKhoan]);
    }

    // 3. Đăng xuất
    public function logout()
    {
        // Xóa session user
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        }
        
        // Hủy toàn bộ session (nếu cần thiết)
        // session_destroy(); 

        // Chuyển hướng về trang đăng nhập
        header("Location: ?act=login");
        exit();
    }
}
?>