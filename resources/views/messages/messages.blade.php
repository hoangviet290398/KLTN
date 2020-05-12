<!DOCTYPE html>
<html lang="en">

<head>

    @include('messages.messagecss')
    @yield('messagespublic/css')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.14.1/moment.min.js"></script>
    <script src="https://js.pusher.com/6.0/pusher.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
    .pending {
        position: absolute;
        left:65px;
        top: 9px;
        background: #FF6347;
        margin: 0;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        line-height: 18px;
        padding-left: 5px;
        color: #ffffff;
        font-size: 12px;
    }
    </style>
</head>

<body>
    <div class="wrapper rounded-lg overflow-x-hidden shadow">
        <div class="row">
            <!-- Users box-->
            <div class="col-3 px-0 border-right">
                <div class="bg-white">

                    <div class="px-4 py-2  ">
                        <div class="row px-2 align-center">
                            <a href="/" style="color:#0275d8"><i class="fa fa-arrow-left fa-2x pr-2 pt-2"></i></a>
                            
                            <img src="https://res.cloudinary.com/mhmd/image/upload/v1564960395/avatar_usae7z.svg"
                                alt="user" width="50" class="rounded-circle">
                            <p class="h4 mb-0 px-2 py-3">{{Auth::user()->fullname}} (you)</p>
                        </div>

                    </div>
                    <div class="messages-box">
                        <div class="list-group rounded-0">

                            @foreach($users as $user)
                            <a id="{{$user->id}}" data-receiverName="{{$user->fullname}}" href="#"
                                class="list-group-item list-group-item-action list-group-item-light rounded-0">

                                <span id="messageNotification" class="pending">0</span>
                                <div class="media"><img
                                        src="https://res.cloudinary.com/mhmd/image/upload/v1564960395/avatar_usae7z.svg"
                                        alt="user" width="65" class="rounded-circle">
                                    <div class="media-body ml-4">
                                        <div id="userInboxName"
                                            class="d-flex align-items-center justify-content-between mb-1">
                                            <h6 class="mb-0 " style="font-size:1.4rem"><strong>{{$user->fullname}}</strong></h6>
                                            <!--Date-->
                                            <small class="small font-weight-bold"></small>
                                        </div>
                                        <p class="font-italic mb-0 text-small">{{$user->email}}</p>
                                    </div>
                                </div>
                            </a>

                            @endforeach


                        </div>
                    </div>
                </div>
            </div>
            <!-- Chat Box-->

            <div id="UserChatBox" style="display:none" class="col-6 px-0 border-right">
                @include('messages.chatbox')

            </div>
            <div id="UserProfile" class="col-3" style="display:none">
                @include('messages.user_profile')
            </div>
            <div id="welcomeToMessage" style="display:block" class="col-9">
                @include('messages.welcome')

            </div>
        </div>

    </div>
    </div>
    <script>
    var receiver_id = '';
    var my_id = '{{ Auth::user()->id }}';

    var receiver_name = '';
    var message = '';

    // ajax setup form csrf token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $('.list-group-item').click(function() {
        $('.list-group-item').removeClass('active list-group-item-light');
        receiver_name = $(this).attr('data-receiverName');


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
                // make a function to scroll down auto

                var objDiv = document.getElementById("chat-box");
                objDiv.scrollTop = objDiv.scrollHeight;
            }
        });



    });

    $('.list-group-item').click(function() {

        $.ajax({
            type: "GET",
            url: "profile/" + receiver_id,
            data: "",
            cache: false,
            success: function(data) {
                //alert(data);
                $('#userProfile').html(data);

            }
        });
    });

    function sendMessageOnClick() {
        if (message == '') {

            alert('Message cannot be empty!');
        } else if (receiver_id == '') {
            alert('Choose a receiver to send message!');

        } else if (message != '' && receiver_id != '') {
            alert(message);
            $('.input-group input').val(''); // while pressed enter text box will be empty

            var datastr = "receiver_id=" + receiver_id + "&message=" + message;
            $.ajax({
                type: "post",
                url: "messages", // need to create this post route
                data: datastr,
                cache: false,
                success: function(data) {},
                error: function(jqXHR, status, err) {},
                complete: function() {
                    //scrollToBottomFunc();
                }
            })
        }

    }
    $(document).on('keyup', '.input-group input', function(e) {
        message = $(this).val();
        // check if enter key is pressed and message is not null also receiver is selected
        if (e.keyCode == 13 && message != '' && receiver_id != '') {
            alert(message);
            $(this).val(''); // while pressed enter text box will be empty

            var datastr = "receiver_id=" + receiver_id + "&message=" + message;
            $.ajax({
                type: "post",
                url: "messages", // need to create this post route
                data: datastr,
                cache: false,
                success: function(data) {},
                error: function(jqXHR, status, err) {},
                complete: function() {
                    //scrollToBottomFunc();
                }
            })
        }
    });

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('0d5466969582ad7a648f', {
        cluster: 'ap1',
        forceTLS: true
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
        //alert(JSON.stringify(data));

        if (my_id == data.from_user) {
            $('#' + data.to_user).click();
        } else if (my_id == data.to_user) {
            if (receiver_id == data.from_user) {
                // if receiver is selected, reload the selected user ...
                $('#' + data.from_user).click();
            } else {
                // if receiver is not seleted, add notification for that user
                var isDisplayed = document.getElementById("messageNotification");

                var pending = parseInt($('#' + data.from_user).find('.pending').html());
                if (pending) {
                    $('#' + data.from_user).find('.pending').html(pending + 1);

                } else {
                    $('#' + data.from_user).append('<span class="pending">1</span>');
                }
            }
        }
    });
    </script>
</body>


</html>