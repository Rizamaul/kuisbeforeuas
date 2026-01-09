@extends('layouts.app')

@section('title', 'Tambah Kamar')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Tambah Kamar Baru</h1>
        <a href="{{ route('kamar.index') }}" class="text-gray-500 hover:text-gray-700 font-medium">
            &larr; Kembali
        </a>
    </div>

   
    <form action="{{ route('kamar.store') }}" method="POST" class="bg-white shadow-xl rounded-lg p-6 space-y-6">
        @csrf
        
   
        <div>
            <label for="nomor_kamar" class="block text-sm font-medium text-gray-700 mb-1">Nomor Kamar</label>
            <input type="text" 
                   name="nomor_kamar" 
                   id="nomor_kamar" 
                   value="{{ old('nomor_kamar') }}"
                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nomor_kamar') border-red-500 @enderror"
                   placeholder="Contoh: A-01">
            
          
            @error('nomor_kamar')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="tipe" class="block text-sm font-medium text-gray-700 mb-1">Tipe Kamar</label>
            <select name="tipe" id="tipe" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="" disabled selected>-- Pilih Tipe --</option>
                <option value="standard" {{ old('tipe') == 'standard' ? 'selected' : '' }}>Standard</option>
                <option value="deluxe" {{ old('tipe') == 'deluxe' ? 'selected' : '' }}>Deluxe</option>
                <option value="vip" {{ old('tipe') == 'vip' ? 'selected' : '' }}>VIP</option>
            </select>
            @error('tipe')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

     
        <div>
            <label for="harga_bulanan" class="block text-sm font-medium text-gray-700 mb-1">Harga Sewa (Per Bulan)</label>
            <div class="relative rounded-md shadow-sm">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                  <span class="text-gray-500 sm:text-sm">Rp</span>
                </div>
                <input type="number" 
                       name="harga_bulanan" 
                       id="harga_bulanan" 
                       value="{{ old('harga_bulanan') }}"
                       class="w-full rounded-md border-gray-300 pl-10 focus:border-blue-500 focus:ring-blue-500" 
                       placeholder="0">
            </div>
            @error('harga_bulanan')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

   
        <div>
            <label for="fasilitas" class="block text-sm font-medium text-gray-700 mb-1">Fasilitas</label>
            <textarea name="fasilitas" 
                      id="fasilitas" 
                      rows="3" 
                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                      placeholder="Contoh: Kasur, Lemari, WiFi, AC, Kamar Mandi Dalam">{{ old('fasilitas') }}</textarea>
            @error('fasilitas')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

    
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Awal</label>
            <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="terisi" {{ old('status') == 'terisi' ? 'selected' : '' }}>Terisi</option>
            </select>
            @error('status')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
            <a href="{{ route('kamar.index') }}" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                Batal
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md shadow-md transition duration-150 ease-in-out">
                Simpan Data
            </button>
        </div>
    </form>
</div>
@endsection