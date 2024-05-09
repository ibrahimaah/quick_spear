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
       

        

        </style> 
	</head>

	<body>
		<h3 class="title">كشف استلام الطلبات</h3>
		
		
		<div class="invoice-box">
			<table id="invoice-table">
                <tr> 
                  <th colspan="4"><span>اسم الصفحة/المتجر : </span><span id="shop_name"></span></th>
                  <th colspan="3">اليوم :</th>
                </tr>
                <tr>
                    <th colspan="4">اسم العميل :</th>
                    <th colspan="3">التاريخ :</th>
                </tr>
                <tr>
                    <th>الرقم</th>
                    <th>العنوان</th>
                    <th>رقم الزبون</th>
                    <th>السعر</th>
                    <th>خصم التوصيل</th>
                    <th>حالة الشحنة</th>
                    <th>الملاحظات</th>
                </tr>
                @foreach ($selected_shipments as $selected_shipment)
                    <tr>
                        <td>{{ ++$loop->index }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="4">المدفوع:</th>
                    <th colspan="3" rowspan="2">اسم المندوب وتوقيعه :</th>
                </tr>
                <tr>
                    <th colspan="4">له :</th>
                </tr>
                <tr>
                    <th colspan="4">عليه :</th>
                    <th colspan="3">اسم المستلم وتوقيعه :</th>
                </tr>
              </table>
              
		</div>
	</body>
</html>