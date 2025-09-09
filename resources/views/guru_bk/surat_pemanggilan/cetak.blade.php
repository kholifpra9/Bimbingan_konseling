<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Pemanggilan Orang Tua - {{ $cekMasalah->siswa->nama }}</title>
    <style>
        @page {
            size: A4;
            margin: 2cm;
        }
        
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.6;
            color: #000;
            margin: 0;
            padding: 0;
        }
        
        .kop-surat {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        
        .kop-surat .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }
        
        .kop-surat img {
            width: 80px;
            height: 80px;
            margin-right: 20px;
        }
        
        .kop-surat .text-container {
            text-align: center;
        }
        
        .kop-surat h1 {
            font-size: 16pt;
            margin: 0;
            font-weight: bold;
            line-height: 1.2;
        }
        
        .kop-surat h2 {
            font-size: 18pt;
            margin: 5px 0;
            font-weight: bold;
            color: #1a365d;
        }
        
        .kop-surat p {
            margin: 2px 0;
            font-size: 11pt;
        }
        
        .nomor-surat {
            text-align: center;
            margin: 20px 0;
        }
        
        .nomor-surat p {
            margin: 2px 0;
        }
        
        .isi-surat {
            text-align: justify;
            margin: 20px 0;
        }
        
        .isi-surat p {
            margin: 10px 0;
            text-indent: 40px;
        }
        
        .data-siswa {
            margin: 20px 0 20px 40px;
        }
        
        .data-siswa table {
            border-collapse: collapse;
        }
        
        .data-siswa td {
            padding: 3px 10px;
        }
        
        .data-siswa td:first-child {
            width: 150px;
        }
        
        .ttd-container {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }
        
        .ttd-box {
            text-align: center;
            width: 45%;
        }
        
        .ttd-box.kiri {
            text-align: left;
            margin-left: 40px;
        }
        
        .ttd-box.kanan {
            text-align: center;
            margin-right: 40px;
        }
        
        .ttd-nama {
            margin-top: 80px;
            font-weight: bold;
            text-decoration: underline;
        }
        
        .ttd-nip {
            font-size: 11pt;
        }
        
        .lampiran {
            margin-top: 30px;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }
        
        .lampiran h3 {
            margin-top: 0;
            font-size: 14pt;
            text-align: center;
        }
        
        .lampiran ul {
            margin: 10px 0;
            padding-left: 20px;
        }
        
        .lampiran li {
            margin: 5px 0;
        }
        
        @media print {
            body {
                margin: 0;
            }
            
            .no-print {
                display: none;
            }
            
            .lampiran {
                page-break-before: always;
            }
        }
        
        .btn-print {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        .btn-print:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <button class="btn-print no-print" onclick="window.print()">
        <i class="fas fa-print"></i> Cetak Surat
    </button>

    <!-- KOP SURAT -->
    <div class="kop-surat">
        <div class="logo-container">
            <img src="/img/Logo smk.png" alt="Logo Sekolah">
            <div class="text-container">
                <h1>PEMERINTAH PROVINSI JAWA BARAT</h1>
                <h1>DINAS PENDIDIKAN</h1>
                <h2>{{ strtoupper($dataSekolah['nama']) }}</h2>
                <p>{{ $dataSekolah['alamat'] }}</p>
                <p>Telp. {{ $dataSekolah['telepon'] }} | Email: {{ $dataSekolah['email'] }} | Website: {{ $dataSekolah['website'] }}</p>
            </div>
        </div>
    </div>

    <!-- NOMOR SURAT -->
    <div class="nomor-surat">
        <p><strong><u>SURAT PEMANGGILAN ORANG TUA/WALI MURID</u></strong></p>
        <p>Nomor: 421.5/{{ str_pad($cekMasalah->id, 3, '0', STR_PAD_LEFT) }}/BK/{{ date('Y') }}</p>
    </div>

    <!-- ISI SURAT -->
    <div class="isi-surat">
        <p style="text-indent: 0;">Kepada Yth.</p>
        <p style="text-indent: 0;"><strong>Bapak/Ibu Orang Tua/Wali Murid dari:</strong></p>
        
        <div class="data-siswa">
            <table>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td><strong>{{ $cekMasalah->siswa->nama }}</strong></td>
                </tr>
                <tr>
                    <td>NIS</td>
                    <td>:</td>
                    <td>{{ $cekMasalah->siswa->nis }}</td>
                </tr>
                <tr>
                    <td>Kelas</td>
                    <td>:</td>
                    <td>{{ $cekMasalah->siswa->kelas }}</td>
                </tr>
                <tr>
                    <td>Jurusan</td>
                    <td>:</td>
                    <td>{{ $cekMasalah->siswa->jurusan }}</td>
                </tr>
            </table>
        </div>

        <p style="text-indent: 0;">di tempat</p>

        <p><em>Assalamu'alaikum Warahmatullahi Wabarakatuh</em></p>

        <p>Dengan hormat,</p>
        
        <p>Sehubungan dengan hasil pemantauan dan evaluasi yang dilakukan oleh Tim Bimbingan dan Konseling {{ $dataSekolah['nama'] }}, 
        kami menemukan beberapa hal yang perlu mendapat perhatian khusus terkait dengan perkembangan putra/putri Bapak/Ibu di sekolah.</p>

        <p>Berdasarkan hasil analisis Daftar Cek Masalah (DCM) yang telah diisi oleh siswa yang bersangkutan pada tanggal 
        {{ $cekMasalah->created_at->format('d F Y') }}, ditemukan bahwa siswa tersebut mengalami beberapa permasalahan dalam kategori 
        <strong>{{ $cekMasalah->kategori_masalah_string }}</strong> dengan tingkat urgensi <strong>{{ strtoupper($cekMasalah->tingkat_urgensi) }}</strong> 
        yang memerlukan penanganan segera melalui kerjasama antara pihak sekolah dan orang tua.</p>

        <p>Untuk itu, kami mengharapkan kehadiran Bapak/Ibu pada:</p>
        
        <div class="data-siswa">
            <table>
                <tr>
                    <td><strong>Hari/Tanggal</strong></td>
                    <td>:</td>
                    <td>{{ \Carbon\Carbon::now()->addDays(3)->locale('id')->isoFormat('dddd, D MMMM Y') }}</td>
                </tr>
                <tr>
                    <td><strong>Waktu</strong></td>
                    <td>:</td>
                    <td>09.00 WIB s.d. selesai</td>
                </tr>
                <tr>
                    <td><strong>Tempat</strong></td>
                    <td>:</td>
                    <td>Ruang Bimbingan dan Konseling</td>
                </tr>
                <tr>
                    <td><strong>Keperluan</strong></td>
                    <td>:</td>
                    <td>Konsultasi mengenai perkembangan siswa</td>
                </tr>
            </table>
        </div>

        <p>Kehadiran Bapak/Ibu sangat kami harapkan demi kelancaran proses pendidikan dan tercapainya perkembangan optimal 
        putra/putri Bapak/Ibu. Apabila berhalangan hadir pada waktu yang telah ditentukan, dimohon untuk menghubungi 
        pihak sekolah melalui nomor telepon {{ $dataSekolah['telepon'] }}.</p>

        <p>Demikian surat pemanggilan ini kami sampaikan. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.</p>

        <p><em>Wassalamu'alaikum Warahmatullahi Wabarakatuh</em></p>
    </div>

    <!-- TANDA TANGAN -->
    <div class="ttd-container">
        <div class="ttd-box kiri">
            <p>Mengetahui,<br>Kepala Sekolah</p>
            <p class="ttd-nama">{{ $dataSekolah['kepala_sekolah'] }}</p>
            <p class="ttd-nip">NIP. 196501011990031001</p>
        </div>
        <div class="ttd-box kanan">
            <p>{{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}<br>Guru Bimbingan Konseling</p>
            <p class="ttd-nama">{{ $dataSekolah['guru_bk'] }}</p>
            <p class="ttd-nip">NIP. 198001012005012001</p>
        </div>
    </div>

    <!-- LAMPIRAN HASIL ANALISIS -->
    <div class="lampiran">
        <h3>LAMPIRAN: RINGKASAN HASIL ANALISIS MASALAH</h3>
        
        <p><strong>Kategori Masalah:</strong> {{ $cekMasalah->kategori_masalah_string }}</p>
        
        <p><strong>Masalah yang Teridentifikasi:</strong></p>
        <ul>
            @foreach($cekMasalah->masalah_terpilih as $masalah)
                <li>{{ $masalah }}</li>
            @endforeach
            @if($cekMasalah->masalah_lain)
                <li>{{ $cekMasalah->masalah_lain }}</li>
            @endif
        </ul>
        
        @if($cekMasalah->deskripsi_tambahan)
        <p><strong>Deskripsi Tambahan dari Siswa:</strong></p>
        <p style="margin-left: 20px; font-style: italic;">{{ $cekMasalah->deskripsi_tambahan }}</p>
        @endif
        
        @if($cekMasalah->catatan_guru)
        <p><strong>Catatan Guru BK:</strong></p>
        <p style="margin-left: 20px;">{{ $cekMasalah->catatan_guru }}</p>
        @endif
        
        <p style="margin-top: 20px; font-size: 11pt; font-style: italic;">
            <strong>Catatan:</strong> Informasi ini bersifat rahasia dan hanya untuk kepentingan pembinaan siswa. 
            Mohon untuk tidak disebarluaskan kepada pihak yang tidak berkepentingan.
        </p>
    </div>

    <script>
        // Auto print when page loads (optional)
        // window.onload = function() {
        //     window.print();
        // }
    </script>
</body>
</html>
