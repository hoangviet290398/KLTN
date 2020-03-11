
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
                            <li>Total question: {{ $user->questions->count() }}</li>
                            <li>Total answer: {{ $user->answers->count() }}</li>
                        </ul>
                    </div>
                    <div class="col-sm">
                        <ul>
                            <li>Total like: {{ $totalLike }}</li>
                            <li>Total dislike: {{ $totalDislike }}</li>
                            <li>Total accepted answer: {{ $totalAccepted }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>
</div>

@endsection
