<div class="col-sm-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-user"></i> Users</h6>
        </div>
        <div class="card-body">
            <form action="">
                <div class="form-group mb-4">
                    <input id="searchUsers" type="search" placeholder="Filter by user" aria-describedby="button-addon" class="form-control-lg border-primary">
                </div>
                </form>
            <div class="">
                <div id="allUsers">
                    <div class="row" id="allU">
                        @foreach($users as $user)
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
                                            <div class="mb-0 text-muted">{{$user->questions->count()}} Questions</div>
                                            <div class="mb-0  text-muted">{{$user->answers->count()}} Answers</div>
                                        </div>

                                    </div>
                                </div>
                               <i href="#myModal" data-toggle="modal" class="fa fa-trash text-right text-danger pr-2" aria-hidden="true" style=""></i>
                                
                                <div id="myModal" class="modal fade" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirmation</h5>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to delete this user?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                <form action="{{route('adminDeleteUser')}}" method="post">
                                                                    @csrf
                                                                    <input type="text" name="_id" value="{{$user->_id}}" hidden>
                                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                            </div>

                        </div>

                        @endforeach
                    </div>

                </div>
            </div>
            <hr>
            Showing all users in <code>Q&A System</code>
        </div>
    </div>
</div>

<script type="text/javascript">
   
    $('#searchUsers').keyup(function () {
            var keyword = $(this).val();
            if (keyword != '') {
                $.ajax({
                    url: "{{ route('adminAjaxSearchUsers') }}",
                    method: "GET",
                    data: {
                        keyword
                    },
                    success: function (data) {
                        if(data!=""){
                            $('#allU').empty();
                            $('#allU').html(data);
                            $('#allU').show();
                        }
                        else{
                            $('#allU').hide();
                        }
                    }
                })
            }
            else{
                $.ajax({
                    url: "{{ route('adminAjaxSearchUsers1') }}",
                    method: "GET",
                    data: {
                        keyword
                    },
                    success: function (data) {
                        if(data!=""){
                            $('#allU').empty();
                            $('#allU').html(data);
                            $('#allU').show();
                        }
                        else{
                            $('#allU').hide();
                        }
                    }
                })
            }
        });
</script>