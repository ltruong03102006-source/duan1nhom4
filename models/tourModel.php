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
        $sql = "
        SELECT 
            t.*,
            d.TenDanhMuc,

            -- Tổng dự toán chi phí
            COALESCE(dt.TongDuToan, 0) AS TongDuToan,

            -- Giá theo loại khách (lấy giá mới nhất theo ApDungTuNgay)
            nl.GiaTien AS GiaNguoiLon,
            te.GiaTien AS GiaTreEm,
            eb.GiaTien AS GiaEmBe

        FROM Tour t
        LEFT JOIN DanhMucTour d ON t.MaDanhMuc = d.MaDanhMuc

        LEFT JOIN (
            SELECT MaTour, SUM(SoTienDuKien) AS TongDuToan
            FROM DuToanChiPhiTour
            GROUP BY MaTour
        ) dt ON dt.MaTour = t.MaTour

        LEFT JOIN (
            SELECT gt1.MaTour, gt1.GiaTien
            FROM GiaTour gt1
            INNER JOIN (
                SELECT MaTour, MAX(COALESCE(ApDungTuNgay, '1000-01-01')) AS maxDate
                FROM GiaTour
                WHERE LoaiKhach = 'nguoi_lon'
                GROUP BY MaTour
            ) x ON x.MaTour = gt1.MaTour 
               AND COALESCE(gt1.ApDungTuNgay, '1000-01-01') = x.maxDate
            WHERE gt1.LoaiKhach = 'nguoi_lon'
        ) nl ON nl.MaTour = t.MaTour

        LEFT JOIN (
            SELECT gt1.MaTour, gt1.GiaTien
            FROM GiaTour gt1
            INNER JOIN (
                SELECT MaTour, MAX(COALESCE(ApDungTuNgay, '1000-01-01')) AS maxDate
                FROM GiaTour
                WHERE LoaiKhach = 'tre_em'
                GROUP BY MaTour
            ) x ON x.MaTour = gt1.MaTour 
               AND COALESCE(gt1.ApDungTuNgay, '1000-01-01') = x.maxDate
            WHERE gt1.LoaiKhach = 'tre_em'
        ) te ON te.MaTour = t.MaTour

        LEFT JOIN (
            SELECT gt1.MaTour, gt1.GiaTien
            FROM GiaTour gt1
            INNER JOIN (
                SELECT MaTour, MAX(COALESCE(ApDungTuNgay, '1000-01-01')) AS maxDate
                FROM GiaTour
                WHERE LoaiKhach = 'em_be'
                GROUP BY MaTour
            ) x ON x.MaTour = gt1.MaTour 
               AND COALESCE(gt1.ApDungTuNgay, '1000-01-01') = x.maxDate
            WHERE gt1.LoaiKhach = 'em_be'
        ) eb ON eb.MaTour = t.MaTour

        ORDER BY t.MaTour DESC
    ";

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
        $sql = "
        SELECT 
            t.*,
            d.TenDanhMuc,

            COALESCE(dt.TongDuToan, 0) AS TongDuToan,

            nl.GiaTien AS GiaNguoiLon,
            te.GiaTien AS GiaTreEm,
            eb.GiaTien AS GiaEmBe

        FROM Tour t
        LEFT JOIN DanhMucTour d ON t.MaDanhMuc = d.MaDanhMuc

        LEFT JOIN (
            SELECT MaTour, SUM(SoTienDuKien) AS TongDuToan
            FROM DuToanChiPhiTour
            GROUP BY MaTour
        ) dt ON dt.MaTour = t.MaTour

        LEFT JOIN (
            SELECT gt1.MaTour, gt1.GiaTien
            FROM GiaTour gt1
            INNER JOIN (
                SELECT MaTour, MAX(COALESCE(ApDungTuNgay, '1000-01-01')) AS maxDate
                FROM GiaTour
                WHERE LoaiKhach = 'nguoi_lon'
                GROUP BY MaTour
            ) x ON x.MaTour = gt1.MaTour 
               AND COALESCE(gt1.ApDungTuNgay, '1000-01-01') = x.maxDate
            WHERE gt1.LoaiKhach = 'nguoi_lon'
        ) nl ON nl.MaTour = t.MaTour

        LEFT JOIN (
            SELECT gt1.MaTour, gt1.GiaTien
            FROM GiaTour gt1
            INNER JOIN (
                SELECT MaTour, MAX(COALESCE(ApDungTuNgay, '1000-01-01')) AS maxDate
                FROM GiaTour
                WHERE LoaiKhach = 'tre_em'
                GROUP BY MaTour
            ) x ON x.MaTour = gt1.MaTour 
               AND COALESCE(gt1.ApDungTuNgay, '1000-01-01') = x.maxDate
            WHERE gt1.LoaiKhach = 'tre_em'
        ) te ON te.MaTour = t.MaTour

        LEFT JOIN (
            SELECT gt1.MaTour, gt1.GiaTien
            FROM GiaTour gt1
            INNER JOIN (
                SELECT MaTour, MAX(COALESCE(ApDungTuNgay, '1000-01-01')) AS maxDate
                FROM GiaTour
                WHERE LoaiKhach = 'em_be'
                GROUP BY MaTour
            ) x ON x.MaTour = gt1.MaTour 
               AND COALESCE(gt1.ApDungTuNgay, '1000-01-01') = x.maxDate
            WHERE gt1.LoaiKhach = 'em_be'
        ) eb ON eb.MaTour = t.MaTour

        WHERE t.MaTour = :id
        LIMIT 1
    ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
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

        $ok = $stmt->execute();
        if (!$ok) return false;

        // TRẢ VỀ ID VỪA THÊM
        return (int)$this->conn->lastInsertId();
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
    // Thêm nhiều dòng giá tour sau khi đã có MaTour
    public function addGiaTourBulk($maTour, $listGia)
    {
        if (empty($listGia)) return true;

        $sql = "INSERT INTO GiaTour
            (MaTour, LoaiKhach, GiaTien, ApDungTuNgay, ApDungDenNgay, LoaiMua, TenKhuyenMai, PhanTramGiamGia)
            VALUES
            (:MaTour, :LoaiKhach, :GiaTien, :ApDungTuNgay, :ApDungDenNgay, :LoaiMua, :TenKhuyenMai, :PhanTramGiamGia)";
        $stmt = $this->conn->prepare($sql);

        foreach ($listGia as $g) {
            // bỏ dòng rỗng
            if (empty($g['LoaiKhach']) || $g['GiaTien'] === '' || $g['GiaTien'] === null) continue;

            $stmt->execute([
                ':MaTour' => $maTour,
                ':LoaiKhach' => $g['LoaiKhach'],
                ':GiaTien' => $g['GiaTien'],
                ':ApDungTuNgay' => !empty($g['ApDungTuNgay']) ? $g['ApDungTuNgay'] : null,
                ':ApDungDenNgay' => !empty($g['ApDungDenNgay']) ? $g['ApDungDenNgay'] : null,
                ':LoaiMua' => !empty($g['LoaiMua']) ? $g['LoaiMua'] : 'binh_thuong',
                ':TenKhuyenMai' => !empty($g['TenKhuyenMai']) ? $g['TenKhuyenMai'] : null,
                ':PhanTramGiamGia' => isset($g['PhanTramGiamGia']) ? $g['PhanTramGiamGia'] : 0,
            ]);
        }
        return true;
    }

    // Thêm nhiều dòng dự toán sau khi đã có MaTour
    public function addDuToanBulk($maTour, $listDuToan)
    {
        if (empty($listDuToan)) return true;

        $sql = "INSERT INTO DuToanChiPhiTour (MaTour, HangMucChi, SoTienDuKien, GhiChu)
            VALUES (:MaTour, :HangMucChi, :SoTienDuKien, :GhiChu)";
        $stmt = $this->conn->prepare($sql);

        foreach ($listDuToan as $d) {
            if (empty($d['HangMucChi']) || $d['SoTienDuKien'] === '' || $d['SoTienDuKien'] === null) continue;

            $stmt->execute([
                ':MaTour' => $maTour,
                ':HangMucChi' => $d['HangMucChi'],
                ':SoTienDuKien' => $d['SoTienDuKien'],
                ':GhiChu' => !empty($d['GhiChu']) ? $d['GhiChu'] : null,
            ]);
        }
        return true;
    }
    // XÓA HẾT GIÁ CŨ theo MaTour rồi insert lại list mới
    public function replaceGiaTour($maTour, $listGia)
    {
        // xóa cũ
        $del = $this->conn->prepare("DELETE FROM GiaTour WHERE MaTour = :MaTour");
        $del->execute([':MaTour' => $maTour]);

        // thêm lại
        return $this->addGiaTourBulk($maTour, $listGia);
    }

    // XÓA HẾT DỰ TOÁN CŨ theo MaTour rồi insert lại list mới
    public function replaceDuToan($maTour, $listDuToan)
    {
        // xóa cũ
        $del = $this->conn->prepare("DELETE FROM DuToanChiPhiTour WHERE MaTour = :MaTour");
        $del->execute([':MaTour' => $maTour]);

        // thêm lại
        return $this->addDuToanBulk($maTour, $listDuToan);
    }
}
