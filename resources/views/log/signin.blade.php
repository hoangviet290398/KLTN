@extends('layout.log')
@section('title','Sign in')

@section('js')
<script>
    $(function () {
        $('#signinform').validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                },

            },
            messages: {                   
                email: {
                    required: 'Please enter your email.',
                    email: 'Your email is invalid!',
                },
                password: {
                    required: 'Please enter your password.',
                },                    
            },
            errorElement: 'small',
            errorClass: 'help-block text-danger mt-2',
            validClass: 'is-valid',
            highlight: function (e) {
                $(e).addClass('is-invalid');
            },
            unhighlight: function (e) {
                $(e).removeClass('is-invalid');
            }
        });
    })

</script>
@endsection

@section('content')
<div class="container h-100 d-flex justify-content-center align-items-center">
    <div class="card shadow" style ="width:400px;">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-4">
                    <a href="{{route('homePage')}}">
                        <img src="{{ asset('images/resource/logo2a.png') }}" alt="" class="w-100" style="margin-top: 15px;margin-left:15px" ></a>
                    </div>
                    <div class="col-sm-8 mt-3">
                        <h4 class="font-weight-bold">Welcome to TechSolution</h4>
                        <small>Ask anything you want!</small>
                    </div>
                </div>
            </div>
            <div class="card-body pr-5 pl-5 pb-5">              
                <form id="signinform" action="{{route('signIn')}}" method="post">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">    
                    <div class="form-group">
                        <label class="font-weight-bold " for="email">Email:</label>
                        <input id="email" name="email" type="email" class="form-control" aria-describedby="emailHelp" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold" for="password">Password:</label>
                        <input id="password" name="password" type="password" class="form-control" placeholder="Password">
                    </div>
                    @if($errors->any())
                    <div class="alert alert-danger">{{$errors->first()}}</div>
                    @endif
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary w-100 font-weight-bold">Sign In</button>
                    </div>
                    <div class="text-center">
                        Hasn't had an account? <a href="{{ route('signUp' )}}">Sign up here</a>
                    </div>
                </form>
                <br/>
                <a class="btn btn-dark w-100 " href="{{ url('login/github') }}">
                    <i class="fa fa-github fa-lg" aria-hidden="true"></i>  Sign in with GitHub
                </a>
                <br/>
                <br/>
                 <a class="btn w-100 text-white" style="background-color: #385499" href="{{ url('login/facebook') }}">
                    <i class="fa fa-facebook-square fa-lg" aria-hidden="true"></i>  Sign in with Facebook
                </a>
                <br/>
                <br/>
                 <a class="btn btn-danger w-100" href="{{ url('login/google') }}">
                    <i class="fa fa-google fa-lg" aria-hidden="true"></i>  Sign in with Google
                </a>
            </div>
        </div>
    </div>
    @endsection