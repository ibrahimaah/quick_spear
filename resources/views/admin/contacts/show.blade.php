@extends('admin.layouts.app')
@section('content')
<div class="col-12 py-0 px-3 row card">
    <div class="col-12 pt-4" style="min-height: 80vh">
        <div class="col-12 px-3">
            <h5>
                عرض الرسالة رقم {{ $contact->id }} القادمة من
                {{ $contact->name }}
            </h5>
        </div>
        <div class="col-12 px-3 py-1 mt-4 card-body">
            <div class="col-12" style="direction: rtl" id="{{ $contact->id }}">
                <div class="col-12 col-md-10 col-lg-9 col-xl-6 p-2 row rounded-2"
                    style="direction: rtl">
                    <div style="width: 70px" class="text-center d-none d-md-flex align-items-start">
                        <div class="d-inline-block">
                            @if($contact->user_id!=null)

                            <a href="{{ route('admin.users.index',['id'=>$contact->user_id]) }}"
                                class="d-inline-block text-center">
                                <span style="
                                        display: inline-block;
                                        position: relative;
                                        top: 6px;
                                    " class="px-2 pt-0 float-end kufi">
                                </span>
                            </a>

                            @else

                            {{-- <img src="https://manager.almadarisp.com/user/img/user.png" style="
                                    width: 45px;
                                    height: 45px;
                                    display: inline-block;
                                    border-radius: 50% !important;
                                    padding: 3px;
                                " class="mx-auto" alt="صورة المستخدم" /> --}}
                            <span style="
                                    display: inline-block;
                                    position: relative;
                                    top: 6px;
                                " class="px-2 pt-0 float-end kufi">
                            </span>

                            @endif
                        </div>
                    </div>
                    <div class="px-2" style="width: calc(100% - 70px)">
                        <div class="col-12 rounded py-2" style="background: var(--message-sender-bg)">
                            <div class="col-12 px-0 row">
                                <div class="col-7 px-0">
                                    @if($contact->user_id!=null)
                                    <a href="{{ route('admin.users.index',['id'=>$contact->user_id]) }}"
                                        class="d-inline-block text-center">
                                        <span style="
                                                font-size: 13px;
                                                opacity: 0.7;
                                                font-weight: bold;
                                                color: var(--bg-color-0);
                                            " class="kufi">{{ $contact->user->name }}
                                            <br /> {{ $contact->user->phone }}</span>
                                        </span>
                                    </a>

                                    @else

                                    <span style="
                                            font-size: 13px;
                                            opacity: 0.7;
                                            font-weight: bold;
                                            color: var(--bg-color-0);
                                        " class="kufi">{{ $contact->name
                                        }}<br />{{ $contact->email }}
                                        <br />{{ $contact->phone }}</span>

                                    @endif
                                </div>
                                <div class="col-5 px-0 text-end">
                                    <span style="font-size: 14px; opacity: 0.7" class="naskh">{{
                                        $contact->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <div class="col-12 px-0">
                                <div style="position: relative; top: 0px" class="py-2">
                                    <span style="
                                            position: relative;
                                            color: var(--bg-color-0);
                                            font-size: 17px;
                                            white-space: pre-line;
                                            word-wrap: break-word;
                                            overflow: hidden;
                                        " class="p-0 naskh">
                                        {{ $contact->message }}</span>
                                </div>
                                <div class="col-12 px-1">
                                    <div class="col-12 px-0"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
