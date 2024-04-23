@extends('admin.layouts.app')
@section('title', 'اضافة مندوب')
@section('content')

 <div class="row">
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h5>بيانات المندوب</h5>
                  </div>
                  @if(session()->has('errors'))
                  @foreach(session()->get('errors') as $err)
                    <div class="invalid-feedback">{{ $err }}</div>
                  @endforeach
                  @endif
                  <form class="form theme-form" method="POST" action="{{ route('admin.delegates.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                      <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">الاسم</label>
                        <div class="col-sm-9">
                          <input class="form-control @error('name') is-invalid @enderror" name="name" id="exampleFormControlInput1" value="{{ old('name') }}" type="text" placeholder="الاسم" required>
                          @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      
                      <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">رقم الهاتف</label>
                        <div class="col-sm-9">
                          <input class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" id="exampleFormControlInput1" type="text" placeholder="رقم الهاتف" required>
                          @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">اختر مدينة</label>
                        <div class="col-sm-9">
                        <select id="delegate-cities-select2" class="form-control" name="cities[]" multiple="multiple" required>
                          
                          @if($cities->isNotEmpty())
                              @foreach($cities as $city)
                              <option value="{{ $city->id }}">{{ $city->name }}</option> 
                              @endforeach
                          @endif
                        </select>
                        </div>
                      </div>
                      
                    </div>
                    <div class="card-footer text-end">
                      <button class="btn btn-primary" type="submit">حفظ</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

@endsection


@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() 
    {
        $('#delegate-cities-select2').select2(); 

        
    });

</script>
@endpush 
