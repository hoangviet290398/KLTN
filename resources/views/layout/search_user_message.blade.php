<a id="{{$user->id}}" data-receiverName="{{$user->fullname}}"
                                data-avatar="{{$user->avatar}}" href="#"
                                class="list-group-item list-group-item-action rounded-0">


                                <div class="media">
                                    @if(is_file('storage/avatars/'.$user->avatar))
                                    <img src="{{ asset('storage/avatars')}}/{{$user->avatar}}" alt="user" width="65" height="65"
                                        class="rounded-circle">
                                    @else
                                    <img src="{{$user->avatar}}" alt="user" width="65" height="65" class="rounded-circle">
                                    @endif
                                    <div class="media-body ml-4">
                                        <div id="userInboxName"
                                            class="d-flex align-items-center justify-content-between mb-1">
                                            <h6 id="{{$user->id}}name" class="mb-0" style="font-size:1.5rem">
                                                {{$user->fullname}}</h6>
                                            <!--Date-->
                                        </div>
                                        <div id="messagePreview">

                                            @foreach($latestUserMessages as $nestedArray1)
                                            @foreach($nestedArray1 as $nestedArray2)
                                            @foreach($nestedArray2 as $latestMessage)
                                            @if(($user->id == $latestMessage['from_user'] || $user->id ==
                                            $latestMessage['to_user']) && $user->id != Auth::user()->id)

                                            <div class="row pt-1 pb-2">
                                                @if($user->id != $latestMessage['from_user'] &&
                                                $latestMessage['from_user'] == Auth::user()->id)
                                                <p id="singleMessagePreview{{$latestMessage['to_user']}}"
                                                    class="truncateLongTexts col-8 mb-0 text-small  "
                                                    data-latestMessage="" style="font-size:1.15rem">Bạn:
                                                    {{$latestMessage['message']}}</p>

                                                @else
                                                <p id="singleMessagePreview{{$latestMessage['to_user']}}"
                                                    class="truncateLongTexts col-8 mb-0 text-small  "
                                                    style="font-size:1.15rem"
                                                    data-isMessageRead="{{$latestMessage['is_read']}}">
                                                    {{$latestMessage['message']}}</p>
                                                <!--message notification-->
                                                @if($latestMessage['is_read']==0)
                                                <span id="{{$latestMessage['from_user']}}messageNotification"
                                                    class="pending"></span>
                                                <script>
                                                unreadMessage("{{$user->id}}");
                                                </script>
                                                @endif
                                                @endif
                                                <p class="col-4 mb-0 text-small ">
                                                    {{date("F d", strtotime($latestMessage['created_at']))}}</p>
                                            </div>
                                            @endif
                                            @endforeach
                                            @endforeach
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </a>

<script>
$('.list-group-item').click(function() {
        $('.list-group-item').removeClass('active list-group-item-light');
        receiver_name = $(this).attr('data-receiverName');
        user_avatar = $(this).attr('data-avatar');

        $(this).addClass('active');

        receiver_id = $(this).attr('id');
        $.ajax({
            type: "GET",
            url: "messages/" + receiver_id,
            data: "",
            cache: false,
            success: function(data) {
                //alert(data);
                $('#messages').html(data);

                //appear current receiver 
                replace = document.getElementById("target_name");
                replace.innerHTML = "<strong>" + receiver_name + "</strong>";
                replace_avatar = document.getElementById("target_name");
                //show chatbox
                var isChatBoxDisplayed = document.getElementById("UserChatBox");
                if (isChatBoxDisplayed.style.display === "none") {
                    isChatBoxDisplayed.style.display = "block";

                }
                //show user profile
                var isProfileDisplayed = document.getElementById("UserProfile");
                if (isProfileDisplayed.style.display === "none") {
                    isProfileDisplayed.style.display = "block";

                }
                //hide welcome msg
                var isWelcomeDisplayed = document.getElementById("welcomeToMessage");
                if (isWelcomeDisplayed.style.display === "block") {
                    isWelcomeDisplayed.style.display = "none";

                }
                //remove unread message notification
                $('#' + receiver_id + 'messageNotification').removeClass('pending');
                $('#' + receiver_id).removeClass('font-weight-bold');
                $('#' + receiver_id + 'name').removeClass('font-weight-bold');
                // make a function to scroll down auto

                var objDiv = document.getElementById("chat-box");
                objDiv.scrollTop = objDiv.scrollHeight;
            }
        });



    });

    $('.list-group-item').click(function() {

        $.ajax({
            type: "GET",
            url: "getProfile/" + receiver_id,
            data: "",
            cache: false,
            success: function(data) {
                //alert(data);
                $('#userProfile').html(data);

            }
        });
    });

    //show unread message notification
    function unreadMessage(id) {
        //isMessageRead = $("#messageNotification").attr('data-userId');
        if ($('#' + id + 'messageNotification').length != 0) {
            $('#' + id).addClass('font-weight-bold');
            $('#' + id + 'name').addClass('font-weight-bold');

        }
        console.log(id);
    };
</script>
