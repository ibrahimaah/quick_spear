@extends('pages.user.account.index')
@section('active3', 'active')
@section('accountContent')
<h2 class="mb-4">{{ __('Documents') }}</h2>
<div class="card">
    @if (session()->has('error'))
        <div class="alert text-center py-4 my-3 alert-danger">{{ session()->get('error') }}</div>
    @endif
    @if (session()->has('success'))
        <div class="alert text-center py-4 my-3 alert-success">{{ session()->get('success') }}</div>
    @endif
    @csrf
    <div class="card-header">
        <h4>{{ __('Add') }} {{ __('Documents') }}</h4>
    </div>
    <div class="card-body">
        <div class="container">
            <form action="{{ route('front.user.documents_store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12 my-2 col-md-4">
                        <label>{{ __('Documents') }}</label><span class="text-danger"> * </span>
                        <input class="form-control mt-2 ml-2" type="file" name="document" />
                        @error('document')
                            <span class="text-danger text-center p-2">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12 my-2 col-md-4">
                        @php
                            $providers = ['id', 'passport', 'license'];
                        @endphp
                        <label>{{ __('Type') }}</label><span class="text-danger"> * </span>
                        <select class="form-control mt-2 ml-2" name="type">
                            @foreach ($providers as $provider)
                                <option value="{{ $provider }}">{{ $provider }}</option>
                            @endforeach

                        </select>
                        @error('type')
                            <span class="text-danger text-center p-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="card-header">
                    <button class="btn btn-primary" type="submit">{{ __('Add') }}</button>
                </div>
            </form>
            <hr />
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{__('Documents') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Created.') }}</th>
                                            <th>{{ __('Type') }}</th>
                                            <th>{{ __('Documents') }}</th>
                                            <th>{{ __('Action Status') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{--  @dd($addresses)  --}}
                                        @foreach($documents as $document)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $document->created_at }}</td>
                                            <td>{{ $document->type }}</td>
                                            <td><img src="{{ asset($document->document) }}" width="150" alt=""></td>
                                            <td>
                                                @if ($document->statusVerify == 1)
                                                    <span class="badge bg-success">{{ __('Done.') }}</span>
                                                @elseif($document->statusVerify == 2)
                                                <span class="badge bg-success">{{ __('Failed to load :resource!') }}</span>
                                                @else
                                                <span class="badge bg-success">{{ __('Processing') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a class="btn btn-danger btn-sm" href="{{ route('front.user.documents_delete', $document->id) }}">
                                                    <i class="bi bi-trash"></i>
                                                    {{ __('Delete') }}
                                                </a>
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
        </div>
    </div>
</div>
@endsection
