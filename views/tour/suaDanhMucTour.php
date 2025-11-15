<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Danh Mục Tour</title>
    <style>
        body { margin:0; background:#f4f6f9; font-family:Arial }
        .header { background:#1e88e5; color:#fff; padding:15px; font-size:22px; }
        .container { width:90%; max-width:900px; margin:25px auto; }
        .card { background:#fff; padding:25px; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.1); }
        label { font-weight:bold; margin-bottom:5px; display:block; }
        input, textarea { width:100%; padding:10px; border-radius:5px; border:1px solid #ccc; }
        button { background:#1e88e5; color:#fff; border:none; padding:10px 20px; border-radius:5px; cursor:pointer; }
        button:hover { background:#1565c0; }
        .btn-back { background:#777; }
        .btn-back:hover { background:#555; }
    </style>
</head>
<body>

<div class="header">Sửa Danh Mục Tour</div>

<div class="container">
    <div class="card">
        <h2>Chỉnh sửa thông tin danh mục</h2>

        <form action="?act=updateDanhMucTour" method="POST">
            
            <input type="hidden" name="id" value="<?= $danhmuc['MaDanhMuc'] ?>">

            <div class="form-group">
                <label>Tên danh mục:</label>
                <input type="text" name="tenDanhMuc" value="<?= $danhmuc['TenDanhMuc'] ?>" required>
            </div>

            <div class="form-group">
                <label>Mô tả:</label>
                <textarea name="moTa" rows="3"><?= $danhmuc['MoTa'] ?></textarea>
            </div>

            <button type="submit">Cập nhật</button>
            <a href="?act=danhMuctour"><button type="button" class="btn-back">Quay lại</button></a>
        </form>

    </div>
</div>

</body>
</html>
