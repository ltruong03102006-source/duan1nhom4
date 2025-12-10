<div class="container-fluid px-4">
  <h1 class="mt-4">Lịch Trình Tour</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="?act=hdvHome">Dashboard HDV</a></li>
    <li class="breadcrumb-item active">Lịch trình</li>
  </ol>

  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-route me-1"></i>
      <?= htmlspecialchars(($tourTitle ?? '').($tourCode ? " ($tourCode)" : '')) ?>
    </div>
    <div class="card-body">
      <?php if (empty($listLichTrinh)): ?>
        <div class="alert alert-warning mb-0">Chưa có lịch trình cho tour này.</div>
      <?php else: ?>
        <div class="accordion" id="accLichTrinh">
          <?php foreach ($listLichTrinh as $i => $lt): 
            $hid = "h$i"; $cid = "c$i"; ?>
            <div class="accordion-item">
              <h2 class="accordion-header" id="<?= $hid ?>">
                <button class="accordion-button <?= $i ? 'collapsed':'' ?>" type="button"
                        data-bs-toggle="collapse" data-bs-target="#<?= $cid ?>"
                        aria-expanded="<?= $i ? 'false':'true' ?>" aria-controls="<?= $cid ?>">
                  Ngày <?= htmlspecialchars($lt['NgayThu']) ?>: <?= htmlspecialchars($lt['TieuDeNgay'] ?? '') ?>
                </button>
              </h2>
              <div id="<?= $cid ?>" class="accordion-collapse collapse <?= $i ? '':'show' ?>" aria-labelledby="<?= $hid ?>" data-bs-parent="#accLichTrinh">
                <div class="accordion-body">
                  <p class="mb-1"><b>Địa điểm tham quan:</b> <?= htmlspecialchars($lt['DiaDiemThamQuan'] ?? '') ?></p>
                  <p class="mb-1"><b>Nơi ở:</b> <?= htmlspecialchars($lt['NoiO'] ?? '') ?></p>
                  <p class="mb-2"><b>Bữa ăn:</b>
                    <?= !empty($lt['CoBuaSang']) ? 'Sáng ' : '' ?>
                    <?= !empty($lt['CoBuaTrua']) ? 'Trưa ' : '' ?>
                    <?= !empty($lt['CoBuaToi']) ? 'Tối ' : '' ?>
                    <?= (empty($lt['CoBuaSang']) && empty($lt['CoBuaTrua']) && empty($lt['CoBuaToi'])) ? 'Không' : '' ?>
                  </p>
                  <div><b>Chi tiết hoạt động:</b><br><?= nl2br(htmlspecialchars($lt['ChiTietHoatDong'] ?? '')) ?></div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <div class="mt-3">
        <a href="javascript:history.back()" class="btn btn-secondary">
          <i class="fas fa-arrow-left"></i> Quay lại
        </a>
      </div>
    </div>
  </div>
</div>
