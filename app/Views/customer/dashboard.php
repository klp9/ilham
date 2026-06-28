<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <h2 class="fw-bold">Dashboard Customer</h2>
    <p class="text-muted">Kelola profil dan riwayat pemesanan kamar Anda</p>
</div>

<div class="row g-4">
    <!-- Customer Profile Info Card -->
    <div class="col-md-4">
        <div class="card p-4 border-0 shadow-sm gradient-card text-white">
            <h5 class="fw-bold mb-4">Profil Saya</h5>
            <div class="text-center mb-4">
                <i class="bi bi-person-circle text-warning" style="font-size: 5rem;"></i>
                <h4 class="fw-bold mt-2 mb-0"><?= esc($user['fullname']) ?></h4>
                <small class="text-light opacity-75">Customer</small>
            </div>
            
            <hr class="opacity-25 mb-4">

            <div class="mb-3">
                <span class="text-light opacity-50 d-block small">Username</span>
                <strong><?= esc($user['username']) ?></strong>
            </div>
            <div class="mb-3">
                <span class="text-light opacity-50 d-block small">Email</span>
                <strong><?= esc($user['email']) ?></strong>
            </div>
            <div class="mb-4">
                <span class="text-light opacity-50 d-block small">No. HP / Telepon</span>
                <strong><?= esc($user['phone'] ?? '-') ?></strong>
            </div>
            
            <a href="<?= base_url('customer/profile') ?>" class="btn btn-warning text-dark fw-bold w-100"><i class="bi bi-pencil-square me-1"></i> Edit Profil</a>
        </div>
    </div>

    <!-- Booking History Card -->
    <div class="col-md-8">
        <div class="card p-4 border-0 shadow-sm">
            <h5 class="fw-bold mb-4">Riwayat Pemesanan Kamar</h5>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Kamar</th>
                            <th>Check-In</th>
                            <th>Check-Out</th>
                            <th>Total Biaya</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($bookings)): ?>
                            <?php foreach ($bookings as $b): ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold">No. <?= $b['room_number'] ?></div>
                                        <small class="text-primary text-uppercase" style="font-size: 0.75rem;"><?= $b['category_name'] ?></small>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($b['check_in_date'])) ?></td>
                                    <td><?= date('d/m/Y', strtotime($b['check_out_date'])) ?></td>
                                    <td class="fw-bold text-dark">Rp <?= number_format($b['total_price'], 0, ',', '.') ?></td>
                                    <td>
                                        <span class="badge badge-<?= $b['status'] ?> text-capitalize py-2 px-2.5">
                                            <?= $b['status'] === 'approved' ? 'Disetujui' : ($b['status'] === 'rejected' ? 'Ditolak' : $b['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('customer/bookings/detail/' . $b['id']) ?>" class="btn btn-sm btn-outline-primary fw-bold"><i class="bi bi-receipt"></i> Detail</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Anda belum pernah memesan kamar. <a href="<?= base_url('rooms') ?>" class="fw-bold text-decoration-none">Cari Kamar Sekarang!</a></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
