<nav x-data="{ open: false, dropdownOpen: false }" class="bg-gradient-to-r from-red-700 via-red-800 to-red-900 shadow-lg sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">

            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-4 hover:scale-105 transition-transform duration-300 group">
                        <div class="relative">
                            <img src="{{asset('img/Logo smk.png')}}" class="h-14 w-14 rounded-full border-3 border-white shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                            <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-400 rounded-full border-2 border-white animate-pulse"></div>
                        </div>
                        <div class="hidden lg:block">
                            <h1 class="text-white font-bold text-lg tracking-wide">BIMBINGAN KONSELING</h1>
                            <p class="text-red-100 text-sm font-medium">SMK Negeri 1 Cilaku</p>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden xl:flex items-center space-x-1 ml-10">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-9 9a1 1 0 001.414 1.414L2 12.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-4.586l.293.293a1 1 0 001.414-1.414l-9-9z"/>
                        </svg>
                        <span>Beranda</span>
                    </a>
                </div>
                
                <!-- Main Navigation Menu -->
                <div class="hidden xl:flex items-center space-x-1 ml-6" x-data="{ activeDropdown: null }">
                    
                    <!-- Data Management Dropdown -->
                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('gurubk'))
                    <div class="relative" @mouseenter="activeDropdown = 'data'" @mouseleave="activeDropdown = null">
                        <button class="nav-link group">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                            </svg>
                            <span>Data Master</span>
                            <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        <div x-show="activeDropdown === 'data'" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute top-full left-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('gurubk'))
                            <a href="{{ route('siswa.index') }}" class="dropdown-item {{ request()->routeIs('siswa.*') ? 'active' : '' }}">
                                <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>Data Siswa</span>
                            </a>
                            @endif
                            @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('guru_bk.index') }}" class="dropdown-item {{ request()->routeIs('guru_bk.*') ? 'active' : '' }}">
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                </svg>
                                <span>Data Guru BK</span>
                            </a>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Bimbingan Konseling Dropdown -->
                    @if(auth()->user()->hasRole('siswa') || auth()->user()->hasRole('gurubk'))
                    <div class="relative" @mouseenter="activeDropdown = 'konseling'" @mouseleave="activeDropdown = null">
                        <button class="nav-link group">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"/>
                            </svg>
                            <span>Konseling</span>
                            <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        <div x-show="activeDropdown === 'konseling'" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute top-full left-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                            <!-- <a href="{{ route('konsultasi.index') }}" class="dropdown-item {{ request()->routeIs('konsultasi.*') ? 'active' : '' }}">
                                <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"/>
                                </svg>
                                <span>Konsultasi</span>
                            </a> -->
                            <!-- <a href="{{ route('gurubk.bimbingan-lanjutan') }}" class="dropdown-item {{ request()->routeIs('gurubk.bimbingan-lanjutan*') ? 'active' : '' }}">
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Bimbingan Lanjutan</span>
                            </a> -->
                            <a href="{{ route('gurubk.daftar-cek-masalah') }}" class="dropdown-item {{ request()->routeIs('gurubk.daftar-cek-masalah') ? 'active' : '' }}">
                                <svg class="w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Cek Masalah</span>
                            </a>
                            <a href="{{ route('gurubk.curhat') }}" class="dropdown-item {{ request()->routeIs('gurubk.curhat') ? 'active' : '' }}">
                                <svg class="w-5 h-5 text-pink-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2z" clip-rule="evenodd"/>
                                </svg>
                                <span>Curhat Rahasia</span>
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- Pengaduan & Pelanggaran -->
                    @if(auth()->user()->hasRole('siswa') || auth()->user()->hasRole('admin') || auth()->user()->hasRole('gurubk') || auth()->user()->hasRole('kesiswaan') || auth()->user()->hasRole('kepsek') || auth()->user()->hasRole('orangtua') || auth()->user()->hasRole('kajur'))
                    <div class="relative" @mouseenter="activeDropdown = 'laporan'" @mouseleave="activeDropdown = null">
                        <button class="nav-link group">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92z" clip-rule="evenodd"/>
                            </svg>
                            <span>Laporan</span>
                            <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        <div x-show="activeDropdown === 'laporan'" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute top-full left-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                            @if(auth()->user()->hasRole('siswa') || auth()->user()->hasRole('admin') || auth()->user()->hasRole('gurubk'))
                            <a href="{{ route('pengaduan.index') }}" class="dropdown-item {{ request()->routeIs('pengaduan.*') ? 'active' : '' }}">
                                <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92z" clip-rule="evenodd"/>
                                </svg>
                                <span>Pengaduan</span>
                            </a>
                            @endif
                            @if(!auth()->user()->hasRole('admin'))
                            <a href="{{ route('pelanggaran.rekap') }}" class="dropdown-item {{ request()->routeIs('pelanggaran.*') ? 'active' : '' }}">
                                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92z" clip-rule="evenodd"/>
                                </svg>
                                <span>Data Pelanggaran</span>
                            </a>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="relative" x-data="{ userDropdown: false }">
                    <button @click="userDropdown = !userDropdown" 
                            class="flex items-center space-x-3 px-4 py-2 rounded-xl bg-white/10 backdrop-blur-sm border border-white/20 hover:bg-white/20 transition-all duration-300 group">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <div class="text-sm font-semibold text-white">
                                @if (Auth::check())
                                {{ Auth::user()->name }}
                                @else
                                Guest
                                @endif
                            </div>
                            <div class="text-xs text-red-100">
                                @if (Auth::check())
                                    @if(auth()->user()->hasRole('admin'))
                                        Administrator
                                    @elseif(auth()->user()->hasRole('gurubk'))
                                        Guru BK
                                    @elseif(auth()->user()->hasRole('siswa'))
                                        Siswa
                                    @elseif(auth()->user()->hasRole('kesiswaan'))
                                        Kesiswaan
                                    @elseif(auth()->user()->hasRole('kepsek'))
                                        Kepala Sekolah
                                    @elseif(auth()->user()->hasRole('kajur'))
                                        Ketua Jurusan
                                    @elseif(auth()->user()->hasRole('orangtua'))
                                        Orang Tua
                                    @else
                                        User
                                    @endif
                                @endif
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-white transition-transform group-hover:rotate-180" :class="{'rotate-180': userDropdown}" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    
                    <div x-show="userDropdown" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         @click.away="userDropdown = false"
                         class="absolute top-full right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                            <span>Profile</span>
                        </a>
                        <hr class="my-2 border-gray-100">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-red-600 w-full text-left">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/>
                                </svg>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <div class="flex items-center xl:hidden">
                <button @click="open = !open" 
                        class="p-2 rounded-lg bg-white/10 backdrop-blur-sm border border-white/20 hover:bg-white/20 transition-all duration-300">
                    <svg class="h-6 w-6 text-white" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden xl:hidden">
        <div class="px-4 py-6 bg-white/95 backdrop-blur-sm border-t border-white/20">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center">
                <svg class="w-4 h-4 mr-3 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-9 9a1 1 0 001.414 1.414L2 12.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-4.586l.293.293a1 1 0 001.414-1.414l-9-9z"/>
                </svg>
                {{ __('Beranda') }}
            </x-responsive-nav-link>
            
            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('gurubk'))
            <x-responsive-nav-link :href="route('siswa.index')" :active="request()->routeIs('siswa.*')" class="flex items-center">
                <svg class="w-4 h-4 mr-3 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                </svg>
                {{ __('Data Siswa') }}
            </x-responsive-nav-link>
            @endif
            
            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('siswa'))
            <x-responsive-nav-link :href="route('guru_bk.index')" :active="request()->routeIs('guru_bk.*')" class="flex items-center">
                <svg class="w-4 h-4 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                </svg>
                {{ __('Data Guru BK') }}
            </x-responsive-nav-link>
            @endif
            
            @if(auth()->user()->hasRole('siswa') || auth()->user()->hasRole('gurubk'))
            <x-responsive-nav-link :href="route('konsultasi.index')" :active="request()->routeIs('konsultasi.*')" class="flex items-center">
                <svg class="w-4 h-4 mr-3 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"/>
                </svg>
                {{ __('Bimbingan Konseling') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('gurubk.bimbingan-lanjutan')" :active="request()->routeIs('gurubk.bimbingan-lanjutan*')" class="flex items-center">
                <svg class="w-4 h-4 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ __('Bimbingan Lanjutan') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('gurubk.daftar-cek-masalah')" :active="request()->routeIs('gurubk.daftar-cek-masalah')" class="flex items-center">
                <svg class="w-4 h-4 mr-3 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" clip-rule="evenodd"/>
                </svg>
                {{ __('Daftar Cek Masalah') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('gurubk.curhat')" :active="request()->routeIs('gurubk.curhat')" class="flex items-center">
                <svg class="w-4 h-4 mr-3 text-pink-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"/>
                </svg>
                {{ __('Curhat Rahasia') }}
            </x-responsive-nav-link>
            @endif
            
            @if(auth()->user()->hasRole('siswa') || auth()->user()->hasRole('admin') || auth()->user()->hasRole('gurubk'))
            <x-responsive-nav-link :href="route('pengaduan.index')" :active="request()->routeIs('pengaduan.*')" class="flex items-center">
                <svg class="w-4 h-4 mr-3 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ __('Pengaduan') }}
            </x-responsive-nav-link>
            @endif
            
            @if(auth()->user()->hasRole('kesiswaan') || auth()->user()->hasRole('gurubk') || auth()->user()->hasRole('kepsek') || auth()->user()->hasRole('orangtua') || auth()->user()->hasRole('kajur') || auth()->user()->hasRole('siswa'))
            <x-responsive-nav-link :href="route('pelanggaran.rekap')" :active="request()->routeIs('pelanggaran.*')" class="flex items-center">
                <svg class="w-4 h-4 mr-3 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ __('Data Pelanggaran') }}
            </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4 flex items-center space-x-3">
                <div class="w-10 h-10 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="flex items-center">
                    <svg class="w-4 h-4 mr-3 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        class="flex items-center text-red-600">
                        <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/>
                        </svg>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
