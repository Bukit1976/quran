@extends('layouts.app')

@section('title', 'Profil Saya')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-100">
        {{ __('Profil Saya') }}
    </h2>
@endsection

@section('content')
    <div class="mx-auto max-w-2xl">
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
            @if (session('success'))
                <div class="mb-6 rounded-lg bg-emerald-100 p-4 text-emerald-700 dark:bg-emerald-900 dark:text-emerald-300">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 outline-none focus:ring-2 focus:ring-emerald-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    @error('name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 outline-none focus:ring-2 focus:ring-emerald-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                        class="rounded-lg bg-emerald-500 px-6 py-2 font-medium text-white transition hover:bg-emerald-600">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('dashboard') }}"
                        class="rounded-lg bg-gray-200 px-6 py-2 font-medium text-gray-900 transition hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
