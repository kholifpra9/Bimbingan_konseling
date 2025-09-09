<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Red Header Section -->
        <div class="bg-red-800 text-white py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-2xl font-bold">CURHAT RAHASIA</h1>
            </div>
        </div>

        <!-- Main Content -->
        <div class="py-8">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Information Section -->
                <div class="mb-8">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 p-6 rounded-r-lg shadow-sm">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-blue-500 text-xl mt-1"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">Layanan Curhat Rahasia</h3>
                                <div class="space-y-2 text-gray-700">
                                    <p class="flex items-start">
                                        <i class="fas fa-shield-alt text-green-500 mt-1 mr-2 flex-shrink-0"></i>
                                        <span>Ceritakan masalah atau keluh kesah dengan aman dan terjamin kerahasiaannya</span>
                                    </p>
                                    <p class="flex items-start">
                                        <i class="fas fa-user-graduate text-blue-500 mt-1 mr-2 flex-shrink-0"></i>
                                        <span>Guru BK akan membaca dan merespon dengan penuh perhatian</span>
                                    </p>
                                    <p class="flex items-start">
                                        <i class="fas fa-lock text-red-500 mt-1 mr-2 flex-shrink-0"></i>
                                        <span>Semua informasi dijaga kerahasiaannya dan hanya dapat diakses oleh Guru BK</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chat Input Form -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 py-3 border-b border-gray-200">
                        <h4 class="text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-comment-dots text-blue-500 mr-2"></i>
                            Tulis Curhatmu
                        </h4>
                    </div>
                    
                    <form action="{{ route('konsultasi.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                        @csrf
                        
                        <!-- Text Input Area -->
                        <div class="mb-4">
                            <textarea 
                                id="isi_curhat" 
                                name="isi_curhat" 
                                rows="4" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg resize-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                                placeholder="Ketik ceritamu di sini... Jangan ragu untuk berbagi apa yang ada di hatimu."
                                required
                                style="min-height: 100px;"
                            ></textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('isi_curhat')" />
                        </div>
                        
                        <!-- File Upload and Send Button Section -->
                        <div class="flex items-center justify-between bg-gray-50 rounded-lg p-4">
                            <!-- File Upload Section -->
                            <div class="flex items-center space-x-3">
                                <label for="attachment" class="cursor-pointer inline-flex items-center px-4 py-3 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm">
                                    <i class="fas fa-paperclip text-gray-500 mr-2"></i>
                                    Lampirkan File
                                </label>
                                <input type="file" id="attachment" name="attachment" class="hidden" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                <span class="text-xs text-gray-500">JPG, PNG, PDF, DOC (Max: 5MB)</span>
                            </div>
                            
                            <!-- Send Button -->
                            <button 
                                type="submit" 
                                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1 focus:outline-none focus:ring-4 focus:ring-blue-300"
                            >
                                <i class="fas fa-paper-plane mr-3 text-lg"></i>
                                Kirim Curhat
                            </button>
                        </div>
                        
                        <!-- File Preview Area -->
                        <div id="file-preview" class="mt-4 hidden">
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2 text-sm text-blue-700">
                                        <i class="fas fa-file text-blue-500"></i>
                                        <span id="file-name" class="font-medium"></span>
                                    </div>
                                    <button type="button" onclick="removeFile()" class="text-red-500 hover:text-red-700 transition-colors duration-200">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for file handling -->
    <script>
        document.getElementById('attachment').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('file-preview');
            const fileName = document.getElementById('file-name');
            
            if (file) {
                fileName.textContent = file.name;
                preview.classList.remove('hidden');
            } else {
                preview.classList.add('hidden');
            }
        });
        
        function removeFile() {
            document.getElementById('attachment').value = '';
            document.getElementById('file-preview').classList.add('hidden');
        }
    </script>

    <!-- SweetAlert for notifications -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
        });

        @if(session('alert-type'))
            var type = "{{ Session::get('alert-type') }}";
            switch (type) {
                case 'success':
                    Toast.fire({
                        icon: 'success',
                        title: "{{ Session::get('message') }}"
                    });
                    break;
                case 'error':
                    Toast.fire({
                        icon: 'error',
                        title: "{{ Session::get('message') }}"
                    });
                    break;
            }
        @endif

        @if($errors->any())
            var errors = @json($errors->all());
            if (errors && errors.length > 0) {
                var errorList = errors.map(function(error) {
                    return "<li>" + error + "</li>";
                }).join("");
                Swal.fire({
                    icon: 'error',
                    title: "Terjadi Kesalahan",
                    html: "<ul style='text-align: left;'>" + errorList + "</ul>",
                });
            }
        @endif
    </script>
</body>
</html>
