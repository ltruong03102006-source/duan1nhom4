<?php 
// Có class chứa các function thực thi tương tác với cơ sở dữ liệu 
class tourModel 
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Viết truy vấn danh sách sản phẩm 
    public function getAllTour()
    {
        $sql = "SELECT * FROM `tour`";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
