<div>
    <a href="{{ route('admin.shipments.edit',['shipment'=>$query->id])}}" 
       class="btn btn-sm btn-warning">
       <i class="bi bi-pencil"></i>
    </a>

    
    <a href="{{ route('admin.shipments.show',['shipment'=>$query->id])}}" 
       class="btn btn-sm btn-primary">
       <i class="bi bi-eye"></i>
    </a>
    

    
    <a onclick="confirm('برجاء تأكيد العملية') ? document.getElementById('delete_shipment{{ $query->id }}').submit() : '';" class="btn btn-sm btn-danger"> <i class="bi bi-trash"></i></a>

    <form action="{{ route('admin.shipments.destroy',['shipment'=>$query->id])}}" id="delete_shipment{{ $query->id }}" method="post">
        @csrf
        @method('DELETE')
    </form>
    
</div>