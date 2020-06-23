@extends('layout.master')
@section('title','TechSolution - Connect, Learn and Share')
@section('content')
@php
use Carbon\Carbon;

@endphp

<main>								
	{{-- <img src="{{ asset('images/resource/slogan.png') }}" style="height:15%" alt="placeholder+image"> --}}

	<div class="mt-1 d-flex justify-content-center">
		@include('layout.leftpanel')
		<div class="card col-7">
			<div class="card-header text-left" style="background-color: white">
				{{-- <ul class="nav nav-pills font-weight-bold" >
					<li class="nav-item">
						<a class="nav-link active" data-toggle="pill" href="#home">Recent Question</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="pill" href="#menu1">Hot</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="pill" href="#menu1">Most Answered</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="pill" href="#menu1">No Answers</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="pill" href="#menu1">Week</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="pill" href="#menu2">Month</a>
					</li>
				</ul> --}}
				<h2>Results for "{{$keyword}}"</h2>
				<form action="{{ route('searchIndex') }}" method="get">
					<div class="input-group mb-4">
						<input type="search" name="keyword" placeholder="" aria-describedby="button-addon5" class="form-control" value="{{$keyword}}">
						<div class="input-group-append">
							<button id="button-addon5" type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
						</div>
					</div>
				</form>
				<br/>
				<h5 class="text-left">{{number_format($all_question)}} results</h5>

			</div>
			<div class="card-body p-0">
				@if($questions->count()==0)
				<div class="text-center">
					<br/>
					<img src="{{ asset('images/resource/magnifying.svg') }}" width="90px">
					<p>We couldn't find anything for <b>{{$keyword}}</b></p>
					<small>Try different or less specific keywords</small>
				</div>
				@endif
				@foreach($questions as $question)
				<div class="row px-3 pt-3">
					@if(is_file('storage/avatars/'.$question->user->avatar))
					<div class="col-sm-1"><a href="/personalinfomation/{{ $question->user->_id }}" class="text-decoration-none"><img src="{{ asset('storage/avatars')}}/{{$question->user->avatar}}"
						class="img-fluid rounded-circle align-middle user-avatar"></a></div>
						@else
						<div class="col-sm-1"><a href="/personalinfomation/{{ $question->user->_id }}" class="text-decoration-none"><img src="{{$question->user->avatar}}"
							class="img-fluid rounded-circle align-middle user-avatar"></a></div>
							@endif
							<div class="col-sm-11">
								<a href="/personalinfomation/{{ $question->user->_id }}" class="text-decoration-none">
									<small class="font-weight-bold" style="color:#5488c7;">{{$question->user->fullname}}</small>
								</a>
								<small class="text-muted pl-4" style="color:#5488c7;" data-toggle="tooltip" title="{{$question->created_at->toDayDateTimeString()}}">asked:

									{{$question->created_at->diffForHumans()}}
								</small>
								<br>
								<div class="row">
									<div class="col-12">
										<div class="word-wrap">
											<a href="topic/{{ $question->_id }}" class="text-decoration-none">
												<h5>{{$question->title}}</h5>
											</a></div>


										</div>

									</div>

									<p class="pv-archiveText">{{$question->content}}</p>
									<!-- QuyTran added -->
									<div class="row">
										<div class="pl-3 pt-1 pb-3">
											<a href="{{ route('viewByCategory', ['id' => $question->category->id]) }}" class="border text-muted p-1 rounded text-decoration-none">
												{{$question->category->name}}
											</a>

										</div>
									</div>
									<!-- QuyTran end add -->
									<div class="ml-3">
										<div class="row col-sm-12 bg-light py-3" style="">
											<div class="col-sm-3 px-1">
												<div class="border rounded text-muted bg-white text-center px-1">
													<i class="fa fa-thumbs-up"></i>
													{{$question->total_like}} likes
												</div>
											</div>
											<div class="col-sm-3 px-1">
												<div class="border rounded text-muted bg-white text-center">
													<i class="fa fa-thumbs-down"></i>
													{{$question->total_dislike}} dislikes
												</div>
											</div>

											<div class="col-sm-3 px-1">
												<div class="border rounded text-muted bg-white text-center">
													<i class="fa fa-comment"></i>
													{{$question->total_answer}} answers
												</div>
											</div>


											<div class="col-sm-3">
												@if(Auth::check())
												<a href="topic/{{ $question->id }}" class="border rounded text-light bg-dark text-center px-4 text-decoration-none" style="font-size:18px">Answer</a>
												@else
												<a href="/signin" class="border rounded text-light bg-dark text-center px-4 text-decoration-none" style="font-size:18px">Answer</a>
												@endif

											</div>

										</div>
									</div>

								</div>

							</div>
							<hr>
							@endforeach
							<div class="row px-3 pt-3 justify-content-sm-center">{!! $questions->appends(request()->query())->links() !!}</div>
						</div>
					</div>
					@include('layout.rightpanel')

				</main>
				@endsection