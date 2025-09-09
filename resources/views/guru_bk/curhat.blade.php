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
                @hasrole('siswa')
                <p class="text-red-200 text-sm mt-1">Komunikasi pribadi antara Anda dan Guru BK</p>
                @else
                <p class="text-red-200 text-sm mt-1">Komunikasi rahasia dengan siswa</p>
                @endhasrole
            </div>
        </div>

        <!-- Main Content -->
        <div class="py-8">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                @if($curhats->isEmpty())
                    <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                        <i class="fas fa-comments text-gray-400 text-6xl mb-4"></i>
                        @hasrole('siswa')
                        <p class="text-gray-500 text-lg">Anda belum memiliki curhat rahasia.</p>
                        <p class="text-gray-400 text-sm mt-2">Gunakan menu Bimbingan Konseling untuk memulai curhat.</p>
                        @else
                        <p class="text-gray-500 text-lg">Tidak ada curhat rahasia saat ini.</p>
                        @endhasrole
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach($curhats as $curhat)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                            <!-- Header Card -->
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900">{{ $curhat->user->name ?? 'N/A' }}</h3>
                                            <p class="text-sm text-gray-500">{{ $curhat->created_at->format('d M Y, H:i') }}</p>
                                        </div>
                                    </div>
                                    <div>
                                        @php
                                            $hasConversations = $curhat->conversations->count() > 0;
                                            $lastMessage = $curhat->conversations->last();
                                        @endphp
                                        
                                        @if($hasConversations)
                                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                <i class="fas fa-comments mr-1"></i>
                                                Dalam Percakapan
                                            </span>
                                        @elseif($curhat->reply_guru)
                                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Sudah Dibalas
                                            </span>
                                        @else
                                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-1"></i>
                                                @hasrole('siswa')
                                                Menunggu Balasan
                                                @else
                                                Belum Dibalas
                                                @endhasrole
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6">
                                <!-- Original Message -->
                                <div class="mb-6">
                                    <div class="bg-blue-50 rounded-lg p-4 border-l-4 border-blue-500">
                                        <div class="flex items-start space-x-3">
                                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-user text-white text-sm"></i>
                                            </div>
                                            <div class="flex-1">
                                                <div class="flex items-center justify-between mb-2">
                                                    <span class="text-sm font-medium text-blue-800">Pesan Awal - {{ $curhat->user->name }}</span>
                                                    <span class="text-xs text-blue-600">{{ $curhat->created_at->format('d M Y, H:i') }}</span>
                                                </div>
                                                <p class="text-gray-800 leading-relaxed">{{ $curhat->isi_curhat }}</p>
                                                @if($curhat->attachment)
                                                    <div class="mt-3">
                                                        <a href="{{ asset('storage/' . $curhat->attachment) }}" 
                                                           target="_blank" 
                                                           class="inline-flex items-center px-3 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors duration-200">
                                                            <i class="fas fa-paperclip mr-2"></i>
                                                            Lihat Lampiran
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Conversations -->
                                @if($curhat->conversations->count() > 0)
                                    <div class="space-y-4 mb-6">
                                        @foreach($curhat->conversations as $conversation)
                                            <div class="@if($conversation->sender_type == 'gurubk') ml-8 @else mr-8 @endif">
                                                <div class="@if($conversation->sender_type == 'gurubk') bg-green-50 border-l-4 border-green-500 @else bg-gray-50 border-l-4 border-gray-500 @endif rounded-lg p-4">
                                                    <div class="flex items-start space-x-3">
                                                        <div class="w-8 h-8 @if($conversation->sender_type == 'gurubk') bg-green-500 @else bg-gray-500 @endif rounded-full flex items-center justify-center flex-shrink-0">
                                                            <i class="fas @if($conversation->sender_type == 'gurubk') fa-user-tie @else fa-user @endif text-white text-sm"></i>
                                                        </div>
                                                        <div class="flex-1">
                                                            <div class="flex items-center justify-between mb-2">
                                                                <span class="text-sm font-medium @if($conversation->sender_type == 'gurubk') text-green-800 @else text-gray-800 @endif">
                                                                    @if($conversation->sender_type == 'gurubk')
                                                                        Guru BK
                                                                    @else
                                                                        {{ $conversation->sender->name }}
                                                                    @endif
                                                                </span>
                                                                <span class="text-xs @if($conversation->sender_type == 'gurubk') text-green-600 @else text-gray-600 @endif">
                                                                    {{ $conversation->created_at->format('d M Y, H:i') }}
                                                                </span>
                                                            </div>
                                                            <p class="text-gray-800 leading-relaxed">{{ $conversation->message }}</p>
                                                            @if($conversation->attachment)
                                                                <div class="mt-3">
                                                                    <a href="{{ asset('storage/' . $conversation->attachment) }}" 
                                                                       target="_blank" 
                                                                       class="inline-flex items-center px-3 py-2 @if($conversation->sender_type == 'gurubk') bg-green-100 text-green-700 hover:bg-green-200 @else bg-gray-100 text-gray-700 hover:bg-gray-200 @endif rounded-lg transition-colors duration-200">
                                                                        <i class="fas fa-paperclip mr-2"></i>
                                                                        Lihat Lampiran
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Legacy Reply (jika ada) -->
                                @if($curhat->reply_guru && $curhat->conversations->count() == 0)
                                    <div class="mb-6 ml-8">
                                        <div class="bg-green-50 rounded-lg p-4 border-l-4 border-green-500">
                                            <div class="flex items-start space-x-3">
                                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                                                    <i class="fas fa-user-tie text-white text-sm"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <div class="flex items-center justify-between mb-2">
                                                        <span class="text-sm font-medium text-green-800">Balasan Guru BK</span>
                                                        <span class="text-xs text-green-600">{{ $curhat->reply_date->format('d M Y, H:i') }}</span>
                                                    </div>
                                                    <p class="text-gray-800 leading-relaxed">{{ $curhat->reply_guru }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Reply Form -->
                                <div class="border-t border-gray-200 pt-6">
                                    <form action="{{ route('gurubk.curhat.reply', $curhat->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-4">
                                            <label for="message_{{ $curhat->id }}" class="block text-sm font-medium text-gray-700 mb-2">
                                                <i class="fas fa-reply mr-2 text-blue-500"></i>
                                                @hasrole('siswa')
                                                Balas Pesan
                                                @else
                                                Tulis Balasan Anda
                                                @endhasrole
                                            </label>
                                            <textarea 
                                                id="message_{{ $curhat->id }}" 
                                                name="message" 
                                                rows="4" 
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg resize-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                                                placeholder="@hasrole('siswa')Ketik balasan Anda...@elseKetik balasan Anda untuk siswa...@endhasrole"
                                                required
                                            ></textarea>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="attachment_{{ $curhat->id }}" class="block text-sm font-medium text-gray-700 mb-2">
                                                <i class="fas fa-paperclip mr-2 text-gray-500"></i>
                                                Lampiran (Opsional)
                                            </label>
                                            <input 
                                                type="file" 
                                                id="attachment_{{ $curhat->id }}" 
                                                name="attachment" 
                                                accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                            >
                                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, PDF, DOC, DOCX. Maksimal 2MB.</p>
                                        </div>
                                        
                                        <div class="flex justify-end mt-3">
                                            <button 
                                                type="submit" 
                                                class="inline-flex items-center px-6 py-3 bg-red-800 hover:bg-red-900 text-white font-semibold text-sm rounded-lg border border-red-900 shadow-lg hover:shadow-xl transform hover:scale-105 active:scale-95 transition-all duration-200 ease-in-out focus:outline-none focus:ring-4 focus:ring-red-300 focus:ring-opacity-50"
                                            >
                                                <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
                                                </svg>
                                                <span class="font-semibold">Kirim Pesan</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

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
    </script>
</body>
</html>
