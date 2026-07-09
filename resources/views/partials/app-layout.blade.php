<!doctype html>

<html
  lang="en"
  class="layout-menu-fixed layout-compact"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>@yield('title','judul')</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="../assets/vendor/fonts/iconify-icons.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js@10.2.0/public/assets/styles/choices.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/choices.js@10.2.0/public/assets/scripts/choices.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css  -->

    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="/assets/css/demo.css" />

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- endbuild -->

    <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

    <script src="../assets/js/config.js"></script>

    <style>
    /* Light mode (default) - variabel warna sesuai tema existing Anda */
    :root {
        --bg-body: #f5f5f9;
        --bg-card: #ffffff;
        --bg-sidebar: #ffffff;
        --text-primary: #2c2c2c;
        --text-secondary: #6c6c6c;
        --border-color: #e0e0e0;
        --table-header-bg: #f8f9fa;
        --hover-bg: #f1f1f1;
        --progress-bg: #e9ecef;
        --badge-light-bg: #eef2f6;
        --badge-light-text: #1e293b;
        --code-badge-bg: #f1f5f9;
        --code-badge-text: #334155;
        /* tombol-tombol */
        --btn-outline-border: #cbd5e1;
        --btn-icon-color: #6c757d;
    }

    /* Dark mode - akan diaktifkan jika body memiliki kelas .dark-mode */
    body.dark-mode {
        --bg-body: #17181d;
        --bg-card: #23262f;
        --bg-sidebar: #1c1e24;
        --text-primary: #e9ecef;
        --text-secondary: #9aa3b2;
        --border-color: #2f333d;
        --table-header-bg: #2a2e38;
        --hover-bg: #2c303b;
        --progress-bg: #2c2c3a;
        --badge-light-bg: #2d3140;
        --badge-light-text: #d6dbe5;
        --code-badge-bg: #2d3140;
        --code-badge-text: #d6dbe5;
        --btn-outline-border: #3a3f4b;
        --btn-icon-color: #c2c8d0;
        /* samakan tema navbar & kertas bootstrap agar ikut gelap */
        --bs-paper-bg: var(--bg-card);
    }

    /* Terapkan variabel ke elemen global */
    body {
        background-color: var(--bg-body);
        color: var(--text-primary);
        transition: background-color 0.3s ease, color 0.2s ease;
    }

    /* Sidebar (disesuaikan dengan class di layout Anda) */
    .layout-menu {
        background-color: var(--bg-sidebar) !important;
        border-right-color: var(--border-color) !important;
    }
    .menu-inner > .menu-item a {
        color: var(--text-secondary) !important;
    }
    .menu-inner > .menu-item.active > a {
        background-color: var(--hover-bg) !important;
        color: var(--text-primary) !important;
    }

    /* Card, modal, info card */
    .card, .modal-content, .clean-card, .info-card {
        background-color: var(--bg-card) !important;
        border-color: var(--border-color) !important;
    }

    /* Tabel */
    .table thead th, .table-clean th {
        background-color: var(--table-header-bg) !important;
        color: var(--text-secondary) !important;
        border-bottom-color: var(--border-color) !important;
    }
    .table td, .table-clean td {
        border-bottom-color: var(--border-color) !important;
    }
    .table tbody tr:hover, .table-clean tbody tr:hover {
        background-color: var(--hover-bg) !important;
    }

    /* Komponen kustom */
    .code-badge {
        background-color: var(--code-badge-bg);
        color: var(--code-badge-text);
    }
    .btn-icon, .btn-outline-primary, .btn-outline-secondary {
        border-color: var(--btn-outline-border) !important;
        color: var(--btn-icon-color) !important;
    }
    .btn-icon:hover, .btn-outline-primary:hover, .btn-outline-secondary:hover {
        background-color: var(--hover-bg) !important;
        color: var(--text-primary) !important;
    }
    .progress {
        background-color: var(--progress-bg) !important;
    }

    /* Tombol toggle tema di navbar */
    .theme-toggle {
        border: 1px solid transparent;
        background-color: transparent;
        color: var(--text-secondary) !important;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
    }
    .theme-toggle:hover {
        background-color: var(--hover-bg);
        color: var(--text-primary) !important;
    }
    .theme-toggle:focus {
        outline: none;
        box-shadow: none;
    }

    /* Select2, Choices.js jika digunakan */
    .select2-container--bootstrap-5 .select2-selection,
    .choices__inner {
        background-color: var(--bg-card) !important;
        border-color: var(--border-color) !important;
        color: var(--text-primary) !important;
    }
    .select2-dropdown, .choices__list--dropdown {
        background-color: var(--bg-card) !important;
        border-color: var(--border-color) !important;
    }
    .choices__list--dropdown .choices__item--selectable.is-highlighted {
        background-color: var(--hover-bg) !important;
    }
