<?php
class NhatKyTourModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lấy toàn bộ nhật ký (ADMIN)
    public function getAll()
    {
        $sql = "SELECT nk.*, d.MaTour, t.TenTour, nv.HoTen
                FROM nhatkytour nk
                JOIN doankhoihanh d ON nk.MaDoan = d.MaDoan
                JOIN tour t ON d.MaTour = t.MaTour
                LEFT JOIN nhanvien nv ON nk.MaNguoiTao = nv.MaNhanVien
                ORDER BY nk.NgayGhi DESC, nk.GioGhi DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Lấy nhật ký theo đoàn (HDV)
    public function getByDoan($maDoan)
    {
        $sql = "SELECT nk.*, nv.HoTen
                FROM nhatkytour nk
                LEFT JOIN nhanvien nv ON nk.MaNguoiTao = nv.MaNhanVien
                WHERE nk.MaDoan = :maDoan
                ORDER BY nk.NgayGhi DESC, nk.GioGhi DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':maDoan' => $maDoan]);
        return $stmt->fetchAll();
    }

    // Thêm nhật ký
    public function add($data)
    {
        $sql = "INSERT INTO nhatkytour (MaDoan, NgayGhi, GioGhi, NoiDung, LoaiSuCo, LinkAnh, MaNguoiTao) 
                VALUES (:MaDoan, :NgayGhi, :GioGhi, :NoiDung, :LoaiSuCo, :LinkAnh, :MaNguoiTao)";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }
}
