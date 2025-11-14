<?php
// Có class chứa các function thực thi tương tác với cơ sở dữ liệu 
class danhMuctourModel
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Viết truy vấn danh sách sản phẩm 
    public function getAlltour()
    {
        $sql = "SELECT * FROM `danhmuctour`";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function addDanhMucTour($tenDanhMuc, $moTa)
    {
        $sql = "INSERT INTO `danhmuctour` (`TenDanhMuc`, `MoTa`) VALUES (:tenDanhMuc, :moTa)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':tenDanhMuc', $tenDanhMuc);
        $stmt->bindParam(':moTa', $moTa);
        return $stmt->execute();
    }
    public function deleteDanhMucTour($id)
    {
        $sql = "DELETE FROM `danhmuctour` WHERE `danhmuctour`.`MaDanhMuc` = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    // Lấy 1 danh mục theo ID
    public function getDanhMucById($id)
    {
        $sql = "SELECT * FROM danhmuctour WHERE MaDanhMuc = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Cập nhật danh mục
    public function updateDanhMucTour($id, $tenDanhmuc, $moTa)
    {
        $sql = "UPDATE danhmuctour 
            SET TenDanhMuc = :tenDanhmuc, MoTa = :moTa 
            WHERE MaDanhMuc = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':tenDanhmuc', $tenDanhmuc);
        $stmt->bindParam(':moTa', $moTa);
        return $stmt->execute();
    }
}
