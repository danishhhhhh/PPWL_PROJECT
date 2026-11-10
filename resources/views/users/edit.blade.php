@extends('layouts.windmill')

@section('content')
<div class="w-full">
    <!-- Header -->
    <div class="flex items-center justify-between my-6">
        <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Edit User
        </h2>
        <a
            href="{{ route('users.index') }}"
            class="px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray"
        >
            Kembali
        </a>
    </div>

    <!-- Error Alert Box -->
    @if(isset($errors) && $errors->any())
        <div class="p-4 mb-8 text-sm font-semibold text-red-700 bg-red-100 rounded-lg dark:bg-red-700 dark:text-red-100 shadow-xs">
            <span class="block font-bold mb-1">Perhatian:</span>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Card -->
    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <form method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf
            @method('PUT')

            <!-- Nama -->
            <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400 font-medium">Nama</span>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name', $user->name) }}"
                    placeholder="Masukkan nama pengguna..."
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('name') border-red-600 focus:border-red-600 @enderror"
                    required
                />
                @error('name')
                    <span class="text-xs text-red-600 dark:text-red-400 font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </label>

            <!-- Email -->
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400 font-medium">Email</span>
                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email', $user->email) }}"
                    placeholder="contoh: user@gmail.com"
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('email') border-red-600 focus:border-red-600 @enderror"
                    required
                />
                @error('email')
                    <span class="text-xs text-red-600 dark:text-red-400 font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </label>

            <!-- Password Baru (Opsional) -->
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400 font-medium">Password Baru (Kosongkan jika tidak diubah)</span>
                <input
                    type="password"
                    name="password"
                    id="password"
                    placeholder="Minimal 8 karakter jika ingin mengganti..."
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('password') border-red-600 focus:border-red-600 @enderror"
                />
                @error('password')
                    <span class="text-xs text-red-600 dark:text-red-400 font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </label>

            <!-- Konfirmasi Password Baru -->
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400 font-medium">Konfirmasi Password Baru</span>
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    placeholder="Ulangi password baru..."
                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                />
            </label>

            <!-- Level -->
            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400 font-medium">Level</span>
                <select
                    name="level"
                    id="level"
                    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                    required
                >
                    <option value="user" {{ old('level', $user->level) == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('level', $user->level) == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('level')
                    <span class="text-xs text-red-600 dark:text-red-400 font-semibold mt-1 block">{{ $message }}</span>
                @enderror
            </label>

            <!-- Action Buttons -->
            <div class="flex items-center space-x-3 mt-6">
                <button
                    type="submit"
                    class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple shadow-sm"
                >
                    Update
                </button>
                <a
                    href="{{ route('users.index') }}"
                    class="px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray"
                >
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
