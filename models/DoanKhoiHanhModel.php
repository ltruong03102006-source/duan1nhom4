<?php
class DoanKhoiHanhModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lấy danh sách đoàn
    // File: duAn1Nhom4/models/DoanKhoiHanhModel.php

    public function getAllDoan()
    {
        // Thêm sub-query đếm tổng số khách (NguoiLon + TreEm + EmBe) từ bảng Booking
        // Chỉ đếm các booking chưa bị hủy
        $sql = "SELECT dk.*, t.TenTour, nv1.HoTen AS TenHDV, nv2.HoTen AS TenTaiXe,
            (
                SELECT COALESCE(SUM(b.TongNguoiLon + b.TongTreEm + b.TongEmBe), 0)
                FROM Booking b
                WHERE b.MaDoan = dk.MaDoan AND b.TrangThai != 'da_huy'
            ) AS DaDat
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
    public function getBusyNhanVienIdsByDate($date)
    {
        // Nhân viên bận nếu TrangThai = 'ban' trong ngày đó
        $sql = "SELECT MaNhanVien 
            FROM lichlamviec
            WHERE NgayLamViec = :d AND TrangThai = 'ban'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':d' => $date]);
        return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'MaNhanVien');
    }
    public function getDetail($MaDoan)
    {
        // Tận dụng luôn hàm getOneDoan đã có sẵn để đỡ phải viết lại SQL
        return $this->getOneDoan($MaDoan);
    }
    public function getCapacityInfo($MaDoan)
    {
        $sql = "SELECT dk.MaDoan, dk.SoChoToiDa,
            (
                SELECT COALESCE(SUM(b.TongNguoiLon + b.TongTreEm + b.TongEmBe), 0)
                FROM Booking b
                WHERE b.MaDoan = dk.MaDoan AND b.TrangThai != 'da_huy'
            ) AS DaDat
            FROM DoanKhoiHanh dk
            WHERE dk.MaDoan = :MaDoan";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":MaDoan", $MaDoan);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
