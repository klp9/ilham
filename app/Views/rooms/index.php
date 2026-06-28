<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <h2 class="fw-bold">Temukan Kamar Sempurna Anda</h2>
    <p class="text-muted">Cari dan filter kamar yang tersedia secara real-time</p>
</div>

<!-- AJAX Filter & Search Section -->
<div class="card p-3 mb-5 border-0 shadow-sm">
    <div class="card-body">
        <div class="row g-3 align-items-center">
            <!-- Search bar -->
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Cari nomor kamar atau deskripsi...">
                </div>
            </div>
            
            <!-- Category Filter -->
            <div class="col-md-4">
                <select id="categoryFilter" class="form-select">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <!-- Clear Button -->
            <div class="col-md-3 d-grid">
                <button type="button" id="clearBtn" class="btn btn-outline-secondary py-2"><i class="bi bi-x-circle me-1"></i>Reset Filter</button>
            </div>
        </div>
    </div>
</div>

<!-- Room Listing Grid -->
<div class="row g-4" id="roomsContainer">
    <!-- Spinner Loader -->
    <div class="text-center py-5">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-3 text-muted">Memuat daftar kamar...</p>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        const roomsContainer = $('#roomsContainer');
        const searchInput = $('#searchInput');
        const categoryFilter = $('#categoryFilter');
        const clearBtn = $('#clearBtn');

        // Initial fetch
        fetchRooms();

        // Listeners for filters
        searchInput.on('keyup input', debounce(function() {
            fetchRooms();
        }, 300));

        categoryFilter.on('change', function() {
            fetchRooms();
        });

        clearBtn.on('click', function() {
            searchInput.val('');
            categoryFilter.val('');
            fetchRooms();
        });

        function fetchRooms() {
            const search = searchInput.val();
            const categoryId = categoryFilter.val();

            // Display loading spinner
            roomsContainer.html(`
                <div class="col-12 text-center py-5">
                    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3 text-muted">Memuat data kamar...</p>
                </div>
            `);

            // Call the RESTful API endpoint
            let apiUrl = `<?= base_url('api/rooms') ?>`;
            let params = [];
            if (search) params.push(`search=${encodeURIComponent(search)}`);
            if (categoryId) params.push(`category_id=${encodeURIComponent(categoryId)}`);

            if (params.length > 0) {
                apiUrl += '?' + params.join('&');
            }

            fetch(apiUrl)
                .then(response => response.json())
                .then(res => {
                    if (res.status === 200) {
                        renderRooms(res.data);
                    } else {
                        roomsContainer.html(`<div class="col-12 text-center py-5 text-danger"><i class="bi bi-exclamation-triangle fs-1"></i><p class="mt-2">Gagal mengambil data kamar.</p></div>`);
                    }
                })
                .catch(err => {
                    console.error(err);
                    roomsContainer.html(`<div class="col-12 text-center py-5 text-danger"><i class="bi bi-exclamation-triangle fs-1"></i><p class="mt-2">Terjadi kesalahan koneksi.</p></div>`);
                });
        }

        function renderRooms(rooms) {
            if (rooms.length === 0) {
                roomsContainer.html(`
                    <div class="col-12 text-center py-5 card border-0 shadow-sm">
                        <i class="bi bi-folder-x fs-1 text-muted"></i>
                        <h4 class="mt-3 fw-bold">Kamar Tidak Ditemukan</h4>
                        <p class="text-muted">Coba ubah kata kunci pencarian atau filter kategori Anda.</p>
                    </div>
                `);
                return;
            }

            let html = '';
            rooms.forEach(room => {
                let badgeClass = 'bg-success';
                let badgeText = 'Tersedia';
                if (room.status === 'booked') {
                    badgeClass = 'bg-danger';
                    badgeText = 'Dipesan';
                } else if (room.status === 'maintenance') {
                    badgeClass = 'bg-warning text-dark';
                    badgeText = 'Perawatan';
                }

                const imageUrl = room.image ? `<?= base_url('uploads/rooms/') ?>${room.image}` : '';
                const imageTag = imageUrl ? 
                    `<img src="${imageUrl}" class="card-img-top" alt="Room ${room.room_number}" style="height: 200px; object-fit: cover;">` :
                    `<div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;"><i class="bi bi-image fs-1 opacity-50"></i></div>`;

                let facilitiesHtml = '';
                if (room.facilities && room.facilities.length > 0) {
                    facilitiesHtml = '<div class="mb-3 d-flex flex-wrap gap-1">';
                    room.facilities.forEach(fac => {
                        facilitiesHtml += `<span class="badge bg-light text-dark border"><i class="bi bi-check-circle text-success me-1"></i>${fac.name}</span>`;
                    });
                    facilitiesHtml += '</div>';
                }

                // Format price to Rupiah
                const priceFormatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(room.price);

                html += `
                    <div class="col-md-4">
                        <div class="card card-hover h-100 overflow-hidden border-0 shadow-sm">
                            <div class="position-relative">
                                ${imageTag}
                                <span class="position-absolute top-0 start-0 m-3 badge rounded-pill ${badgeClass}">
                                    ${badgeText}
                                </span>
                                <span class="position-absolute bottom-0 end-0 m-3 badge bg-dark py-2 px-3 text-white fw-bold">
                                    ${priceFormatted} / Malam
                                </span>
                            </div>
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-primary fw-bold text-uppercase small">${room.category_name}</span>
                                    <h5 class="mb-0 fw-bold">No. ${room.room_number}</h5>
                                </div>
                                <p class="card-text text-muted text-truncate mb-3">${room.description}</p>
                                ${facilitiesHtml}
                                <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                                    <span class="text-muted small"><i class="bi bi-star-fill text-warning me-1"></i> 4.9 (Review)</span>
                                    <a href="<?= base_url('rooms/') ?>${room.id}" class="btn btn-primary btn-sm text-white px-3">Detail Kamar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            roomsContainer.html(html);
        }

        function debounce(func, wait) {
            let timeout;
            return function(...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), wait);
            };
        }
    });
</script>
<?= $this->endSection() ?>
