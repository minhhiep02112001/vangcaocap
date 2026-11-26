ĐƠN ĐẶT HÀNG MỚI -
Loại combo / form: {{ $form_type }}
Sản phẩm: @switch($form)
@case('combo_1')@case('form_1'){{ config('data.combo.combo_1.name', 'Combo 1') }}@break
@case('combo_2')@case('form_2')@case('form_4'){{ config('data.combo.combo_2.name', 'Combo 2') }}@break
@case('combo_cart')Đặt hàng giỏ hàng@break
@default{{ $form_type ?? $form }}@break
@endswitch
Thời gian: {{ $created_at }}

Tên khách: {{ $customerName }}
Điện thoại: {{ $phone }}
Địa chỉ: {{ $address }}
Số lượng combo: {{ $count_combo ?? '1' }}

Chi tiết đơn hàng:
{{ $note ?? '—' }}