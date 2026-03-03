<?php

return [
    // ====================================================
    // NHÓM 1: CẤP CỨU & TRIỆU CHỨNG NGUY HIỂM (Ưu tiên số 1)
    // ====================================================
    [
        'keywords' => ['đột quỵ', 'tai biến', 'méo miệng', 'yếu tay chân', 'nói ngọng'],
        'answer' => "⚠️ <b>KHẨN CẤP: Dấu hiệu Đột quỵ (Quy tắc F.A.S.T)</b><br>
        - <b>Face (Mặt):</b> Cười có bị méo một bên không?<br>
        - <b>Arm (Tay):</b> Giơ 2 tay lên, 1 tay có bị rơi xuống không?<br>
        - <b>Speech (Lời nói):</b> Nói có bị dính chữ, khó hiểu không?<br>
        - <b>Time (Thời gian):</b> Nếu có dấu hiệu trên, gọi <b>115</b> ngay lập tức.<br>
        👉 <b>Hành động:</b> Đặt bệnh nhân nằm nghiêng an toàn, nới lỏng quần áo. Tuyệt đối KHÔNG cho ăn uống, KHÔNG cạo gió hay dùng kim châm đầu ngón tay."
    ],
    [
        'keywords' => ['đau ngực', 'nhồi máu cơ tim', 'tức ngực trái', 'đau tim'],
        'answer' => "⚠️ <b>KHẨN CẤP: Nghi ngờ Nhồi máu cơ tim</b><br>
        Nếu đau thắt ngực trái lan lên vai, cổ hoặc tay trái, vã mồ hôi lạnh, khó thở:<br>
        1. Gọi cấp cứu <b>115</b> ngay.<br>
        2. Ngừng mọi vận động, ngồi nghỉ hoặc nằm đầu cao.<br>
        3. Nới rộng quần áo cho thoáng khí.<br>
        4. Nếu bệnh nhân đã từng được bác sĩ kê thuốc giãn mạch (Nitroglycerin), hãy dùng ngay theo hướng dẫn cũ."
    ],
    [
        'keywords' => ['huyết áp cao', 'tăng huyết áp', 'lên tăng xông'],
        'answer' => "<b>Xử lý Tăng Huyết Áp (Khi HA > 140/90 mmHg):</b><br>
        1. <b>Nghỉ ngơi:</b> Nằm nghỉ nơi yên tĩnh, thoáng mát ít nhất 15 phút, thả lỏng cơ thể.<br>
        2. <b>Dùng thuốc:</b> Nếu đã có đơn bác sĩ, hãy uống thuốc hạ áp hằng ngày ngay nếu quên.<br>
        3. <b>Theo dõi:</b> Đo lại sau 30 phút. Nếu vẫn trên 180/110 mmHg hoặc kèm đau đầu dữ dội, mờ mắt, buồn nôn -> <b>Đi viện ngay</b> (Nguy cơ tai biến)."
    ],
    [
        'keywords' => ['huyết áp thấp', 'tụt huyết áp', 'chóng mặt', 'xây xẩm'],
        'answer' => "<b>Sơ cứu Tụt Huyết Áp:</b><br>
        1. <b>Tư thế:</b> Nằm xuống ngay lập tức, kê chân cao hơn đầu (để máu dồn về não).<br>
        2. <b>Bù dịch:</b> Uống 1 cốc nước ấm, trà gừng, nước chanh đường, nước sâm hoặc cà phê đậm.<br>
        3. <b>Lưu ý:</b> Ngồi dậy từ từ để tránh ngất xỉu. Nếu ngất, hãy đưa đến cơ sở y tế."
    ],
    [
        'keywords' => ['co giật', 'động kinh'],
        'answer' => "⚠️ <b>Sơ cứu Co giật:</b><br>
        1. <b>An toàn:</b> Đặt bệnh nhân nằm nghiêng sang một bên, kê gối mềm dưới đầu. Di dời vật sắc nhọn xung quanh.<br>
        2. <b>KHÔNG:</b> Không đè chặt, không giữ tay chân, KHÔNG nhét bất cứ vật gì vào miệng (nguy cơ gãy răng hoặc hóc).<br>
        3. <b>Theo dõi:</b> Ghi lại thời gian cơn co giật. Nếu kéo dài trên 5 phút hoặc lặp lại nhiều lần -> Gọi <b>115</b>."
    ],

    // ====================================================
    // NHÓM 2: SỐT & HÔ HẤP (Chăm sóc tại nhà)
    // ====================================================
    [
        'keywords' => ['sốt cao', 'sốt trẻ em', 'người lớn sốt', 'nóng sốt'],
        'answer' => "<b>Hướng dẫn hạ sốt an toàn:</b><br>
        1. <b>Hạ nhiệt vật lý:</b> Nới lỏng quần áo, chườm ấm (nước 37°C) vào trán, nách, bẹn. Lau người nhẹ nhàng.<br>
        2. <b>Dùng thuốc:</b> Chỉ dùng Paracetamol khi sốt > 38.5°C. Liều lượng: 10-15mg/kg cân nặng/lần, cách nhau 4-6h.<br>
        3. <b>Bù nước (Rất quan trọng):</b> Uống Oresol (pha đúng tỷ lệ), nước dừa, nước cam.<br>
        ⚠️ <b>Cảnh báo:</b> Sốt > 39.5°C không hạ, co giật, li bì hoặc nghi ngờ sốt xuất huyết (chấm đỏ dưới da) cần nhập viện ngay."
    ],
    [
        'keywords' => ['chảy máu cam', 'máu mũi'],
        'answer' => "<b>Sơ cứu Chảy máu cam đúng cách:</b><br>
        ❌ <b>SAI:</b> Không ngửa cổ ra sau (máu chảy ngược vào họng gây sặc/nôn).<br>
        ✅ <b>ĐÚNG:</b><br>
        1. Ngồi thẳng, đầu hơi cúi về phía trước.<br>
        2. Dùng ngón tay cái và trỏ bóp chặt 2 cánh mũi trong <b>10-15 phút</b> liên tục (thở bằng miệng).<br>
        3. Chườm lạnh vùng gốc mũi để co mạch.<br>
        4. Nếu sau 15-20 phút máu vẫn chảy, hãy đến bệnh viện (chuyên khoa Tai Mũi Họng)."
    ],
    [
        'keywords' => ['nghẹt đường thở', 'hóc dị vật', 'nghẹn', 'hóc xương'],
        'answer' => "⚠️ <b>Sơ cứu Hóc dị vật đường thở (Nghiệm pháp Heimlich):</b><br>
        1. Đứng sau lưng nạn nhân, vòng tay ôm eo.<br>
        2. Một tay nắm đấm đặt lên vùng thượng vị (trên rốn, dưới xương ức), tay kia nắm lấy tay đấm.<br>
        3. Giật mạnh dứt khoát theo hướng <b>từ trước ra sau, từ dưới lên trên</b> 5 lần.<br>
        4. Lặp lại đến khi dị vật bật ra hoặc nạn nhân thở được.<br>
        *Nếu hóc xương cá nhỏ: Không nuốt cơm to, nên đến bác sĩ gắp ra để tránh tổn thương thực quản."
    ],
    [
        'keywords' => ['ho', 'đau họng', 'viêm họng'],
        'answer' => "<b>Chăm sóc giảm Ho & Đau họng:</b><br>
        1. Súc miệng nước muối sinh lý ấm 2-3 lần/ngày.<br>
        2. Uống nhiều nước ấm, trà mật ong gừng chanh.<br>
        3. Giữ ấm vùng cổ, ngực.<br>
        4. Nếu ho kéo dài trên 2 tuần, ho ra máu hoặc kèm sốt cao, tức ngực -> Cần đi khám phổi."
    ],

    // ====================================================
    // NHÓM 3: TIÊU HÓA (Vấn đề dạ dày, ruột)
    // ====================================================
    [
        'keywords' => ['tiêu chảy', 'ngộ độc thức ăn', 'ỉa chảy', 'đi ngoài'],
        'answer' => "<b>Xử lý Tiêu chảy cấp & Bù nước:</b><br>
        1. <b>Bù nước (Quan trọng số 1):</b> Uống Oresol (pha đúng tỷ lệ, uống từng ngụm nhỏ sau mỗi lần đi ngoài).<br>
        2. <b>Dinh dưỡng:</b> Ăn cháo loãng, thịt nạc, cà rốt, chuối, táo. Tránh sữa bò, nước ngọt, đồ dầu mỡ, cay nóng.<br>
        3. <b>Thuốc:</b> Có thể dùng Smecta (bảo vệ niêm mạc) hoặc Men vi sinh. KHÔNG tự ý dùng thuốc cầm đi ngoài (Loperamid) nếu nghi ngờ ngộ độc (để cơ thể thải độc).<br>
        ⚠️ <b>Đi viện nếu:</b> Phân có máu, sốt cao, nôn nhiều hoặc khát nước dữ dội (dấu hiệu mất nước nặng)."
    ],
    [
        'keywords' => ['đau dạ dày', 'đau bao tử', 'trào ngược'],
        'answer' => "<b>Giảm đau Dạ dày & Trào ngược:</b><br>
        1. Uống 1 cốc nước ấm từng ngụm nhỏ để trung hòa axit.<br>
        2. Ăn nhẹ bánh mì hoặc bánh quy (thấm hút dịch vị).<br>
        3. Có thể dùng thuốc trung hòa axit (dạng sữa gói chữ P, Y, G) có bán tại nhà thuốc.<br>
        4. Tránh nằm ngay sau ăn, nằm nghiêng bên trái khi ngủ.<br>
        5. Kiêng: Chua, cay, cà phê, rượu bia, thuốc lá."
    ],
    [
        'keywords' => ['táo bón', 'khó đi cầu'],
        'answer' => "<b>Cải thiện Táo bón:</b><br>
        1. <b>Nước:</b> Uống đủ 2-2.5 lít nước/ngày.<br>
        2. <b>Chất xơ:</b> Ăn nhiều rau xanh (mồng tơi, rau lang), khoai lang, đu đủ, thanh long.<br>
        3. <b>Vận động:</b> Tập thể dục, xoa bụng theo chiều kim đồng hồ.<br>
        4. Có thể dùng thuốc nhuận tràng nhẹ (Duphalac/Sorbitol) nếu cần thiết, nhưng không lạm dụng."
    ],

    // ====================================================
    // NHÓM 4: CƠ XƯƠNG KHỚP & CHẤN THƯƠNG
    // ====================================================
    [
        'keywords' => ['bong gân', 'trẹo chân', 'sưng chân', 'chấn thương'],
        'answer' => "<b>Sơ cứu chấn thương phần mềm (Nguyên tắc R.I.C.E):</b><br>
        1. <b>R - Rest (Nghỉ ngơi):</b> Hạn chế vận động vùng bị đau ngay lập tức.<br>
        2. <b>I - Ice (Chườm lạnh):</b> Chườm đá bọc khăn trong 15-20 phút (giảm sưng, giảm đau). KHÔNG chườm nóng/dầu nóng trong 48h đầu.<br>
        3. <b>C - Compression (Băng ép):</b> Băng thun nhẹ nhàng để cố định và giảm sưng.<br>
        4. <b>E - Elevation (Kê cao):</b> Kê cao vùng bị thương hơn mức tim để giảm phù nề."
    ],
    [
        'keywords' => ['chuột rút', 'vọp bẻ', 'co rút cơ'],
        'answer' => "<b>Xử lý Chuột rút ngay lập tức:</b><br>
        1. <b>Kéo dãn cơ:</b> Nếu bị ở bắp chân, duỗi thẳng chân và bẻ ngược mũi chân về phía mặt mình. Giữ nguyên tư thế.<br>
        2. <b>Xoa bóp:</b> Xoa nhẹ nhàng làm ấm vùng cơ bị co rút.<br>
        3. <b>Phòng ngừa:</b> Uống đủ nước, bổ sung điện giải (Canxi, Magie, Kali) có trong chuối, sữa, nước dừa. Khởi động kỹ trước khi vận động."
    ],
    [
        'keywords' => ['đau lưng', 'thoát vị đĩa đệm', 'đau thắt lưng'],
        'answer' => "<b>Chăm sóc Đau lưng cấp:</b><br>
        1. Nghỉ ngơi trên đệm cứng vừa phải, tránh nằm võng/ghế mềm.<br>
        2. Chườm ấm vùng thắt lưng 20 phút/lần.<br>
        3. Tránh cúi gập người, bê vác nặng sai tư thế.<br>
        4. Tập các bài tập nhẹ nhàng cho lưng (yoga, bơi lội). Nếu đau lan xuống chân, tê bì -> Khám chuyên khoa Cột sống."
    ],

    // ====================================================
    // NHÓM 5: DA LIỄU, DỊ ỨNG & CÔN TRÙNG
    // ====================================================
    [
        'keywords' => ['bỏng', 'phỏng', 'bỏng nước sôi'],
        'answer' => "<b>Sơ cứu Bỏng đúng cách:</b><br>
        1. <b>Làm mát ngay:</b> Ngâm vùng bỏng vào nước mát (nước vòi) sạch trong <b>15-20 phút</b>. (Tuyệt đối KHÔNG dùng đá lạnh, nước mắm, kem đánh răng).<br>
        2. <b>Bảo vệ:</b> Che phủ bằng gạc sạch hoặc vải sạch để tránh nhiễm trùng.<br>
        3. <b>Lưu ý:</b> Không chọc vỡ bọng nước.<br>
        4. Nếu bỏng diện rộng, bỏng điện, hóa chất hoặc ở vùng mặt, bàn tay -> Đi viện ngay."
    ],
    [
        'keywords' => ['dị ứng', 'mề đay', 'ngứa', 'nổi mẩn'],
        'answer' => "<b>Xử lý Dị ứng/Mề đay cấp tính:</b><br>
        1. <b>Cách ly:</b> Ngừng ngay tiếp xúc với tác nhân nghi ngờ (thức ăn, thuốc, mỹ phẩm, lông thú).<br>
        2. <b>Giảm ngứa:</b> Chườm mát. Có thể dùng thuốc kháng Histamin (Loratadin, Fexofenadin, Cetirizin) thông dụng tại nhà thuốc.<br>
        3. <b>Cảnh báo Sốc phản vệ:</b> Nếu kèm khó thở, sưng môi/mắt, nôn mửa, tụt huyết áp -> <b>Gọi 115 ngay</b>."
    ],
    [
        'keywords' => ['ong đốt', 'côn trùng cắn', 'kiến ba khoang'],
        'answer' => "<b>Sơ cứu Côn trùng đốt:</b><br>
        1. <b>Ong đốt:</b> Khều nhẹ ngòi ong ra (nếu thấy). Rửa sạch bằng xà phòng. Chườm lạnh giảm đau.<br>
        2. <b>Kiến ba khoang:</b> Rửa nhẹ nhàng dưới vòi nước chảy, dùng hồ nước hoặc mỡ Corticoid bôi dịu. Tránh chà xát làm lan độc tố.<br>
        3. Nếu bị đốt nhiều nốt, sưng phù nề lớn hoặc khó thở -> Đi viện ngay."
    ],

    // ====================================================
    // NHÓM 6: BỆNH MÃN TÍNH & THÔNG TIN CHUNG
    // ====================================================
    [
        'keywords' => ['tiểu đường', 'đái tháo đường', 'đường huyết'],
        'answer' => "<b>Lời khuyên cho người Tiểu đường:</b><br>
        1. <b>Dinh dưỡng:</b> Ăn nhiều rau xanh, ngũ cốc nguyên hạt. Hạn chế tinh bột trắng, bánh kẹo ngọt, trái cây quá ngọt (mít, vải, sầu riêng). Chia nhỏ bữa ăn.<br>
        2. <b>Vận động:</b> Đi bộ hoặc tập thể dục ít nhất 30 phút/ngày.<br>
        3. <b>Theo dõi:</b> Kiểm tra đường huyết thường xuyên. Tuân thủ thuốc bác sĩ kê.<br>
        4. Chăm sóc bàn chân kỹ lưỡng, tránh vết thương lâu lành."
    ],
    [
        'keywords' => ['mỡ máu', 'cholesterol'],
        'answer' => "<b>Kiểm soát Mỡ máu cao:</b><br>
        1. <b>Ăn uống:</b> Giảm mỡ động vật, nội tạng, da gà/vịt, đồ chiên rán. Tăng cường cá (Omega-3), dầu thực vật, rau quả.<br>
        2. <b>Lối sống:</b> Bỏ thuốc lá, hạn chế rượu bia, giảm cân nếu thừa cân.<br>
        3. Tái khám định kỳ để theo dõi chỉ số Cholesterol và Triglyceride."
    ],
    [
        'keywords' => ['mất ngủ', 'khó ngủ'],
        'answer' => "<b>Vệ sinh giấc ngủ (Cải thiện mất ngủ):</b><br>
        1. Tạo thói quen đi ngủ và thức dậy đúng giờ.<br>
        2. Phòng ngủ tối, yên tĩnh, thoáng mát. Tránh ánh sáng xanh (điện thoại, TV) trước khi ngủ 1 tiếng.<br>
        3. Tránh cà phê, trà đậm sau 3h chiều.<br>
        4. Có thể dùng trà tâm sen, lạc tiên hoặc ngâm chân nước ấm trước khi ngủ."
    ],

    // ====================================================
    // NHÓM 7: SỨC KHỎE PHỤ NỮ & TRẺ EM
    // ====================================================
    [
        'keywords' => ['có thai', 'mang bầu', 'thai nghén', 'bà bầu'],
        'answer' => "<b>Lưu ý sức khỏe Thai kỳ:</b><br>
        1. <b>Dinh dưỡng:</b> Bổ sung Sắt, Canxi, Axit Folic theo chỉ định. Ăn chín uống sôi.<br>
        2. <b>Dấu hiệu nguy hiểm:</b> Đau bụng dữ dội, ra máu âm đạo, hoa mắt chóng mặt, thai máy ít -> <b>Đi khám ngay</b>.<br>
        3. Khám thai định kỳ đúng lịch hẹn để sàng lọc dị tật và theo dõi sức khỏe mẹ bé."
    ],
    [
        'keywords' => ['kinh nguyệt', 'đau bụng kinh'],
        'answer' => "<b>Giảm đau bụng kinh:</b><br>
        1. Chườm ấm vùng bụng dưới.<br>
        2. Uống nước ấm, trà gừng.<br>
        3. Nghỉ ngơi, massage nhẹ nhàng.<br>
        4. Có thể dùng thuốc giảm đau thông thường (Paracetamol, Ibuprofen) nếu đau nhiều.<br>
        5. Nếu đau dữ dội, rong kinh kéo dài -> Cần đi khám phụ khoa (loại trừ lạc nội mạc, u xơ)."
    ],
    [
        'keywords' => ['trẻ biếng ăn', 'bé lười ăn'],
        'answer' => "<b>Cải thiện tình trạng biếng ăn ở trẻ:</b><br>
        1. Không ép trẻ ăn, tạo không khí bữa ăn vui vẻ.<br>
        2. Đa dạng thực đơn, trang trí món ăn bắt mắt.<br>
        3. Hạn chế ăn vặt trước bữa chính.<br>
        4. Bổ sung vi chất (Kẽm, Lysine, Vitamin nhóm B) nếu có chỉ định của bác sĩ.<br>
        5. Tẩy giun định kỳ cho trẻ trên 2 tuổi."
    ]
];