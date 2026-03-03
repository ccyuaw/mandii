@extends('layouts.app')

@section('content')
<div class="relative bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
            <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                <div class="sm:text-center lg:text-left">
                    <h1 class="text-4xl tracking-tight font-extrabold text-slate-900 sm:text-5xl md:text-6xl">
                        <span class="block xl:inline">Chăm sóc sức khỏe</span>
                        <span class="block text-blue-600 xl:inline">mọi lúc, mọi nơi</span>
                    </h1>
                    <p class="mt-3 text-base text-slate-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                        Mandi kết nối bạn với đội ngũ bác sĩ chuyên khoa hàng đầu. Tư vấn trực tuyến, đặt lịch khám nhanh chóng và quản lý hồ sơ sức khỏe thông minh.
                    </p>
                    <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                        <div class="rounded-md shadow">
                            <a href="{{ route('dashboard') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-bold rounded-full text-white bg-blue-600 hover:bg-blue-700 md:py-4 md:text-lg md:px-10 transition">
                                Đặt tư vấn ngay
                            </a>
                        </div>
                        <div class="mt-3 sm:mt-0 sm:ml-3">
                            <a href="{{ route('login') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-bold rounded-full text-blue-700 bg-blue-100 hover:bg-blue-200 md:py-4 md:text-lg md:px-10 transition">
                                Đăng nhập
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 bg-blue-50 flex items-center justify-center">
        <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="https://img.freepik.com/free-photo/team-young-specialist-doctors-standing-corridor-hospital_1303-21199.jpg" alt="Đội ngũ bác sĩ Mandi">
    </div>
</div>

<div class="py-12 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:text-center">
            <h2 class="text-base text-blue-600 font-semibold tracking-wide uppercase">Dịch vụ</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                Tại sao chọn Mandi?
            </p>
        </div>

        <div class="mt-10">
            <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-3 md:gap-x-8 md:gap-y-10">
                <div class="relative">
                    <dt>
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                            <i class="fa-solid fa-user-doctor text-xl"></i>
                        </div>
                        <p class="ml-16 text-lg leading-6 font-bold text-slate-900">Bác sĩ chuyên khoa</p>
                    </dt>
                    <dd class="mt-2 ml-16 text-base text-slate-500">
                        Đội ngũ bác sĩ giàu kinh nghiệm từ các bệnh viện lớn, sẵn sàng tư vấn đa dạng chuyên khoa.
                    </dd>
                </div>

                <div class="relative">
                    <dt>
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                            <i class="fa-regular fa-clock text-xl"></i>
                        </div>
                        <p class="ml-16 text-lg leading-6 font-bold text-slate-900">Hỗ trợ 24/7</p>
                    </dt>
                    <dd class="mt-2 ml-16 text-base text-slate-500">
                        Bất kể ngày hay đêm, bạn luôn có thể kết nối với bác sĩ để giải đáp thắc mắc sức khỏe.
                    </dd>
                </div>

                <div class="relative">
                    <dt>
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                            <i class="fa-solid fa-file-shield text-xl"></i>
                        </div>
                        <p class="ml-16 text-lg leading-6 font-bold text-slate-900">Bảo mật thông tin</p>
                    </dt>
                    <dd class="mt-2 ml-16 text-base text-slate-500">
                        Hồ sơ bệnh án và thông tin cá nhân của bạn được bảo mật tuyệt đối theo tiêu chuẩn quốc tế.
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</div>
@endsection