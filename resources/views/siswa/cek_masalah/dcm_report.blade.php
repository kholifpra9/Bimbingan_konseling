<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profil Individual Daftar Cek Masalah (DCM)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Header DCM -->
                    <div class="text-center mb-8 print:mb-6">
                        <h1 class="text-2xl font-bold mb-2">PROFIL INDIVIDUAL</h1>
                        <h2 class="text-xl font-semibold mb-4">DAFTAR CEK MASALAH ( DCM )</h2>
                        <p class="text-lg font-medium">SMK SILIWANGI</p>
                    </div>

                    <!-- Student Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 print:mb-6">
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <div class="space-y-2">
                                <div class="flex">
                                    <span class="font-medium w-24">No. Urut:</span>
                                    <span>{{ $cekMasalah->id }}</span>
                                </div>
                                <div class="flex">
                                    <span class="font-medium w-24">Nama:</span>
                                    <span>{{ $cekMasalah->siswa->nama }}</span>
                                </div>
                                <div class="flex">
                                    <span class="font-medium w-24">Kelas:</span>
                                    <span>{{ $cekMasalah->siswa->kelas }}</span>
                                </div>
                                <div class="flex">
                                    <span class="font-medium w-24">Jenis Kelamin:</span>
                                    <span>{{ $cekMasalah->siswa->jenis_kelamin }}</span>
                                </div>
                                <div class="flex">
                                    <span class="font-medium w-24">Tanggal Mengisi:</span>
                                    <span>{{ $cekMasalah->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Summary Stats -->
                        <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
                            <h3 class="font-semibold text-lg mb-3">Ringkasan Hasil</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span>Total Masalah:</span>
                                    <span class="font-bold">{{ $cekMasalah->total_masalah }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Persentase Keseluruhan:</span>
                                    <span class="font-bold">{{ $cekMasalah->persentase_keseluruhan }}%</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Kategori Terpilih:</span>
                                    <span class="font-bold">{{ count($cekMasalah->kategori_masalah ?? []) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DCM Table -->
                    <div class="overflow-x-auto mb-8">
                        <table class="w-full border-collapse border border-gray-300 dark:border-gray-600 text-sm">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700">
                                    <th class="border border-gray-300 dark:border-gray-600 px-3 py-2 text-left">NO</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-3 py-2 text-left">BIDANG MASALAH</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-3 py-2 text-center">NO. MASALAH</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-3 py-2 text-center">JUMLAH</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-3 py-2 text-center">MAKS</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-3 py-2 text-center">%</th>
                                    <th class="border border-gray-300 dark:border-gray-600 px-3 py-2 text-center">KATEGORI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                    $skorPerKategori = $cekMasalah->skor_per_kategori ?? [];
                                    $nomorPerKategori = $cekMasalah->nomor_masalah_per_kategori ?? [];
                                    $daftarMasalah = \App\Models\CekMasalah::getDaftarMasalahWithNumbers();
                                @endphp
                                
                                @foreach(['pribadi', 'sosial', 'belajar', 'karir'] as $kategori)
                                    @php
                                        $skor = $skorPerKategori[$kategori] ?? null;
                                        $nomor = $nomorPerKategori[$kategori] ?? [];
                                        $totalMasalahKategori = count($daftarMasalah[$kategori] ?? []);
                                        $kategoriName = strtoupper($kategori);
                                        $persentase = $skor['persentase'] ?? 0;
                                        $jumlahTerpilih = $skor['jumlah_terpilih'] ?? 0;
                                        $kategoriMasalah = $skor['kategori_masalah'] ?? 'TIDAK BERMASALAH';
                                        
                                        // Color coding
                                        $bgColor = '';
                                        if ($persentase > 50) $bgColor = 'bg-red-100 dark:bg-red-900';
                                        elseif ($persentase >= 26) $bgColor = 'bg-orange-100 dark:bg-orange-900';
                                        elseif ($persentase >= 11) $bgColor = 'bg-yellow-100 dark:bg-yellow-900';
                                        else $bgColor = 'bg-green-100 dark:bg-green-900';
                                    @endphp
                                    
                                    <tr class="{{ $bgColor }}">
                                        <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 text-center">{{ $no++ }}</td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 font-medium">{{ $kategoriName }}</td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 text-center">
                                            @if(!empty($nomor))
                                                {{ implode(', ', $nomor) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 text-center font-bold">{{ $jumlahTerpilih }}</td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 text-center">{{ $totalMasalahKategori }}</td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 text-center font-bold">{{ $persentase }}%</td>
                                        <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 text-center font-medium">{{ $kategoriMasalah }}</td>
                                    </tr>
                                @endforeach
                                
                                <!-- Total Row -->
                                <tr class="bg-gray-200 dark:bg-gray-600 font-bold">
                                    <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 text-center" colspan="3">Keseluruhan:</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 text-center">{{ $cekMasalah->total_masalah }}</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 text-center">
                                        {{ array_sum(array_map('count', $daftarMasalah)) }}
                                    </td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 text-center">{{ $cekMasalah->persentase_keseluruhan }}%</td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-3 py-2 text-center">-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Legend -->
                    <div class="mb-8 print:mb-6">
                        <h3 class="font-semibold text-lg mb-3">Keterangan:</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                            <div class="flex items-center">
                                <div class="w-4 h-4 bg-red-100 border mr-2"></div>
                                <span>>50% = BERMASALAH</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-4 h-4 bg-orange-100 border mr-2"></div>
                                <span>26%-50% = CUKUP BERMASALAH</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-4 h-4 bg-yellow-100 border mr-2"></div>
                                <span>11%-25% = AGAK BERMASALAH</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-4 h-4 bg-green-100 border mr-2"></div>
                                <span>≤10% = TIDAK BERMASALAH</span>
                            </div>
                        </div>
                    </div>

                    <!-- Chart Section -->
                    <div class="mb-8 print:mb-6">
                        <h3 class="font-semibold text-lg mb-4 text-center">Masalah Siswa Tiap Topik</h3>
                        <div class="bg-white p-4 rounded-lg border">
                            <canvas id="dcmChart" width="400" height="200"></canvas>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row justify-center items-center gap-4 pt-6 border-t print:hidden">
                        <a href="{{ route('gurubk.daftar-cek-masalah') }}" 
                           class="bg-gray-500 hover:bg-gray-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-300">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                        <button onclick="window.print()" 
                                class="bg-blue-600 hover:bg-blue-800 text-white font-semibold py-2 px-6 rounded-lg transition duration-300">
                            <i class="fas fa-print mr-2"></i>Cetak DCM
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('dcmChart').getContext('2d');
            
            // Data from PHP
            const skorData = @json($cekMasalah->skor_per_kategori ?? []);
            
            const labels = ['PRIBADI', 'SOSIAL', 'BELAJAR', 'KARIR'];
            const data = labels.map(label => {
                const key = label.toLowerCase();
                return skorData[key] ? skorData[key].persentase : 0;
            });
            
            const backgroundColors = data.map(value => {
                if (value > 50) return '#FCA5A5'; // Red
                if (value >= 26) return '#FCD34D'; // Orange  
                if (value >= 11) return '#FDE047'; // Yellow
                return '#86EFAC'; // Green
            });

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Persentase Masalah (%)',
                        data: data,
                        backgroundColor: backgroundColors,
                        borderColor: backgroundColors.map(color => color.replace('A5', '80')),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            ticks: {
                                callback: function(value) {
                                    return value + '%';
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + '%';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>

    <!-- Print Styles -->
    <style>
        @media print {
            /* Reset visibility */
            body * {
                visibility: visible !important;
            }
            
            /* Hide navigation and non-printable elements */
            nav, header, .print\:hidden {
                display: none !important;
            }
            
            /* Make content area full width */
            .max-w-7xl {
                max-width: 100% !important;
            }
            
            /* Remove dark mode styles */
            .dark\:bg-gray-800,
            .dark\:bg-gray-700,
            .dark\:bg-gray-600,
            .dark\:bg-blue-900,
            .dark\:bg-red-900,
            .dark\:bg-orange-900,
            .dark\:bg-yellow-900,
            .dark\:bg-green-900 {
                background-color: white !important;
            }
            
            .dark\:text-gray-100,
            .dark\:text-gray-200,
            .dark\:text-gray-300,
            .dark\:text-gray-400,
            .dark\:text-gray-500,
            .dark\:text-white {
                color: black !important;
            }
            
            .dark\:border-gray-600 {
                border-color: #d1d5db !important;
            }
            
            /* Ensure backgrounds print */
            .bg-gray-50 { background-color: #f9fafb !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .bg-blue-50 { background-color: #eff6ff !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .bg-gray-100 { background-color: #f3f4f6 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .bg-gray-200 { background-color: #e5e7eb !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .bg-red-100 { background-color: #fee2e2 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .bg-orange-100 { background-color: #fed7aa !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .bg-yellow-100 { background-color: #fef3c7 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .bg-green-100 { background-color: #d1fae5 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            
            /* Page setup */
            @page {
                size: A4;
                margin: 1cm;
            }
            
            /* Adjust spacing */
            .py-12 {
                padding-top: 0 !important;
                padding-bottom: 0 !important;
            }
            
            .p-6 {
                padding: 0.5rem !important;
            }
            
            /* Table adjustments */
            table {
                page-break-inside: avoid;
                width: 100% !important;
                font-size: 12px !important;
            }
            
            /* Hide chart on print - canvas doesn't print well */
            #dcmChart, canvas {
                display: none !important;
            }
            
            /* Ensure text is black */
            * {
                color: black !important;
            }
            
            /* Remove shadows and rounded corners */
            .shadow-sm {
                box-shadow: none !important;
            }
            
            .rounded-lg {
                border-radius: 0 !important;
            }
        }
        
        /* Additional print-specific class */
        @media print {
            .print-only {
                display: block !important;
            }
        }
        
        @media screen {
            .print-only {
                display: none !important;
            }
        }
    </style>
</x-app-layout>
