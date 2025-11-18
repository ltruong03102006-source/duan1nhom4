<?php
// Class chứa các function thực thi tương tác với cơ sở dữ liệu cho Nhân Viên
class NhanVienModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lấy tất cả nhân viên
    public function getAllNhanVien()
    {
        $sql = "SELECT * FROM NhanVien ORDER BY MaNhanVien DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm nhân viên mới
    public function addNhanVien($data)
    {
        $sql = "INSERT INTO NhanVien (
                    MaCodeNhanVien, HoTen, VaiTro, SoDienThoai, Email, NgaySinh, GioiTinh, 
                    DiaChi, LinkAnhDaiDien, ChungChi, NgonNgu, SoNamKinhNghiem, ChuyenMon, TrangThai, NgayTao
                ) VALUES (
                    :MaCodeNhanVien, :HoTen, :VaiTro, :SoDienThoai, :Email, :NgaySinh, :GioiTinh, 
                    :DiaChi, :LinkAnhDaiDien, :ChungChi, :NgonNgu, :SoNamKinhNghiem, :ChuyenMon, :TrangThai, CURRENT_TIMESTAMP
                )";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Lấy 1 nhân viên theo ID
    public function getOneNhanVien($id)
    {
        $sql = "SELECT * FROM NhanVien WHERE MaNhanVien = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cập nhật thông tin nhân viên
    public function updateNhanVien($data)
    {
        $sql = "UPDATE NhanVien SET 
                HoTen = :HoTen,
                VaiTro = :VaiTro,
                SoDienThoai = :SoDienThoai,
                Email = :Email,
                NgaySinh = :NgaySinh,
                GioiTinh = :GioiTinh,
                DiaChi = :DiaChi,
                LinkAnhDaiDien = :LinkAnhDaiDien,
                ChungChi = :ChungChi,
                NgonNgu = :NgonNgu,
                SoNamKinhNghiem = :SoNamKinhNghiem,
                ChuyenMon = :ChuyenMon,
                TrangThai = :TrangThai
            WHERE MaNhanVien = :MaNhanVien";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Xóa nhân viên
    public function deleteNhanVien($id)
    {
        $sql = "DELETE FROM NhanVien WHERE MaNhanVien = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}