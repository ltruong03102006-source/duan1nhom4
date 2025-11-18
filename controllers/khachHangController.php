<?php
// File: vuanh-duan/duan1nhom4/controllers/khachHangController.php

// Include model
require_once './models/khachHangModel.php';

class KhachHangController
{
    public $modelKhachHang;

    public function __construct()
    {
        $this->modelKhachHang = new KhachHangModel();
    }

    // 1. Danh sách Khách hàng
    public function listKhachHang()
    {
        try {
            $listKhachHang = $this->modelKhachHang->getAllKhachHang();
            $viewFile = './views/khachhang/listKhachHang.php';
            include './views/layout.php';
        } catch (Exception $e) {
            die("Lỗi: " . $e->getMessage());
        }
    }

    // 2. Thêm Khách hàng (Hiển thị form)
    public function addKhachHang()
    {
        $viewFile = './views/khachhang/addKhachHang.php';
        include './views/layout.php';
    }

    // 3. Xử lý Thêm Khách hàng
    public function addKhachHangProcess()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate dữ liệu
            if (empty($_POST['HoTen']) || empty($_POST['SoDienThoai'])) {
                header("Location: ?act=addKhachHang&error=empty");
                exit();
            }

            $data = [
                ':MaCodeKhachHang' => $_POST['MaCodeKhachHang'] ?? '',
                ':HoTen' => trim($_POST['HoTen']),
                ':SoDienThoai' => trim($_POST['SoDienThoai']),
                ':Email' => trim($_POST['Email'] ?? ''),
                ':DiaChi' => trim($_POST['DiaChi'] ?? ''),
                ':NgaySinh' => $_POST['NgaySinh'] ?? null,
                ':GioiTinh' => $_POST['GioiTinh'] ?? '',
                ':SoGiayTo' => $_POST['SoGiayTo'] ?? '',
                ':LoaiKhach' => $_POST['LoaiKhach'] ?? 'Ca nhan',
                ':TenCongTy' => $_POST['TenCongTy'] ?? null,
                ':MaSoThue' => $_POST['MaSoThue'] ?? null,
                ':GhiChu' => $_POST['GhiChu'] ?? ''
            ];

            try {
                $result = $this->modelKhachHang->addKhachHang($data);
                if ($result) {
                    header("Location: ?act=listKhachHang&success=add");
                } else {
                    header("Location: ?act=addKhachHang&error=failed");
                }
            } catch (Exception $e) {
                header("Location: ?act=addKhachHang&error=exception");
            }
            exit();
        }
    }

    // 4. Sửa Khách hàng (Hiển thị form)
    public function editKhachHang()
    {
        // Validate ID
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            header("Location: ?act=listKhachHang&error=invalid_id");
            exit();
        }

        $id = intval($_GET['id']);
        
        try {
            $khachHang = $this->modelKhachHang->getOneKhachHang($id);
            
            if (!$khachHang) {
                header("Location: ?act=listKhachHang&error=not_found");
                exit();
            }
            
            $viewFile = './views/khachhang/editKhachHang.php';
            include './views/layout.php';
        } catch (Exception $e) {
            die("Lỗi: " . $e->getMessage());
        }
    }

    // 5. Xử lý Sửa Khách hàng
    public function updateKhachHangProcess()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate dữ liệu
            if (empty($_POST['MaKhachHang']) || empty($_POST['HoTen'])) {
                header("Location: ?act=listKhachHang&error=empty");
                exit();
            }

            $data = [
                ':MaKhachHang' => intval($_POST['MaKhachHang']),
                ':HoTen' => trim($_POST['HoTen']),
                ':SoDienThoai' => trim($_POST['SoDienThoai']),
                ':Email' => trim($_POST['Email'] ?? ''),
                ':DiaChi' => trim($_POST['DiaChi'] ?? ''),
                ':NgaySinh' => $_POST['NgaySinh'] ?? null,
                ':GioiTinh' => $_POST['GioiTinh'] ?? '',
                ':SoGiayTo' => $_POST['SoGiayTo'] ?? '',
                ':LoaiKhach' => $_POST['LoaiKhach'] ?? 'Ca nhan',
                ':TenCongTy' => $_POST['TenCongTy'] ?? null,
                ':MaSoThue' => $_POST['MaSoThue'] ?? null,
                ':GhiChu' => $_POST['GhiChu'] ?? ''
            ];

            try {
                $result = $this->modelKhachHang->updateKhachHang($data);
                if ($result) {
                    header("Location: ?act=listKhachHang&success=update");
                } else {
                    header("Location: ?act=editKhachHang&id=" . $data[':MaKhachHang'] . "&error=failed");
                }
            } catch (Exception $e) {
                header("Location: ?act=listKhachHang&error=exception");
            }
            exit();
        }
    }

    // 6. Xóa Khách hàng
    public function deleteKhachHang()
    {
        // Validate ID
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            header("Location: ?act=listKhachHang&error=invalid_id");
            exit();
        }

        $id = intval($_GET['id']);
        
        try {
            $result = $this->modelKhachHang->deleteKhachHang($id);
            if ($result) {
                header("Location: ?act=listKhachHang&success=delete");
            } else {
                header("Location: ?act=listKhachHang&error=delete_failed");
            }
        } catch (Exception $e) {
            header("Location: ?act=listKhachHang&error=exception");
        }
        exit();
    }
}