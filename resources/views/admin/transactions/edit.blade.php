@extends('admin.layouts.app')
@section('title', 'الرئيسية')
@section('content')

 <div class="row">
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <h5>بيانات القسم</h5>
                  </div>
                  <form class="form theme-form" method="POST" action="{{ route('admin.categories.update', $category->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="card-body">
                      <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">اسم القسم بالعربية</label>
                        <div class="col-sm-9">
                          <input value="{{ $category->getTranslation('name', 'ar') }}" class="form-control @error('name_ar') is-invalid @enderror" name="name_ar" id="exampleFormControlInput1" type="text" placeholder="اسم القسم بالعربية">
                          @error('name_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      
                      <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">الاسم بالانجليزية</label>
                        <div class="col-sm-9">
                          <input value="{{ $category->getTranslation('name', 'en') }}" class="form-control @error('name_en') is-invalid @enderror" name="name_en" id="exampleFormControlInput1" type="text" placeholder="الاسم بالانجليزية">
                          @error('name_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="exampleFormControlInput1">الاسم باللغة الكردية</label>
                        <div class="col-sm-9">
                          <input value="{{ $category->getTranslation('name', 'ku') }}" class="form-control @error('name_ku') is-invalid @enderror" name="name_ku" id="exampleFormControlInput1" type="text" placeholder="الاسم باللغة الكردية">
                          @error('name_ku')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="company">الشركة</label>
                        <div class="col-sm-9">
                          <select class="form-control @error('company') is-invalid @enderror" name="company" required id="company">
                            <option value="" selected>اختار الشركة</option>
                            @foreach($companies as $company)
                              <option {{ $category->company_id == $company->id ? 'selected' : '' }} value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                          </select>
                          @error('company')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>

                      <div class="row">
                        <div class="col">
                            <img width="100" src="{{ asset($category->photo) }}" alt="{{ $category->name }}" />
                          <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">صورة القسم</label>
                            <div class="col-sm-9">
                              <input class="form-control @error('photo') is-invalid @enderror" name="photo" type="file">
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
