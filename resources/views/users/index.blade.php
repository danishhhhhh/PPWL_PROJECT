@extends('layouts.windmill')

@section('content')
<div class="w-full">
    <!-- Header Title & Action -->
    <div class="flex items-center justify-between my-6">
        <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Data User
        </h2>
        <a
            href="{{ route('users.create') }}"
            class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple shadow-sm"
        >
            <span>Tambah User</span>
            <span class="ml-2" aria-hidden="true">+</span>
        </a>
    </div>

    <!-- Flash Message -->
    @if(Session::has('pesan'))
        <div class="p-4 mb-6 text-sm font-semibold text-green-700 bg-green-100 rounded-lg dark:bg-green-700 dark:text-green-100 shadow-xs flex items-center justify-between">
            <span>{{ Session::get('pesan') }}</span>
        </div>
    @endif

    @if(Session::has('error'))
        <div class="p-4 mb-6 text-sm font-semibold text-red-700 bg-red-100 rounded-lg dark:bg-red-700 dark:text-red-100 shadow-xs flex items-center justify-between">
            <span>{{ Session::get('error') }}</span>
        </div>
    @endif

    <!-- Table Card -->
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3 text-center w-12">No</th>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3 text-center">Level</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @forelse($users as $user)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <!-- No -->
                            <td class="px-4 py-3 text-center text-sm">
                                {{ $no++ }}
                            </td>

                            <!-- Nama dengan Avatar Inisial -->
                            <td class="px-4 py-3">
                                <div class="flex items-center text-sm">
                                    <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block bg-purple-100 dark:bg-purple-700/50 text-purple-600 dark:text-purple-300 flex items-center justify-center font-bold text-xs uppercase">
                                        {{ substr($user->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">
                                            ID #{{ $user->id }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <!-- Email -->
                            <td class="px-4 py-3 text-sm">
                                {{ $user->email }}
                            </td>

                            <!-- Level Badge -->
                            <td class="px-4 py-3 text-xs text-center">
                                @if($user->level == 'admin')
                                    <span class="px-2 py-1 font-semibold leading-tight text-purple-700 bg-purple-100 rounded-full dark:bg-purple-700 dark:text-purple-100 uppercase">
                                        Admin
                                    </span>
                                @else
                                    <span class="px-2 py-1 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full dark:text-gray-100 dark:bg-gray-700 uppercase">
                                        User
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center space-x-4 text-sm">
                                    <!-- Edit Button -->
                                    <a
                                        href="{{ route('users.edit', $user->id) }}"
                                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray hover:bg-gray-100 dark:hover:bg-gray-700"
                                        aria-label="Edit"
                                        title="Edit"
                                    >
                                        <svg
                                            class="w-5 h-5"
                                            aria-hidden="true"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"
                                            ></path>
                                        </svg>
                                    </a>

                                    <!-- Delete Button -->
                                    <form
                                        method="POST"
                                        action="{{ route('users.destroy', $user->id) }}"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data user ini?');"
                                        class="inline"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray hover:bg-gray-100 dark:hover:bg-gray-700"
                                            aria-label="Delete"
                                            title="Delete"
                                        >
                                            <svg
                                                class="w-5 h-5 text-red-500"
                                                aria-hidden="true"
                                                fill="currentColor"
                                                viewBox="0 0 20 20"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd"
                                                ></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                Tidak ada data user.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-4 py-3 border-t dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-500 dark:text-gray-400">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection

