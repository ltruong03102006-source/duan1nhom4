// File: vuanh-duan/duan1nhom4/models/khachHangModel.php
<?php
// Class chứa các function thực thi tương tác với cơ sở dữ liệu cho Khách Hàng
class KhachHangModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lấy tất cả khách hàng
    public function getAllKhachHang()
    {
        $sql = "SELECT * FROM KhachHang ORDER BY MaKhachHang DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm khách hàng mới
    public function addKhachHang($data)
    {
        $sql = "INSERT INTO KhachHang (
                    MaCodeKhachHang, HoTen, SoDienThoai, Email, DiaChi, NgaySinh, GioiTinh, 
                    SoGiayTo, LoaiKhach, TenCongTy, MaSoThue, GhiChu, NgayTao
                ) VALUES (
                    :MaCodeKhachHang, :HoTen, :SoDienThoai, :Email, :DiaChi, :NgaySinh, :GioiTinh, 
                    :SoGiayTo, :LoaiKhach, :TenCongTy, :MaSoThue, :GhiChu, CURRENT_TIMESTAMP
                )";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Lấy 1 khách hàng theo ID
    public function getOneKhachHang($id)
    {
        $sql = "SELECT * FROM KhachHang WHERE MaKhachHang = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cập nhật thông tin khách hàng
    public function updateKhachHang($data)
    {
        $sql = "UPDATE KhachHang SET 
                HoTen = :HoTen,
                SoDienThoai = :SoDienThoai,
                Email = :Email,
                DiaChi = :DiaChi,
                NgaySinh = :NgaySinh,
                GioiTinh = :GioiTinh,
                SoGiayTo = :SoGiayTo,
                LoaiKhach = :LoaiKhach,
                TenCongTy = :TenCongTy,
                MaSoThue = :MaSoThue,
                GhiChu = :GhiChu
            WHERE MaKhachHang = :MaKhachHang";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Xóa khách hàng
    public function deleteKhachHang($id)
    {
        $sql = "DELETE FROM KhachHang WHERE MaKhachHang = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}