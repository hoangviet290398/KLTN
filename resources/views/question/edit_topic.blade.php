@extends('layout.master')
@section('title', 'Edit topic')



@section('js')
<script>
	$('#fileUpload').fileinput({
		theme: 'fa',
	            allowedFileExtensions: ['zip', 'rar'],
	            //uploadUrl: '/upload_article_poster',
	            uploadAsync: false,
	            showUpload: false,
	            maxFileSize: 5120,
	            removeClass: 'btn btn-warning'
	        });
	var simplemde = new SimpleMDE({
		element: document.getElementById("markdown")
	});

	function checkContent() {
		if (simplemde.value() != "") {
			document.getElementById("addquestion").submit();
		}
	}

</script>
@endsection

@section('content')

<div class="container mt-5">
	<div class="card shadow">

		<div class="card-header">
			<h3>Edit topic</h3>
		</div>

		<div class="card-body">
			 @if(Session::has('errorUpload'))
                <div class="alert alert-danger">{{ Session::get('errorUpload') }}</div>
            @endif
			<form method="post" action="{{url('edittopic')}}" id="addquestion" enctype="multipart/form-data">
				@csrf
				<!-- Start topic title -->
				<input type="text" name="id" hidden value="{{$question->id}}">
				<div class="form-group">
					<label for="title">Topic title</label>
					<input type="text" class="form-control" id="title" name="title" required
					placeholder="Subject of your topic (limit of 100 characters)" maxlength="100" value="{{ $question->title }}">
				</div>
				<!-- End topic title-->

				<!-- Category -->
				<div class="form-group">

					@foreach($errors->all() as $error)
						<div class="alert alert-danger">{{ $error }}</div>
					@endforeach

					<label for="category">Category</label>
					<select class="form-control col-sm-3" id="category" name="category">
						@foreach($categories as $category)
							@if($question->category_id==$category->_id)
								<option value="{{$category->_id}}" selected="selected">{{$category->name}}</option>
							@else
								<option value="{{$category->_id}}">{{$category->name}}</option>
							@endif
						@endforeach
					</select>

					@if($question->attachment_path)
						<div class="float-right">
						<b class="badge badge-warning">Attachment:</b>
						<a href="{{asset('storage/files/'.$question->attachment_path)}}"><i>{{$question->attachment_path}}</i></a>

						</div>
					@endif
				</div>
				<!-- End category-->

				<!-- Content -->
				<label for="markdown">Content</label>
				<div class="row">
					<div class="col-sm-4">
						<div class="file-loading">
							<input id="fileUpload" name="attachment" type="file">
						</div>
					</div>
					<div class="col-sm-8">
						<div class="form-group">
							<textarea id="markdown" rows="3" name="content">{{ $question->content }}</textarea>
						</div>
					</div>
				</div>
				<!-- End content-->

				<button type="button" onclick="checkContent()" class="btn btn-primary float-right">Save changes</button>

			</form>
		</div>

	</div>
</div>

@endsection