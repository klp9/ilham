<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row g-5">
    <!-- Room Media / Gallery -->
    <div class="col-md-7">
        <div class="card overflow-hidden border-0 shadow-sm">
            <?php if ($room['image'] && file_exists(FCPATH . 'uploads/rooms/' . $room['image'])): ?>
                <img src="<?= base_url('uploads/rooms/' . $room['image']) ?>" class="img-fluid" alt="Room <?= $room['room_number'] ?>" style="width: 100%; height: 450px; object-fit: cover;">
            <?php else: ?>
                <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 100%; height: 450px;">
                    <i class="bi bi-image fs-1 opacity-50"></i>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="mt-4">
            <h3 class="fw-bold">Deskripsi Kamar</h3>
            <p class="text-muted leading-relaxed"><?= $room['description'] ?></p>
        </div>

        <div class="mt-4">
            <h4 class="fw-bold mb-3">Fasilitas Tersedia</h4>
            <div class="d-flex flex-wrap gap-2">
                <?php if (!empty($room['facilities'])): ?>
                    <?php foreach ($room['facilities'] as $fac): ?>
                        <div class="bg-white p-3 rounded shadow-sm border d-flex align-items-center" style="min-width: 180px;">
                            <i class="bi bi-patch-check-fill text-success fs-4 me-2"></i>
                            <div>
                                <h6 class="mb-0 fw-bold"><?= $fac['name'] ?></h6>
                                <small class="text-muted" style="font-size: 0.75rem;"><?= $fac['description'] ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <span class="text-muted">Tidak ada fasilitas spesifik terdaftar.</span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Booking Sidebar Form -->
    <div class="col-md-5">
        <div class="card border-0 shadow-lg p-4 sticky-top" style="top: 100px; z-index: 1;">
            <span class="badge bg-primary align-self-start mb-2 px-3 py-2 text-uppercase"><?= $room['category_name'] ?></span>
            <h2 class="fw-bold mb-1">Kamar Nomor <?= $room['room_number'] ?></h2>
            <div class="d-flex align-items-center mb-4">
                <h3 class="text-primary fw-bold mb-0">Rp <?= number_format($room['price'], 0, ',', '.') ?></h3>
                <span class="text-muted ms-1">/ Malam</span>
            </div>

            <hr class="mb-4 opacity-25">

            <?php if (session()->get('isLoggedIn') && session()->get('role') === 'admin'): ?>
                <div class="alert alert-info border-0 shadow-sm" role="alert">
                    <i class="bi bi-info-circle-fill me-2"></i>Anda masuk sebagai <strong>Admin</strong>. Hanya customer yang dapat melakukan pemesanan.
                </div>
                <a href="<?= base_url('admin/rooms') ?>" class="btn btn-outline-secondary w-100">Kembali ke Manajemen Kamar</a>
            <?php elseif ($room['status'] !== 'available'): ?>
                <div class="alert alert-danger border-0 shadow-sm" role="alert">
                    <i class="bi bi-slash-circle-fill me-2"></i>Kamar ini sedang tidak tersedia untuk dipesan (Status: <strong><?= ucfirst($room['status']) ?></strong>).
                </div>
                <a href="<?= base_url('rooms') ?>" class="btn btn-outline-secondary w-100">Cari Kamar Lain</a>
            <?php else: ?>
                <h5 class="fw-bold mb-3">Formulir Pemesanan</h5>
                
                <?php if (session()->get('isLoggedIn') && session()->get('role') === 'customer'): ?>
                    <form action="<?= base_url('customer/bookings/create') ?>" method="POST" id="bookingForm">
                        <?= csrf_field() ?>
                        <input type="hidden" name="room_id" value="<?= $room['id'] ?>">

                        <div class="mb-3">
                            <label for="check_in_date" class="form-label">Tanggal Check-In</label>
                            <input type="date" class="form-control" id="check_in_date" name="check_in_date" min="<?= date('Y-m-d') ?>" required>
                        </div>

                        <div class="mb-4">
                            <label for="check_out_date" class="form-label">Tanggal Check-Out</label>
                            <input type="date" class="form-control" id="check_out_date" name="check_out_date" min="<?= date('Y-m-d', strtotime('+1 day')) ?>" required>
                        </div>

                        <!-- Summary calculation widget -->
                        <div class="card bg-light p-3 mb-4 border-0" id="summaryWidget" style="display: none;">
                            <h6 class="fw-bold mb-2">Rincian Estimasi Biaya</h6>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Durasi Menginap</span>
                                <span id="summaryDays">0 Malam</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Tarif Per Malam</span>
                                <span>Rp <?= number_format($room['price'], 0, ',', '.') ?></span>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between">
                                <strong class="text-dark">Total Biaya</strong>
                                <strong class="text-primary" id="summaryTotal">Rp 0</strong>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3 text-white fw-bold"><i class="bi bi-wallet2 me-2"></i>Konfirmasi & Pesan Kamar</button>
                    </form>
                <?php else: ?>
                    <div class="alert alert-warning border-0 shadow-sm mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Silakan login terlebih dahulu untuk melakukan pemesanan kamar.
                    </div>
                    <a href="<?= base_url('login') ?>" class="btn btn-primary w-100 py-2.5 text-white fw-bold mb-2">Login Ke Akun</a>
                    <a href="<?= base_url('register') ?>" class="btn btn-outline-secondary w-100 py-2.5">Daftar Akun Baru</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        const checkIn = $('#check_in_date');
        const checkOut = $('#check_out_date');
        const summaryWidget = $('#summaryWidget');
        const summaryDays = $('#summaryDays');
        const summaryTotal = $('#summaryTotal');
        const pricePerNight = <?= $room['price'] ?>;

        function calculateEstimate() {
            const inDateVal = checkIn.val();
            const outDateVal = checkOut.val();

            if (inDateVal && outDateVal) {
                const date1 = new Date(inDateVal);
                const date2 = new Date(outDateVal);
                
                const timeDiff = date2.getTime() - date1.getTime();
                const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

                if (daysDiff > 0) {
                    const totalCost = pricePerNight * daysDiff;
                    const formattedTotal = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(totalCost);

                    summaryDays.text(`${daysDiff} Malam`);
                    summaryTotal.text(formattedTotal);
                    summaryWidget.slideDown(200);
                } else {
                    summaryWidget.slideUp(200);
                }
            } else {
                summaryWidget.slideUp(200);
            }
        }

        checkIn.on('change', function() {
            if (checkIn.val()) {
                const minOutDate = new Date(checkIn.val());
                minOutDate.setDate(minOutDate.getDate() + 1);
                
                const yyyy = minOutDate.getFullYear();
                let mm = minOutDate.getMonth() + 1;
                let dd = minOutDate.getDate();
                if (mm < 10) mm = '0' + mm;
                if (dd < 10) dd = '0' + dd;
                
                checkOut.attr('min', `${yyyy}-${mm}-${dd}`);
            }
            calculateEstimate();
        });

        checkOut.on('change', calculateEstimate);
    });
</script>
<?= $this->endSection() ?>
