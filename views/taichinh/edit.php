<div class="container px-4">
    <h2 class="mt-4">Chỉnh Sửa Giao Dịch</h2>
    
    <div class="card mb-4">
        <div class="card-body">
            <form action="?act=updateTaiChinhProcess" method="POST">
                <input type="hidden" name="MaTaiChinh" value="<?= $taiChinh['MaTaiChinh'] ?>">
                <input type="hidden" name="MaDoan" value="<?= $taiChinh['MaDoan'] ?>">

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Loại giao dịch</label>
                        <select name="LoaiGiaoDich" class="form-select">
                            <option value="chi" <?= $taiChinh['LoaiGiaoDich']=='chi'?'selected':'' ?>>Chi</option>
                            <option value="thu" <?= $taiChinh['LoaiGiaoDich']=='thu'?'selected':'' ?>>Thu</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Ngày giao dịch</label>
                        <input type="date" name="NgayGiaoDich" class="form-control" value="<?= $taiChinh['NgayGiaoDich'] ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Số tiền</label>
                        <input type="number" name="SoTien" class="form-control" value="<?= $taiChinh['SoTien'] ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Hạng mục</label>
                        <input type="text" name="HangMucChi" class="form-control" value="<?= $taiChinh['HangMucChi'] ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nhà cung cấp</label>
                        <select name="MaNhaCungCap" class="form-select">
                            <option value="">-- Chọn Nhà Cung Cấp --</option>
                            <?php foreach ($listNCC as $ncc): ?>
                                <option value="<?= $ncc['MaNhaCungCap'] ?>" 
                                    <?= $ncc['MaNhaCungCap'] == $taiChinh['MaNhaCungCap'] ? 'selected' : '' ?>>
                                    <?= $ncc['TenNhaCungCap'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Phương thức thanh toán</label>
                        <select name="PhuongThucThanhToan" class="form-select">
                            <option value="tien_mat" <?= $taiChinh['PhuongThucThanhToan']=='tien_mat'?'selected':'' ?>>Tiền mặt</option>
                            <option value="chuyen_khoan" <?= $taiChinh['PhuongThucThanhToan']=='chuyen_khoan'?'selected':'' ?>>Chuyển khoản</option>
                            <option value="the_tin_dung" <?= $taiChinh['PhuongThucThanhToan']=='the_tin_dung'?'selected':'' ?>>Thẻ tín dụng</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Số hóa đơn</label>
                        <input type="text" name="SoHoaDon" class="form-control" value="<?= $taiChinh['SoHoaDon'] ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="MoTa" class="form-control" rows="3"><?= $taiChinh['MoTa'] ?></textarea>
                </div>

                <button type="submit" class="btn btn-warning">Cập Nhật</button>
                <a href="?act=listTaiChinh&MaDoan=<?= $taiChinh['MaDoan'] ?>" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</div>