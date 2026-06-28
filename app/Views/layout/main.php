<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Hotel Ilham' ?></title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --secondary-color: #0f172a;
            --accent-color: #f59e0b;
            --bg-light: #f8fafc;
            --text-dark: #0f172a;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background-color: rgba(15, 23, 42, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 800;
            letter-spacing: 0.5px;
            color: #ffffff !important;
        }

        .navbar-brand span {
            color: var(--accent-color);
        }

        .nav-link {
            font-weight: 500;
            color: rgba(255, 255, 255, 0.8) !important;
            transition: all 0.3s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--accent-color) !important;
            transform: translateY(-1px);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            font-weight: 500;
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: #ffffff;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .gradient-card {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: white;
        }

        footer {
            margin-top: auto;
            background-color: #0f172a;
            color: rgba(255, 255, 255, 0.7);
        }

        /* Form styling */
        .form-control, .form-select {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        /* Badge status styling */
        .badge-pending { background-color: #fef3c7; color: #d97706; }
        .badge-approved { background-color: #d1fae5; color: #059669; }
        .badge-rejected { background-color: #fee2e2; color: #dc2626; }
        .badge-check_in { background-color: #e0f2fe; color: #0284c7; }
        .badge-check_out { background-color: #f3f4f6; color: #4b5563; }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg sticky-top py-3 navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <i class="bi bi-building-fill me-2 text-warning"></i>HOTEL <span>ILHAM</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= url_is('/') ? 'active' : '' ?>" href="<?= base_url() ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= url_is('rooms') || url_is('rooms/*') ? 'active' : '' ?>" href="<?= base_url('rooms') ?>">Daftar Kamar</a>
                    </li>
                    
                    <?php if (session()->get('isLoggedIn') && session()->get('role') === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= url_is('admin/dashboard') ? 'active' : '' ?>" href="<?= base_url('admin/dashboard') ?>">Dashboard Admin</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Manajemen
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-menu-item dropdown-item" href="<?= base_url('admin/categories') ?>">Kategori Kamar</a></li>
                                <li><a class="dropdown-menu-item dropdown-item" href="<?= base_url('admin/rooms') ?>">Data Kamar</a></li>
                                <li><a class="dropdown-menu-item dropdown-item" href="<?= base_url('admin/facilities') ?>">Fasilitas Kamar</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-menu-item dropdown-item" href="<?= base_url('admin/bookings') ?>">Seluruh Pemesanan</a></li>
                                <li><a class="dropdown-menu-item dropdown-item" href="<?= base_url('admin/reports') ?>">Laporan Keuangan</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if (session()->get('isLoggedIn') && session()->get('role') === 'customer'): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= url_is('customer/dashboard') ? 'active' : '' ?>" href="<?= base_url('customer/dashboard') ?>">Dashboard Saya</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= url_is('customer/profile') ? 'active' : '' ?>" href="<?= base_url('customer/profile') ?>">Edit Profil</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="d-flex align-items-center">
                    <?php if (session()->get('isLoggedIn')): ?>
                        <span class="text-white me-3 d-none d-lg-inline">Hai, <strong><?= session()->get('fullname') ?></strong></span>
                        <a href="<?= base_url('logout') ?>" class="btn btn-outline-light btn-sm"><i class="bi bi-box-arrow-right me-1"></i>Logout</a>
                    <?php else: ?>
                        <a href="<?= base_url('login') ?>" class="btn btn-outline-light me-2 btn-sm">Login</a>
                        <a href="<?= base_url('register') ?>" class="btn btn-primary btn-sm text-white">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Container -->
    <main class="py-4">
        <div class="container">
            <!-- Flash Message Alerts -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i><?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Mohon perbaiki kesalahan berikut:
                    <ul class="mb-0 mt-2">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- View Content Injection -->
            <?= $this->renderSection('content') ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-4 mt-auto">
        <div class="container text-center">
            <p class="mb-1 text-light">&copy; <?= date('Y') ?> Hotel Ilham. Hak Cipta Dilindungi.</p>
            <small class="text-muted">Dibuat untuk syarat UAS Pemrograman Web - Dosen: Pak Raga</small>
        </div>
    </footer>

    <!-- Bootstrap 5 Bundle JS with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery (essential for AJAX operations / UI interactivity) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- View Custom Scripts Injection -->
    <?= $this->renderSection('scripts') ?>
</body>
</html>
