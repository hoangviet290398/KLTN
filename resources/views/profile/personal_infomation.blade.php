
@extends('layout.master')
@section('title','Personal information')
@section('content')

<div class="container mt-5">
<div class="card bg-light shadow px-5">
    <div class="card-body">
        <div class="row">
            @if(is_file('storage/avatars/'.$user->avatar))
            <div class="col-sm-5">
            <img src="{{ asset('storage/avatars') }}/{{ $user->avatar }}" class="w-100" alt="">
            </div>
            @else
            <div class="col-sm-5">
            <img src="{{ $user->avatar }}" class="w-100" alt="">
            </div>
            @endif
            <div class="col-sm-7 py-5">
                <h1 class="text-primary font-weight-bold">{{ $user->fullname }}</h1>
                <p>{{ $user->about_me }}</p>
                <div class="row">
                    <div class="col-sm">
                        <ul>
                            <li>Tổng câu hỏi: {{ $user->questions->count() }}</li>
                            <li>Tổng câu trả lời: {{ $user->answers->count() }}</li>
                        </ul>
                    </div>
                    <div class="col-sm">
                        <ul>
                            <li>Tổng lượt thích: {{ $totalLike }}</li>
                            <li>Tổng lượt không thích: {{ $totalDislike }}</li>
                            <li>Tổng câu trả lời được chấp thuận: {{ $totalAccepted }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>
</div>

@endsection
