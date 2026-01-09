@extends('layouts.app')

@section('title', 'Daftar Kamar')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Daftar Kamar</h1>
        <a href="{{ route('kamar.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition duration-150">
            + Tambah Kamar
        </a>
    </div>

    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
        <form action="{{ route('kamar.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <select name="tipe" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    <option value="">-- Semua Tipe --</option>
                    <option value="standard" {{ request('tipe') == 'standard' ? 'selected' : '' }}>Standard</option>
                    <option value="deluxe" {{ request('tipe') == 'deluxe' ? 'selected' : '' }}>Deluxe</option>
                    <option value="vip" {{ request('tipe') == 'vip' ? 'selected' : '' }}>VIP</option>
                </select>
            </div>
            <div class="flex-1">
                <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    <option value="">-- Semua Status --</option>
                    <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="terisi" {{ request('status') == 'terisi' ? 'selected' : '' }}>Terisi</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 text-sm font-medium">
                    Filter Data
                </button>
                @if(request('tipe') || request('status'))
                    <a href="{{ route('kamar.index') }}" class="ml-2 text-red-500 hover:text-red-700 text-sm font-medium py-2">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    
    <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Kamar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga/Bulan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($kamar as $kamar)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-bold text-gray-900">{{ $kamar->nomor_kamar }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ ucfirst($kamar->tipe) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                Rp {{ number_format($kamar->harga_bulanan, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($kamar->status == 'tersedia')
                                    <span class="px-2 inline-flex