<?php
// ===================== KẾT NỐI DATABASE =====================
function connectDB()
{
    $host = DB_HOST;
    $port = DB_PORT;
    $dbname = DB_NAME;

    try {
        $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", DB_USERNAME, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $conn;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit;
    }
}

// ===================== UPLOAD & DELETE FILE =====================
function uploadFile($file, $folderSave)
{
    $file_upload = $file;
    $pathStorage = $folderSave . rand(10000, 99999) . $file_upload['name'];

    $tmp_file = $file_upload['tmp_name'];
    $pathSave = PATH_ROOT . $pathStorage;

    if (move_uploaded_file($tmp_file, $pathSave)) {
        return $pathStorage;
    }
    return null;
}

function deleteFile($file)
{
    $pathDelete = PATH_ROOT . $file;
    if (file_exists($pathDelete)) {
        unlink($pathDelete);
    }
}

// ===================== HỆ THỐNG PHÂN QUYỀN =====================

// Kiểm tra đã đăng nhập chưa
function checkLogin()
{
    if (!isset($_SESSION['user'])) {
        header("Location: ?act=login");
        exit();
    }
}

// Chỉ cho phép HDV
function onlyHDV()
{
    checkLogin();

    if ($_SESSION['user']['VaiTro'] !== 'huong_dan_vien') {
        echo "<div style='text-align:center; margin-top:100px; font-family:Arial'>
            <h1 style='color:#dc3545'>⛔ Không có quyền truy cập!</h1>
            <p style='color:#666; font-size:18px'>Chức năng này chỉ dành cho <strong>HƯỚNG DẪN VIÊN</strong></p>
            <a href='?act=login' style='display:inline-block; margin-top:20px; padding:12px 30px; background:#007bff; color:white; text-decoration:none; border-radius:6px'>
                ← Quay lại đăng nhập
            </a>
          </div>";
        exit();
    }
}

// Chỉ cho phép Admin
function onlyAdmin()
{
    checkLogin();

    if ($_SESSION['user']['VaiTro'] !== 'admin') {
        echo "<div style='text-align:center; margin-top:100px; font-family:Arial'>
            <h1 style='color:#dc3545'>⛔ Không có quyền truy cập!</h1>
            <p style='color:#666; font-size:18px'>Chức năng này chỉ dành cho <strong>ADMIN</strong></p>
            <a href='?act=hdvHome' style='display:inline-block; margin-top:20px; padding:12px 30px; background:#28a745; color:white; text-decoration:none; border-radius:6px'>
                ← Về trang HDV
            </a>
          </div>";
        exit();
    }
}

// Cho phép nhiều vai trò (admin, dieu_hanh,...)
function requireRole($allowedRoles = [])
{
    checkLogin();

    $userRole = $_SESSION['user']['VaiTro'];

    if (!in_array($userRole, $allowedRoles)) {
        echo "<div style='text-align:center; margin-top:100px; font-family:Arial'>
            <h1 style='color:#dc3545'>⛔ Không có quyền truy cập!</h1>
            <p style='color:#666; font-size:18px'>Vai trò của bạn: <strong>" . htmlspecialchars($userRole) . "</strong></p>
            <a href='?act=login' style='display:inline-block; margin-top:20px; padding:12px 30px; background:#007bff; color:white; text-decoration:none; border-radius:6px'>
                ← Quay lại đăng nhập
            </a>
          </div>";
        exit();
    }
}

// Lấy user hiện tại
function getCurrentUser()
{
    return $_SESSION['user'] ?? null;
}

// Kiểm tra vai trò cụ thể
function isAdmin()
{
    return isset($_SESSION['user']) && $_SESSION['user']['VaiTro'] === 'admin';
}

function isHDV()
{
    return isset($_SESSION['user']) && $_SESSION['user']['VaiTro'] === 'huong_dan_vien';
}
