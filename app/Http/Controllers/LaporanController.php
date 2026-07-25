<?php

namespace App\Http\Controllers;

use App\Models\Risiko;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tahun = (int) $request->query(
            'tahun',
            now()->year
        );

        $triwulan = (int) $request->query(
            'triwulan',
            (int) ceil(now()->month / 3)
        );

        $this->validasiPeriode($tahun, $triwulan);

        [$tanggalAwal, $tanggalAkhir] =
            $this->periodeTriwulan($tahun, $triwulan);

        $risikos = $this->ambilDataRisiko(
            $tanggalAwal,
            $tanggalAkhir
        );

        $namaTriwulan = $this->namaTriwulan($triwulan);

        return view('laporan.index', compact(
            'risikos',
            'tahun',
            'triwulan',
            'namaTriwulan',
            'tanggalAwal',
            'tanggalAkhir'
        ));
    }

    public function download(Request $request)
    {
        $tahun = (int) $request->query(
            'tahun',
            now()->year
        );

        $triwulan = (int) $request->query(
            'triwulan',
            (int) ceil(now()->month / 3)
        );

        $this->validasiPeriode($tahun, $triwulan);

        [$tanggalAwal, $tanggalAkhir] =
            $this->periodeTriwulan($tahun, $triwulan);

        $risikos = $this->ambilDataRisiko(
            $tanggalAwal,
            $tanggalAkhir
        );

        $namaTriwulan = $this->namaTriwulan($triwulan);

        $pdf = Pdf::loadView(
            'laporan.pdf',
            compact(
                'risikos',
                'tahun',
                'triwulan',
                'namaTriwulan',
                'tanggalAwal',
                'tanggalAkhir'
            )
        );

        /*
         * Format laporan resmi berbentuk lembar
         * pemantauan untuk setiap risiko.
         */
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download(
            'laporan-pemantauan-triwulan-'
            . strtolower($namaTriwulan)
            . '-'
            . $tahun
            . '.pdf'
        );
    }

    private function ambilDataRisiko(
        Carbon $tanggalAwal,
        Carbon $tanggalAkhir
    ): Collection {
        $query = Risiko::query()
            ->with([
                'user',
                'verifikator',
                'pereviu',
            ])
            /*
             * updated_at digunakan sebagai tanggal
             * pemantauan terakhir risiko.
             */
            ->whereBetween('updated_at', [
                $tanggalAwal,
                $tanggalAkhir,
            ]);

        $role = strtoupper(
            (string) auth()->user()->role
        );

        /*
         * UPR hanya dapat melihat risiko miliknya.
         */
        if ($role === 'UPR') {
            $query->where(
                'user_id',
                auth()->id()
            );
        }

        
        if ($role === 'UPI') {
            $query->where(
                'status_verifikasi',
                'Disetujui'
            );
        }

        return $query
            ->orderBy('kode_risiko')
            ->get();
    }

    private function periodeTriwulan(
        int $tahun,
        int $triwulan
    ): array {
        $bulanAwal = (($triwulan - 1) * 3) + 1;

        $tanggalAwal = Carbon::create(
            $tahun,
            $bulanAwal,
            1
        )->startOfDay();

        $tanggalAkhir = $tanggalAwal
            ->copy()
            ->addMonths(3)
            ->subDay()
            ->endOfDay();

        return [
            $tanggalAwal,
            $tanggalAkhir,
        ];
    }

    private function namaTriwulan(
        int $triwulan
    ): string {
        return match ($triwulan) {
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
        };
    }

    private function validasiPeriode(
        int $tahun,
        int $triwulan
    ): void {
        abort_unless(
            $tahun >= 2000
            && $tahun <= 2100
            && in_array(
                $triwulan,
                [1, 2, 3, 4],
                true
            ),
            422,
            'Periode laporan tidak valid.'
        );
    }
}