<?php
class ThanhToanModel {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function getAll() {
        $sql = "SELECT t.*, b.MaCodeBooking, k.HoTen AS TenKhach 
                FROM ThanhToan t
                LEFT JOIN Booking b ON t.MaBooking = b.MaBooking
                LEFT JOIN KhachHang k ON b.MaKhachHang = k.MaKhachHang
                ORDER BY t.MaThanhToan DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllBooking() {
        $sql = "SELECT MaBooking, MaCodeBooking FROM Booking ORDER BY MaBooking DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($data) {
        $sql = "INSERT INTO ThanhToan 
            (MaBooking, SoTien, NgayThanhToan, PhuongThucThanhToan, LoaiThanhToan, MaGiaoDich, TrangThai, GhiChu, NgayTao)
            VALUES (:MaBooking, :SoTien, :NgayThanhToan, :PhuongThucThanhToan, :LoaiThanhToan, :MaGiaoDich, :TrangThai, :GhiChu, NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':MaBooking' => $data['MaBooking'],
            ':SoTien' => $data['SoTien'],
            ':NgayThanhToan' => $data['NgayThanhToan'],
            ':PhuongThucThanhToan' => $data['PhuongThucThanhToan'],
            ':LoaiThanhToan' => $data['LoaiThanhToan'],
            ':MaGiaoDich' => $data['MaGiaoDich'],
            ':TrangThai' => $data['TrangThai'],
            ':GhiChu' => $data['GhiChu']
        ]);
    }

    public function getOne($id) {
        $sql = "SELECT * FROM ThanhToan WHERE MaThanhToan = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($data) {
        $sql = "UPDATE ThanhToan SET 
                    MaBooking=:MaBooking, SoTien=:SoTien, NgayThanhToan=:NgayThanhToan,
                    PhuongThucThanhToan=:PhuongThucThanhToan, LoaiThanhToan=:LoaiThanhToan,
                    MaGiaoDich=:MaGiaoDich, TrangThai=:TrangThai, GhiChu=:GhiChu
                WHERE MaThanhToan=:MaThanhToan";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($data);
    }

    public function delete($id) {
        $sql = "DELETE FROM ThanhToan WHERE MaThanhToan = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
    }
}
