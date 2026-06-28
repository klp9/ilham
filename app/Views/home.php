<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<!-- Hero Section -->
<div class="row align-items-center mb-5 py-5 gradient-card rounded-4 p-5 position-relative overflow-hidden">
    <div class="col-md-7 position-relative" style="z-index: 2;">
        <h1 class="display-4 fw-extrabold text-white mb-3">Temukan Kenyamanan Terbaik Anda</h1>
        <p class="lead text-light mb-4 opacity-75">Sistem Pemesanan Hotel Ilham menawarkan berbagai jenis kamar modern dengan fasilitas lengkap dan pelayanan prima.</p>
        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
            <a href="<?= base_url('rooms') ?>" class="btn btn-warning btn-lg px-4 me-md-2 text-dark fw-bold"><i class="bi bi-calendar-check me-2"></i>Pesan Kamar Sekarang</a>
            <a href="#kategori" class="btn btn-outline-light btn-lg px-4">Lihat Kategori</a>
        </div>
    </div>
    <div class="col-md-5 d-none d-md-block text-end">
        <i class="bi bi-building text-warning" style="font-size: 15rem; opacity: 0.15;"></i>
    </div>
</div>

<!-- Kategori Kamar -->
<div id="kategori" class="mb-5">
    <div class="text-center mb-4">
        <span class="badge bg-primary px-3 py-2 mb-2">KATEGORI PILIHAN</span>
        <h2 class="fw-bold">Pilih Tipe Kamar Sesuai Kebutuhan</h2>
        <p class="text-muted">Kami menyediakan kamar dari kelas Standard hingga Suite termewah</p>
    </div>
    
    <div class="row g-4">
        <?php foreach ($categories as $cat): ?>
            <div class="col-md-4">
                <div class="card card-hover h-100 border-0 p-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 text-primary rounded p-3 me-3">
                                <?php if ($cat['name'] === 'Standard'): ?>
                                    <i class="bi bi-door-closed-fill fs-3"></i>
                                <?php elseif ($cat['name'] === 'Deluxe'): ?>
                                    <i class="bi bi-gem fs-3"></i>
                                <?php else: ?>
                                    <i class="bi bi-award-fill fs-3"></i>
                                <?php endif; ?>
                            </div>
                            <h4 class="card-title fw-bold mb-0"><?= $cat['name'] ?></h4>
                        </div>
                        <p class="card-text text-muted"><?= $cat['description'] ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Featured Rooms -->
<div class="mb-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h2 class="fw-bold mb-0">Rekomendasi Kamar Terpopuler</h2>
            <p class="text-muted mb-0">Kamar pilihan terbaik yang siap memanjakan Anda</p>
        </div>
        <a href="<?= base_url('rooms') ?>" class="btn btn-outline-primary fw-bold">Lihat Semua Kamar <i class="bi bi-arrow-right ms-1"></i></a>
    </div>

    <div class="row g-4">
        <?php $count = 0; foreach ($rooms as $room): if ($count++ >= 3) break; ?>
            <div class="col-md-4">
                <div class="card card-hover h-100 overflow-hidden border-0">
                    <div class="position-relative">
                        <?php if ($room['image'] && file_exists(FCPATH . 'uploads/rooms/' . $room['image'])): ?>
                            <img src="<?= base_url('uploads/rooms/' . $room['image']) ?>" class="card-img-top" alt="Room <?= $room['room_number'] ?>" style="height: 220px; object-fit: cover;">
                        <?php else: ?>
                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 220px;">
                                <i class="bi bi-image fs-1 text-light opacity-50"></i>
                            </div>
                        <?php endif; ?>
                        <span class="position-absolute top-0 start-0 m-3 badge rounded-pill <?= $room['status'] === 'available' ? 'bg-success' : 'bg-danger' ?>">
                            <?= $room['status'] === 'available' ? 'Tersedia' : ($room['status'] === 'booked' ? 'Dipesan' : 'Perawatan') ?>
                        </span>
                        <span class="position-absolute bottom-0 end-0 m-3 badge bg-dark py-2 px-3 text-white fw-bold">
                            Rp <?= number_format($room['price'], 0, ',', '.') ?> / Malam
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-primary fw-bold text-uppercase small"><?= $room['category_name'] ?></span>
                            <h5 class="mb-0 fw-bold">No. <?= $room['room_number'] ?></h5>
                        </div>
                        <p class="card-text text-muted text-truncate mb-3"><?= $room['description'] ?></p>
                        <hr class="text-muted opacity-25">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small"><i class="bi bi-star-fill text-warning me-1"></i> 4.9 (Review)</span>
                            <a href="<?= base_url('rooms/' . $room['id']) ?>" class="btn btn-primary btn-sm text-white">Detail Kamar</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?= $this->endSection() ?>
