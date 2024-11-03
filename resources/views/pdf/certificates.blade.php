<!DOCTYPE html>
<html>
<head>
    <title>Data Asesi Yang Kompeten</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Data Asesi Yang Kompeten</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Asesi</th>
                <th>Nama Event</th>
                <th>Skema</th>
                <th>Tanggal Validasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($certificates as $certificate)
                <tr>
                    <td>{{ $loop->iteration }}</td> <!-- Penomoran otomatis -->
                    <td>{{ $certificate->asesi->user->name }}</td>
                    <td>{{ $certificate->kelompokAsesor->event->nama_event }}</td>
                    <td>{{ $certificate->kelompokAsesor->skema->judul_skema }}</td>
                    <td>{{ $certificate->asesi->valid_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
