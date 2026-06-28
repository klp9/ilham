<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-center mb-4">
    <a href="<?= base_url('customer/dashboard') ?>" class="btn btn-light me-3"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h2 class="fw-bold mb-0">Rincian Pemesanan #<?= $booking['id'] ?></h2>
        <p class="text-muted mb-0">Invoice pemesanan dan status pembayaran Anda</p>
    </div>
</div>

<div class="row g-4">
    <!-- Invoice details -->
    <div class="col-md-7">
        <div class="card p-4 border-0 shadow-sm mb-4">
            <h5 class="fw-bold mb-4">Detail Pemesanan & Kamar</h5>
            <div class="row g-3">
                <div class="col-6">
                    <span class="text-muted d-block small">Nama Pemesan</span>
                    <strong class="text-dark"><?= esc($booking['customer_name']) ?></strong>
                </div>
                <div class="col-6">
                    <span class="text-muted d-block small">Email Kontak</span>
                    <strong class="text-dark"><?= esc($booking['customer_email']) ?></strong>
                </div>
                <div class="col-6">
                    <span class="text-muted d-block small">Nomor Kamar</span>
                    <strong class="text-dark">Kamar <?= esc($booking['room_number']) ?> (<?= esc($booking['category_name']) ?>)</strong>
                </div>
                <div class="col-6">
                    <span class="text-muted d-block small">Tarif Per Malam</span>
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
                    <span class="text-muted d-block small">Status Pemesanan</span>
                    <span class="badge badge-<?= $booking['status'] ?> text-capitalize py-2 px-2.5">
                        <?= $booking['status'] === 'approved' ? 'Disetujui' : ($booking['status'] === 'rejected' ? 'Ditolak' : $booking['status']) ?>
                    </span>
                </div>
                <div class="col-6">
                    <span class="text-muted d-block small">Total Pembayaran</span>
                    <strong class="text-primary fs-5">Rp <?= number_format($booking['total_price'], 0, ',', '.') ?></strong>
                </div>
            </div>
        </div>

        <div class="card p-4 border-0 shadow-sm">
            <h5 class="fw-bold mb-4">Informasi Pembayaran</h5>
            <?php if ($booking['proof_image'] && file_exists(FCPATH . 'uploads/payments/' . $booking['proof_image'])): ?>
                <div class="row g-3">
                    <div class="col-6">
                        <span class="text-muted d-block small">Metode Pembayaran</span>
                        <strong class="text-dark text-capitalize"><?= esc($booking['payment_method']) ?></strong>
                    </div>
                    <div class="col-6">
                        <span class="text-muted d-block small">Status Verifikasi</span>
                        <span class="badge bg-<?= $booking['payment_status'] === 'verified' ? 'success' : ($booking['payment_status'] === 'rejected' ? 'danger' : 'warning') ?> py-2">
                            <?= $booking['payment_status'] === 'verified' ? 'Terverifikasi' : ($booking['payment_status'] === 'rejected' ? 'Ditolak' : 'Menunggu Verifikasi') ?>
                        </span>
                    </div>
                    <div class="col-12 mt-3">
                        <span class="text-muted d-block mb-2 small">Bukti Transfer</span>
                        <img src="<?= base_url('uploads/payments/' . $booking['proof_image']) ?>" class="img-fluid rounded border shadow-sm" alt="Bukti Transfer" style="max-height: 250px; object-fit: contain;">
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-info border-0 mb-0" role="alert">
                    <i class="bi bi-info-circle-fill me-2"></i>Anda belum mengunggah bukti pembayaran yang valid. Silakan lakukan pembayaran sesuai petunjuk di samping.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Payment Upload Form (Side Widget) -->
    <div class="col-md-5">
        <div class="card p-4 border-0 shadow-lg sticky-top" style="top: 100px; z-index: 1;">
            <?php if ($booking['status'] === 'pending'): ?>
                <h5 class="fw-bold mb-3">Petunjuk Pembayaran</h5>
                <p class="text-muted small">Silakan transfer sebesar <strong class="text-primary">Rp <?= number_format($booking['total_price'], 0, ',', '.') ?></strong> ke salah satu rekening berikut:</p>
                
                <div class="p-3 border rounded bg-light mb-4">
                    <div class="mb-2">
                        <span class="text-muted d-block small">Bank BCA (Transfer)</span>
                        <strong class="text-dark">123-4567-890</strong> <span class="text-muted small">a/n Hotel Ilham</span>
                    </div>
                    <div class="mb-0">
                        <span class="text-muted d-block small">Bank Mandiri (Transfer)</span>
                        <strong class="text-dark">987-6543-210</strong> <span class="text-muted small">a/n Hotel Ilham</span>
                    </div>
                </div>

                <h5 class="fw-bold mb-3">Unggah Bukti Pembayaran</h5>
                <form action="<?= base_url('customer/bookings/payment/' . $booking['id']) ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Metode Pembayaran</label>
                        <select class="form-select" id="payment_method" name="payment_method" required>
                            <option value="" disabled selected>Pilih Metode</option>
                            <option value="bca" <?= old('payment_method') === 'bca' ? 'selected' : '' ?>>Transfer BCA</option>
                            <option value="mandiri" <?= old('payment_method') === 'mandiri' ? 'selected' : '' ?>>Transfer Mandiri</option>
                            <option value="gopay" <?= old('payment_method') === 'gopay' ? 'selected' : '' ?>>GoPay / E-Wallet</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="proof_image" class="form-label">Foto Bukti Transfer</label>
                        <input class="form-control" type="file" id="proof_image" name="proof_image" accept="image/*" required>
                        <small class="text-muted">Maks. 2MB (Format: JPG, JPEG, PNG)</small>
                    </div>

                    <button type="submit" class="btn btn-primary text-white w-100 py-3 fw-bold"><i class="bi bi-cloud-arrow-up me-1"></i> Unggah Bukti Transfer</button>
                </form>
            <?php else: ?>
                <div class="text-center py-4">
                    <div class="text-success mb-3">
                        <i class="bi bi-shield-check" style="font-size: 5rem;"></i>
                    </div>
                    <h5 class="fw-bold">Pemesanan <?= $booking['status'] === 'approved' ? 'Telah Disetujui' : ($booking['status'] === 'check_in' ? 'Telah Check-In' : ($booking['status'] === 'check_out' ? 'Telah Check-Out' : 'Telah Ditolak')) ?></h5>
                    <p class="text-muted small">Pemesanan ini tidak membutuhkan tindakan pembayaran lagi. Terima kasih telah memilih layanan kami.</p>
                    <a href="<?= base_url('customer/dashboard') ?>" class="btn btn-outline-primary w-100 mt-2">Kembali ke Dashboard</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
