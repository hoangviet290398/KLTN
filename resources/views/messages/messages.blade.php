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
        left: 13px;
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
                            <img src="https://res.cloudinary.com/mhmd/image/upload/v1564960395/avatar_usae7z.svg"
                                alt="user" width="60" class="rounded-circle">
                            <p class="h4 mb-0 px-2 py-3">{{Auth::user()->fullname}} (you)</p>
                        </div>

                    </div>
                    <div class="messages-box">
                        <div class="list-group rounded-0">

                            @foreach($users as $user)
                            <a id="{{$user->id}}" data-receiverName="{{$user->fullname}}" href="#"
                                class="list-group-item list-group-item-action list-group-item-light rounded-0">

                                <span class="pending">1</span>
                                <div class="media"><img
                                        src="https://res.cloudinary.com/mhmd/image/upload/v1564960395/avatar_usae7z.svg"
                                        alt="user" width="50" class="rounded-circle">
                                    <div class="media-body ml-4">
                                        <div id="userInboxName"
                                            class="d-flex align-items-center justify-content-between mb-1">
                                            <h6 class="mb-0">{{$user->fullname}}</h6>
                                            <small class="small font-weight-bold">14 Dec</small>
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
            <div class="col-6 px-0 border-right">
                @include('messages.chatbox')

                <!-- Right side bar -->
            </div>
            <div class="col-3 px-0 ">
                <div class="bg-white">

                    <div class="bg-gray px-2 py-2 bg-light">
                        <p class="h5 mb-0 py-1">Recent</p>
                    </div>


                </div>
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
                replace.innerHTML = receiver_name;
            }
        });
    });

    function sendMessageOnClick() {
        if (message == '') {

            alert('Message cannot be empty!');
        } else if (receiver_id == '') {
            alert('Choose a receiver to send message!');

        } else if(message !='' && receiver_id!='') {
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