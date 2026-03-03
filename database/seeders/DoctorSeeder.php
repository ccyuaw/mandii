<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;
use App\Models\Specialty;

class DoctorSeeder extends Seeder
{
    public function run()
    {
        // 1. TẠO CÁC CHUYÊN KHOA (Nếu chưa có thì tạo mới)
        $khoaTimMach = Specialty::firstOrCreate(['name' => 'Tim mạch'], ['description' => 'Chuyên trị các bệnh lý về tim mạch, huyết áp.']);
        $khoaDaLieu = Specialty::firstOrCreate(['name' => 'Da liễu'], ['description' => 'Điều trị các vấn đề về da, tóc, móng và thẩm mỹ da.']);
        $khoaNhi = Specialty::firstOrCreate(['name' => 'Nhi khoa'], ['description' => 'Chăm sóc sức khỏe toàn diện cho trẻ sơ sinh và trẻ nhỏ.']);
        $khoaThanKinh = Specialty::firstOrCreate(['name' => 'Thần kinh'], ['description' => 'Chẩn đoán và điều trị các bệnh lý hệ thần kinh.']);

        // 2. DANH SÁCH BÁC SĨ MẪU
        $doctors = [
            [
                'name' => 'TS.BS Nguyễn Tâm Anh',
                'specialty_id' => $khoaTimMach->id,
                'phone' => '0912345678',
                'email' => 'tamanh@mandi.com',
                'price' => 500000,
                'bio' => 'Hơn 15 năm kinh nghiệm tại Viện Tim mạch Quốc gia. Chuyên gia hàng đầu về can thiệp tim mạch.',
                'avatar' => 'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&q=80&w=300', // Ảnh bác sĩ nam
            ],
            [
                'name' => 'ThS.BS Lê Thị Hồng Hoa',
                'specialty_id' => $khoaDaLieu->id,
                'phone' => '0987654321',
                'email' => 'honghoa@mandi.com',
                'price' => 300000,
                'bio' => 'Bác sĩ chuyên khoa Da liễu với nhiều năm tu nghiệp tại Pháp. Sở trường điều trị mụn và trẻ hóa da.',
                'avatar' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&q=80&w=300', // Ảnh bác sĩ nữ
            ],
            [
                'name' => 'BS.CKII Trần Văn Bình',
                'specialty_id' => $khoaNhi->id,
                'phone' => '0909090909',
                'email' => 'tranbinh@mandi.com',
                'price' => 250000,
                'bio' => 'Nguyên Trưởng khoa Nhi bệnh viện Nhi Đồng. Rất mát tay và yêu trẻ.',
                'avatar' => 'https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&q=80&w=300', // Ảnh bác sĩ nam già
            ],
            [
                'name' => 'ThS.BS Phạm Minh Tuấn',
                'specialty_id' => $khoaThanKinh->id,
                'phone' => '0911223344',
                'email' => 'minhtuan@mandi.com',
                'price' => 400000,
                'bio' => 'Chuyên điều trị đau đầu, mất ngủ, rối loạn tiền đình và các bệnh lý thần kinh khác.',
                'avatar' => 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&q=80&w=300', // Ảnh bác sĩ trẻ
            ],
            [
                'name' => 'BS. Đỗ Mỹ Linh',
                'specialty_id' => $khoaDaLieu->id,
                'phone' => '0888888888',
                'email' => 'mylinh@mandi.com',
                'price' => 350000,
                'bio' => 'Bác sĩ trẻ tài năng, chuyên sâu về laser thẩm mỹ và chăm sóc da công nghệ cao.',
                'avatar' => 'https://images.unsplash.com/photo-1594824476967-48c8b964273f?auto=format&fit=crop&q=80&w=300', // Ảnh bác sĩ nữ trẻ
            ]
        ];

        // 3. LƯU VÀO DATABASE
        foreach ($doctors as $doc) {
            Doctor::create($doc);
        }
    }
}