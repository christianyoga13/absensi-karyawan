<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Cek Absensi - Sistem Absensi</title>

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
                    <a class="nav-link" href="/absen-keluar">
                        <i class="bi bi-box-arrow-right me-2"></i>Absen Keluar
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        <i class="bi bi-bar-chart me-2"></i>Cek Absensi
                    </a>
                </li>
            </ul>
        </div>

        <div class="container mt-5">
            <div class="text-center mb-5">
                <h2 class="section-title">Riwayat Absensi</h2>
                <p class="section-subtitle">Lihat semua data absensi Anda</p>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-md-3">
                    <div class="card stat-card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-calendar3 text-primary mb-3" style="font-size: 2rem;"></i>
                            <div class="stat-number text-primary" id="total-hari">0</div>
                            <div class="stat-label">Total Hari</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-bar-chart text-success mb-3" style="font-size: 2rem;"></i>
                            <div class="stat-number text-success" id="absensi-lengkap">0</div>
                            <div class="stat-label">Absensi Lengkap</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-clock text-warning mb-3" style="font-size: 2rem;"></i>
                            <div class="stat-number text-warning" id="belum-lengkap">0</div>
                            <div class="stat-label">Belum Lengkap</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-speedometer2 text-info mb-3" style="font-size: 2rem;"></i>
                            <div class="stat-number text-info" id="rata-rata-kerja">0.0h</div>
                            <div class="stat-label">Rata-rata Kerja</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card stat-card">
                <div class="card-header bg-white border-bottom-0 pt-4">
                    <h5 class="mb-0">
                        <i class="bi bi-bar-chart me-2"></i>Data Absensi
                    </h5>
                    <small class="text-muted">Riwayat lengkap absensi masuk dan pulang Anda</small>
                </div>
                <div class="card-body">
                    <div id="data-absensi-container">
                        <div class="data-empty">
                            <i class="bi bi-clock-history"></i>
                            <h5>Belum ada data absensi</h5>
                            <p class="mb-0">Mulai absen untuk melihat riwayat di sini</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                updateStatistics();
                updateDataTable();
            });
            
            async function updateStatistics() {
                try {
                    const response = await fetch('/api/statistik');
                    const result = await response.json();
                    
                    if (result.success) {
                        const data = result.data;
                        
                        document.getElementById('total-hari').textContent = data.total_hari;
                        document.getElementById('absensi-lengkap').textContent = data.absensi_lengkap;
                        document.getElementById('belum-lengkap').textContent = data.belum_lengkap;
                        document.getElementById('rata-rata-kerja').textContent = data.rata_rata_kerja + 'h';
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
                    
                    if (!result.success || result.data.length === 0) {
                        container.innerHTML = `
                            <div class="data-empty">
                                <i class="bi bi-clock-history"></i>
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
                            if (record.durasi_kerja && record.durasi_kerja > 0) {
                                duration = record.durasi_kerja + ' jam';
                            } else {
                                duration = 'Error: ' + (record.durasi_kerja || 'null');
                            }
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
                                <td>${record.jam_masuk || '- jam'}</td>
                                <td>${lokasiMasuk}</td>
                                <td>${record.jam_keluar || '- jam'}</td>
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
                    const container = document.getElementById('data-absensi-container');
                    container.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Gagal memuat data absensi
                        </div>
                    `;
                }
            }
        </script>
    </body>
</html>
