<?php
class DoanKhoiHanhModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lấy danh sách đoàn
    public function getAllDoan()
    {
        $sql = "SELECT dk.*, t.TenTour, nv1.HoTen AS TenHDV, nv2.HoTen AS TenTaiXe
                FROM DoanKhoiHanh dk
                JOIN Tour t ON dk.MaTour = t.MaTour
                LEFT JOIN NhanVien nv1 ON dk.MaHuongDanVien = nv1.MaNhanVien
                LEFT JOIN NhanVien nv2 ON dk.MaTaiXe = nv2.MaNhanVien
                ORDER BY dk.MaDoan DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy thông tin 1 đoàn
    public function getOneDoan($id)
    {
        $sql = "SELECT * FROM DoanKhoiHanh WHERE MaDoan = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm đoàn
    public function addDoan($data)
    {
        $sql = "INSERT INTO DoanKhoiHanh 
                (MaTour, NgayKhoiHanh, GioKhoiHanh, NgayVe, DiemTapTrung, 
                SoChoToiDa, SoChoConTrong, MaHuongDanVien, MaTaiXe, ThongTinXe)
                VALUES 
                (:MaTour, :NgayKhoiHanh, :GioKhoiHanh, :NgayVe, :DiemTapTrung,
                :SoChoToiDa, :SoChoConTrong, :MaHuongDanVien, :MaTaiXe, :ThongTinXe)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Cập nhật đoàn
    public function updateDoan($data)
    {
        $sql = "UPDATE DoanKhoiHanh SET
                MaTour = :MaTour,
                NgayKhoiHanh = :NgayKhoiHanh,
                GioKhoiHanh = :GioKhoiHanh,
                NgayVe = :NgayVe,
                DiemTapTrung = :DiemTapTrung,
                SoChoToiDa = :SoChoToiDa,
                SoChoConTrong = :SoChoConTrong,
                MaHuongDanVien = :MaHuongDanVien,
                MaTaiXe = :MaTaiXe,
                ThongTinXe = :ThongTinXe
                WHERE MaDoan = :MaDoan";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Xóa đoàn
    public function deleteDoan($id)
    {
        $sql = "DELETE FROM DoanKhoiHanh WHERE MaDoan = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    // Lấy danh sách tour
    public function getListTour()
    {
        $sql = "SELECT MaTour, TenTour FROM Tour WHERE TrangThai='hoat_dong'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Danh sách HDV
    public function getListHDV()
    {
        $sql = "SELECT MaNhanVien, HoTen FROM NhanVien WHERE VaiTro='huong_dan_vien'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Danh sách tài xế
    public function getListTaiXe()
    {
        $sql = "SELECT MaNhanVien, HoTen FROM NhanVien WHERE VaiTro='tai_xe'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
