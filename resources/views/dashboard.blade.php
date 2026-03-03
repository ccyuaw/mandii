@extends('layouts.app')

@section('content')
<div class="bg-white">
    
    {{-- 1. BANNER HERO (Giữ nguyên bố cục nhưng tinh chỉnh khoảng cách) --}}
    <div class="relative bg-gradient-to-r from-blue-50 to-indigo-50 py-16 lg:py-24 overflow-hidden">
        {{-- Hình trang trí nền (Blob animation) --}}
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                
                {{-- Text giới thiệu --}}
                <div class="space-y-8 text-center lg:text-left"> {{-- Mobile căn giữa, PC căn trái --}}
                    <div>
                        <span class="inline-block py-1.5 px-4 rounded-full bg-blue-100 text-blue-700 text-sm font-bold tracking-wide mb-4">
                            ✨ Nền tảng Y tế Công nghệ cao 2026
                        </span>
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-900 leading-tight">
                            Tư vấn y tế từ xa <br>
                            <span class="text-blue-600">Nhanh chóng & Tiện lợi</span>
                        </h1>
                    </div>
                    
                    <p class="text-lg md:text-xl text-slate-600 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        Kết nối ngay với các bác sĩ chuyên khoa hàng đầu qua Video Call. 
                        Chẩn đoán sơ bộ miễn phí với AI Trợ lý sức khỏe 24/7. 
                        Chăm sóc sức khỏe gia đình bạn mọi lúc, mọi nơi.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('ai.index') }}" class="px-8 py-4 bg-blue-600 text-white rounded-xl font-bold shadow-lg hover:bg-blue-700 hover:shadow-blue-500/30 transition transform hover:-translate-y-1 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-robot text-xl"></i> 
                            <span>Chẩn đoán với AI</span>
                        </a>
                        <a href="{{ route('doctors.index') }}" class="px-8 py-4 bg-white text-blue-600 border-2 border-blue-100 rounded-xl font-bold hover:bg-blue-50 hover:border-blue-200 transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-calendar-check text-xl"></i> 
                            <span>Đặt lịch Bác sĩ</span>
                        </a>
                    </div>
                </div>

                {{-- Hình ảnh minh họa --}}
                <div class="hidden lg:block relative group">
                    <img src="https://img.freepik.com/free-vector/doctor-consulting-patient-online-via-smartphone-screen_74855-5464.jpg" 
                         alt="Doctor Online" 
                         class="relative rounded-3xl shadow-2xl border-4 border-white transform rotate-2 group-hover:rotate-0 transition duration-700 ease-in-out">
                </div>
            </div>
        </div>
    </div>

    {{-- 2. PHẦN BÀI VIẾT GIỚI THIỆU (Đã căn chỉnh cân đối) --}}
    <div class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header bài viết (Căn giữa hoàn toàn) --}}
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6">
                    Tại sao bạn nên chọn <span class="text-blue-600">MANDI?</span>
                </h2>
                <p class="text-lg text-slate-600 leading-relaxed">
                    Tư vấn y tế trực tuyến với bác sĩ qua video call không chỉ là xu hướng mà còn là giải pháp tối ưu: giúp bạn tiết kiệm thời gian, giảm chi phí đi lại và đảm bảo an toàn sức khỏe trong mọi tình huống.
                </p>
                <div class="w-24 h-1 bg-blue-600 mx-auto mt-8 rounded-full opacity-20"></div>
            </div>

            {{-- Grid Lợi ích (3 cột cân đối) --}}
            <div class="grid md:grid-cols-3 gap-10 mb-16">
                {{-- Card 1 --}}
                <div class="bg-slate-50 rounded-3xl p-8 text-center hover:shadow-xl transition duration-300 border border-slate-100 group">
                    <div class="w-20 h-20 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl group-hover:scale-110 transition duration-300">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <h3 class="font-bold text-xl text-slate-800 mb-3">Tiết kiệm thời gian</h3>
                    <p class="text-slate-600 leading-relaxed">Không cần xếp hàng bốc số, không chờ đợi mệt mỏi tại bệnh viện. Khám ngay tại nhà chỉ với một chạm.</p>
                </div>

                {{-- Card 2 --}}
                <div class="bg-slate-50 rounded-3xl p-8 text-center hover:shadow-xl transition duration-300 border border-slate-100 group">
                    <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl group-hover:scale-110 transition duration-300">
                        <i class="fa-solid fa-shield-virus"></i>
                    </div>
                    <h3 class="font-bold text-xl text-slate-800 mb-3">An toàn tuyệt đối</h3>
                    <p class="text-slate-600 leading-relaxed">Hạn chế tối đa nguy cơ lây nhiễm chéo nơi đông người. Bảo mật tuyệt đối hồ sơ bệnh án cá nhân.</p>
                </div>

                {{-- Card 3 --}}
                <div class="bg-slate-50 rounded-3xl p-8 text-center hover:shadow-xl transition duration-300 border border-slate-100 group">
                    <div class="w-20 h-20 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl group-hover:scale-110 transition duration-300">
                        <i class="fa-solid fa-user-doctor"></i>
                    </div>
                    <h3 class="font-bold text-xl text-slate-800 mb-3">Đội ngũ Bác sĩ giỏi</h3>
                    <p class="text-slate-600 leading-relaxed">Kết nối trực tiếp với mạng lưới bác sĩ chuyên khoa giàu kinh nghiệm từ các bệnh viện tuyến đầu.</p>
                </div>
            </div>

            {{-- Footer bài viết (Căn giữa) --}}
            <div class="text-center max-w-4xl mx-auto bg-blue-50 rounded-3xl p-8 md:p-12">
                <p class="text-xl md:text-2xl font-medium text-slate-800 leading-relaxed mb-6">
                    "Với MANDI, sức khỏe của bạn và gia đình luôn được đặt lên hàng đầu. Hệ thống AI thông minh hỗ trợ sàng lọc triệu chứng ban đầu, giúp bạn kết nối đúng bác sĩ chuyên khoa cần thiết."
                </p>
                <div class="flex items-center justify-center gap-3">
                    <img src="https://ui-avatars.com/api/?name=Mandi+AI&background=0D8ABC&color=fff" class="w-10 h-10 rounded-full">
                    <span class="font-bold text-slate-600 uppercase tracking-widest text-sm">Đội ngũ phát triển Mandi</span>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection