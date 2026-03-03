<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Mandi Health') }} - Trợ lý sức khỏe AI</title>
    
    {{-- Font Awesome & Google Fonts --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    {{-- Leaflet CSS (Bản đồ) --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Hiệu ứng nút AI */
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .animate-bounce-slow {
            animation: bounce-slow 3s infinite;
        }
        /* Fix lỗi map Leaflet */
        .leaflet-container { z-index: 0; }
    </style>
</head>

<body class="font-sans antialiased bg-slate-50 text-slate-700 flex flex-col min-h-screen relative">
    
    {{-- HEADER --}}
    <header class="sticky top-0 z-40">
        <div class="bg-blue-600 text-white py-3 shadow-md relative z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center gap-4 lg:gap-8">
                
                {{-- LOGO --}}
                <a href="{{ route('dashboard') }}" class="flex flex-col shrink-0 group">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-heart-pulse text-2xl text-white group-hover:animate-pulse"></i>
                        <span class="font-black text-2xl tracking-tighter uppercase">MANDI</span>
                    </div>
                    <span class="text-[10px] md:text-xs text-blue-100 font-medium tracking-wide">TRỢ LÝ SỨC KHỎE AI & BÁC SĨ 24/7</span>
                </a>

                {{-- LOCATION (NÚT CHỌN VỊ TRÍ) --}}
                <div class="hidden lg:flex items-center gap-2 bg-blue-700/50 hover:bg-blue-700 transition px-4 py-2 rounded-full cursor-pointer border border-blue-500/30 max-w-[250px]">
                    <div class="relative group w-full">
                        <button onclick="openLocationModal()" class="flex items-center gap-2 w-full text-white text-sm font-medium">
                            <i class="fa-solid fa-location-dot"></i>
                            <span id="user-location-text" class="truncate">
                                {{ session('user_location', 'Hà Nội, Việt Nam') }}
                            </span>
                            <i class="fa-solid fa-chevron-down text-xs ml-auto"></i>
                        </button>
                    </div>
                </div>

                {{-- SEARCH BAR --}}
                <div class="flex-1 relative">
                    <form action="#" method="GET"> 
                        <input type="text" 
                               placeholder="Bạn đang cảm thấy thế nào? Nhập triệu chứng..." 
                               class="w-full pl-5 pr-12 py-2.5 rounded-full text-slate-800 focus:outline-none focus:ring-4 focus:ring-blue-400/50 shadow-inner text-sm font-medium">
                        <button type="submit" class="absolute right-1 top-1 bottom-1 bg-blue-600 text-white w-10 rounded-full hover:bg-blue-700 transition flex items-center justify-center">
                            <i class="fa-solid fa-magnifying-glass text-sm"></i>
                        </button>
                    </form>
                </div>

                {{-- USER ACTIONS --}}
                <div class="flex items-center gap-4 shrink-0">
                    @auth
                        <div class="relative group h-full flex items-center">
                            <button class="flex items-center gap-2 bg-blue-700/50 hover:bg-blue-700 py-2 px-4 rounded-full transition border border-blue-500/30">
                                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=fff&color=0D8ABC" class="w-6 h-6 rounded-full">
                                <span class="text-sm font-bold truncate max-w-[100px] hidden md:block">{{ Auth::user()->name }}</span>
                                <i class="fa-solid fa-caret-down text-xs"></i>
                            </button>

                            {{-- Dropdown Menu User --}}
                            <div class="absolute right-0 top-full pt-2 w-64 hidden group-hover:block z-50">
                                <div class="bg-white rounded-xl shadow-xl border border-slate-100 py-2 text-slate-700 overflow-hidden">
                                    <div class="px-4 py-2 border-b border-slate-50 bg-slate-50">
                                        <p class="text-xs text-slate-500">Xin chào,</p>
                                        <p class="font-bold text-blue-600 truncate">{{ Auth::user()->name }}</p>
                                    </div>
                                    
                                    @if(Auth::user()->role === 'admin')
                                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-blue-50 text-sm font-semibold">
                                            <i class="fa-solid fa-gauge-high mr-2 text-blue-500"></i> Trang quản trị
                                        </a>
                                    @endif
                                    
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-blue-50 text-sm font-semibold">
                                        <i class="fa-regular fa-user mr-2 text-slate-400"></i> Hồ sơ cá nhân
                                    </a>
                                    
                                    <a href="{{ route('booking.history') }}" class="block px-4 py-2 hover:bg-blue-50 text-sm font-semibold">
                                        <i class="fas fa-file-medical mr-2 text-slate-400"></i> Lịch sử khám bệnh
                                    </a>

                                    <a href="{{ route('my_orders.index') }}" class="block px-4 py-2 hover:bg-blue-50 text-sm font-semibold">
                                        <i class="fa-solid fa-clock-rotate-left mr-2 text-slate-400"></i> Lịch sử đơn hàng
                                    </a>

                                    <div class="border-t border-slate-100 my-1"></div>
                                    
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-red-500 hover:bg-red-50 text-sm font-bold">
                                            <i class="fa-solid fa-right-from-bracket mr-2"></i> Đăng xuất
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center gap-2 text-sm font-bold bg-white text-blue-600 px-4 py-2 rounded-full hover:bg-blue-50 transition shadow-sm">
                            <i class="fa-regular fa-user"></i>
                            <span class="hidden md:inline">Đăng nhập</span>
                        </a>
                    @endauth

                    {{-- CART BUTTON --}}
                    <a href="{{ route('cart.index') }}" class="relative mr-4 text-white/80 hover:text-white transition">
                        <i class="fa-solid fa-cart-shopping text-xl"></i>
                        @if(session('cart'))
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center border-2 border-white">
                                {{ count((array) session('cart')) }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>
        </div>

        {{-- MAIN NAVIGATION --}}
        <div class="bg-white border-b border-slate-200 shadow-sm hidden md:block relative z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <ul class="flex items-center gap-8 text-sm font-bold text-slate-600">
                    <li class="py-3 cursor-pointer text-blue-600 hover:text-blue-800 border-b-2 border-transparent hover:border-blue-600 transition flex items-center gap-2">
                        <a href="{{ route('ai.index') }}" class="flex items-center gap-2">
                            <i class="fa-solid fa-robot text-lg"></i> Chẩn đoán AI
                        </a>
                    </li>
                    <div class="w-px h-4 bg-slate-300 mx-2"></div>
                    
                    <li><a href="{{ route('doctors.index') }}" class="hover:text-blue-600 transition">Đặt lịch Bác sĩ</a></li>
                    
                    <div class="w-px h-4 bg-slate-300 mx-2"></div>

                    {{-- NHÀ THUỐC MENU --}}
                    <li class="relative group py-3 cursor-pointer hover:text-blue-600 transition">
                        <a href="{{ route('pharmacy.index') }}" class="flex items-center gap-1">
                            <span>Nhà thuốc Online</span> <i class="fa-solid fa-chevron-down text-[10px] opacity-50"></i>
                        </a>
                        <div class="absolute left-0 top-full pt-1 hidden group-hover:block w-56 z-50">
                            <div class="bg-white shadow-xl rounded-lg border border-slate-100 py-2">
                                <a href="{{ route('pharmacy.index', ['category' => 1]) }}" class="block px-4 py-2 hover:bg-slate-50 hover:text-blue-600">Thuốc kê đơn</a>
                                <a href="{{ route('pharmacy.index', ['category' => 2]) }}" class="block px-4 py-2 hover:bg-slate-50 hover:text-blue-600">Thực phẩm chức năng</a>
                                <a href="{{ route('pharmacy.index', ['category' => 3]) }}" class="block px-4 py-2 hover:bg-slate-50 hover:text-blue-600">Thiết bị y tế</a>
                                <a href="{{ route('pharmacy.index', ['category' => 4]) }}" class="block px-4 py-2 hover:bg-slate-50 hover:text-blue-600">Chăm sóc cá nhân</a>
                            </div>
                        </div>
                    </li>

                    <div class="w-px h-4 bg-slate-300 mx-2"></div>
                    
                    <a href="{{ route('news.index') }}" class="hover:text-blue-600 transition {{ request()->routeIs('news.*') ? 'text-blue-600' : '' }}">Góc sức khỏe</a>
                </ul>
            </div>
        </div>
    </header>

    {{-- CONTENT --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-slate-900 text-slate-300 py-12 mt-12 relative z-10">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-white font-black text-xl mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-heart-pulse text-blue-500"></i> MANDI
                </h3>
                <p class="text-sm leading-relaxed">Hệ thống Y tế thông minh, ứng dụng AI trong chẩn đoán sơ bộ và kết nối bác sĩ chuyên khoa hàng đầu.</p>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4">Dịch vụ chính</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('ai.index') }}" class="hover:text-white">Chẩn đoán bệnh qua AI</a></li>
                    <li><a href="{{ route('doctors.index') }}" class="hover:text-white">Đặt lịch khám bệnh</a></li>
                    <li><a href="{{ route('pharmacy.index') }}" class="hover:text-white">Nhà thuốc trực tuyến</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4">Hỗ trợ khách hàng</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-white">Hướng dẫn sử dụng</a></li>
                    <li><a href="#" class="hover:text-white">Chính sách bảo mật</a></li>
                    <li><a href="#" class="hover:text-white">Câu hỏi thường gặp</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4">Liên hệ</h4>
                <p class="text-sm"><i class="fa-solid fa-phone mr-2 text-blue-500"></i> 1900 1234</p>
                <p class="text-sm mt-2"><i class="fa-solid fa-envelope mr-2 text-blue-500"></i> contact@mandi.ai</p>
                <p class="text-sm mt-2"><i class="fa-solid fa-location-dot mr-2 text-blue-500"></i> Hà Nội, Việt Nam</p>
            </div>
        </div>
        <div class="border-t border-slate-800 mt-8 pt-8 text-center text-xs text-slate-500">
            &copy; {{ date('Y') }} Mandi Health AI. All rights reserved.
        </div>
    </footer>

    {{-- FLOATING BUTTON AI --}}
    <div class="fixed bottom-6 right-6 z-50 group">
        <div class="absolute bottom-full right-0 mb-3 w-64 p-3 bg-white rounded-xl shadow-xl border border-blue-100 opacity-0 group-hover:opacity-100 transition-opacity duration-300 transform translate-y-2 group-hover:translate-y-0 pointer-events-none">
            <p class="text-sm text-slate-600">
                👋 Chào bạn, mình là <strong>Mandi AI</strong>.
                <br>Bạn đang thấy mệt ở đâu? Hãy chat với mình nhé!
            </p>
            <div class="absolute top-full right-6 -mt-1 w-4 h-4 bg-white border-r border-b border-blue-100 transform rotate-45"></div>
        </div>
        <a href="{{ route('ai.index') }}" class="flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-full shadow-2xl hover:scale-110 transition-transform duration-300 animate-bounce-slow border-4 border-white">
            <i class="fa-solid fa-robot text-2xl"></i>
        </a>
    </div>

    {{-- MODAL BẢN ĐỒ (ĐỂ Ở CUỐI CÙNG CHO ĐỠ VƯỚNG) --}}
    <div id="locationModal" class="fixed inset-0 z-[9999] hidden">
        <div class="absolute inset-0 bg-black bg-opacity-50" onclick="closeLocationModal()"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white w-[90%] max-w-2xl rounded-xl shadow-2xl overflow-hidden animate-fade-in-up">
            <div class="bg-blue-600 text-white p-4 flex justify-between items-center">
                <h3 class="font-bold text-lg"><i class="fa-solid fa-map"></i> Chọn vị trí của bạn</h3>
                <button onclick="closeLocationModal()" class="hover:text-red-200"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>
            <div class="p-0 relative">
                <div id="map" class="w-full h-[400px]"></div>
                <button onclick="locateUser()" class="absolute bottom-4 right-4 z-[500] bg-white text-blue-600 p-3 rounded-full shadow-lg hover:bg-blue-50 border border-blue-100" title="Vị trí của tôi">
                    <i class="fa-solid fa-crosshairs text-xl"></i>
                </button>
            </div>
            <div class="p-4 bg-slate-50 flex justify-between items-center border-t">
                <p class="text-sm text-slate-500" id="address-preview">Đang chọn: <span class="font-bold text-slate-800">Chưa chọn</span></p>
                <button onclick="confirmLocation()" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition">
                    Xác nhận
                </button>
            </div>
        </div>
    </div>

    {{-- SCRIPTS (ĐẶT Ở CUỐI CÙNG ĐỂ KHÔNG BỊ LỖI MAP) --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        let map, marker;
        let currentLat = 21.028511; // Mặc định Hà Nội
        let currentLng = 105.804817;
        let currentAddress = "Hà Nội, Việt Nam";

        function openLocationModal() {
            document.getElementById('locationModal').classList.remove('hidden');
            if (!map) {
                setTimeout(() => { initMap(); }, 100);
            }
        }

        function closeLocationModal() {
            document.getElementById('locationModal').classList.add('hidden');
        }

        function initMap() {
            map = L.map('map').setView([currentLat, currentLng], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            marker = L.marker([currentLat, currentLng], {draggable: true}).addTo(map);

            map.on('click', function(e) { updateMarker(e.latlng.lat, e.latlng.lng); });
            marker.on('dragend', function(e) { 
                let position = marker.getLatLng(); 
                updateMarker(position.lat, position.lng); 
            });
        }

        function updateMarker(lat, lng) {
            marker.setLatLng([lat, lng]);
            currentLat = lat;
            currentLng = lng;

            document.getElementById('address-preview').innerHTML = 'Đang lấy địa chỉ...';
            
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(response => response.json())
                .then(data => {
                    let city = data.address.city || data.address.town || data.address.village || "";
                    // Xử lý chuỗi địa chỉ cho gọn
                    let displayName = data.display_name.split(',')[0];
                    if(city) displayName += ", " + city;
                    
                    currentAddress = displayName;
                    document.getElementById('address-preview').innerHTML = `Đang chọn: <span class="font-bold text-slate-800">${currentAddress}</span>`;
                })
                .catch(err => {
                    console.error(err);
                    document.getElementById('address-preview').innerHTML = 'Không lấy được tên đường.';
                });
        }

        function locateUser() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(position => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    map.setView([lat, lng], 15);
                    updateMarker(lat, lng);
                }, () => {
                    alert("Không thể lấy vị trí của bạn. Hãy kiểm tra quyền truy cập vị trí.");
                });
            }
        }

        function confirmLocation() {
            document.getElementById('user-location-text').innerText = currentAddress;
            closeLocationModal();
            saveLocationToSession(currentAddress);
        }

        function saveLocationToSession(address) {
            fetch('{{ route("update.location") }}', { 
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ location: address })
            });
        }
    </script>
</body>
</html>