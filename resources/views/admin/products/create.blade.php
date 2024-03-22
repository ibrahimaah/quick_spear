@extends('admin.layouts.app')
@section('title', 'الرئيسية')
@section('content')

 <div class="row">
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h5>بيانات المنتج</h5>
                  </div>
                  <form class="form theme-form" method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                      <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">اسم المنتج بالعربية</label>
                        <div class="col-sm-9">
                          <input class="form-control @error('name_ar') is-invalid @enderror" name="name_ar" id="exampleFormControlInput1" value="{{ old('name_ar') }}" type="text" placeholder="اسم المنتج بالعربية">
                          @error('name_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">الاسم بالانجليزية</label>
                        <div class="col-sm-9">
                          <input class="form-control @error('name_en') is-invalid @enderror" name="name_en" value="{{ old('name_en') }}" id="exampleFormControlInput1" type="text" placeholder="الاسم بالانجليزية">
                          @error('name_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">الاسم باللغة الكردية</label>
                        <div class="col-sm-9">
                          <input class="form-control @error('name_ku') is-invalid @enderror" name="name_ku" value="{{ old('name_ku') }}" id="exampleFormControlInput1" type="text" placeholder="الاسم باللغة الكردية">
                          @error('name_ku')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">شرح المنتج بالعربية</label>
                        <div class="col-sm-9">
                          <textarea class="form-control @error('desc_ar') is-invalid @enderror" cols="4" rows="5" name="desc_ar" id="exampleFormControlInput1" value="{{ old('desc_ar') }}" type="text" placeholder="شرح المنتج بالعربية"></textarea>
                          @error('desc_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">الشرح بالانجليزية</label>
                        <div class="col-sm-9">
                          <textarea class="form-control @error('desc_en') is-invalid @enderror" cols="4" rows="5" name="desc_en" value="{{ old('desc_en') }}" id="exampleFormControlInput1" type="text" placeholder="الشرح بالانجليزية"></textarea>
                          @error('desc_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">الشرح باللغة الكردية</label>
                        <div class="col-sm-9">
                          <textarea class="form-control @error('desc_ku') is-invalid @enderror" cols="4" rows="5" name="desc_ku" value="{{ old('desc_ku') }}" id="exampleFormControlInput1" type="text" placeholder="الشرح باللغة الكردية"></textarea>
                          @error('desc_ku')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">الوحدة</label>
                            <div class="col-sm-9">
                                <input class="form-control @error('unit') is-invalid @enderror" name="unit" value="{{ old('unit') }}"
                                    id="exampleFormControlInput1" type="text" placeholder="يمكن كتابة اكثر من وحدة للمنتج والفصل بينهم ب - مثلا : كجم - شوال">
                                @error('unit')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">الشركة المصنعة</label>
                            <div class="col-sm-9">
                                <input class="form-control @error('company_made') is-invalid @enderror" name="company_made"
                                    value="{{ old('company_made') }}" id="exampleFormControlInput1" type="text" placeholder="الشركة المصنعة">
                                @error('company_made')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                      <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="category"> القسم</label>
                        <div class="col-sm-9">
                          <select class="form-control @error('category') is-invalid @enderror" name="category" required id="category">
                            <option value="" selected>اختار  القسم</option>
                            @foreach($categories as $category)
                              <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                          </select>
                          @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">صور المنتج</label>
                            <div class="col-sm-9">
                              <input class="form-control @error('photo') is-invalid @enderror" name="photo[]" multiple type="file">
                              @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
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

@endsection
