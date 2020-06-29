<div id="userProfile" class="text-center">
    <div class="card-body pt-5 border-bottom">
    @if(is_file('storage/avatars/'.$userProfile[0]->avatar))
        <img src="{{ asset('storage/avatars')}}/{{$userProfile[0]->avatar}}" alt="user" width="160"
            class="rounded-circle ">
    @else
    <img src="{{$userProfile[0]->avatar}}" alt="user" width="160"
            class="rounded-circle ">
    @endif
        <h2 class="card-title pt-3" ><strong>{{$userProfile[0]->fullname}}</strong></h4>
    </div>
    <div class="pt-3"></div>
    <div  class="card-body">
        <h4><i class="fa fa-envelope"></i> {{$userProfile[0]->email}}</h4><br/>
        <h4><i class="fa fa-birthday-cake"></i> Thành viên từ {{date("F d, Y", strtotime($userProfile[0]->created_at))}}</h4><br/>
        
        @if($userProfile[0]->admin==0)
        <h4><i class="fa fa-user"> </i> Thành viên</h4>
        @else
        <h4><i class="fa fa-user"></i> Quản trị viên</i></h4><br/>
        @endif
        @if($userProfile[0]->about_me!='')
        <h4>Về tôi:</h4>
        <h4>"{{$userProfile[0]->about_me}}"</h4><br/>
        @endif
    </div>
</div>