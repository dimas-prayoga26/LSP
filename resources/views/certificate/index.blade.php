<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Kompetensi</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('{{ public_path('sertifikat.jpg') }}');
            background-size: cover;
            background-position: center;
            color: black;
            height: 100%;
            text-align: center;
            position: relative;
        }

        .certificate-content {
            padding: 50px;
            height: 100%;
            position: relative;
            left: 2%; /* Menggeser seluruh konten sedikit ke kanan */
        }

        .title-indo {
            font-size: 18px;
            margin-top: 150px;
            margin-bottom: 0;
            color: #1f4e79; /* Warna biru sesuai gambar */
            font-weight: bold;
        }

        .title-eng {
            font-size: 16px;
            margin-top: 2px;
            color: #1f4e79; /* Warna biru sesuai gambar */
            font-style: italic;
            font-weight: bold;
        }

        .number {
            font-size: 14px;
            margin-top: 10px;
            position: relative;
            left: 50%; 
            transform: translateX(-50%);
        }

        .statement-indo {
            font-size: 14px;
            margin-top: 8px;
            margin-bottom: 0;
            position: relative;
            left: 50%;
            transform: translateX(-50%);
        }

        .statement-eng {
            font-size: 14px;
            margin-top: 2px;
            font-style: italic; /* Membuat teks miring */
            position: relative;
            left: 50%;
            transform: translateX(-50%);
        }

        .name {
            font-size: 20px;
            font-weight: bold;
            margin-top: 30px;
        }

        .noreg {
            font-size: 16px;
            margin-top: 20px;
        }

        .competence-indo {
            font-size: 14px;
            margin-top: 20px;
            margin-bottom: 0;
            position: relative;
            left: 50%;
            transform: translateX(-50%);
        }

        .competence-eng {
            font-size: 14px;
            margin-top: 2px;
            font-style: italic; /* Membuat teks miring */
            position: relative;
            left: 50%;
            transform: translateX(-50%);
        }

        .skill-indo {
            font-size: 14px;
            margin-top: 20px;
            margin-bottom: 0;
            position: relative;
            left: 50%;
            transform: translateX(-50%);
        }

        .skill-eng {
            font-size: 14px;
            margin-top: 2px;
            font-style: italic; /* Membuat teks miring */
            position: relative;
            left: 50%;
            transform: translateX(-50%);
        }

        .qualification-indo {
            font-size: 14px;
            margin-top: 20px;
            margin-bottom: 0;
            position: relative;
            left: 50%;
            transform: translateX(-50%);
        }

        .qualification-eng {
            font-size: 14px;
            margin-top: 2px;
            font-style: italic; /* Membuat teks miring */
            position: relative;
            left: 50%;
            transform: translateX(-50%);
        }

        .skill2 {
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
            position: relative;
            left: 50%;
            transform: translateX(-50%);
        }

        .validity-indo {
            font-size: 14px;
            margin-top: 8px;
            margin-bottom: 0;
            position: relative;
            left: 50%;
            transform: translateX(-50%);
        }

        .validity-eng {
            font-size: 14px;
            margin-top: 2px;
            font-style: italic; /* Membuat teks miring */
            position: relative;
            left: 50%;
            transform: translateX(-50%);
        }

        .location {
            font-size: 14px;
            margin-top: 8px;
            margin-bottom: 0; /* Menghilangkan margin bawah untuk mendekatkan dengan authority-indo */
            position: relative;
            left: 50%;
            transform: translateX(-50%);
        }

        .authority-indo {
            font-size: 14px;
            margin-top: 2px; /* Mengurangi jarak antara location dan authority-indo */
            margin-bottom: 0; /* Menghilangkan margin bawah untuk mendekatkan dengan authority-eng */
            position: relative;
            left: 50%;
            transform: translateX(-50%);
        }

        .authority-eng {
            font-size: 14px;
            margin-top: 2px;
            font-style: italic; /* Membuat teks miring */
            position: relative;
            left: 50%;
            transform: translateX(-50%);
        }

        .organization-indo {
            font-size: 14px;
            margin-top: 8px;
            margin-bottom: 0;
            position: relative;
            left: 50%;
            transform: translateX(-50%);
        }

        .organization-eng {
            font-size: 14px;
            margin-top: 2px;
            font-style: italic;
            position: relative;
            left: 50%;
            transform: translateX(-50%);
        }
    </style>
</head>
<body>
    <div class="certificate-content">
        <h1 class="title-indo">SERTIFIKAT KOMPETENSI</h1>
        <h2 class="title-eng">CERTIFICATE OF COMPETENCE</h2>
        <p class="number">No. 62090 2431 0 0081623 2024</p>
        <p class="statement-indo">Dengan ini menyatakan bahwa.</p>
        <p class="statement-eng">This is to certify that,</p>
        <p class="name">{{ $name }}</p>
        <p class="noreg">{{ $noreg }}</p>
        <p class="competence-indo">Telah kompeten pada bidang:</p>
        <p class="competence-eng">has been competence in the area of:</p>
        <p class="skill-indo">{{ $skill }}</p>
        <p class="skill-eng">{{ $skillEng }}</p>
        <p class="qualification-indo">Dengan Kualifikasi / Kompetensi:</p>
        <p class="qualification-eng">With Qualification / Competency:</p>
        <p class="skill2">{{ $skill2 }}</p>
        <p class="validity-indo">sertifikat ini berlaku untuk: 3 (tiga) tahun</p>
        <p class="validity-eng">this certificate is valid for: 3 (three) years</p>
        <p class="location">Indramayu, {{ $date }}</p>
        <p class="authority-indo">Atas Nama Badan Nasional Sertifikasi Profesi</p>
        <p class="authority-eng">On Behalf Of Indonesian Professional Certification Authority</p>
        <p class="organization-indo">Lembaga Sertifikasi Profesi Teknologi Digital</p>
        <p class="organization-eng">Professional Certification Body Technology</p>
    </div>
</body>
</html>
