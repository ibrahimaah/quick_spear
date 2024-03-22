<table id="customers" style="font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100vw;">
    <thead>
        <tr>
            <th style="text-align: center;padding: 20px">#</th>
            <th style="text-align: center;padding: 20px">Created At</th>
            <th style="text-align: center;padding: 20px">AWB</th>
            <th style="text-align: center;padding: 20px">Shipper</th>
            <th style="text-align: center;padding: 20px">Consignee</th>
            <th style="text-align: center;padding: 20px">phone</th>
            <th style="text-align: center;padding: 20px">City</th>
            <th style="text-align: center;padding: 20px">COD (JOD)</th>
            <th style="text-align: center;padding: 20px">Cost (JOD)</th>
            <th style="text-align: center;padding: 20px">Total (JOD)</th>
            @if($pdf == false)
                <th style="text-align: center;padding: 20px">Status</th>
            @endisset
        </tr>
    </thead>
    <tbody>
        @foreach ($shipments as $shipment)
            <tr>
                <th style="padding: 12px;text-align: center;" scope="row">{{ $loop->iteration }}</th>
                <td style="width: 70px;padding: 12px auto;text-align: center;">{{ $shipment['created_at'] }}</td>
                <td style="width: 70px;padding: 12px auto;text-align: center;">{{ $shipment['shipmentID'] }}</td>
                <td style="padding: 12px auto;text-align: center;">{{ $shipment['address']['name'] ?? '' }}</td>
                <td style="padding: 12px auto;text-align: center;">{{ $shipment['consignee_name'] }}</td>
                <td style="padding: 12px auto;text-align: center;">{{ $shipment['consignee_phone'] }}</td>
                @php
                if (is_null($shipment['consignee_city'])) {
                    $city_name = 'Not Recorded';
                }else{
                    $city =  \App\Models\City::where('id',$shipment['consignee_city']);
                    if ($city->count() > 0) {
                        $city_name = $city->first()->name;
                    }else {
                        $city_name = 'Not Recorded';
                    }
                }
                @endphp
                <td style="padding: 12px auto;text-align: center;">{{ $city_name ?? '' }}</td>
                <td style="padding: 12px auto;text-align: center;">{{ $shipment['cash_on_delivery_amount'] ?? '0' }}</td>
                <td style="padding: 12px auto;text-align: center;">{{ $shipment['collect_amount'] }}</td>
                <td style="padding: 12px auto;text-align: center;">{{ $shipment['cash_on_delivery_amount'] - ($shipment['collect_amount'] ?? 0) }}</td>
                @if ($pdf == false)
                   <td style="padding: 12px auto;text-align: center;">{{ $shipment->get_status() }}</td>           
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
