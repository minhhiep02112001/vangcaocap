ĐƠN ĐẶT HÀNG MỚI — The Best Wine
Loại combo / form: {{ $form_type }}
Sản phẩm: @switch($form)
@case('combo_1')@case('form_1'){{ config('data.combo.combo_1.name') }}@break
@case('combo_2')@case('form_2'){{ config('data.combo.combo_2.name') }}@break
@default{{ $form }}@break
@endswitch
Thời gian: {{ $created_at }}

Tên khách: {{ $customerName }}
Điện thoại: {{ $phone }}
Địa chỉ: {{ $address }}
Số lượng combo: {{ $count_combo ?? '1' }}

Chi tiết đơn hàng:
{{ $order_detail ?? $note ?? '—' }}

@if(!empty($customer_note))
Ghi chú khách hàng:
{{ $customer_note }}
@endif