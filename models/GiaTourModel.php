<?php
// models/GiaTourModel.php
// Model xử lý các thao tác với bảng GiaTour
class GiaTourModel
{
    public $conn;
    
    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lấy tất cả giá của 1 tour
    public function getGiaByTourId($maTour)
    {
        $sql = "SELECT gt.*, t.TenTour 
                FROM giatour gt
                INNER JOIN tour t ON gt.MaTour = t.MaTour
                WHERE gt.MaTour = :maTour
                ORDER BY gt.ApDungTuNgay DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':maTour', $maTour);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Lấy chi tiết 1 bản ghi giá
    public function getGiaById($maGia)
    {
        $sql = "SELECT gt.*, t.TenTour 
                FROM giatour gt
                INNER JOIN tour t ON gt.MaTour = t.MaTour
                WHERE gt.MaGia = :maGia";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':maGia', $maGia);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Thêm giá tour mới
    public function addGiaTour($maTour, $loaiKhach, $giaTien, $apDungTuNgay, $apDungDenNgay, $loaiMua, $tenKhuyenMai, $phanTramGiamGia)
    {
        $sql = "INSERT INTO giatour (MaTour, LoaiKhach, GiaTien, ApDungTuNgay, ApDungDenNgay, LoaiMua, TenKhuyenMai, PhanTramGiamGia) 
                VALUES (:maTour, :loaiKhach, :giaTien, :apDungTuNgay, :apDungDenNgay, :loaiMua, :tenKhuyenMai, :phanTramGiamGia)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':maTour', $maTour);
        $stmt->bindParam(':loaiKhach', $loaiKhach);
        $stmt->bindParam(':giaTien', $giaTien);
        $stmt->bindParam(':apDungTuNgay', $apDungTuNgay);
        $stmt->bindParam(':apDungDenNgay', $apDungDenNgay);
        $stmt->bindParam(':loaiMua', $loaiMua);
        $stmt->bindParam(':tenKhuyenMai', $tenKhuyenMai);
        $stmt->bindParam(':phanTramGiamGia', $phanTramGiamGia);
        return $stmt->execute();
    }

    // Cập nhật giá tour
    public function updateGiaTour($maGia, $loaiKhach, $giaTien, $apDungTuNgay, $apDungDenNgay, $loaiMua, $tenKhuyenMai, $phanTramGiamGia)
    {
        $sql = "UPDATE giatour 
                SET LoaiKhach = :loaiKhach, 
                    GiaTien = :giaTien, 
                    ApDungTuNgay = :apDungTuNgay, 
                    ApDungDenNgay = :apDungDenNgay, 
                    LoaiMua = :loaiMua, 
                    TenKhuyenMai = :tenKhuyenMai, 
                    PhanTramGiamGia = :phanTramGiamGia 
                WHERE MaGia = :maGia";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':maGia', $maGia);
        $stmt->bindParam(':loaiKhach', $loaiKhach);
        $stmt->bindParam(':giaTien', $giaTien);
        $stmt->bindParam(':apDungTuNgay', $apDungTuNgay);
        $stmt->bindParam(':apDungDenNgay', $apDungDenNgay);
        $stmt->bindParam(':loaiMua', $loaiMua);
        $stmt->bindParam(':tenKhuyenMai', $tenKhuyenMai);
        $stmt->bindParam(':phanTramGiamGia', $phanTramGiamGia);
        return $stmt->execute();
    }

    // Xóa giá tour
    public function deleteGiaTour($maGia)
    {
        $sql = "DELETE FROM giatour WHERE MaGia = :maGia";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':maGia', $maGia);
        return $stmt->execute();
    }

    // Lấy danh sách tour (để chọn khi thêm giá)
    public function getAllTour()
    {
        $sql = "SELECT MaTour, TenTour, MaCodeTour FROM tour WHERE TrangThai = 'hoat_dong' ORDER BY TenTour";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}