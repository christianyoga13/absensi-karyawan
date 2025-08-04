<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function absenKeluar()
    {
        return view('absen-keluar');
    }

    public function cekAbsensi()
    {
        return view('cek-absensi');
    }

    public function absenMasuk(Request $request)
    {
        try {
            $request->validate([
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'alamat' => 'required|string'
            ]);

            Carbon::setLocale('id');
            $today = Carbon::today('Asia/Jakarta');
            $now = Carbon::now('Asia/Jakarta');
            
            $existingAbsen = Absensi::where('user_id', Auth::id())
                ->where('tanggal', $today)
                ->first();

            if ($existingAbsen && $existingAbsen->jam_masuk) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah absen masuk hari ini pada ' . $existingAbsen->jam_masuk
                ]);
            }

            $data = [
                'jam_masuk' => $now->format('H:i:s'),
                'latitude_masuk' => $request->latitude,
                'longitude_masuk' => $request->longitude,
                'alamat_masuk' => $request->alamat
            ];

            if ($existingAbsen) {
                $existingAbsen->update($data);
                $absensi = $existingAbsen;
            } else {
                $absensi = Absensi::create(array_merge($data, [
                    'user_id' => Auth::id(),
                    'tanggal' => $today,
                    'status' => 'Hadir'
                ]));
            }

            return response()->json([
                'success' => true,
                'message' => 'Absen masuk berhasil pada ' . $now->format('H:i:s'),
                'data' => [
                    'tanggal' => $absensi->tanggal->format('Y-m-d'),
                    'jam_masuk' => $absensi->jam_masuk,
                    'jam_keluar' => $absensi->jam_keluar
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function absenPulang(Request $request)
    {
        try {
            $request->validate([
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'alamat' => 'required|string'
            ]);

            Carbon::setLocale('id');
            $today = Carbon::today('Asia/Jakarta');
            $now = Carbon::now('Asia/Jakarta');
            
            $absensi = Absensi::where('user_id', Auth::id())
                ->where('tanggal', $today)
                ->first();

            if (!$absensi || !$absensi->jam_masuk) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda harus absen masuk terlebih dahulu!'
                ]);
            }

            if ($absensi->jam_keluar) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah absen pulang hari ini pada ' . $absensi->jam_keluar
                ]);
            }

            $absensi->update([
                'jam_keluar' => $now->format('H:i:s'),
                'latitude_keluar' => $request->latitude,
                'longitude_keluar' => $request->longitude,
                'alamat_keluar' => $request->alamat
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Absen pulang berhasil pada ' . $now->format('H:i:s'),
                'data' => [
                    'tanggal' => $absensi->tanggal->format('Y-m-d'),
                    'jam_masuk' => $absensi->jam_masuk,
                    'jam_keluar' => $absensi->jam_keluar,
                    'durasi_kerja' => $absensi->durasi_kerja
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAbsensi(Request $request)
    {
        try {
            $absensiData = Absensi::where('user_id', Auth::id())
                ->orderBy('tanggal', 'desc')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'tanggal' => $item->tanggal->format('Y-m-d'),
                        'tanggal_formatted' => $item->tanggal->format('l, d F Y'),
                        'jam_masuk' => $item->jam_masuk,
                        'jam_keluar' => $item->jam_keluar,
                        'alamat_masuk' => $item->alamat_masuk,
                        'alamat_keluar' => $item->alamat_keluar,
                        'latitude_masuk' => $item->latitude_masuk,
                        'longitude_masuk' => $item->longitude_masuk,
                        'latitude_keluar' => $item->latitude_keluar,
                        'longitude_keluar' => $item->longitude_keluar,
                        'durasi_kerja' => $item->durasi_kerja,
                        'status_lengkap' => $item->status_lengkap,
                        'status' => $item->status,
                        'keterangan' => $item->keterangan
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $absensiData
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAbsensiToday(Request $request)
    {
        try {
            $today = Carbon::today('Asia/Jakarta');
            
            $absensi = Absensi::where('user_id', Auth::id())
                ->where('tanggal', $today)
                ->first();

            $data = null;
            if ($absensi) {
                $data = [
                    'tanggal' => $absensi->tanggal->format('Y-m-d'),
                    'jam_masuk' => $absensi->jam_masuk,
                    'jam_keluar' => $absensi->jam_keluar,
                    'alamat_masuk' => $absensi->alamat_masuk,
                    'alamat_keluar' => $absensi->alamat_keluar,
                    'latitude_masuk' => $absensi->latitude_masuk,
                    'longitude_masuk' => $absensi->longitude_masuk,
                    'latitude_keluar' => $absensi->latitude_keluar,
                    'longitude_keluar' => $absensi->longitude_keluar,
                    'status_lengkap' => $absensi->status_lengkap,
                    'durasi_kerja' => $absensi->durasi_kerja
                ];
            }

            return response()->json([
                'success' => true,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getStatistik(Request $request)
    {
        try {
            $totalHari = Absensi::where('user_id', Auth::id())->count();
            $absensiLengkap = Absensi::where('user_id', Auth::id())
                ->whereNotNull('jam_masuk')
                ->whereNotNull('jam_keluar')
                ->count();
            $belumLengkap = Absensi::where('user_id', Auth::id())
                ->whereNotNull('jam_masuk')
                ->whereNull('jam_keluar')
                ->count();
            
            $avgDurasi = Absensi::where('user_id', Auth::id())
                ->whereNotNull('jam_masuk')
                ->whereNotNull('jam_keluar')
                ->get()
                ->average('durasi_kerja');

            return response()->json([
                'success' => true,
                'data' => [
                    'total_hari' => $totalHari,
                    'absensi_lengkap' => $absensiLengkap,
                    'belum_lengkap' => $belumLengkap,
                    'rata_rata_kerja' => $avgDurasi ? round($avgDurasi, 1) : 0
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
