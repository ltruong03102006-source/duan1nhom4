<?php
class BookingModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // ================== BOOKING ==================

    // Danh sách booking + tên tour + tên khách
    public function getAllBooking()
    {
        $sql = "SELECT b.*, t.TenTour, d.NgayKhoiHanh, k.HoTen AS TenKhach
                FROM Booking b
                LEFT JOIN Tour t ON b.MaTour = t.MaTour
                LEFT JOIN DoanKhoiHanh d ON b.MaDoan = d.MaDoan
                LEFT JOIN KhachHang k ON b.MaKhachHang = k.MaKhachHang
                ORDER BY b.MaBooking DESC";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllTour()
    {
        $sql = "SELECT * FROM Tour ORDER BY MaTour DESC";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllDoan()
    {
        $sql = "SELECT d.*, t.TenTour 
                FROM DoanKhoiHanh d
                JOIN Tour t ON d.MaTour = t.MaTour
                ORDER BY d.MaDoan DESC";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllKhachHang()
    {
        $sql = "SELECT * FROM KhachHang ORDER BY MaKhachHang DESC";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addBooking($data)
    {
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

    public function getOneBooking($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM Booking WHERE MaBooking = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateBooking($data)
    {
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

    public function deleteBooking($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM Booking WHERE MaBooking = :id");
        return $stmt->execute([':id' => $id]);
    }

    // Lưu lịch sử thay đổi trạng thái
    public function addLichSuTrangThai($MaBooking, $TrangThaiCu, $TrangThaiMoi, $MaNguoiDoi = null, $GhiChu = null)
    {
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

    public function getKhachTrongBooking($MaBooking)
    {
        $stmt = $this->conn->prepare("SELECT * FROM KhachTrongBooking WHERE MaBooking = :id");
        $stmt->execute([':id' => $MaBooking]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addKhachTrongBooking($data)
    {
        $sql = "INSERT INTO KhachTrongBooking 
                    (MaBooking, HoTen, GioiTinh, NgaySinh, SoGiayTo, SoDienThoai, GhiChuDacBiet, LoaiPhong)
                VALUES (:MaBooking, :HoTen, :GioiTinh, :NgaySinh, :SoGiayTo, :SoDienThoai, :GhiChuDacBiet, :LoaiPhong)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    public function deleteKhachTrongBooking($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM KhachTrongBooking WHERE MaKhachTrongBooking = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function updateDiemDanh($id, $status)
    {
        $stmt = $this->conn->prepare("UPDATE KhachTrongBooking SET TrangThaiDiemDanh = :st WHERE MaKhachTrongBooking = :id");
        return $stmt->execute([':st' => $status, ':id' => $id]);
    }

    // Lấy booking + tour + đoàn để hiển thị trong màn khách
    public function getBookingDetailWithDoan($MaBooking)
    {
        $sql = "SELECT b.*, t.TenTour, d.NgayKhoiHanh, d.NgayVe, d.DiemTapTrung
                FROM Booking b
                LEFT JOIN Tour t ON b.MaTour = t.MaTour
                LEFT JOIN DoanKhoiHanh d ON b.MaDoan = d.MaDoan
                WHERE b.MaBooking = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $MaBooking]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getMaBookingByMaDoan($MaDoan)
    {
        $sql = "SELECT MaBooking FROM Booking WHERE MaDoan = :md ORDER BY MaBooking DESC LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':md' => $MaDoan]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['MaBooking'] ?? null;
    }
    public function hdvCanAccessBooking($MaBooking, $MaHDV)
    {
        $sql = "SELECT COUNT(*) as c
            FROM Booking b
            JOIN DoanKhoiHanh d ON b.MaDoan = d.MaDoan
            WHERE b.MaBooking = :mb AND d.MaHuongDanVien = :hdv";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':mb' => $MaBooking, ':hdv' => $MaHDV]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($row['c'] ?? 0) > 0;
    }
    // Info đoàn để HDV xem (tour, ngày đi/về, điểm tập trung)
    public function getDoanInfoForHdv($MaDoan)
    {
        $sql = "SELECT d.MaDoan, d.NgayKhoiHanh, d.NgayVe, d.DiemTapTrung,
                   t.TenTour, t.MaCodeTour
            FROM DoanKhoiHanh d
            JOIN Tour t ON d.MaTour = t.MaTour
            WHERE d.MaDoan = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $MaDoan]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy toàn bộ khách (KhachTrongBooking) thuộc các booking của 1 đoàn
    public function getKhachTrongDoan($MaDoan)
    {
        $sql = "SELECT ktb.*, b.MaBooking, b.MaCodeBooking
            FROM KhachTrongBooking ktb
            JOIN Booking b ON ktb.MaBooking = b.MaBooking
            WHERE b.MaDoan = :MaDoan
            ORDER BY b.MaBooking DESC, ktb.MaKhachTrongBooking DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':MaDoan' => $MaDoan]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
