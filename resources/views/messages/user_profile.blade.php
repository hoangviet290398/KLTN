<div id="userProfile" class="text-center">
    <div class="card-body pt-5 border-bottom">
        <img src="https://res.cloudinary.com/mhmd/image/upload/v1564960395/avatar_usae7z.svg" alt="user" width="160"
            class="rounded-circle ">
        <h2 class="card-title pt-3" ><strong>{{$userProfile[0]->fullname}}</strong></h4>
    </div>
    <div class="pt-3"></div>
    <div  class="card-body">
        <h4><i class="fa fa-envelope"></i> {{$userProfile[0]->email}}</h4><br/>
        <h4><i class="fa fa-birthday-cake"></i> Member since {{date("F d, Y", strtotime($userProfile[0]->created_at))}}</h4><br/>
        
        @if($userProfile[0]->admin==0)
        <h4><i class="fa fa-user"> </i> Member</h4>
        @else
        <h4><i class="fa fa-user"></i> Administrator</i></h4><br/>
        @endif
        @if($userProfile[0]->about_me!='')
        <h4>Biography:</h4>
        <h4>"{{$userProfile[0]->about_me}}"</h4><br/>
        @endif
    </div>
</div>