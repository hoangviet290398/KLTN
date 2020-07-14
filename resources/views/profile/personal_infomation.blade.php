@extends('layout.master')
@section('title','Personal information')
@section('content')

<div class="container mt-5">
    <div class="card bg-light shadow px-5">
        <div class="card-body">
            <div class="row">
                @if(is_file('storage/avatars/'.$user->avatar))
                <div class="col-sm-3">
                    <img src="{{ asset('storage/avatars') }}/{{ $user->avatar }}" class="w-100" alt="">
                    <h5 class="text-center pt-3"><strong>1234</strong> Danh tiếng</h5>

                </div>
                @else
                <div class="col-sm-3">
                    <img src="{{ $user->avatar }}" class="w-100" alt="">
                    <h5 class="text-center text-muted pt-3"><strong>1234</strong> Danh tiếng</h5>

                </div>
                @endif
                <div class="col-sm-3">
                    <h3 class="text-primary font-weight-bold">{{ $user->fullname }}</h3>
                    <p>{{ $user->about_me }}</p>

                </div>
                <div class="col-sm-6 pt-5">
                    <div class="row">
                        <div class="col-sm-5">
                            <ul>
                                <strong>{{ $user->questions->count() }}</strong>
                                <p>câu hỏi</p>
                                <strong>{{ $user->answers->count() }}</strong>
                                <p>câu trả lời</p>
                            </ul>
                        </div>
                        <div class="col-sm-7">
                            <ul>
                                <strong>{{ $totalLike }}</strong>
                                <p>vote</p>
                                <strong>{{ $totalAccepted }}</strong>
                                <p>câu trả lời được chấp thuận</p>
                            </ul>
                        </div>


                    </div>

                </div>

            </div>

            <div class="col-sm-12 pt-4">
                <div class="row">
                    <div class="col-sm-9 pt-2">
                        <h5>Câu hỏi gần đây</h5>
                    </div>
                    <div class="col-sm-3 pl-5 pb-2">
                        <div class="bg-light" style="">
                            <ul class="nav nav-pills font-weight-bold">
                                <li class="nav-item">
                                    <a class="nav-link active" href="">Câu hỏi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="">Trả lời</a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>

                        </tr>
                    </thead>
                    <tbody>

                        <tr style="line-height: 20px;">
                            <th>
                                <div class="card border-success" style="">
                                    <div class="card-body text-success">
                                        <p class="card-text text-center">0</p>
                                    </div>
                                </div>
                            </th>
                            <th style="max-width: 350px;">
                                THIS IS A QUESTION TITLESDASDSDSDDDDDDDDDDDDDDDD<br>
                            </th>

                            <td><span class="badge badge-info">Python</span></td>
                            <th class="text-right">Wed, Jun 10, 2020 9:43 AM</th>

                        </tr>
                        <tr style="line-height: 20px;">
                            <th>
                                <div class="card border-success" style="">
                                    <div class="card-body text-success">
                                        <p class="card-text text-center">0</p>
                                    </div>
                                </div>
                            </th>
                            <th style="max-width: 350px;">
                                THIS IS A QUESTION TITLESDASDSDSDDDDDDDDDDDDDDDD<br>
                            </th>

                            <td><span class="badge badge-info">Python</span></td>
                            <th class="text-right">Wed, Jun 10, 2020 9:43 AM</th>

                        </tr>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

@endsection