<?php 
// Model xử lý tương tác với bảng LichTrinh
class LichTrinhModel 
{
    public $conn;
    
    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lấy tất cả lịch trình theo MaTour
    public function getAllLichTrinhByTour($maTour)
    {
        $sql = "SELECT * FROM LichTrinh WHERE MaTour = :maTour ORDER BY NgayThu ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':maTour', $maTour);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Lấy thông tin 1 lịch trình theo ID
    public function getLichTrinhById($id)
    {
        $sql = "SELECT * FROM LichTrinh WHERE MaLichTrinh = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Thêm lịch trình mới
    public function addLichTrinh($maTour, $ngayThu, $tieuDeNgay, $diaDiemThamQuan, $noiO, $coBuaSang, $coBuaTrua, $coBuaToi, $chiTietHoatDong)
    {
        $sql = "INSERT INTO LichTrinh (MaTour, NgayThu, TieuDeNgay, DiaDiemThamQuan, NoiO, CoBuaSang, CoBuaTrua, CoBuaToi, ChiTietHoatDong) 
                VALUES (:maTour, :ngayThu, :tieuDeNgay, :diaDiemThamQuan, :noiO, :coBuaSang, :coBuaTrua, :coBuaToi, :chiTietHoatDong)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':maTour', $maTour);
        $stmt->bindParam(':ngayThu', $ngayThu);
        $stmt->bindParam(':tieuDeNgay', $tieuDeNgay);
        $stmt->bindParam(':diaDiemThamQuan', $diaDiemThamQuan);
        $stmt->bindParam(':noiO', $noiO);
        $stmt->bindParam(':coBuaSang', $coBuaSang);
        $stmt->bindParam(':coBuaTrua', $coBuaTrua);
        $stmt->bindParam(':coBuaToi', $coBuaToi);
        $stmt->bindParam(':chiTietHoatDong', $chiTietHoatDong);
        return $stmt->execute();
    }

    // Cập nhật lịch trình
    public function updateLichTrinh($id, $maTour, $ngayThu, $tieuDeNgay, $diaDiemThamQuan, $noiO, $coBuaSang, $coBuaTrua, $coBuaToi, $chiTietHoatDong)
    {
        $sql = "UPDATE LichTrinh SET 
                MaTour = :maTour,
                NgayThu = :ngayThu,
                TieuDeNgay = :tieuDeNgay,
                DiaDiemThamQuan = :diaDiemThamQuan,
                NoiO = :noiO,
                CoBuaSang = :coBuaSang,
                CoBuaTrua = :coBuaTrua,
                CoBuaToi = :coBuaToi,
                ChiTietHoatDong = :chiTietHoatDong
                WHERE MaLichTrinh = :id";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':maTour', $maTour);
        $stmt->bindParam(':ngayThu', $ngayThu);
        $stmt->bindParam(':tieuDeNgay', $tieuDeNgay);
        $stmt->bindParam(':diaDiemThamQuan', $diaDiemThamQuan);
        $stmt->bindParam(':noiO', $noiO);
        $stmt->bindParam(':coBuaSang', $coBuaSang);
        $stmt->bindParam(':coBuaTrua', $coBuaTrua);
        $stmt->bindParam(':coBuaToi', $coBuaToi);
        $stmt->bindParam(':chiTietHoatDong', $chiTietHoatDong);
        return $stmt->execute();
    }

    // Xóa lịch trình
    public function deleteLichTrinh($id)
    {
        $sql = "DELETE FROM LichTrinh WHERE MaLichTrinh = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Lấy danh sách tất cả tour
    public function getAllTours()
    {
        $sql = "SELECT MaTour, MaCodeTour, TenTour FROM Tour WHERE TrangThai = 'hoat_dong' ORDER BY TenTour ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Lấy thông tin tour theo ID
    public function getTourById($id)
    {
        $sql = "SELECT * FROM Tour WHERE MaTour = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
}
?>