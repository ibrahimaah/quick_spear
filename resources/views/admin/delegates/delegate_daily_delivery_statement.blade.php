<!DOCTYPE html>
<html lang="ar" dir="rtl">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<title>كشف استلام الطلبات</title>

		<!-- Favicon -->
		<link rel="icon" href="./images/favicon.png" type="image/x-icon" />

		<!-- Invoice styling -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
        <style>
            
            * { font-family: DejaVu Sans, sans-serif; }
            body {
                direction: rtl; /* Right-to-left direction */
                text-align: right; /* Text alignment */
            }
            .title{
                text-align: center !important;
            }
            td, th {
                border: 1px solid #dddddd;
                text-align: right;
                padding: 8px;
            }
            #invoice-table {
                width: 100%;
                border-collapse: collapse;
            }
            .text-center{
                text-align: center !important;  
            }
       

        

        </style> 
	</head>

	<body>
		<h3 class="title">كشف تسليم</h3>
		<h3 class="title">يومي</h3>
		
		
		<div class="invoice-box">
			<table id="invoice-table">
                <tr> 
                  <th colspan="2" class="text-center">{{ $statement['current_day'] }}</th>
                  <th colspan="3" class="text-center">{{ $delegate->name }}</th>
                  <th colspan="3" class="text-center">{{ $statement['current_date'] }}</th> 
                </tr>
             
                <tr class="text-center">
                    <th>الرقم</th>
                    <th>المدينة</th>
                    <th>المنطقة</th>
                    <th>المتجر</th>
                    <th>التحصيل</th>
                    <th>حالة الطلب</th>
                    <th>هاتف الزبون</th>
                    <th>ملاحظات جانبية</th>
                </tr>
                @foreach ($delegate->shipments as $shipment)
                    <tr> 
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $shipment->city_to->name }}</td>
                        <td>{{ $shipment->consignee_region }}</td>
                        <td>{{ $shipment->shop->name }}</td> 
                        <td>{{ $shipment->order_price }}</td> 
                        <td>{{ getStatusInfo($shipment->status) }}</td>
                        <td>{{ $shipment->consignee_phone }}</td>
                        <td>{{ $shipment->notes }}</td>
                        
                    </tr>
                @endforeach
                {{-- <tr>
                    <th colspan="4">المدفوع:</th>
                    <th colspan="3" rowspan="2">اسم المندوب وتوقيعه :</th>
                </tr>
                <tr>
                    <th colspan="4">له :</th>
                </tr>
                <tr>
                    <th colspan="4">عليه :</th>
                    <th colspan="3">اسم المستلم وتوقيعه :</th>
                </tr> --}}
              </table>
              
		</div>
	</body>
</html>