<?php
class LichTrinhModel {

    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function getByTour($MaTour) {
        $sql = "SELECT * FROM lichtrinh WHERE MaTour = ? ORDER BY NgayThu ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$MaTour]);
        return $stmt->fetchAll();
    }

    public function insert($data) {
        $sql = "INSERT INTO lichtrinh(MaTour, NgayThu, TieuDeNgay, ChiTietHoatDong, DiaDiemThamQuan, CoBuaSang, CoBuaTrua, CoBuaToi, NoiO)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    public function getOne($id) {
        $sql = "SELECT * FROM lichtrinh WHERE MaLichTrinh = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function update($id, $data) {
        $sql = "UPDATE lichtrinh SET NgayThu=?, TieuDeNgay=?, ChiTietHoatDong=?, DiaDiemThamQuan=?, CoBuaSang=?, CoBuaTrua=?, CoBuaToi=?, NoiO=? 
                WHERE MaLichTrinh=?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([...$data, $id]);
    }

    public function delete($id) {
        $sql = "DELETE FROM lichtrinh WHERE MaLichTrinh=?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}
