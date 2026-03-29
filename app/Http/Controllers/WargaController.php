<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Services\CryptoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WargaController extends Controller
{
    protected CryptoService $crypto;

    public function __construct(CryptoService $crypto)
    {
        $this->crypto = $crypto;
    }

    public function index()
    {
        $warga = Warga::with('user')->orderBy('nama')->get();
        return view('warga.index', compact('warga'));
    }

    public function create()
    {
        return view('warga.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|size:16',
            'nama' => 'required|string|max:45',
            'tempat_lahir' => 'required|string|max:30',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
        ]);

        // Check NIK uniqueness via HMAC
        $nikHash = $this->crypto->hmacNik($request->nik);
        if (Warga::where('nik_hash', $nikHash)->exists()) {
            return back()->with('error', 'NIK sudah terdaftar')->withInput();
        }

        $warga = new Warga();
        $warga->setNikValue($request->nik);
        $warga->nama = $request->nama;
        $warga->tempat_lahir = $request->tempat_lahir;
        $warga->tanggal_lahir = $request->tanggal_lahir;
        $warga->jenis_kelamin = $request->jenis_kelamin;
        $warga->alamat_ktp = $request->alamat_ktp;
        $warga->alamat = $request->alamat;
        $warga->desa_kelurahan = $request->desa_kelurahan;
        $warga->kecamatan = $request->kecamatan;
        $warga->kabupaten_kota = $request->kabupaten_kota;
        $warga->provinsi = $request->provinsi;
        $warga->negara = $request->negara ?? 'Indonesia';
        $warga->rt = $request->rt;
        $warga->rw = $request->rw;
        $warga->agama = $request->agama;
        $warga->pendidikan_terakhir = $request->pendidikan_terakhir;
        $warga->pekerjaan = $request->pekerjaan;
        $warga->status_perkawinan = $request->status_perkawinan;
        $warga->status = $request->status ?? 'Tetap';
        $warga->user_id = auth()->id();
        $warga->updated_by = auth()->id();
        $warga->keterangan_perubahan = 'Dibuat oleh ' . auth()->user()->nama . ' (' . auth()->user()->status . ') pada ' . now()->format('d/m/Y H:i');

        // Generate SHA-256 document hash
        $warga->document_hash = $warga->generateDocumentHash();
        $warga->save();

        return redirect()->route('warga.index')->with('success', 'Data warga berhasil ditambahkan');
    }

    public function show(Warga $warga)
    {
        $isVerified = $warga->verifyDocument();
        return view('warga.show', compact('warga', 'isVerified'));
    }

    public function edit(Warga $warga)
    {
        return view('warga.edit', compact('warga'));
    }

    public function update(Request $request, Warga $warga)
    {
        $request->validate([
            'nik' => 'required|string|size:16',
            'nama' => 'required|string|max:45',
        ]);

        // Check uniqueness excluding current
        $nikHash = $this->crypto->hmacNik($request->nik);
        if (Warga::where('nik_hash', $nikHash)->where('id', '!=', $warga->id)->exists()) {
            return back()->with('error', 'NIK sudah digunakan warga lain')->withInput();
        }

        $warga->setNikValue($request->nik);
        $warga->nama = $request->nama;
        $warga->tempat_lahir = $request->tempat_lahir;
        $warga->tanggal_lahir = $request->tanggal_lahir;
        $warga->jenis_kelamin = $request->jenis_kelamin;
        $warga->alamat_ktp = $request->alamat_ktp;
        $warga->alamat = $request->alamat;
        $warga->desa_kelurahan = $request->desa_kelurahan;
        $warga->kecamatan = $request->kecamatan;
        $warga->kabupaten_kota = $request->kabupaten_kota;
        $warga->provinsi = $request->provinsi;
        $warga->negara = $request->negara ?? 'Indonesia';
        $warga->rt = $request->rt;
        $warga->rw = $request->rw;
        $warga->agama = $request->agama;
        $warga->pendidikan_terakhir = $request->pendidikan_terakhir;
        $warga->pekerjaan = $request->pekerjaan;
        $warga->status_perkawinan = $request->status_perkawinan;
        $warga->status = $request->status ?? 'Tetap';
        $warga->updated_by = auth()->id();
        $warga->keterangan_perubahan = 'Diubah oleh ' . auth()->user()->nama . ' (' . auth()->user()->status . ') pada ' . now()->format('d/m/Y H:i');
        $warga->document_hash = $warga->generateDocumentHash();
        $warga->save();

        return redirect()->route('warga.index')->with('success', 'Data warga berhasil diperbarui');
    }

    public function destroy(Warga $warga)
    {
        $warga->delete();
        return redirect()->route('warga.index')->with('success', 'Data warga berhasil dihapus');
    }

    // ═══════════════════════════════════════════════
    //  EXPORT — Download data warga as .xls (Excel)
    // ═══════════════════════════════════════════════

    public function export()
    {
        $warga = Warga::orderBy('nama')->get();

        $headers = [
            'No', 'NIK', 'Nama', 'Tempat Lahir', 'Tanggal Lahir', 'Jenis Kelamin',
            'Usia', 'Alamat KTP', 'Alamat Domisili', 'Desa/Kelurahan', 'Kecamatan',
            'Kabupaten/Kota', 'Provinsi', 'Negara', 'RT', 'RW', 'Agama',
            'Pendidikan Terakhir', 'Pekerjaan', 'Status Perkawinan', 'Status Tinggal'
        ];

        $filename = 'data_warga_' . date('Y-m-d_His') . '.xls';

        return response()->streamDownload(function () use ($warga, $headers) {
            // Use XML Spreadsheet format (native Excel-compatible)
            echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
            echo '<?mso-application progid="Excel.Sheet"?>' . "\n";
            echo '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
                    xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">' . "\n";
            echo '<Styles>';
            echo '<Style ss:ID="header"><Font ss:Bold="1" ss:Size="11" ss:Color="#FFFFFF"/><Interior ss:Color="#4F46E5" ss:Pattern="Solid"/><Alignment ss:Horizontal="Center" ss:Vertical="Center"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/></Borders></Style>';
            echo '<Style ss:ID="nik"><NumberFormat ss:Format="@"/></Style>';
            echo '<Style ss:ID="date"><NumberFormat ss:Format="yyyy-mm-dd"/></Style>';
            echo '<Style ss:ID="alt"><Interior ss:Color="#F8FAFC" ss:Pattern="Solid"/></Style>';
            echo '</Styles>';
            echo '<Worksheet ss:Name="Data Warga">';
            echo '<Table>';

            // Column widths
            $widths = [30, 120, 150, 100, 90, 60, 40, 150, 150, 100, 100, 100, 80, 70, 30, 30, 60, 80, 100, 80, 60];
            foreach ($widths as $w) {
                echo "<Column ss:Width=\"{$w}\"/>";
            }

            // Header row
            echo '<Row ss:Height="28">';
            foreach ($headers as $h) {
                echo '<Cell ss:StyleID="header"><Data ss:Type="String">' . htmlspecialchars($h) . '</Data></Cell>';
            }
            echo '</Row>';

            // Data rows
            foreach ($warga as $i => $w) {
                $style = ($i % 2 === 1) ? ' ss:StyleID="alt"' : '';
                echo "<Row{$style}>";
                echo '<Cell><Data ss:Type="Number">' . ($i + 1) . '</Data></Cell>';
                echo '<Cell ss:StyleID="nik"><Data ss:Type="String">' . htmlspecialchars($w->nik) . '</Data></Cell>';
                echo '<Cell><Data ss:Type="String">' . htmlspecialchars($w->nama) . '</Data></Cell>';
                echo '<Cell><Data ss:Type="String">' . htmlspecialchars($w->tempat_lahir ?? '') . '</Data></Cell>';
                echo '<Cell ss:StyleID="date"><Data ss:Type="String">' . ($w->tanggal_lahir ?? '') . '</Data></Cell>';
                echo '<Cell><Data ss:Type="String">' . htmlspecialchars($w->jenis_kelamin ?? '') . '</Data></Cell>';
                echo '<Cell><Data ss:Type="Number">' . (is_numeric($w->usia) ? $w->usia : 0) . '</Data></Cell>';
                echo '<Cell><Data ss:Type="String">' . htmlspecialchars($w->alamat_ktp ?? '') . '</Data></Cell>';
                echo '<Cell><Data ss:Type="String">' . htmlspecialchars($w->alamat ?? '') . '</Data></Cell>';
                echo '<Cell><Data ss:Type="String">' . htmlspecialchars($w->desa_kelurahan ?? '') . '</Data></Cell>';
                echo '<Cell><Data ss:Type="String">' . htmlspecialchars($w->kecamatan ?? '') . '</Data></Cell>';
                echo '<Cell><Data ss:Type="String">' . htmlspecialchars($w->kabupaten_kota ?? '') . '</Data></Cell>';
                echo '<Cell><Data ss:Type="String">' . htmlspecialchars($w->provinsi ?? '') . '</Data></Cell>';
                echo '<Cell><Data ss:Type="String">' . htmlspecialchars($w->negara ?? 'Indonesia') . '</Data></Cell>';
                echo '<Cell><Data ss:Type="String">' . htmlspecialchars($w->rt ?? '') . '</Data></Cell>';
                echo '<Cell><Data ss:Type="String">' . htmlspecialchars($w->rw ?? '') . '</Data></Cell>';
                echo '<Cell><Data ss:Type="String">' . htmlspecialchars($w->agama ?? '') . '</Data></Cell>';
                echo '<Cell><Data ss:Type="String">' . htmlspecialchars($w->pendidikan_terakhir ?? '') . '</Data></Cell>';
                echo '<Cell><Data ss:Type="String">' . htmlspecialchars($w->pekerjaan ?? '') . '</Data></Cell>';
                echo '<Cell><Data ss:Type="String">' . htmlspecialchars($w->status_perkawinan ?? '') . '</Data></Cell>';
                echo '<Cell><Data ss:Type="String">' . htmlspecialchars($w->status ?? '') . '</Data></Cell>';
                echo '</Row>';
            }

            echo '</Table></Worksheet></Workbook>';
        }, $filename, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    // ═══════════════════════════════════
    //  TEMPLATE — Download import template
    // ═══════════════════════════════════

    public function downloadTemplate()
    {
        $headers = [
            'NIK', 'Nama', 'Tempat Lahir', 'Tanggal Lahir', 'Jenis Kelamin',
            'Alamat KTP', 'Alamat Domisili', 'Desa/Kelurahan', 'Kecamatan',
            'Kabupaten/Kota', 'Provinsi', 'Negara', 'RT', 'RW', 'Agama',
            'Pendidikan Terakhir', 'Pekerjaan', 'Status Perkawinan', 'Status Tinggal'
        ];

        $notes = [
            '16 digit angka', 'Nama lengkap', 'Contoh: Jakarta', 'Format: YYYY-MM-DD', 'L / P',
            'Alamat sesuai KTP', 'Alamat tinggal saat ini', '', '', '', '', 'Indonesia', '', '',
            'Islam/Kristen/Katholik/Hindu/Budha/Konghucu',
            'SD/SMP/SMA/D1/D2/D3/S1/S2/S3', '', 'Kawin/Tidak Kawin', 'Tetap/Kontrak'
        ];

        $example = [
            '3201234567890001', 'Budi Santoso', 'Jakarta', '1990-05-15', 'L',
            'Jl. Merdeka No. 1', 'Jl. Merdeka No. 1', 'Sukamaju', 'Pasar Minggu',
            'Jakarta Selatan', 'DKI Jakarta', 'Indonesia', '001', '005', 'Islam',
            'S1', 'PNS', 'Kawin', 'Tetap'
        ];

        $filename = 'template_import_warga.xls';

        return response()->streamDownload(function () use ($headers, $notes, $example) {
            echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
            echo '<?mso-application progid="Excel.Sheet"?>' . "\n";
            echo '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
                    xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">' . "\n";
            echo '<Styles>';
            echo '<Style ss:ID="header"><Font ss:Bold="1" ss:Size="11" ss:Color="#FFFFFF"/><Interior ss:Color="#4F46E5" ss:Pattern="Solid"/><Alignment ss:Horizontal="Center"/></Style>';
            echo '<Style ss:ID="note"><Font ss:Italic="1" ss:Size="9" ss:Color="#64748B"/><Interior ss:Color="#F1F5F9" ss:Pattern="Solid"/></Style>';
            echo '<Style ss:ID="example"><Font ss:Size="10"/><Interior ss:Color="#ECFDF5" ss:Pattern="Solid"/></Style>';
            echo '<Style ss:ID="nik"><NumberFormat ss:Format="@"/></Style>';
            echo '</Styles>';
            echo '<Worksheet ss:Name="Template Import">';
            echo '<Table>';

            // Column widths
            $widths = [120, 150, 100, 100, 60, 150, 150, 100, 100, 100, 80, 70, 30, 30, 80, 80, 100, 80, 60];
            foreach ($widths as $w) {
                echo "<Column ss:Width=\"{$w}\"/>";
            }

            // Header row
            echo '<Row ss:Height="26">';
            foreach ($headers as $h) {
                echo '<Cell ss:StyleID="header"><Data ss:Type="String">' . htmlspecialchars($h) . '</Data></Cell>';
            }
            echo '</Row>';

            // Notes row (format instructions)
            echo '<Row>';
            foreach ($notes as $n) {
                echo '<Cell ss:StyleID="note"><Data ss:Type="String">' . htmlspecialchars($n) . '</Data></Cell>';
            }
            echo '</Row>';

            // Example row
            echo '<Row>';
            foreach ($example as $j => $e) {
                $st = ($j === 0) ? ' ss:StyleID="nik"' : ' ss:StyleID="example"';
                echo "<Cell{$st}><Data ss:Type=\"String\">" . htmlspecialchars($e) . '</Data></Cell>';
            }
            echo '</Row>';

            echo '</Table></Worksheet></Workbook>';
        }, $filename, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    // ═══════════════════════════════════
    //  IMPORT — Upload & process Excel/CSV
    // ═══════════════════════════════════

    public function importForm()
    {
        return view('warga.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xls,xlsx|max:5120',
        ]);

        $file = $request->file('file');
        $ext = strtolower($file->getClientOriginalExtension());

        try {
            $rows = [];

            if ($ext === 'csv' || $ext === 'txt') {
                $rows = $this->parseCsv($file->getPathname());
            } elseif ($ext === 'xls' || $ext === 'xlsx') {
                // Try to parse as XML Spreadsheet first (our template format)
                $content = file_get_contents($file->getPathname());
                if (str_contains($content, 'urn:schemas-microsoft-com:office:spreadsheet')) {
                    $rows = $this->parseXmlSpreadsheet($content);
                } else {
                    // Fallback: try CSV-style tab-delimited parsing
                    $rows = $this->parseCsv($file->getPathname(), "\t");
                }
            }

            if (empty($rows)) {
                return back()->with('error', 'File kosong atau format tidak dikenali. Gunakan template yang disediakan.');
            }

            $success = 0;
            $skipped = 0;
            $errors = [];

            DB::beginTransaction();

            foreach ($rows as $i => $row) {
                $rowNum = $i + 1;

                // Minimum: NIK and Nama required
                $nik = trim($row['nik'] ?? $row[0] ?? '');
                $nama = trim($row['nama'] ?? $row[1] ?? '');

                if (strlen($nik) !== 16 || empty($nama)) {
                    $skipped++;
                    $errors[] = "Baris {$rowNum}: NIK '{$nik}' bukan 16 digit atau Nama kosong — dilewati";
                    continue;
                }

                // Check if NIK already exists
                $nikHash = $this->crypto->hmacNik($nik);
                if (Warga::where('nik_hash', $nikHash)->exists()) {
                    $skipped++;
                    $errors[] = "Baris {$rowNum}: NIK {$nik} ({$nama}) sudah terdaftar — dilewati";
                    continue;
                }

                $warga = new Warga();
                $warga->setNikValue($nik);
                $warga->nama = $nama;
                $warga->tempat_lahir = trim($row['tempat_lahir'] ?? $row[2] ?? '');
                $warga->tanggal_lahir = $this->parseDate(trim($row['tanggal_lahir'] ?? $row[3] ?? ''));
                $warga->jenis_kelamin = strtoupper(trim($row['jenis_kelamin'] ?? $row[4] ?? 'L'));
                $warga->alamat_ktp = trim($row['alamat_ktp'] ?? $row[5] ?? '');
                $warga->alamat = trim($row['alamat'] ?? $row[6] ?? '');
                $warga->desa_kelurahan = trim($row['desa_kelurahan'] ?? $row[7] ?? '');
                $warga->kecamatan = trim($row['kecamatan'] ?? $row[8] ?? '');
                $warga->kabupaten_kota = trim($row['kabupaten_kota'] ?? $row[9] ?? '');
                $warga->provinsi = trim($row['provinsi'] ?? $row[10] ?? '');
                $warga->negara = trim($row['negara'] ?? $row[11] ?? 'Indonesia') ?: 'Indonesia';
                $warga->rt = trim($row['rt'] ?? $row[12] ?? '');
                $warga->rw = trim($row['rw'] ?? $row[13] ?? '');
                $warga->agama = trim($row['agama'] ?? $row[14] ?? '');
                $warga->pendidikan_terakhir = trim($row['pendidikan_terakhir'] ?? $row[15] ?? '');
                $warga->pekerjaan = trim($row['pekerjaan'] ?? $row[16] ?? '');
                $warga->status_perkawinan = trim($row['status_perkawinan'] ?? $row[17] ?? '');
                $warga->status = trim($row['status'] ?? $row[18] ?? 'Tetap') ?: 'Tetap';
                $warga->user_id = auth()->id();
                $warga->document_hash = $warga->generateDocumentHash();
                $warga->save();
                $success++;
            }

            DB::commit();

            $msg = "{$success} data warga berhasil diimport.";
            if ($skipped > 0) {
                $msg .= " {$skipped} baris dilewati.";
            }

            return redirect()->route('warga.index')
                ->with('success', $msg)
                ->with('import_errors', $errors);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    // ─── CSV Parser ───
    private function parseCsv(string $path, string $delimiter = ','): array
    {
        $rows = [];
        if (($handle = fopen($path, 'r')) !== false) {
            $headerRow = fgetcsv($handle, 0, $delimiter);
            if (!$headerRow) {
                fclose($handle);
                return [];
            }

            // Normalize header keys
            $keys = $this->normalizeHeaders($headerRow);

            while (($data = fgetcsv($handle, 0, $delimiter)) !== false) {
                if (count($data) < 2) continue; // Skip empty rows

                $row = [];
                foreach ($data as $j => $val) {
                    $key = $keys[$j] ?? $j;
                    $row[$key] = $val;
                    $row[$j] = $val; // also numeric fallback
                }
                $rows[] = $row;
            }
            fclose($handle);
        }
        return $rows;
    }

    // ─── XML Spreadsheet Parser ───
    private function parseXmlSpreadsheet(string $content): array
    {
        $rows = [];
        // Suppress warnings for imperfect XML
        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($content);
        if (!$xml) return [];

        $ns = $xml->getNamespaces(true);
        $ssNs = $ns['ss'] ?? 'urn:schemas-microsoft-com:office:spreadsheet';

        $worksheets = $xml->children($ssNs)->Worksheet ?? $xml->Worksheet;
        if (!$worksheets) return [];

        $worksheet = $worksheets[0] ?? $worksheets;
        $table = $worksheet->children($ssNs)->Table ?? $worksheet->Table;
        if (!$table) return [];

        $allRows = $table->children($ssNs)->Row ?? $table->Row;
        if (!$allRows || count($allRows) === 0) return [];

        // First row = headers
        $headerCells = $allRows[0]->children($ssNs)->Cell ?? $allRows[0]->Cell;
        $keys = [];
        foreach ($headerCells as $cell) {
            $data = $cell->children($ssNs)->Data ?? $cell->Data;
            $keys[] = (string) $data;
        }
        $keys = $this->normalizeHeaders($keys);

        // Process data rows (skip row 0 header, skip row 1 if it's notes)
        $startRow = 1;
        // Check if row 1 is a notes/instruction row
        if (isset($allRows[1])) {
            $firstCell = $allRows[1]->children($ssNs)->Cell ?? $allRows[1]->Cell;
            if ($firstCell && isset($firstCell[0])) {
                $firstData = $firstCell[0]->children($ssNs)->Data ?? $firstCell[0]->Data;
                $firstVal = trim((string) $firstData);
                // If first cell starts with common note patterns, skip
                if (preg_match('/^(16 digit|contoh|format|catatan|note)/i', $firstVal)) {
                    $startRow = 2;
                }
            }
        }

        for ($r = $startRow; $r < count($allRows); $r++) {
            $cells = $allRows[$r]->children($ssNs)->Cell ?? $allRows[$r]->Cell;
            $row = [];
            $ci = 0;
            foreach ($cells as $cell) {
                // Check for ss:Index attribute (skipped cells)
                $attrs = $cell->attributes($ssNs);
                if (isset($attrs['Index'])) {
                    $ci = (int) $attrs['Index'] - 1;
                }
                $data = $cell->children($ssNs)->Data ?? $cell->Data;
                $val = trim((string) $data);
                $key = $keys[$ci] ?? $ci;
                $row[$key] = $val;
                $row[$ci] = $val;
                $ci++;
            }
            if (!empty(array_filter($row, fn($v) => $v !== ''))) {
                $rows[] = $row;
            }
        }

        return $rows;
    }

    // ─── Normalize headers to consistent keys ───
    private function normalizeHeaders(array $headers): array
    {
        $map = [
            'nik' => 'nik', 'no. nik' => 'nik', 'no nik' => 'nik',
            'nama' => 'nama', 'nama lengkap' => 'nama', 'nama warga' => 'nama',
            'tempat lahir' => 'tempat_lahir', 'tempat_lahir' => 'tempat_lahir',
            'tanggal lahir' => 'tanggal_lahir', 'tgl lahir' => 'tanggal_lahir', 'tanggal_lahir' => 'tanggal_lahir',
            'jenis kelamin' => 'jenis_kelamin', 'l/p' => 'jenis_kelamin', 'gender' => 'jenis_kelamin', 'jk' => 'jenis_kelamin', 'jenis_kelamin' => 'jenis_kelamin',
            'alamat ktp' => 'alamat_ktp', 'alamat_ktp' => 'alamat_ktp',
            'alamat domisili' => 'alamat', 'alamat' => 'alamat',
            'desa' => 'desa_kelurahan', 'kelurahan' => 'desa_kelurahan', 'desa/kelurahan' => 'desa_kelurahan', 'desa_kelurahan' => 'desa_kelurahan',
            'kecamatan' => 'kecamatan', 'kec' => 'kecamatan',
            'kabupaten' => 'kabupaten_kota', 'kota' => 'kabupaten_kota', 'kabupaten/kota' => 'kabupaten_kota', 'kabupaten_kota' => 'kabupaten_kota',
            'provinsi' => 'provinsi', 'prov' => 'provinsi',
            'negara' => 'negara',
            'rt' => 'rt', 'rw' => 'rw',
            'agama' => 'agama',
            'pendidikan' => 'pendidikan_terakhir', 'pendidikan terakhir' => 'pendidikan_terakhir', 'pendidikan_terakhir' => 'pendidikan_terakhir',
            'pekerjaan' => 'pekerjaan', 'kerja' => 'pekerjaan',
            'status perkawinan' => 'status_perkawinan', 'status_perkawinan' => 'status_perkawinan', 'kawin' => 'status_perkawinan',
            'status tinggal' => 'status', 'status' => 'status', 'status_tinggal' => 'status',
        ];

        return array_map(function ($h) use ($map) {
            $key = strtolower(trim($h));
            return $map[$key] ?? $key;
        }, $headers);
    }

    // ─── Parse date from various formats ───
    private function parseDate(string $val): ?string
    {
        if (empty($val)) return null;
        // Try standard Y-m-d
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $val)) return $val;
        // Try d-m-Y or d/m/Y
        if (preg_match('#^(\d{1,2})[/-](\d{1,2})[/-](\d{4})$#', $val, $m)) {
            return "{$m[3]}-{$m[2]}-{$m[1]}";
        }
        // Fallback
        try {
            return \Carbon\Carbon::parse($val)->format('Y-m-d');
        } catch (\Exception) {
            return null;
        }
    }
}
