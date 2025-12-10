<?php
// Model chứa logic truy vấn dành riêng cho vai trò Hướng dẫn viên
class huongDanVienModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // 1. Lấy thông tin chi tiết của một HDV theo Mã nhân viên
    public function getInfoByMaNhanVien($maNhanVien)
    {
        $sql = "SELECT * FROM nhanvien WHERE MaNhanVien = :maNhanVien";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':maNhanVien', $maNhanVien);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    // 2. Lấy danh sách các Đoàn Khởi Hành (tour) mà HDV này được phân công
    public function getListDoanKhoiHanhByHDV($maNhanVien)
    {
        $sql = "SELECT 
                    dk.MaDoan,
                    dk.NgayKhoiHanh,
                    dk.NgayVe,
                    dk.SoChoToiDa,
                    dk.SoChoConTrong,
                    dk.TrangThai,
                    t.TenTour,
                    t.MaCodeTour
                FROM doankhoihanh dk
                JOIN tour t ON dk.MaTour = t.MaTour
                WHERE dk.MaHuongDanVien = :maNhanVien
                ORDER BY dk.NgayKhoiHanh DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':maNhanVien', $maNhanVien);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // 3. Lấy chi tiết một Đoàn Khởi Hành (Bao gồm thông tin Tài xế, Tour)
    public function getChiTietDoan($maDoan)
    {
        $sql = "SELECT
                    dk.*,
                    t.TenTour,
                    t.MaCodeTour,
                    t.ChinhSachBaoGom,
                    t.ChinhSachKhongBaoGom,
                    t.ChinhSachHuy,
                    t.ChinhSachHoanTien,
                    tx.HoTen AS TenTaiXe,
                    tx.SoDienThoai AS SdtTaiXe
                FROM doankhoihanh dk
                JOIN tour t ON dk.MaTour = t.MaTour
                LEFT JOIN nhanvien tx ON dk.MaTaiXe = tx.MaNhanVien
                WHERE dk.MaDoan = :maDoan";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':maDoan', $maDoan);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Tương lai: Thêm các hàm lấy Khách trong Booking, Lịch trình, Tài chính,...
    
    // ** Giả lập MaNhanVien đang đăng nhập **
    // Trong môi trường thực tế, MaNhanVien sẽ được lấy từ session sau khi đăng nhập.
    // Tạm thời, tôi sẽ tạo một hàm giả lập:
    public function getMaNhanVienHienTai()
    {
        // Kiểm tra xem session có tồn tại và có chứa thông tin user không
        if (isset($_SESSION['user']) && isset($_SESSION['user']['MaNhanVien'])) {
            return $_SESSION['user']['MaNhanVien'];
        }
        
        // Trả về 0 hoặc null nếu chưa đăng nhập
        return 0; 
    }
}