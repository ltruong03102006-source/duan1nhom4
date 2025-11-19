<?php
class AnhTourModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getAllAnhByTour($MaTour)
    {
        $sql = "SELECT * FROM AnhTour WHERE MaTour = :MaTour ORDER BY ThuTuHienThi ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':MaTour' => $MaTour]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addAnhTour($MaTour, $DuongDanAnh, $ChuThichAnh, $ThuTu)
    {
        $sql = "INSERT INTO AnhTour (MaTour, DuongDanAnh, ChuThichAnh, ThuTuHienThi)
                VALUES (:MaTour, :DuongDanAnh, :ChuThichAnh, :ThuTu)";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':MaTour' => $MaTour,
            ':DuongDanAnh' => $DuongDanAnh,
            ':ChuThichAnh' => $ChuThichAnh,
            ':ThuTu' => $ThuTu
        ]);
    }

    public function getOneAnh($MaAnh)
    {
        $sql = "SELECT * FROM AnhTour WHERE MaAnh = :MaAnh";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':MaAnh' => $MaAnh]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateAnh($data)
    {
        $sql = "UPDATE AnhTour 
                SET DuongDanAnh = :DuongDanAnh,
                    ChuThichAnh = :ChuThichAnh,
                    ThuTuHienThi = :ThuTuHienThi
                WHERE MaAnh = :MaAnh";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    public function deleteAnh($MaAnh)
    {
        $sql = "DELETE FROM AnhTour WHERE MaAnh = :MaAnh";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':MaAnh' => $MaAnh]);
    }
}
