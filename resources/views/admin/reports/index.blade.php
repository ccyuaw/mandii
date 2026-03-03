@extends('layouts.admin')

@section('content')
<div class="p-8 bg-slate-50 min-h-screen">
    {{-- HEADER & BỘ LỌC --}}
    <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Báo cáo doanh thu</h1>
            <p class="text-sm text-slate-500">Thống kê chi tiết từng nguồn thu</p>
        </div>
        
        <form action="{{ route('admin.reports.index') }}" method="GET" class="bg-white p-2 rounded-lg shadow-sm border border-slate-200 flex items-center gap-2">
            <div class="flex flex-col">
                <label class="text-[10px] uppercase font-bold text-slate-400 px-2">Từ ngày</label>
                <input type="date" name="from_date" value="{{ $fromDate }}" class="border-none text-sm font-bold text-slate-700 focus:ring-0">
            </div>
            <div class="h-8 w-px bg-slate-200"></div>
            <div class="flex flex-col">
                <label class="text-[10px] uppercase font-bold text-slate-400 px-2">Đến ngày</label>
                <input type="date" name="to_date" value="{{ $toDate }}" class="border-none text-sm font-bold text-slate-700 focus:ring-0">
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-bold text-sm transition ml-2">
                <i class="fa-solid fa-filter"></i> Lọc
            </button>
        </form>
    </div>

    {{-- KẾT QUẢ TỔNG QUAN --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        {{-- Card Tổng cộng --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-blue-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition">
                <i class="fa-solid fa-sack-dollar text-6xl text-blue-600"></i>
            </div>
            <p class="text-slate-500 font-bold text-xs uppercase">Tổng doanh thu</p>
            <p class="text-3xl font-black text-blue-600 mt-2">{{ number_format($totalPharmacy + $totalBooking) }}đ</p>
        </div>

        {{-- Card Nhà thuốc --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-green-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition">
                <i class="fa-solid fa-pills text-6xl text-green-600"></i>
            </div>
            <p class="text-slate-500 font-bold text-xs uppercase">Doanh thu Nhà thuốc</p>
            <p class="text-3xl font-black text-green-600 mt-2">{{ number_format($totalPharmacy) }}đ</p>
            <div class="mt-2 h-1 w-full bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-green-500" style="width: {{ ($totalPharmacy + $totalBooking) > 0 ? ($totalPharmacy / ($totalPharmacy + $totalBooking) * 100) : 0 }}%"></div>
            </div>
        </div>

        {{-- Card Đặt lịch --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-purple-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition">
                <i class="fa-solid fa-user-doctor text-6xl text-purple-600"></i>
            </div>
            <p class="text-slate-500 font-bold text-xs uppercase">Doanh thu Đặt khám</p>
            <p class="text-3xl font-black text-purple-600 mt-2">{{ number_format($totalBooking) }}đ</p>
            <div class="mt-2 h-1 w-full bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-purple-500" style="width: {{ ($totalPharmacy + $totalBooking) > 0 ? ($totalBooking / ($totalPharmacy + $totalBooking) * 100) : 0 }}%"></div>
            </div>
        </div>
    </div>

    {{-- BIỂU ĐỒ --}}
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <h3 class="font-bold text-lg text-slate-800 mb-6 flex items-center gap-2">
            <i class="fa-solid fa-chart-column text-blue-500"></i> Biểu đồ chi tiết
        </h3>
        
        {{-- DỮ LIỆU ẨN CHO JS --}}
        <div id="chart-data" 
             data-labels="{{ json_encode($chartLabels) }}" 
             data-pharmacy="{{ json_encode($dataPharmacy) }}"
             data-booking="{{ json_encode($dataBooking) }}"
             class="hidden"></div>

        <div class="relative w-full h-[400px]">
            <canvas id="detailChart"></canvas>
        </div>
    </div>
</div>

{{-- SCRIPT --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('detailChart').getContext('2d');
        const storage = document.getElementById('chart-data');
        
        const labels = JSON.parse(storage.dataset.labels);
        const pharmacyData = JSON.parse(storage.dataset.pharmacy);
        const bookingData = JSON.parse(storage.dataset.booking);

        new Chart(ctx, {
            type: 'bar', // Dạng cột chồng (Stacked Bar)
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Nhà thuốc',
                        data: pharmacyData,
                        backgroundColor: '#10b981', // Green-500
                        borderRadius: 4,
                        barPercentage: 0.6
                    },
                    {
                        label: 'Đặt khám',
                        data: bookingData,
                        backgroundColor: '#8b5cf6', // Purple-500
                        borderRadius: 4,
                        barPercentage: 0.6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: { stacked: true, grid: { display: false } }, // Chồng cột lên nhau
                    y: { 
                        stacked: true, 
                        beginAtZero: true,
                        ticks: { callback: (val) => new Intl.NumberFormat('vi-VN').format(val) + 'đ' }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: (ctx) => ctx.dataset.label + ': ' + new Intl.NumberFormat('vi-VN').format(ctx.raw) + 'đ'
                        }
                    }
                }
            }
        });
    });
</script>
@endsection