<div>
    <select class="form-select" aria-label="Default select example">
        <option selected>اختر حالة الشحنة</option>
        @foreach ($shipment_statuses as $shipment_status)
        <option value="{{ $shipment_status->id }}">{{ __($shipment_status->name) }}</option> 
        @endforeach
      </select>
</div>