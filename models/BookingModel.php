<?php
class BookingModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // ================== BOOKING ==================

    // Danh sách booking + tên tour + tên khách
    public function getAllBooking()
    {
        $sql = "SELECT b.*, t.TenTour, d.NgayKhoiHanh, k.HoTen AS TenKhach
                FROM Booking b
                LEFT JOIN Tour t ON b.MaTour = t.MaTour
                LEFT JOIN DoanKhoiHanh d ON b.MaDoan = d.MaDoan
                LEFT JOIN KhachHang k ON b.MaKhachHang = k.MaKhachHang
                ORDER BY b.MaBooking DESC";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllTour()
    {
        $sql = "
        SELECT 
            t.*,

            nl.GiaTien AS GiaNguoiLon,
            te.GiaTien AS GiaTreEm,
            eb.GiaTien AS GiaEmBe

        FROM Tour t

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
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getAllDoan()
    {
        $sql = "SELECT d.*, t.TenTour 
                FROM DoanKhoiHanh d
                JOIN Tour t ON d.MaTour = t.MaTour
                ORDER BY d.MaDoan DESC";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllKhachHang()
    {
        $sql = "SELECT * FROM KhachHang ORDER BY MaKhachHang DESC";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

     public function addBooking($data)
    {
        $sql = "INSERT INTO Booking (
                MaCodeBooking, MaTour, MaDoan, MaKhachHang, LoaiBooking,
                TongNguoiLon, TongTreEm, TongEmBe,
                TongTien, SoTienDaCoc, SoTienDaTra, SoTienConLai,
                YeuCauDacBiet, MaNguoiTao
            ) VALUES (
                :MaCodeBooking, :MaTour, :MaDoan, :MaKhachHang, :LoaiBooking,
                :TongNguoiLon, :TongTreEm, :TongEmBe,
                :TongTien, :SoTienDaCoc, :SoTienDaTra, :SoTienConLai,
                :YeuCauDacBiet, :MaNguoiTao
            )";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }



    public function getOneBooking($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM Booking WHERE MaBooking = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateBooking($data)
    {
        $sql = "UPDATE Booking SET 
                    MaTour = :MaTour,
                    MaDoan = :MaDoan,
                    MaKhachHang = :MaKhachHang,
                    LoaiBooking = :LoaiBooking,
                    TongNguoiLon = :TongNguoiLon,
                    TongTreEm = :TongTreEm,
                    TongEmBe = :TongEmBe,
                    TongTien = :TongTien,
                    SoTienDaCoc = :SoTienDaCoc,
                    SoTienDaTra = :SoTienDaTra,
                    SoTienConLai = :SoTienConLai,
                    YeuCauDacBiet = :YeuCauDacBiet,
                    TrangThai = :TrangThai,
                    NgayCapNhat = CURRENT_TIMESTAMP
                WHERE MaBooking = :MaBooking";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    public function deleteBooking($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM Booking WHERE MaBooking = :id");
        return $stmt->execute([':id' => $id]);
    }

    // Lưu lịch sử thay đổi trạng thái
    public function addLichSuTrangThai($MaBooking, $TrangThaiCu, $TrangThaiMoi, $MaNguoiDoi = null, $GhiChu = null)
    {
        $sql = "INSERT INTO LichSuTrangThaiBooking 
                    (MaBooking, TrangThaiCu, TrangThaiMoi, MaNguoiDoi, GhiChu)
                VALUES (:MaBooking, :TrangThaiCu, :TrangThaiMoi, :MaNguoiDoi, :GhiChu)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':MaBooking' => $MaBooking,
            ':TrangThaiCu' => $TrangThaiCu,
            ':TrangThaiMoi' => $TrangThaiMoi,
            ':MaNguoiDoi' => $MaNguoiDoi,
            ':GhiChu' => $GhiChu
        ]);
    }

    // ================== KHÁCH TRONG BOOKING ==================

    public function getKhachTrongBooking($MaBooking)
    {
        $stmt = $this->conn->prepare("SELECT * FROM KhachTrongBooking WHERE MaBooking = :id");
        $stmt->execute([':id' => $MaBooking]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addKhachTrongBooking($data)
    {
        $sql = "INSERT INTO KhachTrongBooking 
                    (MaBooking, HoTen, GioiTinh, NgaySinh, SoGiayTo, SoDienThoai, GhiChuDacBiet, LoaiPhong)
                VALUES (:MaBooking, :HoTen, :GioiTinh, :NgaySinh, :SoGiayTo, :SoDienThoai, :GhiChuDacBiet, :LoaiPhong)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    public function deleteKhachTrongBooking($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM KhachTrongBooking WHERE MaKhachTrongBooking = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function updateDiemDanh($id, $status)
    {
        $stmt = $this->conn->prepare("UPDATE KhachTrongBooking SET TrangThaiDiemDanh = :st WHERE MaKhachTrongBooking = :id");
        return $stmt->execute([':st' => $status, ':id' => $id]);
    }

    // Lấy booking + tour + đoàn để hiển thị trong màn khách
    public function getBookingDetailWithDoan($MaBooking)
    {
        $sql = "SELECT b.*, t.TenTour, d.NgayKhoiHanh, d.NgayVe, d.DiemTapTrung
                FROM Booking b
                LEFT JOIN Tour t ON b.MaTour = t.MaTour
                LEFT JOIN DoanKhoiHanh d ON b.MaDoan = d.MaDoan
                WHERE b.MaBooking = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $MaBooking]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getMaBookingByMaDoan($MaDoan)
    {
        $sql = "SELECT MaBooking FROM Booking WHERE MaDoan = :md ORDER BY MaBooking DESC LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':md' => $MaDoan]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['MaBooking'] ?? null;
    }
    public function hdvCanAccessBooking($MaBooking, $MaHDV)
    {
        $sql = "SELECT COUNT(*) as c
            FROM Booking b
            JOIN DoanKhoiHanh d ON b.MaDoan = d.MaDoan
            WHERE b.MaBooking = :mb AND d.MaHuongDanVien = :hdv";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':mb' => $MaBooking, ':hdv' => $MaHDV]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($row['c'] ?? 0) > 0;
    }
    // Info đoàn để HDV xem (tour, ngày đi/về, điểm tập trung)
    public function getDoanInfoForHdv($MaDoan)
    {
        $sql = "SELECT d.MaDoan, d.NgayKhoiHanh, d.NgayVe, d.DiemTapTrung,
                   t.TenTour, t.MaCodeTour
            FROM DoanKhoiHanh d
            JOIN Tour t ON d.MaTour = t.MaTour
            WHERE d.MaDoan = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $MaDoan]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy toàn bộ khách (KhachTrongBooking) thuộc các booking của 1 đoàn
    public function getKhachTrongDoan($MaDoan)
    {
        $sql = "SELECT ktb.*, b.MaBooking, b.MaCodeBooking
            FROM KhachTrongBooking ktb
            JOIN Booking b ON ktb.MaBooking = b.MaBooking
            WHERE b.MaDoan = :MaDoan
            ORDER BY b.MaBooking DESC, ktb.MaKhachTrongBooking DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':MaDoan' => $MaDoan]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // BookingModel.php (hoặc nơi bạn đang query DB của booking)
    public function getGiaHienTaiByTour($maTour)
    {
        $sql = "
        SELECT
            t.MaTour,

            nl.GiaTien AS GiaNguoiLon,
            te.GiaTien AS GiaTreEm,
            eb.GiaTien AS GiaEmBe

        FROM Tour t

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

        WHERE t.MaTour = :maTour
        LIMIT 1
    ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':maTour' => $maTour]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function recalcPaymentByBooking($MaBooking)
    {
        // Tổng tiền đã trả = tổng các thanh toán thành công
        $sqlPaid = "SELECT COALESCE(SUM(SoTien),0) AS Paid
               FROM ThanhToan
               WHERE MaBooking = :mb AND TrangThai = 'thanh_cong'";
        $st = $this->conn->prepare($sqlPaid);
        $st->execute([':mb' => $MaBooking]);
        $paid = (float)($st->fetch(PDO::FETCH_ASSOC)['Paid'] ?? 0);

        // Lấy tổng tiền booking
        $sqlBk = "SELECT TongTien FROM Booking WHERE MaBooking = :mb";
        $st2 = $this->conn->prepare($sqlBk);
        $st2->execute([':mb' => $MaBooking]);
        $tongTien = (float)($st2->fetch(PDO::FETCH_ASSOC)['TongTien'] ?? 0);

        $conLai = max(0, $tongTien - $paid);

        // Set trạng thái booking theo số tiền đã trả
        // (Bạn có thể đổi logic theo ý bạn)
        if ($paid <= 0) $trangThai = 'cho_coc';
        else if ($conLai > 0) $trangThai = 'da_coc';
        else $trangThai = 'hoan_tat';

        $sqlUp = "UPDATE Booking
              SET SoTienDaTra = :paid,
                  SoTienConLai = :conlai,
                  TrangThai = :st,
                  NgayCapNhat = CURRENT_TIMESTAMP
              WHERE MaBooking = :mb";
        $st3 = $this->conn->prepare($sqlUp);
        return $st3->execute([
            ':paid' => $paid,
            ':conlai' => $conLai,
            ':st' => $trangThai,
            ':mb' => $MaBooking
        ]);
    }
     public function updateTrangThaiDoanBySoKhach($MaDoan)
    {
        if (empty($MaDoan)) return;

        // 1) Tổng khách của đoàn = tổng số người của các booking thuộc đoàn (booking chưa huỷ)
        $sql = "SELECT COALESCE(SUM(TongNguoiLon + TongTreEm + TongEmBe),0) AS TongKhach
            FROM Booking
            WHERE MaDoan = :md AND TrangThai <> 'da_huy'";
        $st = $this->conn->prepare($sql);
        $st->execute([':md' => $MaDoan]);
        $tongKhach = (int)($st->fetch(PDO::FETCH_ASSOC)['TongKhach'] ?? 0);

        // 2) Lấy sức chứa đoàn
        $st2 = $this->conn->prepare("SELECT SoChoToiDa FROM DoanKhoiHanh WHERE MaDoan = :md LIMIT 1");
        $st2->execute([':md' => $MaDoan]);
        $soChoToiDa = (int)($st2->fetch(PDO::FETCH_ASSOC)['SoChoToiDa'] ?? 0);

        // 3) Quy tắc trạng thái
        if ($tongKhach < 10) {
            $new = 'da_huy';
        } else if ($soChoToiDa > 0 && $tongKhach >= $soChoToiDa) {
            $new = 'het_cho';
        } else {
            $new = 'con_cho';
        }

        $st3 = $this->conn->prepare("UPDATE DoanKhoiHanh SET TrangThai = :st WHERE MaDoan = :md");
        $st3->execute([':st' => $new, ':md' => $MaDoan]);
    }

    public function getBookingByKhachTrongBooking($MaKhachTrongBooking)
    {
        $sql = "SELECT b.*
            FROM KhachTrongBooking ktb
            JOIN Booking b ON ktb.MaBooking = b.MaBooking
            WHERE ktb.MaKhachTrongBooking = :id
            LIMIT 1";
        $st = $this->conn->prepare($sql);
        $st->execute([':id' => $MaKhachTrongBooking]);
        return $st->fetch(PDO::FETCH_ASSOC);
    }
}
