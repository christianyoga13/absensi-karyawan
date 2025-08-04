<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Absen Keluar - Sistem Absensi</title>

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
                color: #dc3545;
                font-weight: 700;
                font-size: 1.8rem;
                margin-bottom: 10px;
            }
            .section-subtitle {
                color: #6c757d;
                margin-bottom: 30px;
            }
            .greeting {
                color: #6c757d;
            }
            .time-display {
                background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
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
                    <span class="greeting me-3 mt-2">Selamat datang, <strong>admin</strong></span>
                    <a class="nav-link" href="#">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            </div>
        </nav>

        <div class="container mt-4">
            <ul class="nav nav-pills justify-content-start">
                <li class="nav-item">
                    <a class="nav-link" href="/">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Absen Masuk
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        <i class="bi bi-box-arrow-right me-2"></i>Absen Keluar
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/cek-absensi">
                        <i class="bi bi-bar-chart me-2"></i>Cek Absensi
                    </a>
                </li>
            </ul>
        </div>

        <div class="container mt-5">
            <div class="text-center mb-5">
                <h2 class="section-title">Absen Keluar</h2>
                <p class="section-subtitle">Lakukan absensi keluar saat selesai kerja</p>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 mb-4">
                    <div class="card stat-card p-4 text-center h-100">
                        <div class="card-body d-flex flex-column">
                            <i class="bi bi-box-arrow-right text-danger mb-4" style="font-size: 6rem;"></i>
                            <h3 class="mb-3">Absen Keluar</h3>
                            <p class="text-muted mb-4 flex-grow-1">Rekam kehadiran Anda saat selesai kerja hari ini</p>
                            <div class="mb-4">
                                <div id="current-time-keluar" class="h4 text-danger time-display mb-2"></div>
                                <div id="current-date-keluar" class="text-muted date-display"></div>
                            </div>
                            <button class="btn btn-danger btn-lg py-3" onclick="absenPulang()" id="btn-absen-keluar">
                                <i class="bi bi-clock-fill me-2"></i>Absen Keluar Sekarang
                            </button>
                            <div class="mt-3">
                                <span class="badge bg-secondary status-badge-large" id="status-keluar-page">Belum Absen</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Status Hari Ini -->
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
                                <div class="col-md-4">
                                    <div class="p-3">
                                        <i class="bi bi-clock text-success mb-2" style="font-size: 2rem;"></i>
                                        <h6>Jam Masuk</h6>
                                        <span class="badge bg-secondary" id="status-masuk-keluar">Belum Absen</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3">
                                        <i class="bi bi-clock-fill text-danger mb-2" style="font-size: 2rem;"></i>
                                        <h6>Jam Keluar</h6>
                                        <span class="badge bg-secondary" id="status-pulang-keluar">Belum Absen</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3">
                                        <i class="bi bi-hourglass-split text-info mb-2" style="font-size: 2rem;"></i>
                                        <h6>Durasi Kerja</h6>
                                        <span class="badge bg-secondary" id="durasi-kerja-keluar">-</span>
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
            
            document.addEventListener('DOMContentLoaded', function() {
                updateTodayStatus();
                updateClock();
                setInterval(updateClock, 1000); 
            });
            
            function updateClock() {
                const now = new Date();
                const timeString = now.toLocaleTimeString('id-ID');
                const dateString = now.toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                
                const timeKeluar = document.getElementById('current-time-keluar');
                const dateKeluar = document.getElementById('current-date-keluar');
                if (timeKeluar) timeKeluar.textContent = timeString;
                if (dateKeluar) dateKeluar.textContent = dateString;
            }
            
            async function updateTodayStatus() {
                try {
                    const response = await fetch('/api/absensi-today');
                    const result = await response.json();
                    
                    const statusKeluarPage = document.getElementById('status-keluar-page');
                    const statusMasukKeluar = document.getElementById('status-masuk-keluar');
                    const statusPulangKeluar = document.getElementById('status-pulang-keluar');
                    const durasiKerjaKeluar = document.getElementById('durasi-kerja-keluar');
                    const btnAbsenKeluar = document.getElementById('btn-absen-keluar');
                    
                    if (result.success && result.data) {
                        const data = result.data;
                        
                        // Update jam masuk
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
                        
                        // Update jam keluar dan button logic
                        if (data.jam_keluar) {
                            // Sudah absen keluar
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
                            
                            // Disable button karena sudah absen keluar
                            if (btnAbsenKeluar) {
                                btnAbsenKeluar.disabled = true;
                                btnAbsenKeluar.innerHTML = '<i class="bi bi-check-circle me-2"></i>Sudah Absen Keluar';
                                btnAbsenKeluar.className = 'btn btn-success btn-lg py-3';
                            }
                        } else if (data.jam_masuk) {
                            // Sudah absen masuk tapi belum keluar
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
                            
                            // Enable button karena sudah absen masuk tapi belum keluar
                            if (btnAbsenKeluar) {
                                btnAbsenKeluar.disabled = false;
                                btnAbsenKeluar.innerHTML = '<i class="bi bi-clock-fill me-2"></i>Absen Keluar Sekarang';
                                btnAbsenKeluar.className = 'btn btn-danger btn-lg py-3';
                            }
                        } else {
                            // Belum absen masuk
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
                            
                            // Disable button karena belum absen masuk
                            if (btnAbsenKeluar) {
                                btnAbsenKeluar.disabled = true;
                                btnAbsenKeluar.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i>Harus Absen Masuk Dulu';
                                btnAbsenKeluar.className = 'btn btn-secondary btn-lg py-3';
                            }
                        }
                        
                        // Update durasi kerja
                        if (durasiKerjaKeluar) {
                            if (data.jam_masuk && data.jam_keluar && data.durasi_kerja) {
                                durasiKerjaKeluar.textContent = data.durasi_kerja + ' jam';
                                durasiKerjaKeluar.className = 'badge bg-info';
                            } else {
                                durasiKerjaKeluar.textContent = '- jam';
                                durasiKerjaKeluar.className = 'badge bg-secondary';
                            }
                        }
                    } else {
                        // Belum ada data hari ini
                        const defaultText = 'Belum Absen';
                        const defaultClass = 'badge bg-secondary status-badge-large';
                        const btnAbsenKeluar = document.getElementById('btn-absen-keluar');
                        
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
                        if (durasiKerjaKeluar) {
                            durasiKerjaKeluar.textContent = '- jam';
                            durasiKerjaKeluar.className = 'badge bg-secondary';
                        }
                        
                        // Disable button karena belum absen masuk
                        if (btnAbsenKeluar) {
                            btnAbsenKeluar.disabled = true;
                            btnAbsenKeluar.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i>Harus Absen Masuk Dulu';
                            btnAbsenKeluar.className = 'btn btn-secondary btn-lg py-3';
                        }
                    }
                } catch (error) {
                    console.error('Error loading today status:', error);
                }
            }
            
            async function absenPulang() {
                try {
                    // Get user location first
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
                        updateTodayStatus(); 
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
            
            // Function to get current location
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
            
            // Function to get address from coordinates using reverse geocoding
            async function getAddressFromCoordinates(lat, lng) {
                try {
                    // Using OpenStreetMap Nominatim API (free)
                    const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`);
                    const data = await response.json();
                    
                    if (data && data.display_name) {
                        // Parse address components
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
        </script>
    </body>
</html>
