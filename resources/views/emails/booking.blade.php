 <html>

 <head>
     <META http-equiv="Content-Type" content="text/html; charset=utf-8">
 </head>

 <body>
     <h3 style="text-align: center;">
         @switch($form)
         @case('combo_1')
         @case('form_1')
         {{ config('data.combo.combo_1.name', 'COMBO 2.370.000 VNĐ') }}
         @break

         @case('combo_2')
         @case('form_2')
         @case('form_4')
         {{ config('data.combo.combo_2.name', 'Siêu combo 2026 trả 1 được 8') }}
         @break

         @case('combo_cart')
         Đặt hàng giỏ hàng (nhiều combo)
         @break

         @case('form_3')
         {{ 'Ưu đãi đặc biệt - 6 CHAI RƯỢU VANG ELLETRA PRIMITIVO' }}
         @break

         @default
         {{ $form }}
         @break
         @endswitch
     </h3>
     <table align="center" cellspacing="0" cellpadding="6" width="100%"
         style="max-width:100%;background:#e9e9e9;padding:50px 0px;border:0;color:#000000;line-height:150%;text-align:left;font:300 14px/30px 'Helvetica Neue',Helvetica,Arial,sans-serif;"
         border=".5px">
         <tr width="100%">
             <th width="30%"
                 style="text-align:left;vertical-align:middle;border-left:1px solid #eee;border-bottom:1px solid #eee;border-right:0;border-top:0;word-wrap:break-word">
                 Loại combo / form
             </th>
             <td width="70%"
                 style="text-align:right;vertical-align:middle;border-left:1px solid #eee;border-bottom:1px solid #eee;border-right:0;border-top:0;font-weight:bold">
                 {{ $form_type ?? $form ?? '' }}
             </td>
         </tr>
         <tr width="100%">
             <th width="30%"
                 style="text-align:left;vertical-align:middle;border-left:1px solid #eee;border-bottom:1px solid #eee;border-right:0;border-top:0;word-wrap:break-word">
                 Tên Khách Hàng
             </th>
             <td width="70%"
                 style="text-align:right;vertical-align:middle;border-left:1px solid #eee;border-bottom:1px solid #eee;border-right:0;border-top:0">
                 {{ $customerName ?? '' }}
             </td>
         </tr>

         <tr width="100%">
             <th width="30%"
                 style="text-align:left;vertical-align:middle;border-left:1px solid #eee;border-bottom:1px solid #eee;border-right:0;border-top:0;word-wrap:break-word">
                 Số điện thoại
             </th>
             <td width="70%"
                 style="text-align:right;vertical-align:middle;border-left:1px solid #eee;border-bottom:1px solid #eee;border-right:0;border-top:0">
                 {{ $phone ?? '' }}
             </td>
         </tr>
         <tr width="100%">
             <th width="30%"
                 style="text-align:left;vertical-align:middle;border-left:1px solid #eee;border-bottom:1px solid #eee;border-right:0;border-top:0;word-wrap:break-word">
                 Địa chỉ nhận hàng
             </th>
             <td width="70%"
                 style="text-align:right;vertical-align:middle;border-left:1px solid #eee;border-bottom:1px solid #eee;border-right:0;border-top:0">
                 {{ $address ?? '' }}
             </td>
         </tr>

         <tr width="100%">
             <th width="30%"
                 style="text-align:left;vertical-align:middle;border-left:1px solid #eee;border-bottom:1px solid #eee;border-right:0;border-top:0;word-wrap:break-word">
                 Số lượng combo
             </th>
             <td width="70%"
                 style="text-align:right;vertical-align:middle;border-left:1px solid #eee;border-bottom:1px solid #eee;border-right:0;border-top:0">
                 {{ $count_combo ?? '1' }}
             </td>
         </tr>
         <tr width="100%">
             <th width="30%"
                 style="text-align:left;vertical-align:middle;border-left:1px solid #eee;border-bottom:1px solid #eee;border-right:0;border-top:0;word-wrap:break-word">
                 Chi tiết đơn hàng
             </th>
             <td width="70%"
                 style="text-align:left;vertical-align:top;border-left:1px solid #eee;border-bottom:1px solid #eee;border-right:0;border-top:0;white-space:pre-wrap;line-height:1.55;padding-top:8px;padding-bottom:8px">
                 {{ $note ?? '' }}
             </td>
         </tr>
     </table>

 </body>

 </html>