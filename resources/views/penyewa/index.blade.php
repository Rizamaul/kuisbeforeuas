@extends('layouts.app')

@section('title', 'Daftar Penyewa')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Daftar Penyewa</h1>
        <a href="{{ route('penyewa.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition">
            + Tambah Penyewa
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Lengkap</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nomor HP</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">KTP (NIK)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pekerjaan</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($penyewas as $penyewa)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-900">{{ $penyewa->nama_lengkap }}</div>
                                <div class="text-xs text-gray-500">{{ $penyewa->alamat_asal }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $penyewa->nomor_telepon }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $penyewa->nomor_ktp }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $penyewa->pekerjaan }}</td>
                            <td class="px-6 py-4 text-center text-sm font-medium">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('penyewa.edit', $penyewa->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <form action="{{ route('penyewa.destroy', $penyewa->id) }}" method="POST" onsubmit="return confirm('Hapus data penyewa ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">Belum ada data penyewa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection