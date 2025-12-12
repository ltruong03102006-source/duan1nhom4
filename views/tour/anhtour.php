<style>
  .page-wrap{max-width:1100px;margin:24px auto;padding:0 12px}
  .cardx{border:0;border-radius:18px;box-shadow:0 10px 30px rgba(0,0,0,.08);background:#fff}
  .cardx .card-header{border:0;background:transparent;padding:18px 20px}
  .cardx .card-body{padding:18px 20px}

  .title{font-size:20px;font-weight:700;margin:0}
  .muted{opacity:.72}

  .toolbar{display:flex;gap:10px;flex-wrap:wrap;align-items:center;justify-content:space-between}
  .toolbar .left{display:flex;gap:10px;flex-wrap:wrap;align-items:center}

  .btnx{
    display:inline-flex;align-items:center;gap:8px;
    border-radius:12px;padding:10px 14px;
    border:1px solid rgba(0,0,0,.1);
    background:#fff;text-decoration:none;color:#111;
    transition:.15s ease;
  }
  .btnx:hover{transform:translateY(-1px);box-shadow:0 8px 18px rgba(0,0,0,.08)}
  .btnx.primary{background:#0d6efd;color:#fff;border-color:#0d6efd}
  .btnx.danger{background:#fff;color:#dc3545;border-color:rgba(220,53,69,.35)}

  .grid{
    display:grid;
    grid-template-columns:repeat(4, 1fr);
    gap:14px;
  }
  @media (max-width: 1100px){ .grid{grid-template-columns:repeat(3,1fr)} }
  @media (max-width: 820px){ .grid{grid-template-columns:repeat(2,1fr)} }
  @media (max-width: 520px){ .grid{grid-template-columns:1fr} }

  .img-card{
    border:1px solid rgba(0,0,0,.08);
    border-radius:18px;
    overflow:hidden;
    background:#fff;
    transition:.15s ease;
  }
  .img-card:hover{transform:translateY(-2px);box-shadow:0 14px 30px rgba(0,0,0,.10)}
  .img-wrap{position:relative;aspect-ratio: 4/3;background:rgba(0,0,0,.03)}
  .img-wrap img{width:100%;height:100%;object-fit:cover;display:block}

  .badge-tt{
    position:absolute;top:10px;left:10px;
    background:rgba(0,0,0,.75);color:#fff;
    border-radius:999px;padding:6px 10px;
    font-size:12px;
  }

  .img-meta{padding:12px 12px 14px}
  .caption{
    font-weight:600;
    font-size:14px;
    margin:0 0 8px;
    line-height:1.3;
    display:-webkit-box;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
    overflow:hidden;
  }
  .path{
    font-size:12px;opacity:.65;margin:0 0 12px;
    white-space:nowrap;overflow:hidden;text-overflow:ellipsis;
  }
  .actions{display:flex;gap:8px;flex-wrap:wrap}
  .actions a{flex:1;justify-content:center}
  .empty{
    border:2px dashed rgba(0,0,0,.12);
    border-radius:18px;padding:22px;
    background:rgba(0,0,0,.02);
    text-align:center;
  }
</style>

<div class="page-wrap">
  <div class="cardx">
    <div class="card-header">
      <div class="toolbar">
        <div class="left">
          <h2 class="title">Quản lý ảnh tour</h2>
          <span class="muted">Tour #<?= (int)$MaTour ?></span>
        </div>

        <div class="left">
          <a class="btnx" href="?act=tour">← Danh sách tour</a>
          <a class="btnx primary" href="?act=addAnhTour&MaTour=<?= (int)$MaTour ?>">+ Thêm ảnh</a>
        </div>
      </div>
    </div>

    <div class="card-body">
      <?php if (empty($listAnh)) : ?>
        <div class="empty">
          <h5 class="mb-2">Chưa có ảnh nào</h5>
          <div class="muted mb-3">Hãy thêm bộ ảnh minh họa để tour nhìn hấp dẫn hơn.</div>
          <a class="btnx primary" href="?act=addAnhTour&MaTour=<?= (int)$MaTour ?>">+ Thêm ảnh ngay</a>
        </div>
      <?php else : ?>
        <div class="grid">
          <?php foreach ($listAnh as $anh) : ?>
            <div class="img-card">
              <div class="img-wrap">
                <span class="badge-tt">#<?= (int)($anh['ThuTuHienThi'] ?? 0) ?></span>
                <img src="<?= htmlspecialchars($anh['DuongDanAnh']) ?>" alt="Ảnh tour">
              </div>

              <div class="img-meta">
                <p class="caption">
                  <?= htmlspecialchars($anh['ChuThichAnh'] ?: 'Chưa có chú thích') ?>
                </p>
                <p class="path"><?= htmlspecialchars($anh['DuongDanAnh']) ?></p>

                <div class="actions">
                  <a class="btnx" href="?act=editAnhTour&MaAnh=<?= (int)$anh['MaAnh'] ?>">Sửa</a>
                  <a class="btnx danger"
                     href="?act=deleteAnhTour&MaAnh=<?= (int)$anh['MaAnh'] ?>"
                     onclick="return confirm('Xóa ảnh này?');">
                    Xóa
                  </a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
