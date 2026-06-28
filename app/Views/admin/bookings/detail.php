<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-center mb-4">
    <a href="<?= base_url('admin/bookings') ?>" class="btn btn-light me-3"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h2 class="fw-bold mb-0">Rincian Pemesanan #<?= $booking['id'] ?></h2>
        <p class="text-muted mb-0">Verifikasi pembayaran dan ubah status menginap customer</p>
    </div>
</div>

<div class="row g-4">
    <!-- Booking & Customer Info -->
    <div class="col-md-7">
        <div class="card p-4 border-0 shadow-sm mb-4">
            <h5 class="fw-bold mb-4">Detail Pemesanan</h5>
            <div class="row g-3">
                <div class="col-6">
                    <span class="text-muted d-block small">Nama Customer</span>
                    <strong class="text-dark"><?= $booking['customer_name'] ?></strong>
                </div>
                <div class="col-6">
                    <span class="text-muted d-block small">Kontak / HP</span>
                    <strong class="text-dark"><?= $booking['customer_phone'] ?? '-' ?></strong>
                </div>
                <div class="col-6">
                    <span class="text-muted d-block small">Nomor Kamar</span>
                    <strong class="text-dark">Kamar <?= $booking['room_number'] ?> (<?= $booking['category_name'] ?>)</strong>
                </div>
                <div class="col-6">
                    <span class="text-muted d-block small">Harga Kamar per Malam</span>
                    <strong class="text-dark">Rp <?= number_format($booking['room_price'], 0, ',', '.') ?></strong>
                </div>
                <div class="col-6">
                    <span class="text-muted d-block small">Tanggal Check-In</span>
                    <strong class="text-dark"><?= date('d F Y', strtotime($booking['check_in_date'])) ?></strong>
                </div>
                <div class="col-6">
                    <span class="text-muted d-block small">Tanggal Check-Out</span>
                    <strong class="text-dark"><?= date('d F Y', strtotime($booking['check_out_date'])) ?></strong>
                </div>
                <div class="col-12">
                    <hr class="my-2 opacity-25">
                </div>
                <div class="col-6">
                    <span class="text-muted d-block small">Total Durasi</span>
                    <?php 
                        $in = new \DateTime($booking['check_in_date']);
                        $out = new \DateTime($booking['check_out_date']);
                        $days = $in->diff($out)->days;
                    ?>
                    <strong class="text-dark"><?= $days ?> Malam</strong>
                </div>
                <div class="col-6">
                    <span class="text-muted d-block small">Total Biaya Pemesanan</span>
                    <strong class="text-primary fs-5">Rp <?= number_format($booking['total_price'], 0, ',', '.') ?></strong>
                </div>
            </div>
        </div>

        <!-- Payment verification -->
        <div class="card p-4 border-0 shadow-sm">
            <h5 class="fw-bold mb-4">Informasi Pembayaran</h5>
            
            <?php if ($booking['proof_image'] && file_exists(FCPATH . 'uploads/payments/' . $booking['proof_image'])): ?>
                <div class="row g-3">
                    <div class="col-6">
                        <span class="text-muted d-block small">Metode Pembayaran</span>
                        <strong class="text-dark text-capitalize"><?= $booking['payment_method'] ?></strong>
                    </div>
                    <div class="col-6">
                        <span class="text-muted d-block small">Status Verifikasi</span>
                        <span class="badge bg-<?= $booking['payment_status'] === 'verified' ? 'success' : ($booking['payment_status'] === 'rejected' ? 'danger' : 'warning') ?> py-2">
                            <?= $booking['payment_status'] === 'verified' ? 'Terverifikasi' : ($booking['payment_status'] === 'rejected' ? 'Ditolak' : 'Menunggu Verifikasi') ?>
                        </span>
                    </div>
                    <div class="col-12 mt-3">
                        <span class="text-muted d-block mb-2 small">Bukti Transfer</span>
                        <a href="<?= base_url('uploads/payments/' . $booking['proof_image']) ?>" target="_blank">
                            <img src="<?= base_url('uploads/payments/' . $booking['proof_image']) ?>" class="img-fluid rounded border shadow-sm" alt="Bukti Pembayaran" style="max-height: 300px; object-fit: contain;">
                        </a>
                        <small class="text-muted d-block mt-1">Klik gambar untuk melihat ukuran penuh</small>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-warning border-0 mb-0" role="alert">
                    <i class="bi bi-info-circle-fill me-2"></i>Customer belum mengunggah bukti pembayaran yang valid.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Status Modification Form -->
    <div class="col-md-5">
        <div class="card p-4 border-0 shadow-sm sticky-top" style="top: 100px;">
            <h5 class="fw-bold mb-4">Ubah Status Pemesanan</h5>
            
            <div class="mb-4">
                <span class="text-muted d-block small mb-2">Status Saat Ini</span>
                <span class="badge badge-<?= $booking['status'] ?> text-capitalize py-2.5 px-3 fs-6">
                    <?= $booking['status'] === 'approved' ? 'Disetujui' : ($booking['status'] === 'rejected' ? 'Ditolak' : $booking['status']) ?>
                </span>
            </div>

            <hr class="opacity-25 mb-4">

            <form action="<?= base_url('admin/bookings/update-status/' . $booking['id']) ?>" method="POST">
                <?= csrf_field() ?>
                
                <div class="mb-4">
                    <label for="status" class="form-label">Pilih Status Baru</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="pending" <?= $booking['status'] === 'pending' ? 'selected' : '' ?>>Pending (Menunggu Pembayaran/Persetujuan)</option>
                        <option value="approved" <?= $booking['status'] === 'approved' ? 'selected' : '' ?>>Disetujui (Approved)</option>
                        <option value="rejected" <?= $booking['status'] === 'rejected' ? 'selected' : '' ?>>Ditolak (Rejected)</option>
                        <option value="check_in" <?= $booking['status'] === 'check_in' ? 'selected' : '' ?>>Check In (Telah Masuk Kamar)</option>
                        <option value="check_out" <?= $booking['status'] === 'check_out' ? 'selected' : '' ?>>Check Out (Telah Meninggalkan Kamar)</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary text-white w-100 py-2.5 fw-bold"><i class="bi bi-arrow-repeat me-1"></i> Perbarui Status</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
