@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
        <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full border">
            📅 {{ now()->translatedFormat('d F Y') }}
        </span>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
       
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500 transition hover:shadow-lg">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                   
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <div class="text-sm font-medium text-gray-500">Total Kamar</div>
                    <div class="text-3xl font-bold text-gray-900">
                        {{ $totalKamar ?? 0 }}
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-indigo-500 transition hover:shadow-lg">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-indigo-100 text-indigo-500 mr-4">
                  
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div>
                    <div class="text-sm font-medium text-gray-500">Kamar Terisi</div>
                    <div class="text-3xl font-bold text-gray-900">
                        {{ $kamarTerisi ?? 0 }}
                    </div>
                </div>
            </div>
        </div>

    
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500 transition hover:shadow-lg">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4">
                  
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <div class="text-sm font-medium text-gray-500">Kamar Tersedia</div>
                    <div class="text-3xl font-bold text-gray-900">
                        {{ $kamarTersedia ?? 0 }}
                    </div>
                </div>
            </div>
        </div>

        
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500 transition hover:shadow-lg">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-500 mr-4">
                
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <div class="text-sm font-medium text-gray-500">Tertunggak</div>
                    <div class="text-3xl font-bold text-gray-900">
                        {{ $pembayaranTertunggak ?? 0 }} <span class="text-sm font-normal text-gray-400">Item</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="bg-white rounded-lg shadow p-6 border-t-4 border-yellow-500 lg:col-span-1 flex flex-col justify-center">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Pendapatan Bulan Ini</h3>
            <div class="text-3xl font-bold text-yellow-600 mb-2">
                Rp {{ number_format($pendapatanBulanIni ?? 0, 0, ',', '.') }}
            </div>
            <p class="text-gray-500 text-sm leading-relaxed">
                Total pemasukan dari pembayaran sewa yang lunas pada bulan ini.
            </p>
        </div>

        <div class="bg-white rounded-lg shadow p-6 lg:col-span-2">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-700">Grafik Pendapatan Tahun Ini</h3>
            </div>
            <div class="relative h-64 w-full">
                <canvas id="incomeChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('incomeChart');
        

        if (ctx) {
       
            const dataPendapatan = @json($grafikPendapatan ?? array_fill(0, 12, 0));

            new Chart(ctx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: dataPendapatan,
                        backgroundColor: 'rgba(59, 130, 246, 0.6)', 
                        borderColor: 'rgba(59, 130, 246, 1)',      
                        borderWidth: 1,
                        borderRadius: 4,
                        barPercentage: 0.6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }, 
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let value = context.raw;
                                    return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    if (value >= 1000000) return 'Rp ' + (value/1000000) + 'jt';
                                    if (value >= 1000) return 'Rp ' + (value/1000) + 'rb';
                                    return value;
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endsection