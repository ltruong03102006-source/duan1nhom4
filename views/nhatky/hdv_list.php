<div class="container-fluid px-4">
  <h1 class="mt-4">Nhật Ký Tour</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="?act=hdvHome">Dashboard HDV</a></li>
    <li class="breadcrumb-item active">Nhật ký tour</li>
  </ol>

  <!-- FORM THÊM -->
  <div class="card mb-4">
    <div class="card-header"><i class="fas fa-edit me-1"></i> Thêm Nhật Ký Mới</div>
    <div class="card-body">
      <form action="?act=nhatky_add" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="MaDoan" value="<?= (int)$MaDoan ?>">

        <div class="mb-3">
          <label class="form-label">Nội dung</label>
          <textarea name="NoiDung" class="form-control" rows="4" required></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Loại sự cố (nếu có)</label>
          <input type="text" name="LoaiSuCo" class="form-control" placeholder="VD: Trễ giờ, khách đau bụng...">
        </div>

        <div class="mb-3">
          <label class="form-label">Ảnh minh họa</label>
          <input type="file" name="LinkAnh" class="form-control" accept="image/*">
        </div>

        <button class="btn btn-primary"><i class="fas fa-save"></i> Ghi nhật ký</button>
      </form>
    </div>
  </div>

  <!-- DANH SÁCH -->
  <div class="card">
    <div class="card-header"><i class="fas fa-book me-1"></i> Danh sách nhật ký của đoàn</div>
    <div class="card-body">
      <?php if (empty($list)): ?>
        <p class="text-muted">Chưa có nhật ký nào.</p>
      <?php else: ?>
        <?php foreach ($list as $nk): 
          $tenNguoiTao = $nk['NguoiTao'] ?? ("Mã NV: #".($nk['MaNguoiTao'] ?? ''));
        ?>
          <div class="border rounded p-3 mb-3">
            <h5 class="fw-bold">
              <?= date('d/m/Y', strtotime($nk['NgayGhi'])) ?>
              • <?= date('H:i', strtotime($nk['GioGhi'])) ?>
            </h5>
            <p><?= nl2br(htmlspecialchars($nk['NoiDung'])) ?></p>

            <?php if (!empty($nk['LoaiSuCo'])): ?>
              <p><strong>Sự cố:</strong> <?= htmlspecialchars($nk['LoaiSuCo']) ?></p>
            <?php endif; ?>

            <?php if (!empty($nk['LinkAnh'])): ?>
              <img src="<?= htmlspecialchars($nk['LinkAnh']) ?>" class="img-fluid rounded mb-2" style="max-height:250px;">
            <?php endif; ?>

            <p class="text-muted small">Người ghi: <?= htmlspecialchars($tenNguoiTao) ?></p>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>

  <a href="?act=hdvHome" class="btn btn-secondary mt-3"><i class="fas fa-arrow-left"></i> Quay lại</a>
</div>
