<?php
class ThongKeModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // 1. Thống kê tổng quan (Doanh thu, Chi phí, Khách, Tour)
    public function getThongKeTongHop()
    {
        // Tính tổng doanh thu từ Booking (trừ các đơn đã hủy)
        $sqlDoanhThu = "SELECT SUM(TongTien) as TongDoanhThu 
                        FROM Booking 
                        WHERE TrangThai != 'da_huy'";
        $doanhThu = $this->conn->query($sqlDoanhThu)->fetch()['TongDoanhThu'] ?? 0;

        // Tính tổng chi phí từ Tài chính Tour (Loại giao dịch là 'chi')
        $sqlChiPhi = "SELECT SUM(SoTien) as TongChiPhi 
                      FROM TaiChinhTour 
                      WHERE LoaiGiaoDich = 'chi'";
        $chiPhi = $this->conn->query($sqlChiPhi)->fetch()['TongChiPhi'] ?? 0;

        // Đếm tổng số khách (Người lớn + Trẻ em + Em bé) từ Booking thành công
        $sqlKhach = "SELECT SUM(TongNguoiLon + TongTreEm + TongEmBe) as TongKhach 
                     FROM Booking 
                     WHERE TrangThai != 'da_huy'";
        $khach = $this->conn->query($sqlKhach)->fetch()['TongKhach'] ?? 0;

        // Đếm tổng số Tour đang hoạt động
        $sqlTour = "SELECT COUNT(*) as TongTour 
                    FROM Tour 
                    WHERE TrangThai = 'hoat_dong'";
        $tour = $this->conn->query($sqlTour)->fetch()['TongTour'] ?? 0;

        return [
            'DoanhThu' => $doanhThu,
            'ChiPhi'   => $chiPhi,
            'LoiNhuan' => $doanhThu - $chiPhi,
            'TongKhach' => $khach,
            'TongTour' => $tour
        ];
    }

    // 2. Lấy danh sách Booking mới nhất
    public function getBookingGanDay($limit = 5)
    {
        $sql = "SELECT b.*, t.TenTour, k.HoTen as TenKhach 
                FROM Booking b
                LEFT JOIN Tour t ON b.MaTour = t.MaTour
                LEFT JOIN KhachHang k ON b.MaKhachHang = k.MaKhachHang
                ORDER BY b.NgayTao DESC 
                LIMIT $limit";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // 3. Thống kê trạng thái Booking cho biểu đồ tròn
    public function getTyLeBooking()
    {
        $sql = "SELECT TrangThai, COUNT(*) as SoLuong 
                FROM Booking 
                GROUP BY TrangThai";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // 4. Thống kê doanh thu theo tháng (cho biểu đồ cột) - Mở rộng
    public function getDoanhThuTheoThang() {
        $sql = "SELECT MONTH(NgayTao) as Thang, SUM(TongTien) as DoanhThu 
                FROM Booking 
                WHERE TrangThai != 'da_huy' AND YEAR(NgayTao) = YEAR(CURRENT_DATE)
                GROUP BY MONTH(NgayTao)
                ORDER BY Thang";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>