</style>
  </head>

  <body>

    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            @include('partials.sidebar')
            <!-- Layout container -->
            <div class="layout-page">
                
                @include('partials.navbar')
                
                @yield('content')

                @include('partials.footer')
            </div>
            <!-- / Layout page -->
        </div>
        
        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->

    <script src="../assets/vendor/libs/jquery/jquery.js"></script>

    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>

    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->

    <script src="../assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="../assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag before closing body tag for github widget button. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

   {{-- Pastikan CDN SweetAlert2 dimuat --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // SVG Ikon (clean)
        const ICON_SUCCESS = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>`;
        const ICON_ERROR   = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>`;
        const ICON_WARNING = `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>`;

        // Fungsi toast custom dengan HTML
        function showCustomToast(iconSvg, title, text, timer = 3500, bgColor = '#10b981') {
            Swal.fire({
                html: `
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="flex-shrink: 0;">${iconSvg}</div>
                        <div style="flex: 1; text-align: left;">
                            <div style="font-weight: 600; font-size: 14px; color: #0f172a; margin-bottom: 2px;">${title}</div>
                            <div style="font-size: 13px; color: #64748b;">${text}</div>
                        </div>
                    </div>
                `,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: timer,
                timerProgressBar: true,
                background: '#ffffff',
                customClass: {
                    popup: 'custom-toast-fixed'
                },
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                    // Set warna progress bar
                    const progressBar = toast.querySelector('.swal2-timer-progress-bar');
                    if (progressBar) progressBar.style.background = bgColor;
                }
            });
        }

        // ==========================================
        // 1. GLOBAL FLASH MESSAGE
        // ==========================================
        @if(session('success'))
            showCustomToast(ICON_SUCCESS, 'Berhasil', '{{ session('success') }}', 3500, '#10b981');
        @endif

        @if(session('error'))
            showCustomToast(ICON_ERROR, 'Gagal', '{{ session('error') }}', 4000, '#ef4444');
        @endif

        @if(session('warning'))
            showCustomToast(ICON_WARNING, 'Peringatan', '{{ session('warning') }}', 3500, '#f59e0b');
        @endif

        @if($errors->any())
            const errorMessages = {!! json_encode($errors->all()) !!};
            const errorHtml = '<ul class="error-list">' + 
                errorMessages.map(msg => `<li>${msg}</li>`).join('') + 
                '</ul>';
            
            Swal.fire({
                iconHtml: ICON_WARNING,
                title: 'Mohon Perbaiki Form',
                html: errorHtml,
                confirmButtonText: 'Mengerti',
                customClass: {
                    popup: 'swal2-error-popup'
                }
            });
        @endif

        // ==========================================
        // 2. DELETE CONFIRMATION
        // ==========================================
        document.body.addEventListener('submit', function(e) {
            const form = e.target;
            if (form.classList.contains('delete-form')) {
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus Data?',
                    text: "Tindakan ini tidak dapat dibatalkan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Memproses...',
                            text: 'Mohon tunggu sebentar',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            didOpen: () => { Swal.showLoading(); }
                        });
                        form.submit();
                    }
                });
            }
        });
    });
</script>

<script>
    (function() {
        // Cek preferensi tersimpan
        const savedTheme = localStorage.getItem('theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        
        if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode');
        }

        // Update tampilan tombol
        function updateToggleUI() {
            const isDark = document.body.classList.contains('dark-mode');
            const icon = document.getElementById('themeIcon');
            const textSpan = document.getElementById('themeText');
            if (icon && textSpan) {
                if (isDark) {
                    icon.className = 'icon-base bi bi-sun-fill icon-md';
                    textSpan.innerText = 'Light Mode';
                } else {
                    icon.className = 'icon-base bi bi-moon-fill icon-md';
                    textSpan.innerText = 'Dark Mode';
                }
            }
        }

        // Event listener untuk tombol toggle
        const toggleBtn = document.getElementById('themeToggle');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                document.body.classList.toggle('dark-mode');
                const isDark = document.body.classList.contains('dark-mode');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
                updateToggleUI();
            });
        }
        updateToggleUI();
    })();
</script>

<style>
    /* Toast container - pastikan padding dan border rapi */
    .custom-toast-fixed {
        padding: 12px 16px !important;
        border-radius: 12px !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.02) !important;
        border: 1px solid #f1f5f9 !important;
        background: #ffffff !important;
        min-width: 280px !important;
        max-width: 420px !important;
    }
    /* Pastikan progress bar di bawah */
    .swal2-timer-progress-bar {
        height: 3px !important;
        border-radius: 0 0 12px 12px !important;
    }
    /* Popup error validation */
    .swal2-error-popup {
        border-top: 4px solid #f43f5e !important;
        border-radius: 16px !important;
        padding: 1.5rem !important;
    }
    .swal2-error-popup .swal2-title {
        color: #be123c !important;
        font-weight: 700 !important;
    }
    .error-list {
        list-style: none !important;
        padding: 1rem !important;
        margin: 0 !important;
        background: #fff1f2 !important;
        border-radius: 12px !important;
    }
    .error-list li {
        padding-left: 1.5rem !important;
        margin-bottom: 0.5rem !important;
        color: #881337 !important;
        position: relative;
    }
    .error-list li::before {
        content: "•";
        color: #f43f5e;
        position: absolute;
        left: 0.25rem;
        font-size: 1.2rem;
    }
    .swal2-error-popup .swal2-confirm {
        background-color: #f43f5e !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
    }
    .swal2-container {
        z-index: 99999 !important;
    }
