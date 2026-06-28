<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <h2 class="fw-bold">Dashboard Admin</h2>
    <p class="text-muted">Ringkasan operasional dan statistik pemesanan hotel</p>
</div>

<!-- Summary Stats Cards -->
<div class="row g-4 mb-5">
    <!-- Total Rooms -->
    <div class="col-md-3">
        <div class="card p-3 border-0 shadow-sm h-100 card-hover">
            <div class="card-body d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 text-primary rounded p-3 me-3">
                    <i class="bi bi-door-open fs-3"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1 small text-uppercase fw-bold">Total Kamar</h6>
                    <h3 class="fw-bold mb-0"><?= $totalRooms ?></h3>
                </div>
            </div>
        </div>
    </div>
    <!-- Total Customers -->
    <div class="col-md-3">
        <div class="card p-3 border-0 shadow-sm h-100 card-hover">
            <div class="card-body d-flex align-items-center">
                <div class="bg-info bg-opacity-10 text-info rounded p-3 me-3">
                    <i class="bi bi-people fs-3"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1 small text-uppercase fw-bold">Total Customer</h6>
                    <h3 class="fw-bold mb-0"><?= $totalCustomers ?></h3>
                </div>
            </div>
        </div>
    </div>
    <!-- Total Bookings -->
    <div class="col-md-3">
        <div class="card p-3 border-0 shadow-sm h-100 card-hover">
            <div class="card-body d-flex align-items-center">
                <div class="bg-warning bg-opacity-10 text-warning rounded p-3 me-3">
                    <i class="bi bi-journal-bookmark fs-3"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1 small text-uppercase fw-bold">Total Pemesanan</h6>
                    <h3 class="fw-bold mb-0"><?= $totalBookings ?></h3>
                </div>
            </div>
        </div>
    </div>
    <!-- Total Income -->
    <div class="col-md-3">
        <div class="card p-3 border-0 shadow-sm h-100 card-hover">
            <div class="card-body d-flex align-items-center">
                <div class="bg-success bg-opacity-10 text-success rounded p-3 me-3">
                    <i class="bi bi-currency-dollar fs-3"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1 small text-uppercase fw-bold">Total Pendapatan</h6>
                    <h3 class="fw-bold mb-0 text-success" style="font-size: 1.5rem;">Rp <?= number_format($totalIncome, 0, ',', '.') ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-5">
    <!-- Booking Status Stats -->
    <div class="col-md-4">
        <div class="card p-4 border-0 shadow-sm h-100">
            <h5 class="fw-bold mb-4">Statistik Pemesanan</h5>
            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="d-flex align-items-center"><span class="badge badge-pending me-2">&nbsp;&nbsp;</span> Pending</span>
                <span class="fw-bold"><?= $stats['pending'] ?></span>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="d-flex align-items-center"><span class="badge badge-approved me-2">&nbsp;&nbsp;</span> Disetujui</span>
                <span class="fw-bold"><?= $stats['approved'] ?></span>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="d-flex align-items-center"><span class="badge badge-rejected me-2">&nbsp;&nbsp;</span> Ditolak</span>
                <span class="fw-bold"><?= $stats['rejected'] ?></span>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="d-flex align-items-center"><span class="badge badge-check_in me-2">&nbsp;&nbsp;</span> Check In</span>
                <span class="fw-bold"><?= $stats['check_in'] ?></span>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-0">
                <span class="d-flex align-items-center"><span class="badge badge-check_out me-2">&nbsp;&nbsp;</span> Check Out</span>
                <span class="fw-bold"><?= $stats['check_out'] ?></span>
            </div>
        </div>
    </div>

    <!-- Recent Bookings List -->
    <div class="col-md-8">
        <div class="card p-4 border-0 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Pemesanan Terbaru</h5>
                <a href="<?= base_url('admin/bookings') ?>" class="btn btn-sm btn-outline-primary fw-bold">Semua Pemesanan</a>
            </div>
            
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Kamar</th>
                            <th>Check-In</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($recentBookings)): ?>
                            <?php foreach ($recentBookings as $booking): ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold"><?= $booking['customer_name'] ?></div>
                                        <small class="text-muted" style="font-size: 0.75rem;"><?= $booking['customer_email'] ?></small>
                                    </td>
                                    <td>
                                        <div class="fw-bold">No. <?= $booking['room_number'] ?></div>
                                        <small class="text-primary text-uppercase" style="font-size: 0.75rem;"><?= $booking['category_name'] ?></small>
                                    </td>
                                    <td><?= date('d M Y', strtotime($booking['check_in_date'])) ?></td>
                                    <td class="fw-bold text-dark">Rp <?= number_format($booking['total_price'], 0, ',', '.') ?></td>
                                    <td>
                                        <span class="badge badge-<?= $booking['status'] ?> text-capitalize py-2 px-2.5">
                                            <?= $booking['status'] === 'approved' ? 'Disetujui' : ($booking['status'] === 'rejected' ? 'Ditolak' : $booking['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('admin/bookings/detail/' . $booking['id']) ?>" class="btn btn-light btn-sm text-primary fw-bold"><i class="bi bi-eye"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Belum ada pemesanan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
