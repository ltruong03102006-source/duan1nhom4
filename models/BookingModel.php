<?php
class BookingModel {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    // ================== BOOKING ==================

    // Danh sách booking + tên tour + tên khách
    public function getAllBooking() {
        $sql = "SELECT b.*, t.TenTour, d.NgayKhoiHanh, k.HoTen AS TenKhach
                FROM Booking b
                LEFT JOIN Tour t ON b.MaTour = t.MaTour
                LEFT JOIN DoanKhoiHanh d ON b.MaDoan = d.MaDoan
                LEFT JOIN KhachHang k ON b.MaKhachHang = k.MaKhachHang
                ORDER BY b.MaBooking DESC";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllTour() {
        $sql = "SELECT * FROM Tour ORDER BY MaTour DESC";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllDoan() {
        $sql = "SELECT d.*, t.TenTour 
                FROM DoanKhoiHanh d
                JOIN Tour t ON d.MaTour = t.MaTour
                ORDER BY d.MaDoan DESC";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllKhachHang() {
        $sql = "SELECT * FROM KhachHang ORDER BY MaKhachHang DESC";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addBooking($data) {
        $sql = "INSERT INTO Booking (
                    MaCodeBooking, MaTour, MaDoan, MaKhachHang, LoaiBooking,
                    TongNguoiLon, TongTreEm, TongEmBe,
                    TongTien, SoTienDaCoc, SoTienDaTra, SoTienConLai,
                    YeuCauDacBiet, MaNguoiTao
                ) VALUES (
                    :MaCodeBooking, :MaTour, :MaDoan, :MaKhachHang, :LoaiBooking,
                    :TongNguoiLon, :TongTreEm, :TongEmBe,
                    :TongTien, :SoTienDaCoc, :SoTienDaTra, :SoTienConLai,
                    :YeuCauDacBiet, :MaNguoiTao
                )";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    public function getOneBooking($id) {
        $stmt = $this->conn->prepare("SELECT * FROM Booking WHERE MaBooking = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateBooking($data) {
        $sql = "UPDATE Booking SET 
                    MaTour = :MaTour,
                    MaDoan = :MaDoan,
                    MaKhachHang = :MaKhachHang,
                    LoaiBooking = :LoaiBooking,
                    TongNguoiLon = :TongNguoiLon,
                    TongTreEm = :TongTreEm,
                    TongEmBe = :TongEmBe,
                    TongTien = :TongTien,
                    SoTienDaCoc = :SoTienDaCoc,
                    SoTienDaTra = :SoTienDaTra,
                    SoTienConLai = :SoTienConLai,
                    YeuCauDacBiet = :YeuCauDacBiet,
                    TrangThai = :TrangThai,
                    NgayCapNhat = CURRENT_TIMESTAMP
                WHERE MaBooking = :MaBooking";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    public function deleteBooking($id) {
        $stmt = $this->conn->prepare("DELETE FROM Booking WHERE MaBooking = :id");
        return $stmt->execute([':id' => $id]);
    }

    // Lưu lịch sử thay đổi trạng thái
    public function addLichSuTrangThai($MaBooking, $TrangThaiCu, $TrangThaiMoi, $MaNguoiDoi = null, $GhiChu = null) {
        $sql = "INSERT INTO LichSuTrangThaiBooking 
                    (MaBooking, TrangThaiCu, TrangThaiMoi, MaNguoiDoi, GhiChu)
                VALUES (:MaBooking, :TrangThaiCu, :TrangThaiMoi, :MaNguoiDoi, :GhiChu)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':MaBooking' => $MaBooking,
            ':TrangThaiCu' => $TrangThaiCu,
            ':TrangThaiMoi' => $TrangThaiMoi,
            ':MaNguoiDoi' => $MaNguoiDoi,
            ':GhiChu' => $GhiChu
        ]);
    }

    // ================== KHÁCH TRONG BOOKING ==================

    public function getKhachTrongBooking($MaBooking) {
        $stmt = $this->conn->prepare("SELECT * FROM KhachTrongBooking WHERE MaBooking = :id");
        $stmt->execute([':id' => $MaBooking]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addKhachTrongBooking($data) {
        $sql = "INSERT INTO KhachTrongBooking 
                    (MaBooking, HoTen, GioiTinh, NgaySinh, SoGiayTo, SoDienThoai, GhiChuDacBiet, LoaiPhong)
                VALUES (:MaBooking, :HoTen, :GioiTinh, :NgaySinh, :SoGiayTo, :SoDienThoai, :GhiChuDacBiet, :LoaiPhong)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    public function deleteKhachTrongBooking($id) {
        $stmt = $this->conn->prepare("DELETE FROM KhachTrongBooking WHERE MaKhachTrongBooking = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function updateDiemDanh($id, $status) {
        $stmt = $this->conn->prepare("UPDATE KhachTrongBooking SET TrangThaiDiemDanh = :st WHERE MaKhachTrongBooking = :id");
        return $stmt->execute([':st' => $status, ':id' => $id]);
    }

    // Lấy booking + tour + đoàn để hiển thị trong màn khách
    public function getBookingDetailWithDoan($MaBooking) {
        $sql = "SELECT b.*, t.TenTour, d.NgayKhoiHanh, d.NgayVe, d.DiemTapTrung
                FROM Booking b
                LEFT JOIN Tour t ON b.MaTour = t.MaTour
                LEFT JOIN DoanKhoiHanh d ON b.MaDoan = d.MaDoan
                WHERE b.MaBooking = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $MaBooking]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
