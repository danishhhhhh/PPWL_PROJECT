@extends('layouts.windmill')

@section('content')
<div class="w-full">
    <!-- Header -->
    <div class="flex items-center justify-between my-6">
        <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Tambah Rental
        </h2>
        <a
            href="{{ url('/rents') }}"
            class="px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray"
        >
            Kembali
        </a>
    </div>

    <!-- Error Alert Box -->
    @if(count($errors) > 0)
        <div class="p-4 mb-8 text-sm font-semibold text-red-700 bg-red-100 rounded-lg dark:bg-red-700 dark:text-red-100 shadow-xs">
            <span class="block font-bold mb-1">Perhatian:</span>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Card (Sesuai forms.html) -->
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">

        <form method="POST" action="{{ url('/rents') }}" enctype="multipart/form-data">
            @csrf

            <!-- Nama Rental -->
            <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400 font-medium">Nama Rental</span>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}"
                    placeholder="Masukkan nama item rental..."
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('name') border-red-600 focus:border-red-600 @enderror"
                    required
                />
                @error('name')
                    <span class="text-xs text-red-600 dark:text-red-400 font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </label>

            <!-- Harga Sewa -->
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400 font-medium">Harga Sewa (Rp)</span>
                <input
                    type="number"
                    name="price"
                    id="price"
                    value="{{ old('price') }}"
                    placeholder="Contoh: 350000"
                    min="0"
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('price') border-red-600 focus:border-red-600 @enderror"
                    required
                />
                @error('price')
                    <span class="text-xs text-red-600 dark:text-red-400 font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </label>

            <!-- Tanggal Sewa -->
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400 font-medium">Tanggal Sewa</span>
                <input
                    type="date"
                    name="rent_date"
                    id="rent_date"
                    value="{{ old('rent_date', date('Y-m-d')) }}"
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('rent_date') border-red-600 focus:border-red-600 @enderror"
                    required
                />
                @error('rent_date')
                    <span class="text-xs text-red-600 dark:text-red-400 font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </label>

            <!-- Jenis Sewa -->
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400 font-medium">Jenis Sewa</span>
                <select
                    name="rent_type"
                    id="rent_type"
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray @error('rent_type') border-red-600 focus:border-red-600 @enderror"
                    required
                >
                    <option value="Harian" {{ old('rent_type', 'Harian') === 'Harian' ? 'selected' : '' }}>
                        Harian
                    </option>
                    <option value="Mingguan" {{ old('rent_type') === 'Mingguan' ? 'selected' : '' }}>
                        Mingguan
                    </option>
                </select>
                @error('rent_type')
                    <span class="text-xs text-red-600 dark:text-red-400 font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </label>

            <!-- Ketersediaan -->
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400 font-medium">Ketersediaan</span>
                <select
                    name="availability"
                    id="availability"
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray @error('availability') border-red-600 focus:border-red-600 @enderror"
                    required
                >
                    <option value="">-- Pilih Ketersediaan --</option>
                    <option value="1" {{ old('availability') === '1' ? 'selected' : '' }}>
                        Tersedia (Ready)
                    </option>
                    <option value="0" {{ old('availability') === '0' ? 'selected' : '' }}>
                        Sedang Disewa
                    </option>
                </select>
                @error('availability')
                    <span class="text-xs text-red-600 dark:text-red-400 font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </label>

            <!-- Foto Barang -->
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400 font-medium">Foto Barang</span>
                <input
                    type="file"
                    name="image"
                    id="image"
                    accept=".jpg,.jpeg,.png"
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-input @error('image') border-red-600 @enderror"
                />
                <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 block">Format: JPG, JPEG, PNG (Maks 2MB). Opsional.</span>
                @error('image')
                    <span class="text-xs text-red-600 dark:text-red-400 font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </label>

            <!-- Action Buttons -->
            <div class="flex items-center space-x-4 mt-6">
                <button
                    type="submit"
                    class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                >
                    Simpan
                </button>
                <a
                    href="{{ url('/rents') }}"
                    class="px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray"
                >
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
