<?php
// File: vuanh-duan/duan1nhom4/models/khachHangModel.php

class KhachHangModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
        
        // Kiểm tra kết nối
        if (!$this->conn) {
            throw new Exception("Không thể kết nối database");
        }
    }

    // Lấy tất cả khách hàng
    public function getAllKhachHang()
    {
        try {
            $sql = "SELECT * FROM KhachHang ORDER BY MaKhachHang DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Lỗi getAllKhachHang: " . $e->getMessage());
            return [];
        }
    }

    // Thêm khách hàng mới
    public function addKhachHang($data)
    {
        try {
            $sql = "INSERT INTO KhachHang (
                        MaCodeKhachHang, HoTen, SoDienThoai, Email, DiaChi, NgaySinh, GioiTinh, 
                        SoGiayTo, LoaiKhach, TenCongTy, MaSoThue, GhiChu, NgayTao
                    ) VALUES (
                        :MaCodeKhachHang, :HoTen, :SoDienThoai, :Email, :DiaChi, :NgaySinh, :GioiTinh, 
                        :SoGiayTo, :LoaiKhach, :TenCongTy, :MaSoThue, :GhiChu, CURRENT_TIMESTAMP
                    )";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            error_log("Lỗi addKhachHang: " . $e->getMessage());
            return false;
        }
    }

    // Lấy 1 khách hàng theo ID
    public function getOneKhachHang($id)
    {
        try {
            $sql = "SELECT * FROM KhachHang WHERE MaKhachHang = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Lỗi getOneKhachHang: " . $e->getMessage());
            return false;
        }
    }

    // Cập nhật thông tin khách hàng
    public function updateKhachHang($data)
    {
        try {
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
        } catch (PDOException $e) {
            error_log("Lỗi updateKhachHang: " . $e->getMessage());
            return false;
        }
    }

    // Xóa khách hàng
    public function deleteKhachHang($id)
    {
        try {
            $sql = "DELETE FROM KhachHang WHERE MaKhachHang = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Lỗi deleteKhachHang: " . $e->getMessage());
            return false;
        }
    }

    // Kiểm tra email đã tồn tại chưa (tránh trùng lặp)
    public function checkEmailExists($email, $excludeId = null)
    {
        try {
            if ($excludeId) {
                $sql = "SELECT COUNT(*) FROM KhachHang WHERE Email = :email AND MaKhachHang != :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':id', $excludeId, PDO::PARAM_INT);
            } else {
                $sql = "SELECT COUNT(*) FROM KhachHang WHERE Email = :email";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':email', $email);
            }
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Lỗi checkEmailExists: " . $e->getMessage());
            return false;
        }
    }

    // Kiểm tra số điện thoại đã tồn tại chưa
    public function checkPhoneExists($phone, $excludeId = null)
    {
        try {
            if ($excludeId) {
                $sql = "SELECT COUNT(*) FROM KhachHang WHERE SoDienThoai = :phone AND MaKhachHang != :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':id', $excludeId, PDO::PARAM_INT);
            } else {
                $sql = "SELECT COUNT(*) FROM KhachHang WHERE SoDienThoai = :phone";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':phone', $phone);
            }
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Lỗi checkPhoneExists: " . $e->getMessage());
            return false;
        }
    }

    // Tìm kiếm khách hàng
    public function searchKhachHang($keyword)
    {
        try {
            $sql = "SELECT * FROM KhachHang 
                    WHERE HoTen LIKE :keyword 
                    OR SoDienThoai LIKE :keyword 
                    OR Email LIKE :keyword 
                    ORDER BY MaKhachHang DESC";
            $stmt = $this->conn->prepare($sql);
            $searchTerm = "%$keyword%";
            $stmt->bindParam(':keyword', $searchTerm);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Lỗi searchKhachHang: " . $e->getMessage());
            return [];
        }
    }
}