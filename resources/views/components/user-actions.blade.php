<div>
    @if($query->status->id == 1)
    <a href="express/edit/{{$query->id}}" 
       class="btn btn-sm btn-warning">
       <i class="bi bi-pencil"></i>
    </a>

    {{--
    <a href="express/show/{{$query->id}}" 
       class="btn btn-sm btn-primary">
       <i class="bi bi-eye"></i>
    </a>
    --}}

    
    <a onclick="confirm('برجاء تأكيد العملية') ? document.getElementById('delete{{ $query->id }}').submit() : '';" class="btn btn-sm btn-danger"> <i class="bi bi-trash"></i></a>

    <form action="{{ route('front.express.destroy',['shipment'=> $query->id]) }}" id="delete{{ $query->id }}" method="post">
        @csrf
        @method('POST')
    </form>
    @endif
</div>