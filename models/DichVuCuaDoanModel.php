<?php
// models/DichVuCuaDoanModel.php
class DichVuCuaDoanModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lấy thông tin đoàn khởi hành (ĐÃ CẬP NHẬT)
    public function getDoanInfo($maDoan)
    {
        $sql = "SELECT 
                    dk.*, 
                    t.TenTour, 
                    t.MaCodeTour,
                    nv.HoTen AS TenHDV  -- Lấy tên nhân viên (HDV) và đặt alias là TenHDV
                FROM DoanKhoiHanh dk
                JOIN Tour t ON dk.MaTour = t.MaTour
                LEFT JOIN NhanVien nv ON dk.MaHuongDanVien = nv.MaNhanVien -- THÊM DÒNG NÀY (LEFT JOIN để xử lý trường hợp chưa chỉ định)
                WHERE dk.MaDoan = :maDoan";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':maDoan', $maDoan);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Lấy tất cả dịch vụ của một đoàn
    public function getAllDichVuByDoan($maDoan)
    {
        $sql = "SELECT dv.*, ncc.TenNhaCungCap
                FROM DichVuCuaDoan dv
                LEFT JOIN NhaCungCap ncc ON dv.MaNhaCungCap = ncc.MaNhaCungCap
                WHERE dv.MaDoan = :maDoan
                ORDER BY dv.NgaySuDung ASC, dv.MaDichVu DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':maDoan', $maDoan);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy chi tiết 1 dịch vụ
    public function getOneDichVu($maDichVu)
    {
        $sql = "SELECT dv.*, dk.MaTour
                FROM DichVuCuaDoan dv
                JOIN DoanKhoiHanh dk ON dv.MaDoan = dk.MaDoan
                WHERE dv.MaDichVu = :maDichVu";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':maDichVu', $maDichVu);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách nhà cung cấp (Chỉ lấy loại dịch vụ tương ứng hoặc 'khac')
    public function getListNhaCungCap()
    {
        // Giả sử chỉ cần lấy tên NCC và ID
        $sql = "SELECT MaNhaCungCap, TenNhaCungCap, LoaiNhaCungCap
                FROM NhaCungCap 
                WHERE TrangThai = 'hoat_dong'
                ORDER BY TenNhaCungCap ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Thêm dịch vụ mới
    public function addDichVu($data)
    {
        $sql = "INSERT INTO DichVuCuaDoan (
                    MaDoan, LoaiDichVu, MaNhaCungCap, TenDichVu, NgayDat, NgaySuDung, 
                    SoLuong, DonGia, TongTien, TrangThaiXacNhan, GhiChu
                ) VALUES (
                    :MaDoan, :LoaiDichVu, :MaNhaCungCap, :TenDichVu, :NgayDat, :NgaySuDung, 
                    :SoLuong, :DonGia, :TongTien, :TrangThaiXacNhan, :GhiChu
                )";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Cập nhật dịch vụ
    public function updateDichVu($data)
    {
        $sql = "UPDATE DichVuCuaDoan SET
                LoaiDichVu = :LoaiDichVu,
                MaNhaCungCap = :MaNhaCungCap,
                TenDichVu = :TenDichVu,
                NgayDat = :NgayDat,
                NgaySuDung = :NgaySuDung,
                SoLuong = :SoLuong,
                DonGia = :DonGia,
                TongTien = :TongTien,
                TrangThaiXacNhan = :TrangThaiXacNhan,
                GhiChu = :GhiChu
                WHERE MaDichVu = :MaDichVu";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Xóa dịch vụ
    public function deleteDichVu($maDichVu)
    {
        $sql = "DELETE FROM DichVuCuaDoan WHERE MaDichVu = :maDichVu";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':maDichVu', $maDichVu);
        return $stmt->execute();
    }
    // Ví dụ hàm insert chuẩn:
public function insertDichVu($ma_ncc, $loai_dich_vu, $chi_phi, $ghi_chu) {
    // Câu SQL giả định
    $sql = "INSERT INTO dichvucuadoan (MaNhaCungCap, LoaiDichVu, ChiPhi, GhiChu) 
            VALUES (?, ?, ?, ?)";
    // Thực thi câu lệnh với pdo...
    // ...
}
    
}