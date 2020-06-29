<div class="col-sm-3 text-center py-2">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-sm-4 pr-2">
                                            @if(is_file('storage/avatars/'.$user->avatar))
                                            <a href="#">
                                                <img src="{{ asset('storage/avatars')}}/{{$user->avatar}}"
                                                    class="img-fluid rounded-circle align-middle user-avatar">
                                            </a>
                                            @else
                                            <a href="{{ route('manageQuestionsByUser', ['id' => $user->id]) }}">
                                                <img src="{{$user->avatar}}"
                                                    class="img-fluid rounded-circle align-middle user-avatar">
                                            </a>
                                            @endif

                                        </div>

                                        <div class="col-sm-7">
                                            <div class="h5 font-weight-bold text-primary text-uppercase mb-1">
                                                <a href="{{ route('manageQuestionsByUser', ['id' => $user->id]) }}">
                                                    {{$user->fullname}}
                                                </a>
                                            </div>
                                            <div class="mb-0 text-muted">{{$user->questions->count()}} Câu hỏi</div>
                                            <div class="mb-0  text-muted">{{$user->answers->count()}} Trả lời</div>
                                        </div>

                                    </div>
                                </div>
                               <i href="#myModal" data-toggle="modal" class="fa fa-trash text-right text-danger pr-2" aria-hidden="true" style=""></i>
                                
                                <div id="myModal" class="modal fade" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Xác nhận</h5>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Bạn có chắc muốn xóa người dùng này??</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                                                <form action="{{route('adminDeleteUser')}}" method="post">
                                                                    @csrf
                                                                    <input type="text" name="_id" value="{{$user->_id}}" hidden>
                                                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                            </div>

                        </div>
