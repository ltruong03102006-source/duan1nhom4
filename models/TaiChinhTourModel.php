<?php
class TaiChinhTourModel {
    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    // Lấy danh sách thu/chi theo Đoàn
    public function getAllTaiChinhByDoan($maDoan) {
        $sql = "SELECT tc.*, ncc.TenNhaCungCap, nv.HoTen as NguoiTao
                FROM taichinhtour tc
                LEFT JOIN nhacungcap ncc ON tc.MaNhaCungCap = ncc.MaNhaCungCap
                LEFT JOIN nhanvien nv ON tc.MaNguoiTao = nv.MaNhanVien
                WHERE tc.MaDoan = :maDoan
                ORDER BY tc.NgayGiaoDich DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':maDoan' => $maDoan]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy 1 bản ghi chi tiết
    public function getOneTaiChinh($id) {
        $sql = "SELECT * FROM taichinhtour WHERE MaTaiChinh = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm mới giao dịch
    public function addTaiChinh($data) {
        $sql = "INSERT INTO taichinhtour 
                (MaDoan, LoaiGiaoDich, HangMucChi, SoTien, NgayGiaoDich, MoTa, PhuongThucThanhToan, SoHoaDon, MaNhaCungCap, MaNguoiTao)
                VALUES 
                (:MaDoan, :LoaiGiaoDich, :HangMucChi, :SoTien, :NgayGiaoDich, :MoTa, :PhuongThucThanhToan, :SoHoaDon, :MaNhaCungCap, :MaNguoiTao)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Cập nhật giao dịch
    public function updateTaiChinh($data) {
        $sql = "UPDATE taichinhtour SET 
                LoaiGiaoDich = :LoaiGiaoDich,
                HangMucChi = :HangMucChi,
                SoTien = :SoTien,
                NgayGiaoDich = :NgayGiaoDich,
                MoTa = :MoTa,
                PhuongThucThanhToan = :PhuongThucThanhToan,
                SoHoaDon = :SoHoaDon,
                MaNhaCungCap = :MaNhaCungCap
                WHERE MaTaiChinh = :MaTaiChinh";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Xóa giao dịch
    public function deleteTaiChinh($id) {
        $sql = "DELETE FROM taichinhtour WHERE MaTaiChinh = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // Tính tổng thu và tổng chi của đoàn để làm báo cáo
    public function getThongKeTaiChinh($maDoan) {
        $sql = "SELECT 
                    SUM(CASE WHEN LoaiGiaoDich = 'thu' THEN SoTien ELSE 0 END) as TongThu,
                    SUM(CASE WHEN LoaiGiaoDich = 'chi' THEN SoTien ELSE 0 END) as TongChi
                FROM taichinhtour WHERE MaDoan = :maDoan";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':maDoan' => $maDoan]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách Nhà cung cấp để chọn khi tạo phiếu chi
    public function getAllNhaCungCap() {
        $sql = "SELECT MaNhaCungCap, TenNhaCungCap FROM nhacungcap WHERE TrangThai = 'hoat_dong'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Lấy thông tin đoàn để hiển thị tiêu đề
    public function getInfoDoan($maDoan) {
        $sql = "SELECT d.*, t.TenTour, t.MaCodeTour 
                FROM doankhoihanh d 
                JOIN tour t ON d.MaTour = t.MaTour 
                WHERE d.MaDoan = :maDoan";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':maDoan' => $maDoan]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>