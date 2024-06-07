@extends('admin.layouts.app')
@section('title', 'اضافة مندوب')
@section('content')

<style>
  [data-x-group]:first-of-type #rmv-btn {
      display: none;
  }
   
</style>

<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <h5>إضافة مندوب</h5>
      </div>
     
      <div class="px-4">
        @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif
      </div>
      <form class="form theme-form" method="POST" action="{{ route('admin.delegates.store') }}" id="add_delegate_form">
        @csrf
        <div class="card-body">
          <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">الاسم</label>
            <div class="col-sm-9">
              <input class="form-control" name="name" id="exampleFormControlInput1" value="{{ old('name') }}"
                type="text" placeholder="الاسم" required>

            </div>
          </div>

          <div class="mb-3 row">
            <label class="col-sm-3 col-form-label">رقم الهاتف</label>
            <div class="col-sm-9">
              <input class="form-control" name="phone" value="{{ old('phone') }}" type="text" placeholder="رقم الهاتف"
                required>

            </div>
          </div>

          <div data-x-wrapper="delegates">

            <div data-x-group>

              <div class="border p-3 mb-2">

                <div class="d-flex justify-content-between">
                  <button type="button" class="btn btn-outline-success mb-3" data-add-btn>
                    <i class="bi bi-plus-lg"></i>
                  </button>
                  <button type="button" class="btn btn-outline-danger mb-3" id="rmv-btn" data-remove-btn>
                    <i class="bi bi-trash"></i>
                  </button>
                </div>

                <div class="mb-3 row">
                  <label class="col-sm-3 col-form-label">اختر مدينة</label>
                  <div class="col-sm-9">
                    <select class="form-control" name="city" required>
                      <option value="">اختر مدينة</option>
                      @if($cities->isNotEmpty())
                      @foreach($cities as $city)
                      <option value="{{ $city->id }}">{{ $city->name }}</option>
                      @endforeach
                      @endif
                    </select>

                  </div>
                </div>

                <div class="mb-3 row">
                  <label class="col-sm-3 col-form-label">أجرة المندوب</label>
                  <div class="col-sm-9">
                    <input type="number" name="price" class="form-control" placeholder="أجرة المندوب لهذه المدينة" required />

                  </div>
                </div>


              </div>

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



<script src="{{ asset('assets/vendor/jquery/jquery_v3.7.min.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery.replicate/jquery.replicate.js') }}"></script>
<script>
  const selector = '[data-x-wrapper]';
                    let options = {
                        disableNaming: '[data-disable-naming]',
                        wrapper: selector,
                        group: '[data-x-group]',
                        addBtn: '[data-add-btn]',
                        removeBtn: '[data-remove-btn]'
                    };
                    $(selector).replicate(options);
</script>
@endsection