<table id="customers" style="font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100vw;">
    <thead>
        <tr>
            <th style="text-align: center;padding: 20px">#</th>
            <th style="text-align: center;padding: 20px">Created At</th>
            <th style="text-align: center;padding: 20px">Value (JOD)</th>
            <th style="text-align: center;padding: 20px">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transactions as $transaction)
            <tr>
                <th style="width: 70px;padding: 12px;text-align: center;" scope="row">{{ $loop->iteration }}</th>
                <td style="width: 250px;padding: 12px auto;text-align: center;">{{ $transaction->created_at }}</td>
                <td style="width: 100px;padding: 12px auto;text-align: center;">
                    {{ $shipments->sum('cash_on_delivery_amount') - ($shipments->sum('collect_amount') ?? 0) }}</td>
                <td style="width: 150px;padding: 12px auto;text-align: center;">{{ $transaction->get_status() }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
