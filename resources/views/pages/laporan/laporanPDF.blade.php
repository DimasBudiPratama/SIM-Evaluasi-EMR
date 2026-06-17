<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan_Hasil_Evaluasi_EMR</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #1e293b;
            margin: 0;
            padding: 0;
            font-size: 10pt;
            line-height: 1.5;
        }

        .kop-surat {
            border-bottom: 3px double #000000;
            padding-bottom: 8px;
            margin-bottom: 20px;
            text-align: center;
        }

        .kop-surat h2 {
            margin: 0;
            font-size: 15pt;
            color: #1e3a8a;
        }

        .kop-surat h3 {
            margin: 3px 0;
            font-size: 11pt;
            color: #334155;
        }

        .kop-surat p {
            margin: 0;
            font-size: 8.5pt;
            color: #64748b;
        }

        .title-dokumen {
            text-align: center;
            margin-bottom: 25px;
        }

        .title-dokumen h4 {
            margin: 0;
            font-size: 12pt;
            text-transform: uppercase;
            font-weight: bold;
        }

        .title-dokumen p {
            margin: 4px 0 0 0;
            font-size: 9.5pt;
            color: #475569;
        }

        .section-title {
            font-size: 10.5pt;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            text-transform: uppercase;
            border-left: 4px solid #1e3a8a;
            padding-left: 6px;
        }

        table.table-cetak {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table.table-cetak th {
            background-color: #f8fafc;
            color: #475569;
            font-weight: bold;
            padding: 8px 10px;
            border: 1px solid #cbd5e1;
            text-transform: uppercase;
            font-size: 8.5pt;
            text-align: left;
        }

        table.table-cetak td {
            padding: 8px 10px;
            border: 1px solid #cbd5e1;
        }

        table.table-cetak tr:nth-child(even) {
            background-color: #fdfdfd;
        }

        .text-center {
            text-align: center;
        }

        .text-bold {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="kop-surat">
        <h2>RSU Muhammadiyah Metro</h2>
        <p>Jl. Soekarno Hatta No. 42 Mulyojati 16B, Kota Metro, Lampung • Telp: (0725) 47431</p>
    </div>

    <div class="title-dokumen">
        <h4>SIM-Evaluasi EMR RSU Muhammadiyah Metro</h4>
        <p>Data Hasil Analisis Kapabilitas Kuesioner Sistem • Ukuran Sampel Aktual N = {{ $totalResponden }}</p>
    </div>

    @if (isset($laporanPieces))
        <div class="section-title">1. Rekapitulasi Indikator Metode PIECES</div>
        <table class="table-cetak">
            <thead>
                <tr>
                    <th>Kategori / Dimensi Indikator</th>
                    <th class="text-center" style="width: 15%">Jumlah Butir</th>
                    <th class="text-center" style="width: 18%">Rata-rata (Mean)</th>
                    <th class="text-center" style="width: 20%">Persentase Kelayakan</th>
                    <th class="text-center" style="width: 18%">Kriteria Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporanPieces as $row)
                    <tr>
                        <td class="text-bold" style="color: #475569;">{{ $row['kategori'] }}</td>
                        <td class="text-center">{{ $row['total_butir'] }} Item</td>
                        <td class="text-center text-bold" style="color:#1d4ed8;">{{ number_format($row['mean'], 2) }}
                        </td>
                        <td class="text-center" style="color:#15803d;">{{ $row['persentase'] }}%</td>
                        <td class="text-center text-bold">{{ $row['interpretasi'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if (isset($laporanTam))
        <div class="section-title" style="border-left-color: #0f766e;">2. Rekapitulasi Indikator Metode TAM</div>
        <table class="table-cetak">
            <thead>
                <tr>
                    <th>Kategori / Dimensi Indikator</th>
                    <th class="text-center" style="width: 15%">Jumlah Butir</th>
                    <th class="text-center" style="width: 18%">Rata-rata (Mean)</th>
                    <th class="text-center" style="width: 20%">Persentase Kelayakan</th>
                    <th class="text-center" style="width: 18%">Kriteria Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporanTam as $row)
                    <tr>
                        <td class="text-bold" style="color: #475569;">{{ $row['kategori'] }}</td>
                        <td class="text-center">{{ $row['total_butir'] }} Item</td>
                        <td class="text-center text-bold" style="color:#1d4ed8;">{{ number_format($row['mean'], 2) }}
                        </td>
                        <td class="text-center" style="color:#15803d;">{{ $row['persentase'] }}%</td>
                        <td class="text-center text-bold">{{ $row['interpretasi'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>

</html>
