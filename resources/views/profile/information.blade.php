@extends('layout.profile')

@section('title', 'Information')

@section('script')
    <script>
        $(function () {

            jQuery.validator.addMethod("validpass", function (value, element) {
                return this.optional(element) || /^\S+$/i.test(value);
            }, "Password can't contain space.");

            $('#information').validate({
                rules: {
                    fullname: {
                        required: true
                    },
                },
                 messages: {
                    fullname: {
                        required: 'Please enter your fullname.',
                    },
                },
                errorElement: 'small',
                errorClass: 'help-block text-danger mt-2',
                validClass: 'is-valid',
                highlight: function (e) {
                    $(e).removeClass('is-valid').addClass('is-invalid');
                },
                unhighlight: function (e) {
                    $(e).removeClass('is-invalid').addClass('is-valid');
                }
            });
        })

    </script>
@endsection

@section('contentprofile')
		<div class="row">
			<div class="col-sm-12">
				<div class="" style="text-align: center;">
					<h2 class="text-primary ">PERSONAL INFORMATION</h2>
				</div>
				<hr class="my-3">
				<div class="row">
					<div class="col-sm-2"></div>
					<div class="col-sm-8">
					
					@foreach($errors->all() as $error)
						<div class="alert alert-danger">{{ $error }}</div>
					@endforeach
						<form action="{{ route('updateInformation') }}" method="post" id="information">
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							@if(Session::has('message'))
								<div class="alert alert-success">{{ Session::get('message') }}</div>
							@endif
							<div class="form-group">
						    	<label for="email" class="font-weight-bold">Email</label>
						    	<input id="email" type="email" class="form-control" value="{{ $user->email }}" name="email" disabled>
							</div>
							<div class="form-group">
						    	<label for="fullname" class="font-weight-bold">Fullname</label>
						    	<input id="fullname" type="text" class="form-control" value="{{ $user->fullname }}" name="fullname">
							</div>
							<div class="form-group">
								<label for="aboutme" class="font-weight-bold">About me</label>
								<textarea id="aboutme" class="form-control" rows="5" name="aboutme">{{ $user->about_me }}</textarea>
							</div>
						  	<div class="d-flex justify-content-center">
						  		<button type="submit" class="btn btn-primary ">Save</button>
						  		<button type="reset" class="btn btn-outline-primary " style="margin-left: 10px; ">Reset</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

@endsection
