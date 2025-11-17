<?php
// models/DuToanChiPhiModel.php
// Model xử lý các thao tác với bảng DuToanChiPhiTour
class DuToanChiPhiModel
{
    public $conn;
    
    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lấy tất cả dự toán chi phí của 1 tour
    public function getDuToanByTourId($maTour)
    {
        $sql = "SELECT dt.*, t.TenTour, t.MaCodeTour
                FROM dutoanchiphitour dt
                INNER JOIN tour t ON dt.MaTour = t.MaTour
                WHERE dt.MaTour = :maTour
                ORDER BY dt.MaDuToan DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':maTour', $maTour);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Lấy chi tiết 1 dự toán
    public function getDuToanById($maDuToan)
    {
        $sql = "SELECT dt.*, t.TenTour, t.MaCodeTour
                FROM dutoanchiphitour dt
                INNER JOIN tour t ON dt.MaTour = t.MaTour
                WHERE dt.MaDuToan = :maDuToan";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':maDuToan', $maDuToan);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Thêm dự toán chi phí mới
    public function addDuToan($maTour, $hangMucChi, $soTienDuKien, $ghiChu)
    {
        $sql = "INSERT INTO dutoanchiphitour (MaTour, HangMucChi, SoTienDuKien, GhiChu) 
                VALUES (:maTour, :hangMucChi, :soTienDuKien, :ghiChu)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':maTour', $maTour);
        $stmt->bindParam(':hangMucChi', $hangMucChi);
        $stmt->bindParam(':soTienDuKien', $soTienDuKien);
        $stmt->bindParam(':ghiChu', $ghiChu);
        return $stmt->execute();
    }

    // Cập nhật dự toán chi phí
    public function updateDuToan($maDuToan, $hangMucChi, $soTienDuKien, $ghiChu)
    {
        $sql = "UPDATE dutoanchiphitour 
                SET HangMucChi = :hangMucChi, 
                    SoTienDuKien = :soTienDuKien, 
                    GhiChu = :ghiChu
                WHERE MaDuToan = :maDuToan";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':maDuToan', $maDuToan);
        $stmt->bindParam(':hangMucChi', $hangMucChi);
        $stmt->bindParam(':soTienDuKien', $soTienDuKien);
        $stmt->bindParam(':ghiChu', $ghiChu);
        return $stmt->execute();
    }

    // Xóa dự toán chi phí
    public function deleteDuToan($maDuToan)
    {
        $sql = "DELETE FROM dutoanchiphitour WHERE MaDuToan = :maDuToan";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':maDuToan', $maDuToan);
        return $stmt->execute();
    }

    // Lấy danh sách tour (để chọn khi thêm)
    public function getAllTour()
    {
        $sql = "SELECT MaTour, TenTour, MaCodeTour FROM tour WHERE TrangThai = 'hoat_dong' ORDER BY TenTour";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Tính tổng dự toán chi phí của 1 tour
    public function getTongDuToanByTourId($maTour)
    {
        $sql = "SELECT SUM(SoTienDuKien) as TongDuToan 
                FROM dutoanchiphitour 
                WHERE MaTour = :maTour";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':maTour', $maTour);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['TongDuToan'] ?? 0;
    }
}