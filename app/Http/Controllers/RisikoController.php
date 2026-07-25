<?php

namespace App\Http\Controllers;

use App\Models\Risiko;
use App\Models\RiwayatRisiko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RisikoController extends Controller
{
    public function index(Request $request)
{
    $query = Risiko::query()
        ->where('user_id', Auth::id());

    /*
     * Pencarian berdasarkan kode, peristiwa,
     * sasaran, atau kategori risiko.
     */
    if ($request->filled('search')) {
        $search = trim($request->search);

        $query->where(function ($subQuery) use ($search) {
            $subQuery
                ->where('kode_risiko', 'like', "%{$search}%")
                ->orWhere('nama_risiko', 'like', "%{$search}%")
                ->orWhere('sasaran', 'like', "%{$search}%")
                ->orWhere('kategori_risiko', 'like', "%{$search}%");
        });
    }

    /*
     * Filter kategori risiko.
     */
    if ($request->filled('kategori_risiko')) {
        $query->where(
            'kategori_risiko',
            $request->kategori_risiko
        );
    }

    /*
     * Filter level risiko.
     */
    if ($request->filled('level_risiko')) {
        $query->where(
            'level_risiko',
            $request->level_risiko
        );
    }

    /*
     * Filter status verifikasi.
     */
    if ($request->filled('status_verifikasi')) {
        $query->where(
            'status_verifikasi',
            $request->status_verifikasi
        );
    }

    /*
     * Filter status reviu.
     */
    if ($request->filled('status_reviu')) {
        $query->where(
            'status_reviu',
            $request->status_reviu
        );
    }

    /*
     * Filter status penanganan.
     */
    if ($request->filled('status_penanganan')) {
        $query->where(
            'status_penanganan',
            $request->status_penanganan
        );
    }

    $risikos = $query
        ->orderByDesc('besaran_risiko')
        ->paginate(10)
        ->withQueryString();

    return view('risiko.index', compact('risikos'));
}

    public function create()
    {
        return view('risiko.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(
            $this->validationRules()
        );

        $hasilRisiko = $this->hitungRisiko(
            (int) $data['kemungkinan'],
            (int) $data['dampak']
        );

        $hasilResidual = $this->hitungRisikoResidual(
            $data['target_kemungkinan'] ?? null,
            $data['target_dampak'] ?? null
        );

        $risiko = Risiko::create(array_merge(
            $data,
            [
                'user_id' => Auth::id(),

                'besaran_risiko' =>
                    $hasilRisiko['besaran'],

                'level_risiko' =>
                    $hasilRisiko['level'],

                'warna_level' =>
                    $hasilRisiko['warna'],

                'besaran_risiko_residual' =>
                    $hasilResidual['besaran'],

                'level_risiko_residual' =>
                    $hasilResidual['level'],

                'status_verifikasi' =>
                    'Menunggu Verifikasi',

                'status_reviu' =>
                    'Belum Direviu',
            ]
        ));

        $risiko->refresh();

        RiwayatRisiko::create([
            'risiko_id' => $risiko->id,
            'user_id' => Auth::id(),
            'role_pengguna' => Auth::user()->role,
            'jenis_aktivitas' => 'Tambah Risiko',

            'status_sebelum' => null,
            'status_sesudah' =>
                $risiko->status_penanganan,

            'data_sebelum' => null,

            /*
             * Menyimpan seluruh isi Risk Register
             * setelah data berhasil dibuat.
             */
            'data_sesudah' =>
                $this->buatSnapshot($risiko),

            'deskripsi' =>
                'UPR menambahkan data risiko '
                . $risiko->kode_risiko
                . ' - '
                . $risiko->nama_risiko,
        ]);

        return redirect()
            ->route('risiko.index')
            ->with(
                'success',
                'Data Risk Register berhasil ditambahkan.'
            );
    }

    public function edit(Risiko $risiko)
{
    $this->pastikanPemilikRisiko($risiko);

    abort_unless(
        $risiko->dapatDieditOlehUpr(),
        403,
        'Data sedang dalam proses verifikasi/reviu atau sudah disetujui. Data hanya dapat diedit ketika UMR atau UPI meminta perbaikan.'
    );

    return view(
        'risiko.edit',
        compact('risiko')
    );
}

    public function update(
        Request $request,
        Risiko $risiko
    ) {
        $this->pastikanPemilikRisiko($risiko);

        abort_unless(
    $risiko->dapatDieditOlehUpr(),
    403,
    'Data tidak dapat diperbarui karena sedang dalam proses verifikasi/reviu atau sudah disetujui.'
);

        $data = $request->validate(
            $this->validationRules($risiko)
        );

        /*
         * Snapshot lengkap sebelum perubahan.
         */
        $dataSebelum =
            $this->buatSnapshot($risiko);

        $statusSebelum =
            $risiko->status_penanganan;

        $hasilRisiko = $this->hitungRisiko(
            (int) $data['kemungkinan'],
            (int) $data['dampak']
        );

        $hasilResidual = $this->hitungRisikoResidual(
            $data['target_kemungkinan'] ?? null,
            $data['target_dampak'] ?? null
        );

        $risiko->update(array_merge(
            $data,
            [
                'besaran_risiko' =>
                    $hasilRisiko['besaran'],

                'level_risiko' =>
                    $hasilRisiko['level'],

                'warna_level' =>
                    $hasilRisiko['warna'],

                'besaran_risiko_residual' =>
                    $hasilResidual['besaran'],

                'level_risiko_residual' =>
                    $hasilResidual['level'],

                /*
                 * Setelah diubah oleh UPR,
                 * data perlu diverifikasi ulang.
                 */
                'status_verifikasi' =>
                    'Menunggu Verifikasi',

                'verifikator_id' => null,
                'tanggal_verifikasi' => null,
                'catatan_verifikasi' => null,

                'status_reviu' =>
                    'Belum Direviu',

                'pereviu_id' => null,
                'tanggal_reviu' => null,
                'catatan_perbaikan' => null,
            ]
        ));

        /*
         * Memuat ulang data terbaru dari database.
         */
        $risiko->refresh();

        /*
         * Snapshot lengkap setelah perubahan.
         */
        $dataSesudah =
            $this->buatSnapshot($risiko);

        RiwayatRisiko::create([
            'risiko_id' => $risiko->id,
            'user_id' => Auth::id(),
            'role_pengguna' => Auth::user()->role,
            'jenis_aktivitas' => 'Perbarui Risiko',

            'status_sebelum' =>
                $statusSebelum,

            'status_sesudah' =>
                $risiko->status_penanganan,

            'data_sebelum' =>
                $dataSebelum,

            'data_sesudah' =>
                $dataSesudah,

            'deskripsi' =>
                'UPR memperbarui data risiko '
                . $risiko->kode_risiko
                . ' - '
                . $risiko->nama_risiko
                . '. Data dikirim kembali '
                . 'untuk verifikasi.',
        ]);

        return redirect()
            ->route('risiko.index')
            ->with(
                'success',
                'Data Risk Register berhasil diperbarui.'
            );
    }

    public function destroy(Risiko $risiko)
    {
        $this->pastikanPemilikRisiko($risiko);

        abort_unless(
    $risiko->dapatDihapusOlehUpr(),
    403,
    'Data tidak dapat dihapus karena sedang dalam proses verifikasi/reviu atau sudah disetujui.'
);

        /*
         * Menyimpan seluruh kondisi terakhir
         * sebelum data dihapus.
         */
        $dataSebelum =
            $this->buatSnapshot($risiko);

        RiwayatRisiko::create([
            'risiko_id' => $risiko->id,
            'user_id' => Auth::id(),
            'role_pengguna' => Auth::user()->role,
            'jenis_aktivitas' => 'Hapus Risiko',

            'status_sebelum' =>
                $risiko->status_penanganan,

            'status_sesudah' =>
                'Dihapus',

            'data_sebelum' =>
                $dataSebelum,

            'data_sesudah' =>
                null,

            'deskripsi' =>
                'UPR menghapus data risiko '
                . $risiko->kode_risiko
                . ' - '
                . $risiko->nama_risiko,
        ]);

        $risiko->delete();

        return redirect()
            ->route('risiko.index')
            ->with(
                'success',
                'Data Risk Register berhasil dihapus.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Validasi Risk Register
    |--------------------------------------------------------------------------
    */

    private function validationRules(
        ?Risiko $risiko = null
    ): array {
        $kodeRisikoRule = Rule::unique(
            'risikos',
            'kode_risiko'
        );

        if ($risiko) {
            $kodeRisikoRule->ignore($risiko->id);
        }

        return [
            'sasaran' => [
                'required',
                'string',
            ],

            'kode_risiko' => [
                'required',
                'string',
                'max:50',
                $kodeRisikoRule,
            ],

            'nama_risiko' => [
                'required',
                'string',
                'max:255',
            ],

            'kategori_risiko' => [
                'required',
                Rule::in([
                    'Risiko Reputasi',
                    'Risiko Keuangan (Rupiah)',
                    'Keselamatan dan Kesehatan Kerja',
                    'Layanan',
                    'Proyek',
                    'Kinerja',
                    'Operasional',
                ]),
            ],

            'penyebab_risiko' => [
                'required',
                'string',
            ],

            'dampak_risiko' => [
                'required',
                'string',
            ],

            'deskripsi' => [
                'nullable',
                'string',
            ],

            'kontrol_eksisting' => [
                'nullable',
                'string',
            ],

            'kemungkinan' => [
                'required',
                'integer',
                'between:1,5',
            ],

            'dampak' => [
                'required',
                'integer',
                'between:1,5',
            ],

            'kuantifikasi' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'rencana_penanganan' => [
                'nullable',
                'string',
            ],

            'batas_waktu' => [
                'nullable',
                'date',
            ],

            'penanggung_jawab' => [
                'nullable',
                'string',
                'max:255',
            ],

            'target_kemungkinan' => [
                'nullable',
                'required_with:target_dampak',
                'integer',
                'between:1,5',
            ],

            'target_dampak' => [
                'nullable',
                'required_with:target_kemungkinan',
                'integer',
                'between:1,5',
            ],

            'kuantifikasi_residual' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            /*
             * Data pemantauan triwulan tetap
             * dipertahankan untuk laporan.
             */
            'proyeksi_risiko' => [
                'nullable',
                'string',
                'max:255',
            ],

            'tren_risiko' => [
                'nullable',
                Rule::in([
                    'Meningkat',
                    'Tetap',
                    'Menurun',
                ]),
            ],

            'mitigasi_terlaksana' => [
                'nullable',
                'string',
            ],

            'keterangan_pemantauan' => [
                'nullable',
                'string',
            ],

            'status_penanganan' => [
                'required',
                Rule::in([
                    'Belum Ditangani',
                    'Sedang Berjalan',
                    'Selesai',
                ]),
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Perhitungan risiko
    |--------------------------------------------------------------------------
    */

    private function hitungRisiko(
        int $kemungkinan,
        int $dampak
    ): array {
        $matriks = [
            1 => [
                1 => 1,
                2 => 3,
                3 => 7,
                4 => 14,
                5 => 16,
            ],

            2 => [
                1 => 2,
                2 => 5,
                3 => 9,
                4 => 15,
                5 => 20,
            ],

            3 => [
                1 => 4,
                2 => 8,
                3 => 13,
                4 => 18,
                5 => 22,
            ],

            4 => [
                1 => 6,
                2 => 11,
                3 => 17,
                4 => 21,
                5 => 24,
            ],

            5 => [
                1 => 10,
                2 => 12,
                3 => 19,
                4 => 23,
                5 => 25,
            ],
        ];

        $besaran =
            $matriks[$kemungkinan][$dampak];

        if ($besaran <= 6) {
            return [
                'besaran' => $besaran,
                'level' => 'Rendah',
                'warna' => 'Hijau',
            ];
        }

        if ($besaran <= 12) {
            return [
                'besaran' => $besaran,
                'level' => 'Sedang',
                'warna' => 'Kuning',
            ];
        }

        if ($besaran <= 19) {
            return [
                'besaran' => $besaran,
                'level' => 'Tinggi',
                'warna' => 'Oranye',
            ];
        }

        return [
            'besaran' => $besaran,
            'level' => 'Ekstrim',
            'warna' => 'Merah',
        ];
    }

    private function hitungRisikoResidual(
        mixed $targetKemungkinan,
        mixed $targetDampak
    ): array {
        if (
            $targetKemungkinan === null
            || $targetKemungkinan === ''
            || $targetDampak === null
            || $targetDampak === ''
        ) {
            return [
                'besaran' => null,
                'level' => null,
            ];
        }

        $hasil = $this->hitungRisiko(
            (int) $targetKemungkinan,
            (int) $targetDampak
        );

        return [
            'besaran' => $hasil['besaran'],
            'level' => $hasil['level'],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Snapshot Risk Register
    |--------------------------------------------------------------------------
    */

    private function buatSnapshot(
        Risiko $risiko
    ): array {
        /*
         * attributesToArray mengambil seluruh
         * kolom yang dimiliki model Risiko.
         *
         * Jadi kolom Risk Register, status UMR,
         * status UPI, dan kolom baru di masa depan
         * ikut tersimpan secara otomatis.
         */
        return $risiko->attributesToArray();
    }

    /*
    |--------------------------------------------------------------------------
    | Pemeriksaan hak akses UPR
    |--------------------------------------------------------------------------
    */

    private function pastikanPemilikRisiko(
        Risiko $risiko
    ): void {
        abort_if(
            $risiko->user_id !== Auth::id(),
            403,
            'Anda tidak memiliki akses '
            . 'ke data risiko ini.'
        );
    }
}