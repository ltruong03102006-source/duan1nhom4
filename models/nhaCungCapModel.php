<?php
// Có class chứa các function thực thi tương tác với cơ sở dữ liệu 
class nhaCungCapModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // 1. Lấy tất cả nhà cung cấp
    public function getAllNhaCungCap()
    {
        $sql = "SELECT * FROM nhacungcap";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // 2. Lấy một nhà cung cấp theo ID
    public function getNhaCungCapById($id)
    {
        $sql = "SELECT * FROM nhacungcap WHERE MaNhaCungCap = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // 3. Thêm nhà cung cấp mới
    public function addNhaCungCap($data)
    {
        $sql = "INSERT INTO nhacungcap 
                (MaCodeNCC, TenNhaCungCap, LoaiNhaCungCap, NguoiLienHe, SoDienThoai, Email, DiaChi, DichVuCungCap, FileHopDong, NgayBatDauHopDong, NgayKetThucHopDong, DanhGia, GhiChu, TrangThai) 
                VALUES 
                (:MaCodeNCC, :TenNhaCungCap, :LoaiNhaCungCap, :NguoiLienHe, :SoDienThoai, :Email, :DiaChi, :DichVuCungCap, :FileHopDong, :NgayBatDauHopDong, :NgayKetThucHopDong, :DanhGia, :GhiChu, :TrangThai)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':MaCodeNCC', $data['MaCodeNCC']);
        $stmt->bindParam(':TenNhaCungCap', $data['TenNhaCungCap']);
        $stmt->bindParam(':LoaiNhaCungCap', $data['LoaiNhaCungCap']);
        $stmt->bindParam(':NguoiLienHe', $data['NguoiLienHe']);
        $stmt->bindParam(':SoDienThoai', $data['SoDienThoai']);
        $stmt->bindParam(':Email', $data['Email']);
        $stmt->bindParam(':DiaChi', $data['DiaChi']);
        $stmt->bindParam(':DichVuCungCap', $data['DichVuCungCap']);
        $stmt->bindParam(':FileHopDong', $data['FileHopDong']);
        $stmt->bindParam(':NgayBatDauHopDong', $data['NgayBatDauHopDong']);
        $stmt->bindParam(':NgayKetThucHopDong', $data['NgayKetThucHopDong']);
        $stmt->bindParam(':DanhGia', $data['DanhGia']);
        $stmt->bindParam(':GhiChu', $data['GhiChu']);
        $stmt->bindParam(':TrangThai', $data['TrangThai']);
        
        return $stmt->execute();
    }

    // 4. Cập nhật nhà cung cấp
    public function updateNhaCungCap($data)
    {
        $sql = "UPDATE nhacungcap SET
                    MaCodeNCC = :MaCodeNCC,
                    TenNhaCungCap = :TenNhaCungCap,
                    LoaiNhaCungCap = :LoaiNhaCungCap,
                    NguoiLienHe = :NguoiLienHe,
                    SoDienThoai = :SoDienThoai,
                    Email = :Email,
                    DiaChi = :DiaChi,
                    DichVuCungCap = :DichVuCungCap,
                    FileHopDong = :FileHopDong,
                    NgayBatDauHopDong = :NgayBatDauHopDong,
                    NgayKetThucHopDong = :NgayKetThucHopDong,
                    DanhGia = :DanhGia,
                    GhiChu = :GhiChu,
                    TrangThai = :TrangThai
                WHERE MaNhaCungCap = :MaNhaCungCap";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':MaNhaCungCap', $data['MaNhaCungCap']);
        $stmt->bindParam(':MaCodeNCC', $data['MaCodeNCC']);
        $stmt->bindParam(':TenNhaCungCap', $data['TenNhaCungCap']);
        $stmt->bindParam(':LoaiNhaCungCap', $data['LoaiNhaCungCap']);
        $stmt->bindParam(':NguoiLienHe', $data['NguoiLienHe']);
        $stmt->bindParam(':SoDienThoai', $data['SoDienThoai']);
        $stmt->bindParam(':Email', $data['Email']);
        $stmt->bindParam(':DiaChi', $data['DiaChi']);
        $stmt->bindParam(':DichVuCungCap', $data['DichVuCungCap']);
        $stmt->bindParam(':FileHopDong', $data['FileHopDong']);
        $stmt->bindParam(':NgayBatDauHopDong', $data['NgayBatDauHopDong']);
        $stmt->bindParam(':NgayKetThucHopDong', $data['NgayKetThucHopDong']);
        $stmt->bindParam(':DanhGia', $data['DanhGia']);
        $stmt->bindParam(':GhiChu', $data['GhiChu']);
        $stmt->bindParam(':TrangThai', $data['TrangThai']);

        return $stmt->execute();
    }

    // 5. Xóa nhà cung cấp
    public function deleteNhaCungCap($id)
    {
        $sql = "DELETE FROM nhacungcap WHERE MaNhaCungCap = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // 6. Kiểm tra NCC có đang được sử dụng ở bảng dichvucuadoan hay không
    public function isNccInUse($id)
    {
        $sql = "SELECT COUNT(*) FROM dichvucuadoan WHERE MaNhaCungCap = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return ((int)$stmt->fetchColumn()) > 0;
    }

    // 7. Kiểm tra trùng MaCodeNCC (dùng cho add/update)
    // $excludeId: dùng khi update để bỏ qua bản ghi hiện tại
    public function isMaCodeNccExists($maCode, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) FROM nhacungcap WHERE MaCodeNCC = :ma";
        if ($excludeId !== null) {
            $sql .= " AND MaNhaCungCap <> :excludeId";
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':ma', $maCode);
        if ($excludeId !== null) {
            $stmt->bindParam(':excludeId', $excludeId);
        }
        $stmt->execute();
        return ((int)$stmt->fetchColumn()) > 0;
    }
}