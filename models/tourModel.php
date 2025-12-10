<?php
// models/tourModel.php

class tourModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // --- LẤY DANH SÁCH TOUR (HIỂN THỊ TRANG CHỦ QUẢN TRỊ) ---
    public function getAllTour()
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
        ORDER BY t.MaTour DESC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- LẤY DANH MỤC ---
    public function getDanhMucTour()
    {
        $sql = "SELECT * FROM danhmuctour ORDER BY MaDanhMuc ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- LẤY CHI TIẾT 1 TOUR (ĐỂ XEM) ---
    public function getOneTour($id)
    {
        $sql = "
        SELECT 
            t.*, d.TenDanhMuc,
            COALESCE(dt.TongDuToan, 0) AS TongDuToan,
            nl.GiaTien AS GiaNguoiLon, te.GiaTien AS GiaTreEm, eb.GiaTien AS GiaEmBe
        FROM Tour t
        LEFT JOIN DanhMucTour d ON t.MaDanhMuc = d.MaDanhMuc
        LEFT JOIN (SELECT MaTour, SUM(SoTienDuKien) AS TongDuToan FROM DuToanChiPhiTour GROUP BY MaTour) dt ON dt.MaTour = t.MaTour
        LEFT JOIN (SELECT gt1.MaTour, gt1.GiaTien FROM GiaTour gt1 INNER JOIN (SELECT MaTour, MAX(COALESCE(ApDungTuNgay, '1000-01-01')) AS maxDate FROM GiaTour WHERE LoaiKhach = 'nguoi_lon' GROUP BY MaTour) x ON x.MaTour = gt1.MaTour AND COALESCE(gt1.ApDungTuNgay, '1000-01-01') = x.maxDate WHERE gt1.LoaiKhach = 'nguoi_lon') nl ON nl.MaTour = t.MaTour
        LEFT JOIN (SELECT gt1.MaTour, gt1.GiaTien FROM GiaTour gt1 INNER JOIN (SELECT MaTour, MAX(COALESCE(ApDungTuNgay, '1000-01-01')) AS maxDate FROM GiaTour WHERE LoaiKhach = 'tre_em' GROUP BY MaTour) x ON x.MaTour = gt1.MaTour AND COALESCE(gt1.ApDungTuNgay, '1000-01-01') = x.maxDate WHERE gt1.LoaiKhach = 'tre_em') te ON te.MaTour = t.MaTour
        LEFT JOIN (SELECT gt1.MaTour, gt1.GiaTien FROM GiaTour gt1 INNER JOIN (SELECT MaTour, MAX(COALESCE(ApDungTuNgay, '1000-01-01')) AS maxDate FROM GiaTour WHERE LoaiKhach = 'em_be' GROUP BY MaTour) x ON x.MaTour = gt1.MaTour AND COALESCE(gt1.ApDungTuNgay, '1000-01-01') = x.maxDate WHERE gt1.LoaiKhach = 'em_be') eb ON eb.MaTour = t.MaTour
        WHERE t.MaTour = :id LIMIT 1";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // --- LẤY 1 TOUR ĐỂ SỬA (RAW DATA) ---
    public function getOneTourEdit($id)
    {
        $sql = "SELECT * FROM Tour WHERE MaTour = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // --- [MỚI] KIỂM TRA MÃ TOUR CÓ TỒN TẠI KHÔNG ---
    public function checkMaTourExists($maCode)
    {
        // Kiểm tra xem mã này đã có trong bảng Tour chưa
        $sql = "SELECT COUNT(*) FROM Tour WHERE MaCodeTour = :maCode";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':maCode' => $maCode]);
        return $stmt->fetchColumn() > 0;
    }
    // --- THÊM TOUR MỚI ---
    public function addTour($MaCodeTour, $TenTour, $MaDanhMuc, $SoNgay, $SoDem, $DiemKhoiHanh, $MoTa, $GiaVonDuKien, $GiaBanMacDinh, $LinkAnhBia, $ChinhSachBaoGom, $ChinhSachKhongBaoGom, $ChinhSachHuy, $ChinhSachHoanTien, $DuongDanDatTour, $TrangThai)
    {
        $sql = "INSERT INTO Tour (MaCodeTour, TenTour, MaDanhMuc, SoNgay, SoDem, DiemKhoiHanh, MoTa, LinkAnhBia, GiaVonDuKien, GiaBanMacDinh, ChinhSachBaoGom, ChinhSachKhongBaoGom, ChinhSachHuy, ChinhSachHoanTien, DuongDanDatTour, TrangThai, NgayTao, NgayCapNhat) 
                VALUES (:MaCodeTour, :TenTour, :MaDanhMuc, :SoNgay, :SoDem, :DiemKhoiHanh, :MoTa, :LinkAnhBia, :GiaVonDuKien, :GiaBanMacDinh, :ChinhSachBaoGom, :ChinhSachKhongBaoGom, :ChinhSachHuy, :ChinhSachHoanTien, :DuongDanDatTour, :TrangThai, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':MaCodeTour' => $MaCodeTour, ':TenTour' => $TenTour, ':MaDanhMuc' => $MaDanhMuc, 
            ':SoNgay' => $SoNgay, ':SoDem' => $SoDem, ':DiemKhoiHanh' => $DiemKhoiHanh, 
            ':MoTa' => $MoTa, ':LinkAnhBia' => $LinkAnhBia, ':GiaVonDuKien' => $GiaVonDuKien, 
            ':GiaBanMacDinh' => $GiaBanMacDinh, ':ChinhSachBaoGom' => $ChinhSachBaoGom, 
            ':ChinhSachKhongBaoGom' => $ChinhSachKhongBaoGom, ':ChinhSachHuy' => $ChinhSachHuy, 
            ':ChinhSachHoanTien' => $ChinhSachHoanTien, ':DuongDanDatTour' => $DuongDanDatTour, 
            ':TrangThai' => $TrangThai
        ]);
        return (int)$this->conn->lastInsertId();
    }

    // --- CẬP NHẬT TOUR ---
    public function updateTour($data)
    {
        $sql = "UPDATE Tour SET 
                MaCodeTour = :MaCodeTour, TenTour = :TenTour, MaDanhMuc = :MaDanhMuc, 
                SoNgay = :SoNgay, SoDem = :SoDem, DiemKhoiHanh = :DiemKhoiHanh, 
                MoTa = :MoTa, GiaVonDuKien = :GiaVonDuKien, GiaBanMacDinh = :GiaBanMacDinh, 
                ChinhSachBaoGom = :ChinhSachBaoGom, ChinhSachKhongBaoGom = :ChinhSachKhongBaoGom, 
                ChinhSachHuy = :ChinhSachHuy, ChinhSachHoanTien = :ChinhSachHoanTien, 
                DuongDanDatTour = :DuongDanDatTour, TrangThai = :TrangThai, LinkAnhBia = :LinkAnhBia, 
                NgayCapNhat = CURRENT_TIMESTAMP
                WHERE MaTour = :MaTour";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    // --- XÓA TOUR ---
    public function deleteTour($id)
    {
        $sql = "DELETE FROM Tour WHERE MaTour = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // --- CÁC HÀM GET DỮ LIỆU CON (Lịch trình, Giá, Dự toán) ---
    public function getLichTrinhByTourId($tourId) {
        $sql = "SELECT * FROM lichtrinh WHERE MaTour = :tourId ORDER BY NgayThu ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':tourId' => $tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getGiaTourByTourId($tourId) {
        $sql = "SELECT * FROM giatour WHERE MaTour = :tourId ORDER BY LoaiKhach, ApDungTuNgay DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':tourId' => $tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getDuToanByTourId($tourId) {
        $sql = "SELECT * FROM dutoanchiphitour WHERE MaTour = :tourId ORDER BY MaDuToan";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':tourId' => $tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- CÁC HÀM XỬ LÝ BULK INSERT & REPLACE (QUAN TRỌNG CHO ALL-IN-ONE) ---

    // 1. LỊCH TRÌNH
    public function addLichTrinhBulk($maTour, $listLichTrinh) {
        if (empty($listLichTrinh)) return true;
        $sql = "INSERT INTO LichTrinh (MaTour, NgayThu, TieuDeNgay, DiaDiemThamQuan, NoiO, CoBuaSang, CoBuaTrua, CoBuaToi, ChiTietHoatDong) 
                VALUES (:MaTour, :NgayThu, :TieuDeNgay, :DiaDiemThamQuan, :NoiO, :CoBuaSang, :CoBuaTrua, :CoBuaToi, :ChiTietHoatDong)";
        $stmt = $this->conn->prepare($sql);
        foreach ($listLichTrinh as $lt) {
            if (empty($lt['TieuDeNgay'])) continue;
            $stmt->execute([
                ':MaTour' => $maTour,
                ':NgayThu' => $lt['NgayThu'] ?? 1,
                ':TieuDeNgay' => $lt['TieuDeNgay'],
                ':DiaDiemThamQuan' => $lt['DiaDiemThamQuan'] ?? null,
                ':NoiO' => $lt['NoiO'] ?? null,
                ':CoBuaSang' => isset($lt['CoBuaSang']) ? 1 : 0,
                ':CoBuaTrua' => isset($lt['CoBuaTrua']) ? 1 : 0,
                ':CoBuaToi' => isset($lt['CoBuaToi']) ? 1 : 0,
                ':ChiTietHoatDong' => $lt['ChiTietHoatDong'] ?? null
            ]);
        }
        return true;
    }
    public function replaceLichTrinh($maTour, $listLichTrinh) {
        $this->conn->prepare("DELETE FROM LichTrinh WHERE MaTour = :id")->execute([':id' => $maTour]);
        return $this->addLichTrinhBulk($maTour, $listLichTrinh);
    }

    // 2. GIÁ TOUR
    public function addGiaTourBulk($maTour, $listGia) {
        if (empty($listGia)) return true;
        $sql = "INSERT INTO GiaTour (MaTour, LoaiKhach, GiaTien, ApDungTuNgay, ApDungDenNgay, LoaiMua, TenKhuyenMai, PhanTramGiamGia)
                VALUES (:MaTour, :LoaiKhach, :GiaTien, :ApDungTuNgay, :ApDungDenNgay, :LoaiMua, :TenKhuyenMai, :PhanTramGiamGia)";
        $stmt = $this->conn->prepare($sql);
        foreach ($listGia as $g) {
            if (empty($g['LoaiKhach']) || $g['GiaTien'] === '') continue;
            $stmt->execute([
                ':MaTour' => $maTour,
                ':LoaiKhach' => $g['LoaiKhach'],
                ':GiaTien' => $g['GiaTien'],
                ':ApDungTuNgay' => !empty($g['ApDungTuNgay']) ? $g['ApDungTuNgay'] : null,
                ':ApDungDenNgay' => !empty($g['ApDungDenNgay']) ? $g['ApDungDenNgay'] : null,
                ':LoaiMua' => $g['LoaiMua'] ?? 'binh_thuong',
                ':TenKhuyenMai' => $g['TenKhuyenMai'] ?? null,
                ':PhanTramGiamGia' => $g['PhanTramGiamGia'] ?? 0
            ]);
        }
        return true;
    }
    public function replaceGiaTour($maTour, $listGia) {
        $this->conn->prepare("DELETE FROM GiaTour WHERE MaTour = :id")->execute([':id' => $maTour]);
        return $this->addGiaTourBulk($maTour, $listGia);
    }

    // 3. DỰ TOÁN CHI PHÍ
    public function addDuToanBulk($maTour, $listDuToan) {
        if (empty($listDuToan)) return true;
        $sql = "INSERT INTO DuToanChiPhiTour (MaTour, HangMucChi, SoTienDuKien, GhiChu) VALUES (:MaTour, :HangMucChi, :SoTienDuKien, :GhiChu)";
        $stmt = $this->conn->prepare($sql);
        foreach ($listDuToan as $d) {
            if (empty($d['HangMucChi'])) continue;
            $stmt->execute([
                ':MaTour' => $maTour,
                ':HangMucChi' => $d['HangMucChi'],
                ':SoTienDuKien' => $d['SoTienDuKien'] ?? 0,
                ':GhiChu' => $d['GhiChu'] ?? null
            ]);
        }
        return true;
    }
    public function replaceDuToan($maTour, $listDuToan) {
        $this->conn->prepare("DELETE FROM DuToanChiPhiTour WHERE MaTour = :id")->execute([':id' => $maTour]);
        return $this->addDuToanBulk($maTour, $listDuToan);
    }
   // ... (các hàm khác)

    // --- [MỚI] KIỂM TRA TOUR CÓ BỊ BOOKING HOẶC ĐOÀN SỬ DỤNG KHÔNG ---
    public function checkIfUsedByBooking($MaTour)
    {
        // 1. Kiểm tra trong bảng Booking (lý do lỗi 1451)
        $sql = "SELECT COUNT(*) FROM Booking WHERE MaTour = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $MaTour);
        $stmt->execute();
        
        if ($stmt->fetchColumn() > 0) {
            return true;
        }

        // 2. Kiểm tra trong bảng DoanKhoiHanh
        $sql2 = "SELECT COUNT(*) FROM DoanKhoiHanh WHERE MaTour = :id";
        $stmt2 = $this->conn->prepare($sql2);
        $stmt2->bindParam(':id', $MaTour);
        $stmt2->execute();

        return $stmt2->fetchColumn() > 0;
    }
}
?>