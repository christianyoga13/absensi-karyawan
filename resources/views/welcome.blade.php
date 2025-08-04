<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Sistem Absensi</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700" rel="stylesheet">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
                background-color: #f8f9fa;
            }
            .navbar-brand {
                font-weight: 700;
                color: #007bff !important;
            }
            .nav-pills .nav-link {
                color: #6c757d;
                border-radius: 8px;
                margin: 0 5px;
                padding: 10px 20px;
            }
            .nav-pills .nav-link.active {
                background-color: #007bff;
                border: 2px solid #007bff;
            }
            .nav-pills .nav-link:hover {
                background-color: #e9ecef;
            }
            .stat-card {
                border-radius: 15px;
                border: none;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                transition: transform 0.2s;
            }
            .stat-card:hover {
                transform: translateY(-2px);
            }
            .stat-number {
                font-size: 2.5rem;
                font-weight: 700;
            }
            .stat-label {
                color: #6c757d;
                font-weight: 600;
            }
            .section-title {
                color: #007bff;
                font-weight: 700;
                font-size: 1.8rem;
                margin-bottom: 10px;
            }
            .section-subtitle {
                color: #6c757d;
                margin-bottom: 30px;
            }
            .data-empty {
                padding: 60px 20px;
                text-align: center;
                color: #6c757d;
            }
            .data-empty i {
                font-size: 4rem;
                margin-bottom: 20px;
                opacity: 0.5;
            }
            .greeting {
                color: #6c757d;
            }
            .time-display {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                font-weight: 700;
            }
            .date-display {
                font-size: 0.9rem;
            }
            .status-badge-large {
                font-size: 1rem;
                padding: 8px 16px;
            }
            #main-content {
                transition: opacity 0.3s ease-in-out;
                min-height: 500px;
            }
            .nav-link {
                transition: all 0.2s ease-in-out;
            }
            .fade-in {
                animation: fadeIn 0.3s ease-in-out;
            }
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <i class="bi bi-clock-history me-2"></i>
                    Sistem Absensi
                </a>
                <div class="navbar-nav ms-auto">
                    <span class="greeting me-3 mt-2">Selamat datang, <strong>{{ Auth::user()->name ?? 'Guest' }}</strong></span>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-decoration-none" style="border: none; background: none; color: inherit;">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="container mt-4">
            <ul class="nav nav-pills justify-content-start">
                <li class="nav-item">
                    <a class="nav-link active" href="#" onclick="showPage('absen-masuk')" id="absen-masuk-tab">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Absen Masuk
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="showPage('absen-keluar')" id="absen-keluar-tab">
                        <i class="bi bi-box-arrow-right me-2"></i>Absen Keluar
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="showPage('cek-absensi')" id="cek-absensi-tab">
                        <i class="bi bi-bar-chart me-2"></i>Cek Absensi
                    </a>
                </li>
            </ul>
        </div>
        <div id="main-content">
        </div>
        <div style="display: none;">
            <div id="absen-masuk-template">
                <div class="container mt-5">
                    <div class="text-center mb-5">
                        <h2 class="section-title">Absen Masuk</h2>
                        <p class="section-subtitle">Lakukan absensi masuk saat memulai kerja</p>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-md-8 mb-4">
                            <div class="card stat-card p-4 text-center h-100">
                                <div class="card-body d-flex flex-column">
                                    <i class="bi bi-box-arrow-in-right text-primary mb-4" style="font-size: 6rem;"></i>
                                    <h3 class="mb-3">Absen Masuk</h3>
                                    <p class="text-muted mb-4 flex-grow-1">Rekam kehadiran Anda saat memulai kerja hari ini</p>
                                    <div class="mb-4">
                                        <div id="current-time-masuk" class="h4 text-primary time-display mb-2"></div>
                                        <div id="current-date-masuk" class="text-muted date-display"></div>
                                    </div>
                                    <button class="btn btn-primary btn-lg py-3" onclick="absenMasuk()" id="btn-absen-masuk">
                                        <i class="bi bi-clock-fill me-2"></i>Absen Masuk Sekarang
                                    </button>
                                    <div class="mt-3">
                                        <span class="badge bg-secondary status-badge-large" id="status-masuk-page">Belum Absen</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center mt-4">
                        <div class="col-lg-8">
                            <div class="card stat-card">
                                <div class="card-header bg-white border-bottom-0 pt-4">
                                    <h5 class="mb-0 text-center">
                                        <i class="bi bi-calendar-check me-2"></i>Status Absensi Hari Ini
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-md-6">
                                            <div class="p-3">
                                                <i class="bi bi-clock text-success mb-2" style="font-size: 2rem;"></i>
                                                <h6>Jam Masuk</h6>
                                                <span class="badge bg-secondary" id="status-masuk-today">Belum Absen</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-3">
                                                <i class="bi bi-clock-fill text-danger mb-2" style="font-size: 2rem;"></i>
                                                <h6>Jam Keluar</h6>
                                                <span class="badge bg-secondary" id="status-pulang-today">Belum Absen</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        <script>
            let absensiData = [];
            let currentPage = 'absen-masuk';
            let absenKeluarLoaded = false;
            let cekAbsensiLoaded = false;
            let absenKeluarContent = '';
            let cekAbsensiContent = '';
            
            document.addEventListener('DOMContentLoaded', function() {
                showPage('absen-masuk');
                updateClock();
                setInterval(updateClock, 1000);
                loadAbsensiData(); 
            });
            
            function showPage(page, fromNavClick = false) {
                currentPage = page;
                const mainContent = document.getElementById('main-content');
                
                const navLinks = document.querySelectorAll('.nav-link');
                navLinks.forEach(link => link.classList.remove('active'));
                
                const activeLink = document.getElementById(page + '-tab');
                if (activeLink) {
                    activeLink.classList.add('active');
                }
                
                if (page === 'absen-masuk') {
                    const template = document.getElementById('absen-masuk-template');
                    if (template) {
                        mainContent.innerHTML = template.innerHTML;
                        initializePage(page);
                    }
                } else if (page === 'absen-keluar') {
                    if (!absenKeluarLoaded) {
                        mainContent.innerHTML = '<div class="container mt-5"><div class="text-center"><i class="bi bi-hourglass-split text-primary" style="font-size: 3rem;"></i><p class="mt-3">Memuat halaman absen keluar...</p></div></div>';
                        loadAbsenKeluarContent().then(content => {
                            absenKeluarContent = content;
                            mainContent.innerHTML = content;
                            absenKeluarLoaded = true;
                            initializePage(page);
                        });
                    } else {
                        mainContent.innerHTML = absenKeluarContent;
                        initializePage(page);
                    }
                } else if (page === 'cek-absensi') {
                    if (!cekAbsensiLoaded) {
                        mainContent.innerHTML = '<div class="container mt-5"><div class="text-center"><i class="bi bi-hourglass-split text-primary" style="font-size: 3rem;"></i><p class="mt-3">Memuat halaman cek absensi...</p></div></div>';
                        loadCekAbsensiContent().then(content => {
                            cekAbsensiContent = content;
                            mainContent.innerHTML = content;
                            cekAbsensiLoaded = true;
                            initializePage(page);
                        });
                    } else {
                        mainContent.innerHTML = cekAbsensiContent;
                        initializePage(page);
                    }
                }
            }
            
            function updateNavigation(activePage) {
                document.querySelectorAll('.nav-link').forEach(link => {
                    link.classList.remove('active');
                });
                
                const activeTab = document.getElementById(activePage + '-tab');
                if (activeTab) {
                    activeTab.classList.add('active');
                }
            }
            
            async function loadAbsenKeluarContent() {
                try {
                    const response = await fetch('/absen-keluar');
                    const html = await response.text();
                    
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const container = doc.querySelector('.container.mt-5');
                    
                    return container ? container.outerHTML : '';
                } catch (error) {
                    console.error('Error loading absen keluar:', error);
                    return '<div class="container mt-5"><div class="alert alert-danger">Gagal memuat halaman absen keluar</div></div>';
                }
            }
            
            async function loadCekAbsensiContent() {
                try {
                    const response = await fetch('/cek-absensi');
                    const html = await response.text();
                    
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const container = doc.querySelector('.container.mt-5');
                    
                    return container ? container.outerHTML : '';
                } catch (error) {
                    console.error('Error loading cek absensi:', error);
                    return '<div class="container mt-5"><div class="alert alert-danger">Gagal memuat halaman cek absensi</div></div>';
                }
            }
            
            function injectPageScripts(page) {
                const existingScripts = document.querySelectorAll('script[data-page]');
                existingScripts.forEach(script => script.remove());
                
                if (page === 'cek-absensi') {
                    const script = document.createElement('script');
                    script.setAttribute('data-page', 'cek-absensi');
                    script.textContent = `
                        setTimeout(() => {
                            updateStatistics();
                            updateDataTable();
                        }, 100);
                    `;
                    document.body.appendChild(script);
                }
            }
            
            function initializePage(page) {
                setTimeout(() => {
                    switch(page) {
                        case 'absen-masuk':
                            updateTodayStatus();
                            break;
                        case 'absen-keluar':
                            updateTodayStatusKeluar();
                            break;
                        case 'cek-absensi':
                            updateStatistics();
                            updateDataTable();
                            break;
                    }
                }, 50);
            }
            
            document.getElementById('main-content').style.transition = 'opacity 0.3s ease-in-out';
            
            function updateClock() {
                const now = new Date();
                const timeString = now.toLocaleTimeString('id-ID');
                const dateString = now.toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                
                const timeMasuk = document.getElementById('current-time-masuk');
                const dateMasuk = document.getElementById('current-date-masuk');
                if (timeMasuk) timeMasuk.textContent = timeString;
                if (dateMasuk) dateMasuk.textContent = dateString;
                
                const timeKeluar = document.getElementById('current-time-keluar');
                const dateKeluar = document.getElementById('current-date-keluar');
                if (timeKeluar) timeKeluar.textContent = timeString;
                if (dateKeluar) dateKeluar.textContent = dateString;
            }
            
            async function loadAbsensiData() {
                try {
                    const response = await fetch('/api/absensi');
                    const result = await response.json();
                    
                    if (result.success) {
                        absensiData = result.data.map(item => ({
                            date: new Date(item.tanggal).toDateString(),
                            masuk: item.jam_masuk,
                            pulang: item.jam_keluar,
                            id: item.id,
                            durasi_kerja: item.durasi_kerja,
                            status_lengkap: item.status_lengkap
                        }));
                        
                        if (currentPage === 'absen-masuk') {
                            updateTodayStatus();
                        } else if (currentPage === 'absen-keluar') {
                            updateTodayStatusKeluar();
                        }
                    }
                } catch (error) {
                    console.error('Error loading absensi data:', error);
                }
            }
            
            function updateTodayStatus() {
                loadTodayStatus();
            }
            
            async function loadTodayStatus() {
                try {
                    const response = await fetch('/api/absensi-today');
                    const result = await response.json();
                    
                    const statusMasukPage = document.getElementById('status-masuk-page');
                    const statusMasukToday = document.getElementById('status-masuk-today');
                    const statusPulangToday = document.getElementById('status-pulang-today');
                    const btnAbsenMasuk = document.getElementById('btn-absen-masuk');
                    
                    if (result.success && result.data) {
                        const data = result.data;
                        
                        if (data.jam_masuk) {
                            const masukTime = data.jam_masuk;
                            const masukClass = 'badge bg-success status-badge-large';
                            
                            if (statusMasukPage) {
                                statusMasukPage.textContent = 'Sudah Absen: ' + masukTime;
                                statusMasukPage.className = masukClass;
                            }
                            if (statusMasukToday) {
                                statusMasukToday.textContent = masukTime;
                                statusMasukToday.className = 'badge bg-success';
                            }
                            
                            if (btnAbsenMasuk) {
                                btnAbsenMasuk.disabled = true;
                                btnAbsenMasuk.innerHTML = '<i class="bi bi-check-circle me-2"></i>Sudah Absen Masuk';
                                btnAbsenMasuk.className = 'btn btn-success btn-lg py-3';
                            }
                        } else {
                            const defaultText = 'Belum Absen';
                            const defaultClass = 'badge bg-secondary status-badge-large';
                            
                            if (statusMasukPage) {
                                statusMasukPage.textContent = defaultText;
                                statusMasukPage.className = defaultClass;
                            }
                            if (statusMasukToday) {
                                statusMasukToday.textContent = defaultText;
                                statusMasukToday.className = 'badge bg-secondary';
                            }
                            
                            if (btnAbsenMasuk) {
                                btnAbsenMasuk.disabled = false;
                                btnAbsenMasuk.innerHTML = '<i class="bi bi-clock-fill me-2"></i>Absen Masuk Sekarang';
                                btnAbsenMasuk.className = 'btn btn-primary btn-lg py-3';
                            }
                        }
                        
                        if (data.jam_keluar) {
                            const pulangTime = data.jam_keluar;
                            
                            if (statusPulangToday) {
                                statusPulangToday.textContent = pulangTime;
                                statusPulangToday.className = 'badge bg-success';
                            }
                        } else {
                            if (statusPulangToday) {
                                statusPulangToday.textContent = 'Belum Absen';
                                statusPulangToday.className = 'badge bg-secondary';
                            }
                        }
                    } else {
                        const defaultText = 'Belum Absen';
                        const defaultClass = 'badge bg-secondary status-badge-large';
                        const btnAbsenMasuk = document.getElementById('btn-absen-masuk');
                        
                        if (statusMasukPage) {
                            statusMasukPage.textContent = defaultText;
                            statusMasukPage.className = defaultClass;
                        }
                        if (statusMasukToday) {
                            statusMasukToday.textContent = defaultText;
                            statusMasukToday.className = 'badge bg-secondary';
                        }
                        if (statusPulangToday) {
                            statusPulangToday.textContent = defaultText;
                            statusPulangToday.className = 'badge bg-secondary';
                        }
                        
                        if (btnAbsenMasuk) {
                            btnAbsenMasuk.disabled = false;
                            btnAbsenMasuk.innerHTML = '<i class="bi bi-clock-fill me-2"></i>Absen Masuk Sekarang';
                            btnAbsenMasuk.className = 'btn btn-primary btn-lg py-3';
                        }
                    }
                } catch (error) {
                    console.error('Error loading today status:', error);
                }
            }
            
            function updateTodayStatusKeluar() {
                loadTodayStatusKeluar();
            }
            
            async function loadTodayStatusKeluar() {
                try {
                    const response = await fetch('/api/absensi-today');
                    const result = await response.json();
                    
                    const statusKeluarPage = document.getElementById('status-keluar-page');
                    const statusMasukKeluar = document.getElementById('status-masuk-keluar');
                    const statusPulangKeluar = document.getElementById('status-pulang-keluar');
                    
                    if (result.success && result.data) {
                        const data = result.data;
                        
                        if (data.jam_masuk) {
                            const masukTime = data.jam_masuk;
                            
                            if (statusMasukKeluar) {
                                statusMasukKeluar.textContent = masukTime;
                                statusMasukKeluar.className = 'badge bg-success';
                            }
                        } else {
                            if (statusMasukKeluar) {
                                statusMasukKeluar.textContent = 'Belum Absen';
                                statusMasukKeluar.className = 'badge bg-secondary';
                            }
                        }
                        
                        if (data.jam_keluar) {
                            const pulangTime = data.jam_keluar;
                            const pulangClass = 'badge bg-success status-badge-large';
                            
                            if (statusKeluarPage) {
                                statusKeluarPage.textContent = 'Sudah Absen: ' + pulangTime;
                                statusKeluarPage.className = pulangClass;
                            }
                            if (statusPulangKeluar) {
                                statusPulangKeluar.textContent = pulangTime;
                                statusPulangKeluar.className = 'badge bg-success';
                            }
                        } else {
                            const defaultText = 'Belum Absen';
                            const defaultClass = 'badge bg-secondary status-badge-large';
                            
                            if (statusKeluarPage) {
                                statusKeluarPage.textContent = defaultText;
                                statusKeluarPage.className = defaultClass;
                            }
                            if (statusPulangKeluar) {
                                statusPulangKeluar.textContent = defaultText;
                                statusPulangKeluar.className = 'badge bg-secondary';
                            }
                        }
                    } else {
                        const defaultText = 'Belum Absen';
                        const defaultClass = 'badge bg-secondary status-badge-large';
                        
                        if (statusKeluarPage) {
                            statusKeluarPage.textContent = defaultText;
                            statusKeluarPage.className = defaultClass;
                        }
                        if (statusMasukKeluar) {
                            statusMasukKeluar.textContent = defaultText;
                            statusMasukKeluar.className = 'badge bg-secondary';
                        }
                        if (statusPulangKeluar) {
                            statusPulangKeluar.textContent = defaultText;
                            statusPulangKeluar.className = 'badge bg-secondary';
                        }
                    }
                } catch (error) {
                    console.error('Error loading today status keluar:', error);
                }
            }
            
            async function absenMasuk() {
                try {
                    const location = await getCurrentLocation();
                    const address = await getAddressFromCoordinates(location.latitude, location.longitude);
                    
                    const response = await fetch('/api/absen-masuk', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        },
                        body: JSON.stringify({
                            latitude: location.latitude,
                            longitude: location.longitude,
                            alamat: address
                        })
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        alert(result.message + '\nLokasi: ' + address);
                        loadTodayStatus(); 
                        loadAbsensiData(); 
                    } else {
                        alert(result.message);
                    }
                } catch (error) {
                    console.error('Error absen masuk:', error);
                    if (error.message.includes('location')) {
                        alert('Tidak dapat mengakses lokasi. Pastikan Anda mengizinkan akses lokasi.');
                    } else {
                        alert('Terjadi kesalahan saat absen masuk');
                    }
                }
            }
            
            async function absenPulang() {
                try {
                    const location = await getCurrentLocation();
                    const address = await getAddressFromCoordinates(location.latitude, location.longitude);
                    
                    const response = await fetch('/api/absen-pulang', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        },
                        body: JSON.stringify({
                            latitude: location.latitude,
                            longitude: location.longitude,
                            alamat: address
                        })
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        alert(result.message + '\nLokasi: ' + address);
                        loadTodayStatusKeluar(); 
                        loadAbsensiData(); 
                    } else {
                        alert(result.message);
                    }
                } catch (error) {
                    console.error('Error absen pulang:', error);
                    if (error.message.includes('location')) {
                        alert('Tidak dapat mengakses lokasi. Pastikan Anda mengizinkan akses lokasi.');
                    } else {
                        alert('Terjadi kesalahan saat absen pulang');
                    }
                }
            }
            
            function getCurrentLocation() {
                return new Promise((resolve, reject) => {
                    if (!navigator.geolocation) {
                        reject(new Error('Geolocation is not supported by this browser.'));
                        return;
                    }
                    
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            resolve({
                                latitude: position.coords.latitude,
                                longitude: position.coords.longitude
                            });
                        },
                        (error) => {
                            let message = 'Unable to retrieve location: ';
                            switch(error.code) {
                                case error.PERMISSION_DENIED:
                                    message += 'User denied the request for Geolocation.';
                                    break;
                                case error.POSITION_UNAVAILABLE:
                                    message += 'Location information is unavailable.';
                                    break;
                                case error.TIMEOUT:
                                    message += 'The request to get user location timed out.';
                                    break;
                                default:
                                    message += 'An unknown error occurred.';
                                    break;
                            }
                            reject(new Error(message));
                        },
                        {
                            enableHighAccuracy: true,
                            timeout: 10000,
                            maximumAge: 60000
                        }
                    );
                });
            }
            
            async function getAddressFromCoordinates(lat, lng) {
                try {
                    const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`);
                    const data = await response.json();
                    
                    if (data && data.display_name) {
                        const address = data.address || {};
                        const parts = [];
                        
                        if (address.house_number) parts.push(address.house_number);
                        if (address.road) parts.push(address.road);
                        if (address.suburb || address.neighbourhood) parts.push(address.suburb || address.neighbourhood);
                        if (address.city || address.town || address.village) parts.push(address.city || address.town || address.village);
                        if (address.state) parts.push(address.state);
                        
                        return parts.length > 0 ? parts.join(', ') : data.display_name;
                    }
                    
                    return `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                } catch (error) {
                    console.error('Error getting address:', error);
                    return `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                }
            }
            
            function setButtonLoading(buttonId, isLoading) {
                const button = document.querySelector(`button[onclick="${buttonId}()"]`);
                if (button) {
                    if (isLoading) {
                        button.disabled = true;
                        button.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Sedang memproses...';
                    } else {
                        button.disabled = false;
                        if (buttonId === 'absenMasuk') {
                            button.innerHTML = '<i class="bi bi-clock-fill me-2"></i>Absen Masuk Sekarang';
                        } else {
                            button.innerHTML = '<i class="bi bi-clock-fill me-2"></i>Absen Keluar Sekarang';
                        }
                    }
                }
            }
            
            async function updateStatistics() {
                try {
                    const response = await fetch('/api/statistik');
                    const result = await response.json();
                    
                    if (result.success) {
                        const data = result.data;
                        
                        const totalHariEl = document.getElementById('total-hari');
                        const absensiLengkapEl = document.getElementById('absensi-lengkap');
                        const belumLengkapEl = document.getElementById('belum-lengkap');
                        const rataRataKerjaEl = document.getElementById('rata-rata-kerja');
                        
                        if (totalHariEl) totalHariEl.textContent = data.total_hari;
                        if (absensiLengkapEl) absensiLengkapEl.textContent = data.absensi_lengkap;
                        if (belumLengkapEl) belumLengkapEl.textContent = data.belum_lengkap;
                        if (rataRataKerjaEl) rataRataKerjaEl.textContent = data.rata_rata_kerja + 'h';
                    }
                } catch (error) {
                    console.error('Error loading statistics:', error);
                }
            }
            
            async function updateDataTable() {
                try {
                    const response = await fetch('/api/absensi');
                    const result = await response.json();
                    
                    const container = document.getElementById('data-absensi-container');
                    if (!container) return;
                    
                    if (!result.success || result.data.length === 0) {
                        container.innerHTML = `
                            <div style="padding: 60px 20px; text-align: center; color: #6c757d;">
                                <i class="bi bi-clock-history" style="font-size: 4rem; margin-bottom: 20px; opacity: 0.5;"></i>
                                <h5>Belum ada data absensi</h5>
                                <p class="mb-0">Mulai absen untuk melihat riwayat di sini</p>
                            </div>
                        `;
                        return;
                    }
                    
                    let tableHtml = `
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jam Masuk</th>
                                        <th>Lokasi Masuk</th>
                                        <th>Jam Pulang</th>
                                        <th>Lokasi Pulang</th>
                                        <th>Durasi Kerja</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;
                    
                    result.data.forEach(record => {
                        let status = '';
                        let statusClass = '';
                        let duration = '- jam';
                        
                        if (record.jam_masuk && record.jam_keluar) {
                            status = 'Lengkap';
                            statusClass = 'bg-success';
                            duration = record.durasi_kerja ? record.durasi_kerja + ' jam' : '- jam';
                        } else if (record.jam_masuk && !record.jam_keluar) {
                            status = 'Belum Pulang';
                            statusClass = 'bg-warning';
                        } else {
                            status = 'Tidak Masuk';
                            statusClass = 'bg-danger';
                        }
                        
                        const lokasiMasuk = record.alamat_masuk ? 
                            `<small class="text-muted" title="${record.alamat_masuk}">${record.alamat_masuk.length > 30 ? record.alamat_masuk.substring(0, 30) + '...' : record.alamat_masuk}</small>` : 
                            '-';
                            
                        const lokasiKeluar = record.alamat_keluar ? 
                            `<small class="text-muted" title="${record.alamat_keluar}">${record.alamat_keluar.length > 30 ? record.alamat_keluar.substring(0, 30) + '...' : record.alamat_keluar}</small>` : 
                            '-';
                        
                        tableHtml += `
                            <tr>
                                <td>${record.tanggal_formatted}</td>
                                <td>${record.jam_masuk || '-'}</td>
                                <td>${lokasiMasuk}</td>
                                <td>${record.jam_keluar || '-'}</td>
                                <td>${lokasiKeluar}</td>
                                <td>${duration}</td>
                                <td><span class="badge ${statusClass}">${status}</span></td>
                            </tr>
                        `;
                    });
                    
                    tableHtml += `
                                </tbody>
                            </table>
                        </div>
                    `;
                    
                    container.innerHTML = tableHtml;
                } catch (error) {
                    console.error('Error loading data table:', error);
                }
            }
        </script>
    </body>
</html>
