<?php
class NhatKyTourModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
        // Bật lỗi để dễ debug
        if ($this->conn instanceof PDO) {
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }

    // ADMIN: toàn bộ nhật ký (đã join tên tour & người ghi)
    public function getAll()
    {
        $sql = "SELECT nk.*, d.MaTour, t.TenTour, nv.HoTen
                FROM NhatKyTour nk
                JOIN DoanKhoiHanh d ON nk.MaDoan = d.MaDoan
                JOIN Tour t ON d.MaTour = t.MaTour
                LEFT JOIN NhanVien nv ON nk.MaNguoiTao = nv.MaNhanVien
                ORDER BY nk.NgayGhi DESC, nk.GioGhi DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // HDV: theo đoàn
    public function getByDoan($maDoan)
    {
        $sql = "SELECT nk.*, nv.HoTen AS NguoiTao
                FROM NhatKyTour nk
                LEFT JOIN NhanVien nv ON nk.MaNguoiTao = nv.MaNhanVien
                WHERE nk.MaDoan = :MaDoan
                ORDER BY nk.NgayGhi DESC, nk.GioGhi DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':MaDoan' => $maDoan]);
        return $stmt->fetchAll();
    }

    // Insert
    public function add(array $data)
    {
        $sql = "INSERT INTO NhatKyTour
                (MaDoan, NgayGhi, GioGhi, NoiDung, LoaiSuCo, LinkAnh, MaNguoiTao)
                VALUES (:MaDoan, :NgayGhi, :GioGhi, :NoiDung, :LoaiSuCo, :LinkAnh, :MaNguoiTao)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }
}
