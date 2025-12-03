<?php
// Có class chứa các function thực thi tương tác với cơ sở dữ liệu 
class tourModel
{
    public $conn;
    
    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lấy danh sách tất cả tour
    public function getAllTour()
    {
        $sql = "SELECT t.*, d.TenDanhMuc 
                FROM tour t
                LEFT JOIN danhmuctour d ON t.MaDanhMuc = d.MaDanhMuc
                ORDER BY t.MaTour DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh mục tour
    public function getDanhMucTour()
    {
        $sql = "SELECT * FROM danhmuctour ORDER BY MaDanhMuc ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy 1 tour theo ID (để xem chi tiết)
    public function getOneTour($id)
    {
        $sql = "SELECT * FROM tour WHERE MaTour = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Lấy 1 tour theo ID (để edit)
    public function getOneTourEdit($id)
    {
        $sql = "SELECT * FROM Tour WHERE MaTour = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm tour mới - 16 trường (KHÔNG có MaQR)
    public function addTour(
        $MaCodeTour, 
        $TenTour, 
        $MaDanhMuc, 
        $SoNgay, 
        $SoDem, 
        $DiemKhoiHanh, 
        $MoTa, 
        $GiaVonDuKien, 
        $GiaBanMacDinh, 
        $LinkAnhBia, 
        $ChinhSachBaoGom, 
        $ChinhSachKhongBaoGom, 
        $ChinhSachHuy,
        $ChinhSachHoanTien,
        $DuongDanDatTour,
        $TrangThai
    ) {
        $sql = "INSERT INTO Tour (
                    MaCodeTour, 
                    TenTour, 
                    MaDanhMuc, 
                    SoNgay, 
                    SoDem, 
                    DiemKhoiHanh, 
                    MoTa, 
                    LinkAnhBia, 
                    GiaVonDuKien, 
                    GiaBanMacDinh, 
                    ChinhSachBaoGom, 
                    ChinhSachKhongBaoGom, 
                    ChinhSachHuy,
                    ChinhSachHoanTien,
                    DuongDanDatTour,
                    TrangThai, 
                    NgayTao, 
                    NgayCapNhat
                ) VALUES (
                    :MaCodeTour, 
                    :TenTour, 
                    :MaDanhMuc, 
                    :SoNgay, 
                    :SoDem, 
                    :DiemKhoiHanh, 
                    :MoTa, 
                    :LinkAnhBia, 
                    :GiaVonDuKien, 
                    :GiaBanMacDinh, 
                    :ChinhSachBaoGom, 
                    :ChinhSachKhongBaoGom, 
                    :ChinhSachHuy,
                    :ChinhSachHoanTien,
                    :DuongDanDatTour,
                    :TrangThai,
                    CURRENT_TIMESTAMP, 
                    CURRENT_TIMESTAMP
                )";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':MaCodeTour', $MaCodeTour);
        $stmt->bindParam(':TenTour', $TenTour);
        $stmt->bindParam(':MaDanhMuc', $MaDanhMuc);
        $stmt->bindParam(':SoNgay', $SoNgay);
        $stmt->bindParam(':SoDem', $SoDem);
        $stmt->bindParam(':DiemKhoiHanh', $DiemKhoiHanh);
        $stmt->bindParam(':MoTa', $MoTa);
        $stmt->bindParam(':LinkAnhBia', $LinkAnhBia);
        $stmt->bindParam(':GiaVonDuKien', $GiaVonDuKien);
        $stmt->bindParam(':GiaBanMacDinh', $GiaBanMacDinh);
        $stmt->bindParam(':ChinhSachBaoGom', $ChinhSachBaoGom);
        $stmt->bindParam(':ChinhSachKhongBaoGom', $ChinhSachKhongBaoGom);
        $stmt->bindParam(':ChinhSachHuy', $ChinhSachHuy);
        $stmt->bindParam(':ChinhSachHoanTien', $ChinhSachHoanTien);
        $stmt->bindParam(':DuongDanDatTour', $DuongDanDatTour);
        $stmt->bindParam(':TrangThai', $TrangThai);

        return $stmt->execute();
    }

    // Cập nhật tour - 16 trường (KHÔNG có MaQR)
    public function updateTour($data)
    {
        $sql = "UPDATE Tour SET 
                MaCodeTour = :MaCodeTour,
                TenTour = :TenTour,
                MaDanhMuc = :MaDanhMuc,
                SoNgay = :SoNgay,
                SoDem = :SoDem,
                DiemKhoiHanh = :DiemKhoiHanh,
                MoTa = :MoTa,
                GiaVonDuKien = :GiaVonDuKien,
                GiaBanMacDinh = :GiaBanMacDinh,
                ChinhSachBaoGom = :ChinhSachBaoGom,
                ChinhSachKhongBaoGom = :ChinhSachKhongBaoGom,
                ChinhSachHuy = :ChinhSachHuy,
                ChinhSachHoanTien = :ChinhSachHoanTien,
                DuongDanDatTour = :DuongDanDatTour,
                TrangThai = :TrangThai,
                LinkAnhBia = :LinkAnhBia,
                NgayCapNhat = CURRENT_TIMESTAMP
            WHERE MaTour = :MaTour";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // Xóa tour
    public function deleteTour($id)
    {
        $sql = "DELETE FROM Tour WHERE MaTour = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Lấy lịch trình theo tour ID (cho HDV)
    public function getLichTrinhByTourId($tourId)
    {
        $sql = "SELECT * FROM lichtrinh WHERE MaTour = :tourId ORDER BY NgayThu ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':tourId', $tourId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy giá tour theo tour ID (cho HDV)
    public function getGiaTourByTourId($tourId)
    {
        $sql = "SELECT * FROM giatour WHERE MaTour = :tourId ORDER BY LoaiKhach, ApDungTuNgay DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':tourId', $tourId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy dự toán chi phí theo tour ID (cho HDV)
    public function getDuToanByTourId($tourId)
    {
        $sql = "SELECT * FROM dutoanchiphitour WHERE MaTour = :tourId ORDER BY MaDuToan";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':tourId', $tourId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tính tổng dự toán
    public function getTongDuToan($tourId)
    {
        $sql = "SELECT SUM(SoTienDuKien) as TongDuToan FROM dutoanchiphitour WHERE MaTour = :tourId";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':tourId', $tourId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['TongDuToan'] ?? 0;
    }
}