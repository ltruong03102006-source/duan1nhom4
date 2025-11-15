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
        $sql = "SELECT t.*, d.TenDanhMuc 
            FROM tour t
            LEFT JOIN danhmuctour d ON t.MaDanhMuc = d.MaDanhMuc
            ORDER BY t.MaTour DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getDanhMucTour()
    {
        $sql = "SELECT * FROM danhmuctour ORDER BY MaDanhMuc ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getOneTour($id)
    {
        $sql = "SELECT * FROM `tour` WHERE MaTour = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function addTour($MaCodeTour, $TenTour, $MaDanhMuc, $SoNgay, $SoDem, $DiemKhoiHanh, $MoTa, $GiaVonDuKien, $GiaBanMacDinh, $LinkAnhBia, $ChinhSachBaoGom, $ChinhSachKhongBaoGom, $ChinhSachHuy, $TrangThai)
    {
        $sql = "INSERT INTO Tour (
                    MaCodeTour, TenTour, MaDanhMuc, SoNgay, SoDem, DiemKhoiHanh, 
                    MoTa, LinkAnhBia, GiaVonDuKien, GiaBanMacDinh, 
                    ChinhSachBaoGom, ChinhSachKhongBaoGom, ChinhSachHuy, TrangThai, 
                    NgayTao, NgayCapNhat
                ) VALUES (
                    :MaCodeTour, :TenTour, :MaDanhMuc, :SoNgay, :SoDem, :DiemKhoiHanh, 
                    :MoTa, :LinkAnhBia, :GiaVonDuKien, :GiaBanMacDinh, 
                    :ChinhSachBaoGom, :ChinhSachKhongBaoGom, :ChinhSachHuy, :TrangThai,
                    CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
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
        $stmt->bindParam(':TrangThai', $TrangThai);

        $stmt->execute();
    }
    public function getOneTourEdit($id)
    {
        $sql = "SELECT * FROM Tour WHERE MaTour = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

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
                TrangThai = :TrangThai,
                LinkAnhBia = :LinkAnhBia,
                NgayCapNhat = CURRENT_TIMESTAMP
            WHERE MaTour = :MaTour";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }
    public function deleteTour($id)
    {
        $sql = "DELETE FROM Tour WHERE MaTour = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
