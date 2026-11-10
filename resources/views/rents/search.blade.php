@extends('layouts.windmill')

@section('content')
<div class="w-full">
    <!-- Header Title & Action -->
    <div class="flex items-center justify-between my-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Hasil Pencarian Rental
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Kata kunci: <span class="font-semibold text-purple-600 dark:text-purple-400">"{{ $cari }}"</span>
            </p>
        </div>
        <a
            href="{{ url('/rents/create') }}"
            class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple shadow-sm"
        >
            <span>Tambah Rental</span>
            <span class="ml-2" aria-hidden="true">+</span>
        </a>
    </div>

    <!-- Metrics Cards (Sesuai cards.html tanpa icon) -->
    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
        <!-- Total Item -->
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                Total Item
            </p>
            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                {{ $total_items }}
            </p>
        </div>

        <!-- Tersedia -->
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                Tersedia
            </p>
            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                {{ $total_available }}
            </p>
        </div>

        <!-- Disewa -->
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                Disewa
            </p>
            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                {{ $total_rented }}
            </p>
        </div>

        <!-- Rata-rata Harga -->
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                Rata-rata Harga
            </p>
            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                {{ $avg_price }}
            </p>
        </div>

        <!-- Harga Tertinggi -->
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                Harga Tertinggi
            </p>
            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                {{ $highest_price }}
            </p>
        </div>

        <!-- Harga Terendah -->
        <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                Harga Terendah
            </p>
            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                {{ $lowest_price }}
            </p>
        </div>
    </div>

    <!-- Search & Filter Card (Sesuai forms.html) -->
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form method="GET" action="{{ route('rents.search') }}" class="grid gap-6 md:grid-cols-2 xl:grid-cols-4 items-end">
            <!-- Cari Nama Item -->
            <div>
                <label class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400 font-medium">Cari Nama Item</span>
                    <input
                        type="text"
                        name="search"
                        id="search"
                        value="{{ $cari }}"
                        placeholder="Ketik nama item rental..."
                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                    />
                </label>
            </div>

            <!-- Filter Ketersediaan -->
            <div>
                <label class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400 font-medium">Ketersediaan</span>
                    <select
                        name="availability"
                        id="availability"
                        class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                    >
                        <option value="">-- Semua --</option>
                        <option value="1" {{ request('availability') === '1' ? 'selected' : '' }}>Tersedia (Ready)</option>
                        <option value="0" {{ request('availability') === '0' ? 'selected' : '' }}>Sedang Disewa</option>
                    </select>
                </label>
            </div>

            <!-- Urutkan Harga -->
            <div>
                <label class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400 font-medium">Urutkan Harga</span>
                    <select
                        name="sort"
                        id="sort"
                        class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                    >
                        <option value="">Terbaru (Default)</option>
                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Harga Terendah</option>
                    </select>
                </label>
            </div>

            <!-- Tombol Aksi Filter -->
            <div class="flex items-center space-x-3">
                <button
                    type="submit"
                    class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                >
                    Terapkan
                </button>
                <a
                    href="{{ url('/rents') }}"
                    class="px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray"
                >
                    Reset
                </a>
            </div>
        </form>
    </div>

    @if(count($rents))
        <!-- Info Banner Hasil Pencarian -->
        <div class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md">
            <span>Ditemukan <strong>{{ $jumlah_rents }}</strong> data dengan kata kunci: <strong>"{{ $cari }}"</strong></span>
            <a href="{{ url('/rents') }}" class="underline text-xs font-bold text-white hover:text-purple-200">
                Lihat Semua
            </a>
        </div>

        <!-- Cards Grid (Sesuai Windmill Dashboard & Subbab 3.2.2) -->
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
            @foreach($rents as $rent)
                <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 flex flex-col justify-between hover:shadow-md transition-shadow duration-150">
                    <div>
                        <!-- Foto Barang dengan Badges (Ukuran konsisten 190px ada atau tidak ada gambar) -->
                        <div class="card-img-container mb-4 bg-gray-100 dark:bg-gray-700">
                            @if($rent->image)
                                <img
                                    class="object-cover w-full h-full rounded-lg"
                                    style="width: 100%; height: 100%; object-fit: cover;"
                                    src="{{ asset('storage/' . $rent->image) }}"
                                    alt="{{ $rent->name }}"
                                    loading="lazy"
                                />
                            @else
                                <div class="flex flex-col items-center justify-center w-full h-full text-gray-400 dark:text-gray-500 bg-gray-100 dark:bg-gray-700" style="width: 100%; height: 100%;">
                                    <svg width="40" height="40" style="width: 40px; height: 40px;" class="mb-2 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-xs font-medium">Foto Belum Tersedia</span>
                                </div>
                            @endif

                            <!-- Badge Status Ketersediaan (Pojok Kiri Atas) -->
                            <div class="absolute top-2 left-2">
                                @if($rent->availability)
                                    <span class="card-badge card-badge-green">
                                        Tersedia
                                    </span>
                                @else
                                    <span class="card-badge card-badge-orange">
                                        Disewa
                                    </span>
                                @endif
                            </div>

                            <!-- Badge Jenis Sewa (Pojok Kanan Atas - Jelas terlihat) -->
                            <div class="absolute top-2 right-2">
                                <span class="card-badge {{ $rent->rent_type === 'Mingguan' ? 'card-badge-teal' : 'card-badge-purple' }}">
                                    {{ $rent->rent_type ?? 'Harian' }}
                                </span>
                            </div>
                        </div>

                        <!-- Header Card: Nama & Harga (Ukuran teks dan durasi seimbang) -->
                        <div class="mb-3">
                            <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-200 truncate" title="{{ $rent->name }}">
                                {{ $rent->name }}
                            </h4>
                            <div class="flex items-center text-purple-600 dark:text-purple-400 mt-1">
                                <span class="text-xl font-bold">
                                    Rp {{ number_format((float) $rent->price, 0, ',', '.') }}
                                </span>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400 ml-1.5">
                                    / {{ strtolower($rent->rent_type ?? 'harian') }}
                                </span>
                            </div>
                        </div>

                        <!-- Detail Spesifikasi (1 Line Teks + Ukuran Icon Pas 16px) -->
                        <div class="pt-3 pb-3 mb-4 border-t border-b border-gray-100 dark:border-gray-700 text-xs space-y-2">
                            <div class="card-spec-row text-gray-600 dark:text-gray-400">
                                <span class="card-spec-label text-gray-500 dark:text-gray-400">
                                    <svg width="16" height="16" class="card-spec-icon text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                                    </svg>
                                    ID Rental
                                </span>
                                <span class="font-semibold text-gray-700 dark:text-gray-300">#{{ $rent->id }}</span>
                            </div>

                            <div class="card-spec-row text-gray-600 dark:text-gray-400">
                                <span class="card-spec-label text-gray-500 dark:text-gray-400">
                                    <svg width="16" height="16" class="card-spec-icon text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                    Tanggal Sewa
                                </span>
                                <span class="font-semibold text-gray-700 dark:text-gray-300">
                                    {{ $rent->rent_date ? $rent->rent_date->format('d/m/Y') : '-' }}
                                </span>
                            </div>

                            <div class="card-spec-row text-gray-600 dark:text-gray-400">
                                <span class="card-spec-label text-gray-500 dark:text-gray-400">
                                    <svg width="16" height="16" class="card-spec-icon text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    Skema Sewa
                                </span>
                                <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $rent->rent_type ?? 'Harian' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi (Windmill Buttons) -->
                    <div class="flex items-center space-x-3 pt-2">
                        <!-- Tombol Edit (Purple Primary Button) -->
                        <a
                            href="{{ url('/rents/' . $rent->id . '/edit') }}"
                            class="flex items-center justify-center flex-1 px-3 py-2 text-xs font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple shadow-xs"
                        >
                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                            </svg>
                            Edit
                        </a>

                        <!-- Tombol Hapus (Danger Outline Button) -->
                        <form
                            method="POST"
                            action="{{ url('/rents/' . $rent->id) }}"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data rental ini?');"
                            class="flex-1"
                        >
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="w-full flex items-center justify-center px-3 py-2 text-xs font-medium leading-5 text-red-600 transition-colors duration-150 border border-red-200 dark:border-red-600/40 rounded-lg hover:bg-red-50 hover:border-red-400 dark:hover:bg-red-600 dark:hover:text-white dark:text-red-400 focus:outline-none focus:shadow-outline-red"
                            >
                                <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Table Pagination Footer (Sesuai tables.html) -->
        <div class="grid px-4 py-3 mb-8 text-xs font-semibold tracking-wide text-gray-500 uppercase rounded-lg shadow-xs bg-white dark:border-gray-700 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
            <span class="flex items-center col-span-3">
                Ditemukan: {{ $jumlah_rents }} data
            </span>
            <span class="col-span-2"></span>
            <!-- Pagination -->
            <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                {{ $rents->withQueryString()->links() }}
            </span>
        </div>
    @else
        <!-- Empty State Card -->
        <div class="px-4 py-8 mb-8 text-center bg-white rounded-lg shadow-md dark:bg-gray-800">
            <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">
                Data "{{ $cari }}" Tidak Ditemukan
            </h4>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                Silakan coba kata kunci lain atau kembali ke daftar lengkap rental.
            </p>
            <a
                href="{{ url('/rents') }}"
                class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple inline-block"
            >
                Kembali ke Semua Rental
            </a>
        </div>
    @endif
</div>
@endsection
