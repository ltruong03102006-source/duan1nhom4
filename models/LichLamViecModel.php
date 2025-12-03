<?php
// Class chứa các function thực thi tương tác với cơ sở dữ liệu cho LichLamViec
class LichLamViecModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

   // Lấy tất cả lịch làm việc (có join với nhân viên và đoàn)
    public function getAllLichLamViec($keyword = null) // Thêm tham số keyword
    {
        $sql = "SELECT llv.*, nv.HoTen as TenNhanVien, nv.MaCodeNhanVien,
                       dk.NgayKhoiHanh, t.TenTour, t.MaCodeTour
                FROM LichLamViec llv
                LEFT JOIN NhanVien nv ON llv.MaNhanVien = nv.MaNhanVien
                LEFT JOIN DoanKhoiHanh dk ON llv.MaDoan = dk.MaDoan
                LEFT JOIN Tour t ON dk.MaTour = t.MaTour";
        
        $where = "";
        $params = [];

        if ($keyword) {
            // Lọc theo HoTen hoặc MaCodeNhanVien
            $where .= " WHERE nv.HoTen LIKE :keyword OR nv.MaCodeNhanVien LIKE :keyword";
            $params[':keyword'] = '%' . $keyword . '%';
        }

        $sql .= $where;
        $sql .= " ORDER BY llv.NgayLamViec DESC, nv.HoTen ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Lấy danh sách Nhân Viên
    public function getAllNhanVien()
    {
        $sql = "SELECT MaNhanVien, HoTen, VaiTro, MaCodeNhanVien FROM NhanVien WHERE TrangThai = 'dang_lam' ORDER BY HoTen ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách Đoàn Khởi Hành (Chỉ lấy đoàn đang hoạt động hoặc chưa hoàn thành)
    public function getAllDoanKhoiHanh()
    {
        $sql = "SELECT dk.MaDoan, dk.NgayKhoiHanh, dk.NgayVe, t.TenTour, t.MaCodeTour 
                FROM DoanKhoiHanh dk
                JOIN Tour t ON dk.MaTour = t.MaTour
                WHERE dk.TrangThai IN ('con_cho', 'het_cho')
                ORDER BY dk.NgayKhoiHanh DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   // Thêm Lịch làm việc mới (KHÔNG CÓ ThoiGianBatDau)
   public function addLichLamViec($MaNhanVien, $NgayLamViec, $TrangThai, $MaDoan, $GhiChu)
{
    $sql = "INSERT INTO LichLamViec (MaNhanVien, NgayLamViec, TrangThai, MaDoan, GhiChu) 
            VALUES (:MaNhanVien, :NgayLamViec, :TrangThai, :MaDoan, :GhiChu)";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':MaNhanVien', $MaNhanVien);
    $stmt->bindParam(':NgayLamViec', $NgayLamViec);
    $stmt->bindParam(':TrangThai', $TrangThai);
    // Lưu ý: MaDoan phải là NULL nếu không có giá trị
    $stmt->bindParam(':MaDoan', $MaDoan);
    $stmt->bindParam(':GhiChu', $GhiChu);
    return $stmt->execute();
}

// Thêm hàm này để lấy danh sách Tour đang hoạt động
public function getAllActiveTours()
{
    $sql = "SELECT MaTour, TenTour, MaCodeTour FROM Tour WHERE TrangThai = 'hoat_dong' ORDER BY TenTour ASC";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
    // Xóa lịch làm việc
    public function deleteLichLamViec($id)
    {
        $sql = "DELETE FROM LichLamViec WHERE MaLichLamViec = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public function existsLichLamViec($MaNhanVien, $NgayLamViec)
{
    $sql = "SELECT 1 FROM LichLamViec WHERE MaNhanVien = :nv AND NgayLamViec = :ngay LIMIT 1";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([':nv' => $MaNhanVien, ':ngay' => $NgayLamViec]);
    return (bool)$stmt->fetchColumn();
}

    
}