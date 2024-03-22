@extends('admin.layouts.app')
@section('content')
<div class="row">
	<div class="col-sm-12">
	    <div class="card">
            <div class="card-header">
                <h5>الشركات</h5>
            </div>
	        <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>المستخدم</th>
                                <th>تحكم</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contacts as $contact)
                            <tr
                            id="ticket_{{$contact->id}}"
                            class="@if($contact->status=="DONE") ticket-resolved @endif"
                            >
                                <td>{{$contact->id}}</td>
                                <td>
                                    @if($contact->user_id!=null)
                                    <a href="{{route('admin.users.show',$contact->user)}}" class="d-inline-block text-center">
                                        {{-- <img src="{{$contact->user->getUserAvatar()}}" style="width: 45px;height: 45px;display: inline-block;border-radius: 50%!important;padding: 3px;" class="mx-auto" alt="صورة المستخدم"> --}}
                                        <span style="display: inline-block;position: relative;top: 6px; " class="px-2 pt-0  text-start kufi">{{$contact->user->name}}</span>
                                    </a>
                                    @else

                                        <img src="https://manager.almadarisp.com/user/img/user.png" style="width: 45px;height: 45px;display: inline-block;border-radius: 50%!important;padding: 3px;" class="mx-auto" alt="صورة المستخدم">
                                        <span style="display: inline-block;position: relative;top: 6px; " class="px-2 pt-0  text-start kufi">{{$contact->name}}<br>{{$contact->email}}<br>{{$contact->phone}}</span>


                                    @endif
                                </td>
                                <td style="width: 180px;">
                                    {{-- @can('view',$contact) --}}
                                    <a href="{{route('admin.contacts.show',$contact)}}">
                                    <span class="btn  btn-success btn-sm font-1 mx-1">
                                        <span class="fal fa-paper-plane"></span> مراسلة
                                    </span>
                                    </a>
                                    {{-- @endcan
                                    @can('delete',$contact) --}}
                                    <form method="POST" action="{{route('admin.contacts.destroy',$contact)}}" class="d-inline-block">@csrf @method("DELETE")
                                        <button class="btn  btn-outline-danger btn-sm font-1 mx-1" onclick="var result = confirm('هل أنت متأكد من عملية الحذف ؟');if(result){}else{event.preventDefault()}">
                                            <span class="fas fa-trash "></span> حذف
                                        </button>
                                    </form>
                                    {{-- @endif --}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
		    </div>
		</div>
	</div>
</div>
@endsection

