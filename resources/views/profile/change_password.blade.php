@extends('layout.profile')
@section('title','Change password')

@section('script')
    <script>
        $(function () {
            jQuery.validator.addMethod("validpass", function (value, element) {
                return this.optional(element) || /^\S+$/i.test(value);
            }, "Password can't contain space.");

            $('#changepass').validate({
                rules: {
                	curentpassword: {
                        required: true,
                        validpass: true,
                        maxlength:30,
                        minlength:5
                    },
                    newpassword: {
                        required: true,
                        validpass: true,
                        maxlength:30,
                        minlength:5
                    },
                    confirmpass: {
                        required: true,
                        equalTo: $('[name="newpassword"]')
                    
                    }
                },
                messages: {
                	curentpassword: {
                        required: 'Please enter your current password.',
                        maxlength:'Maximum character is 30',
                        minlength:'Password must has at least 5 character.'
                    },
                    newpassword: {
                        required: 'Please enter your password.',
                        maxlength:'Maximum character is 30',
                        minlength:'Password must has at least 5 character.'
                    },
                    confirmpass: {
                        required: 'Please comfirm your password.',
                        equalTo: "Your password isn't matched."
                    }
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

@section('contentprofile')
		<div class="row">
			<div class="col-sm-12">
				<div class="" style="text-align: center;">
					<h2 class="text-primary ">CHANGE PASSWORD</h2>	
				</div>
				<hr class="my-3">
				<div class="row">
					<div class="col-sm-2"></div>
					<div class="col-sm-8">
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
						@if(Session::has('message'))
							<div class="alert alert-success">{{ Session::get('message') }}</div>
						@endif
						@if(Session::has('error'))
							<div class="alert alert-danger">{{ Session::get('error') }}</div>
						@endif
    					<form action="{{ route('storeChangePassword') }}" method="post" id="changepass">
    						<input type="hidden" name="_token" value="{{csrf_token()}}">
    						<div class="form-group">
    					    	<label for="curentpassword" class="font-weight-bold">Current password</label>
    					    	<input id="currentpassword" type="password" class="form-control"  name="curentpassword">
    						</div>
    						<div class="form-group">
    					    	<label for="newpassword" class="font-weight-bold">New password</label>
    					    	<input id="newpassword" type="password" class="form-control" name="newpassword">
    						</div>
    						<div class="form-group">
    					    	<label for="confirmpass" class="font-weight-bold">Confirm password</label>
    					    	<input id="confirmpass" type="password" class="form-control" name="confirmpass">
    						</div>
    					  	<div class="d-flex justify-content-center">
    					  		<button type="submit" class="btn btn-primary">Save</button>
    					  		<button type="reset" class="btn btn-outline-primary " style="margin-left: 10px; ">Reset</button>
    						</div>
    					</form>
					</div>
				</div>
			</div>
		</div>

@endsection