</style>

{{-- Override warna hardcoded light-mode di halaman admin (rules/gejala/penyakit/dashboard).
     Diletakkan paling akhir agar menang !important via source-order saat dark mode aktif. --}}
<style>
    body.dark-mode .layout-navbar {
        background-color: var(--bg-card) !important;
        box-shadow: 0 1px 0 0 var(--border-color) !important;
    }

    /* === Tabel === */
    body.dark-mode .table-clean thead th,
    body.dark-mode .table thead th {
        background-color: var(--table-header-bg) !important;
        color: #aeb6c2 !important;
        border-bottom-color: var(--border-color) !important;
    }
    body.dark-mode .table-clean tbody td,
    body.dark-mode .table tbody td {
        border-bottom-color: var(--border-color) !important;
        color: var(--text-primary) !important;
    }
    body.dark-mode .table-clean tbody tr:hover,
    body.dark-mode .table tbody tr:hover {
        background-color: var(--hover-bg) !important;
    }

    /* === Badge kode === */
    body.dark-mode .code-badge {
        background-color: var(--badge-light-bg) !important;
        color: var(--code-badge-text) !important;
    }

    /* === Tombol aksi tabel (btn-icon) === */
    body.dark-mode .btn-icon {
        background: var(--bg-card) !important;
        border-color: var(--btn-outline-border) !important;
        color: var(--btn-icon-color) !important;
    }
    body.dark-mode .btn-icon:hover {
        background: var(--hover-bg) !important;
        border-color: var(--text-secondary) !important;
        color: var(--text-primary) !important;
    }

    /* === Tombol primary aksi === */
    body.dark-mode .btn-action-primary {
        background-color: #2a2f3a !important;
        color: #ffffff !important;
    }
    body.dark-mode .btn-action-primary:hover {
        background-color: #353b48 !important;
    }

    /* === Box "Show entries" === */
    body.dark-mode .entries-box label {
        color: var(--text-secondary) !important;
    }
    body.dark-mode .entries-box select {
        background-color: var(--bg-card) !important;
        border-color: var(--btn-outline-border) !important;
        color: var(--text-primary) !important;
    }

    /* === Info pencarian & teks abu === */
    body.dark-mode .search-info,
    body.dark-mode .pagination-info {
        color: var(--text-secondary) !important;
    }
    body.dark-mode .text-muted {
        color: var(--text-secondary) !important;
    }

    /* === Pagination === */
    body.dark-mode .pagination-wrapper .page-item .page-link {
        color: var(--text-primary) !important;
        background-color: var(--bg-card) !important;
        border-color: var(--btn-outline-border) !important;
    }
    body.dark-mode .pagination-wrapper .page-item .page-link:hover {
        background-color: var(--hover-bg) !important;
        color: var(--text-primary) !important;
    }
    body.dark-mode .pagination-wrapper .page-item.active .page-link {
        background-color: #3a3f4b !important;
        border-color: #3a3f4b !important;
        color: #ffffff !important;
    }
    body.dark-mode .pagination-wrapper .page-item.disabled .page-link {
        background-color: var(--bg-card) !important;
        border-color: var(--btn-outline-border) !important;
        color: var(--text-secondary) !important;
    }

    /* === Choices.js (select custom) === */
    body.dark-mode .choices__inner {
        background-color: var(--bg-card) !important;
        border-color: var(--btn-outline-border) !important;
        color: var(--text-primary) !important;
    }
    body.dark-mode .choices__list--single .choices__item {
        color: var(--text-primary) !important;
    }
    body.dark-mode .choices__list--dropdown,
    body.dark-mode .choices__list[aria-expanded] {
        background-color: var(--bg-card) !important;
        border-color: var(--btn-outline-border) !important;
    }
    body.dark-mode .choices__list--dropdown .choices__item--selectable.is-highlighted {
        background-color: var(--hover-bg) !important;
    }
    body.dark-mode .choices__list--multiple .choices__item {
        background: var(--badge-light-bg) !important;
        border-color: var(--btn-outline-border) !important;
        color: var(--text-primary) !important;
    }

    /* === Form input standar === */
    body.dark-mode .form-control,
    body.dark-mode .form-select {
        background-color: var(--bg-card) !important;
        border-color: var(--btn-outline-border) !important;
        color: var(--text-primary) !important;
    }
    body.dark-mode .form-control::placeholder {
        color: var(--text-secondary) !important;
    }
    body.dark-mode .form-control:focus,
    body.dark-mode .form-select:focus {
        border-color: var(--text-secondary) !important;
        box-shadow: 0 0 0 4px rgba(120, 130, 150, 0.15) !important;
    }

    /* === Modal header close & title === */
    body.dark-mode .modal-title {
        color: var(--text-primary) !important;
    }
    body.dark-mode .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%);
    }
</style>
</body>
</html>
