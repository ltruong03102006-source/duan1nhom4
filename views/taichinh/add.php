<div class="container px-4">
    <h2 class="mt-4">Thêm Giao Dịch Tài Chính</h2>
    <p class="text-muted">Đoàn: <?= $infoDoan['TenTour'] ?> (Khởi hành: <?= date('d/m/Y', strtotime($infoDoan['NgayKhoiHanh'])) ?>)</p>
    
    <div class="card mb-4">
        <div class="card-body">
            <form action="?act=addTaiChinhProcess" method="POST">
                <input type="hidden" name="MaDoan" value="<?= $infoDoan['MaDoan'] ?>">

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Loại giao dịch *</label>
                        <select name="LoaiGiaoDich" class="form-select" required>
                            <option value="chi">Chi (Chi phí tour)</option>
                            <option value="thu">Thu (Thu tiền khách/Khác)</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Ngày giao dịch *</label>
                        <input type="date" name="NgayGiaoDich" class="form-control" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Số tiền (VNĐ) *</label>
                        <input type="number" name="SoTien" class="form-control" required min="0" step="1000">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Hạng mục (Lý do) *</label>
                        <input type="text" name="HangMucChi" class="form-control" placeholder="VD: Thanh toán tiền xe, Ăn trưa ngày 1..." required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nhà cung cấp (Nếu là chi phí)</label>
                        <select name="MaNhaCungCap" class="form-select">
                            <option value="">-- Chọn Nhà Cung Cấp --</option>
                            <?php foreach ($listNCC as $ncc): ?>
                                <option value="<?= $ncc['MaNhaCungCap'] ?>"><?= $ncc['TenNhaCungCap'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Phương thức thanh toán</label>
                        <select name="PhuongThucThanhToan" class="form-select">
                            <option value="tien_mat">Tiền mặt</option>
                            <option value="chuyen_khoan">Chuyển khoản</option>
                            <option value="the_tin_dung">Thẻ tín dụng</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Số hóa đơn / Chứng từ</label>
                        <input type="text" name="SoHoaDon" class="form-control" placeholder="Số HĐ đỏ, Mã bill...">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả / Ghi chú thêm</label>
                    <textarea name="MoTa" class="form-control" rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-success">Lưu Giao Dịch</button>
                <a href="?act=listTaiChinh&MaDoan=<?= $infoDoan['MaDoan'] ?>" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</div>