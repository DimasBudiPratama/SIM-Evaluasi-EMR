<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        .title-main {
            font-family: Arial, sans-serif;
            font-size: 14pt;
            font-weight: bold;
            color: #1e3a8a;
        }

        .title-sub {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            font-style: italic;
            color: #475569;
        }

        .th-pieces {
            background-color: #1e3a8a;
            color: #ffffff;
            font-weight: bold;
            text-align: center;
            border: 1px solid #cbd5e1;
        }

        .td-label {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            text-align: left;
            border: 1px solid #cbd5e1;
        }

        .td-center {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            text-align: center;
            border: 1px solid #cbd5e1;
        }

        .td-numeric {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            text-align: right;
            border: 1px solid #cbd5e1;
        }

        .td-bold-center {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            font-weight: bold;
            text-align: center;
            border: 1px solid #cbd5e1;
        }

        .bg-zebra {
            background-color: #f8fafc;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td colspan="5" class="title-main">RSU MUHAMMADIYAH METRO</td>
        </tr>
        <tr>
            <td colspan="5" class="title-sub">Laporan Hasil Evaluasi Akhir Implementasi EMR - Metode PIECES Saja</td>
        </tr>
        <tr>
            <td colspan="5" class="title-sub" style="font-weight: bold;">Ukuran Sampel Aktual N = {{ $totalResponden }}
                Responden</td>
        </tr>
        <tr></tr>
    </table>

    <table border="1" style="border-collapse: collapse;">
        <thead>
            <tr>
                <th class="th-pieces" style="width: 35px;">Kategori / Dimensi Indikator</th>
                <th class="th-pieces" style="width: 15px;">Jumlah Butir</th>
                <th class="th-pieces" style="width: 15px;">Rata-rata (Mean)</th>
                <th class="th-pieces" style="width: 18px;">Persentase Kelayakan</th>
                <th class="th-pieces" style="width: 18px;">Kriteria Nilai</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporanPieces as $index => $row)
                <tr class="{{ $index % 2 == 1 ? 'bg-zebra' : '' }}">
                    <td class="td-label">{{ $row['kategori'] }}</td>
                    <td class="td-center">{{ $row['total_butir'] }} Item</td>
                    <td class="td-numeric" style="font-weight: bold;">{{ $row['mean'] }}</td>
                    <td class="td-numeric" style="color: #15803d; font-weight: bold;">{{ $row['persentase'] }}</td>
                    <td class="td-bold-center"
                        style="color: {{ $row['interpretasi'] == 'Buruk' || $row['interpretasi'] == 'Sangat Buruk' ? '#b91c1c' : '#166534' }};">
                        {{ $row['interpretasi'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
