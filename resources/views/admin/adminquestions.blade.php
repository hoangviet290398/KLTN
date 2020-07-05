<div class="col-sm-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-question"></i> Câu hỏi</h6>
        </div>
        <div class="card-body">
            <div id="allQuestions">
                <!-- Question-->
                <div class="row">
                    @foreach($questions as $question)
                    <div class="col-sm-12">
                        <div class="card border-left-info">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <!-- Question stats -->
                                    <div class="col-sm-1 pr-2 text-center">
                                        <p class="text-muted">{{$question->total_like}}<br> lượt thích</p>
                                        <p class="text-muted">{{$question->total_dislike}}<br> lượt không thích</p>
                                        <p class="text-muted">{{$question->total_answer}}<br> trả lời</p>
                                    </div>
                                    <div class="col-sm-11">
                                        <!-- Question title -->
                                        <div class="h3 font-weight-bold text-primary">
                                            <a href="#">
                                                {{$question->title}}
                                            </a>
                                            @if((Auth::check()) and (Auth::user()->admin == 1))
                                            <a href="#myModal" data-toggle="modal">
                                                <i class="float-right fa fa-trash" aria-hidden="true"
                                                style="margin-right:10px; font-size: 30px; "></i></a>
                                                <!-- Modal HTML -->
                                                <div id="myModal" class="modal fade" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Xác nhận</h5>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Bạn có chắc muốn xóa bài viết này?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                                                <form action="{{route('adminDeleteTopic')}}" method="post">
                                                                    @csrf
                                                                    <input type="text" name="_id" value="{{$question->_id}}" hidden>
                                                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            <!-- Question content -->
                                            <div class="h5">
                                                {{$question->content}}
                                            </div>
                                            <!-- Question tag -->
                                            <div class="row pt-2">
                                                <div class="col-sm-9">
                                                    <a href="#" class="border text-muted p-1 rounded ">
                                                        {{$question->category->name}}
                                                    </a>

                                                </div>
                                                <div class="col-sm-3">
                                                    <p class="text-muted">
                                                     {{$question->created_at->diffForHumans()}}
                                                 </p>
                                                 <div class="row">
                                                    <div class="col-sm-3">
                                                        @if(is_file('storage/avatars/'.$question->user->avatar))
                                                        <a href="#">
                                                            <img src="{{ asset('storage/avatars')}}/{{$question->user->avatar}}"
                                                            class="img-fluid rounded-circle align-middle user-avatar">
                                                        </a>
                                                        @else
                                                          <a href="#">
                                                            <img src="{{$question->user->avatar}}"
                                                            class="img-fluid rounded-circle align-middle user-avatar">
                                                        </a>
                                                        @endif

                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="font-weight-bold text-primary">
                                                            <a href="#">
                                                                {{$question->user->fullname}}
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- End of a question -->

            </div>
            <hr>
            Showing all questions in <code>Q&A System</code>
        </div>

    </div>

</div>
</div>
</div>

<!-- <a href="">
    <img src="{{ asset('images/resource/viet.png') }}" class="img-fluid rounded-circle align-middle user-avatar">
</a> -->