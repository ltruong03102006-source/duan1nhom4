<?php
class AuthController
{
    private $modelTaiKhoan;

    public function __construct()
    {
        $this->modelTaiKhoan = new TaiKhoanModel();
    }

    // Hiển thị trang đăng nhập
    public function login()
    {
        require_once './views/login.php';
    }

    // Xử lý đăng nhập
    public function loginProcess()
    {
        if (!isset($_POST['tenDangNhap'], $_POST['matKhau'])) {
            header('Location: ?act=login&error=empty');
            exit;
        }

        $tenDangNhap = trim($_POST['tenDangNhap']);
        $matKhau = trim($_POST['matKhau']);

        if (empty($tenDangNhap) || empty($matKhau)) {
            header('Location: ?act=login&error=empty');
            exit;
        }

        // Gọi model kiểm tra đăng nhập
        $user = $this->modelTaiKhoan->checkLogin($tenDangNhap, $matKhau);

        if (!$user) {
            header('Location: ?act=login&error=invalid');
            exit;
        }

        // ⭐ THỐNG NHẤT: Lưu vào $_SESSION['user']
        $_SESSION['user'] = [
            'MaTaiKhoan' => $user['MaTaiKhoan'],
            'TenDangNhap' => $user['TenDangNhap'],
            'VaiTro' => $user['VaiTro'],
            'MaNhanVien' => $user['MaNhanVien']
        ];

        // Cập nhật lần đăng nhập cuối
        $this->updateLastLogin($user['MaTaiKhoan']);

        // Điều hướng theo vai trò
        if ($user['VaiTro'] == 'admin') {
            header("Location: ?act=/");
            exit;
        }

        if ($user['VaiTro'] == 'huong_dan_vien') {
            header("Location: ?act=hdvHome");
            exit;
        }

        // Vai trò khác
        header("Location: ?act=/");
        exit;
    }

    // Cập nhật lần đăng nhập cuối
    private function updateLastLogin($maTaiKhoan)
    {
        $sql = "UPDATE taikhoan SET LanDangNhapCuoi = NOW() WHERE MaTaiKhoan = :id";
        $stmt = $this->modelTaiKhoan->conn->prepare($sql);
        $stmt->execute([':id' => $maTaiKhoan]);
    }

    // Đăng xuất
    public function logout()
    {
        session_destroy();
        header("Location: ?act=login");
        exit;
    }
}