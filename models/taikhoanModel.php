<?php
// Có class chứa các function thực thi tương tác với cơ sở dữ liệu 
class taikhoanModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // 1. Lấy danh sách tài khoản (JOIN với NhanVien để lấy HoTen)
    public function getAllTaiKhoanNhanVien()
    {
        $sql = "SELECT 
                    tk.MaTaiKhoan, 
                    tk.TenDangNhap, 
                    tk.VaiTro AS VaiTroTaiKhoan, 
                    tk.TrangThai, 
                    tk.NgayTao,
                    tk.LanDangNhapCuoi,
                    nv.MaCodeNhanVien,
                    nv.HoTen,
                    nv.VaiTro AS VaiTroNhanVien,
                    nv.MaNhanVien
                FROM taikhoan tk
                JOIN nhanvien nv ON tk.MaNhanVien = nv.MaNhanVien
                WHERE tk.MaKhachHang IS NULL"; // Chỉ lấy tài khoản của nhân viên
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // 2. Lấy danh sách nhân viên CHƯA CÓ tài khoản
    public function getAllNhanVienChuaCoTaiKhoan()
    {
        $sql = "SELECT * FROM nhanvien 
                WHERE MaNhanVien NOT IN (SELECT MaNhanVien FROM taikhoan WHERE MaNhanVien IS NOT NULL)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // 3. Thêm tài khoản mới cho nhân viên
    public function addTaiKhoanNhanVien($tenDangNhap, $matKhau, $vaiTro, $maNhanVien)
    {
        // Sử dụng password_hash để mã hóa mật khẩu trước khi lưu
        $hashed_password = password_hash($matKhau, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO taikhoan (TenDangNhap, MatKhau, VaiTro, MaNhanVien, TrangThai) 
                VALUES (:tenDangNhap, :matKhau, :vaiTro, :maNhanVien, 'hoat_dong')";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':tenDangNhap', $tenDangNhap);
        $stmt->bindParam(':matKhau', $hashed_password);
        $stmt->bindParam(':vaiTro', $vaiTro);
        $stmt->bindParam(':maNhanVien', $maNhanVien);
        return $stmt->execute();
    }
    
    // 4. Cập nhật trạng thái (Khóa / Mở khóa)
    public function updateTrangThai($maTaiKhoan, $trangThaiMoi)
    {
        $sql = "UPDATE taikhoan SET TrangThai = :trangThaiMoi WHERE MaTaiKhoan = :maTaiKhoan";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':trangThaiMoi', $trangThaiMoi);
        $stmt->bindParam(':maTaiKhoan', $maTaiKhoan);
        return $stmt->execute();
    }

    // 5. Lấy thông tin TÀI KHOẢN và NHÂN VIÊN theo MaTaiKhoan (Phục vụ Edit)
    public function getTaiKhoanVaNhanVienById($id)
    {
        $sql = "SELECT 
                    tk.MaTaiKhoan, 
                    tk.TenDangNhap, 
                    tk.MatKhau,
                    tk.VaiTro AS VaiTroTaiKhoan, 
                    tk.MaNhanVien,
                    nv.HoTen,
                    nv.MaCodeNhanVien
                FROM taikhoan tk
                JOIN nhanvien nv ON tk.MaNhanVien = nv.MaNhanVien
                WHERE tk.MaTaiKhoan = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // 6. Cập nhật tài khoản (Edit)
    public function updateTaiKhoan($maTaiKhoan, $tenDangNhap, $vaiTro, $matKhau = null)
    {
        $sql = "UPDATE taikhoan 
                SET TenDangNhap = :tenDangNhap, VaiTro = :vaiTro";
        
        if ($matKhau !== null) {
            $sql .= ", MatKhau = :matKhau";
        }

        $sql .= " WHERE MaTaiKhoan = :maTaiKhoan";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':maTaiKhoan', $maTaiKhoan);
        $stmt->bindParam(':tenDangNhap', $tenDangNhap);
        $stmt->bindParam(':vaiTro', $vaiTro);
        
        if ($matKhau !== null) {
            $hashed_password = password_hash($matKhau, PASSWORD_DEFAULT);
            $stmt->bindParam(':matKhau', $hashed_password);
        }
        
        return $stmt->execute();
    }
}