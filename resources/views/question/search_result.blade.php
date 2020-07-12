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
				<div class="row">
					<div class="col-8">
						<h2>Kết quả cho "{{$keyword}}"</h2>
					</div>
					<div class="col-4" style="text-align:end">
						<a data-toggle="collapse" aria-expanded="false" href="#advance_search_tutorial" class="text-decoration-none">Advanced Search Tips</a>
					</div>
				</div>
				<div class="collapse" id="advance_search_tutorial">
				
				   <table class="table">
					  <thead>
					    <tr>
					      <th>Search type</th>
					      <th>Search syntax</th>
					    </tr>
					  </thead>
					  <tbody>
					    <tr>
					      <td>Tags</td>
					      <td>tag:python</td>
					    </tr>
					    <tr>
					      <td>Author</td>
					      <td>user:1234<br/>user:me (yours)</td>
					    </tr>
					    <tr>
					      <td>Answers</td>
					      <td>answers:3 (3+)<br/>answers:0 (none)<br/>hasaccepted:yes<br/>hasaccepted:no</td>
					    </tr>
					    <tr>
					      <td>Views</td>
					      <td>views:50 (50+)</td>
					    </tr>
					    <tr>
					      <td>Types</td>
					      <td>is:question<br/>is:answer</td>
					    </tr>
					  </tbody>
					</table>
				 
				</div>
				<form action="{{ route('searchIndex') }}" method="get">
					<div class="input-group mb-4">
						<input type="search" name="keyword" placeholder="" aria-describedby="button-addon5" class="form-control" value="{{$keyword}}">
						<div class="input-group-append">
							<button id="button-addon5" type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
						</div>
					</div>
				</form>
				<br/>
				<h5 class="text-left">{{number_format($questions->total())}} kết quả</h5>

			</div>
			<div class="card-body p-0">
				@if($questions->count()==0)
				<div class="text-center">
					<br/>
					<img src="{{ asset('images/resource/magnifying.svg') }}" width="90px">
					<p>Không tìm thấy kết quả cho <b>{{$keyword}}</b></p>
					<small>Thử từ khóa khác hoặc từ khóa đơn giản hơn</small>
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

									<p class="pv-archiveText">{{strip_tags($question->content)}}</p>
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
													{{$question->total_like}} thích
												</div>
											</div>
											<div class="col-sm-3 px-1">
												<div class="border rounded text-muted bg-white text-center">
													<i class="fa fa-thumbs-down"></i>
													{{$question->total_dislike}} không thích
												</div>
											</div>

											<div class="col-sm-3 px-1">
												<div class="border rounded text-muted bg-white text-center">
													<i class="fa fa-comment"></i>
													{{$question->total_answer}} trả lời
												</div>
											</div>


											<div class="col-sm-3">
												@if(Auth::check())
												<a href="topic/{{ $question->id }}" class="border rounded text-light bg-dark text-center px-4 text-decoration-none" style="font-size:18px">Trả lời</a>
												@else
												<a href="/signin" class="border rounded text-light bg-dark text-center px-4 text-decoration-none" style="font-size:18px">Trả lời</a>
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