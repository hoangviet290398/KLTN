    <div id="messages" >
        <div class="bg-gray px-4 py-2 bg-white border-bottom">
            <!-- Receiver name -->
            <div class="row">
                
                <p id="target_name" class="h4 mb-0 px-2 py-3"></p>
            </div>
        </div>
        <div id="chat-box" class="px-4 py-5 chat-box bg-white">
            <!-- Sender Message-->
            @foreach($messages as $message)
            @if($message->from_user == Auth::user()->id)

            <div class="media w-50 ml-auto mb-3">
                <div class="media-body">
                    <div class="bg-primary rounded py-2 px-3 mb-2">
                        <p class="text-small mb-0 text-white">{{$message->message}}</p>
                    </div>
                    <p class="small text-muted">{{date("H:i | F d, Y", strtotime($message->created_at))}}</p>
                </div>
            </div>
            <!-- Reciever Message-->
            @else
            <div class="media w-50 mb-3">
            @if(is_file('storage/avatars/'.$message->user->avatar))
                <img src="{{ asset('storage/avatars')}}/{{$message->user->avatar}}" alt="user"
                    width="50" height="50" class="rounded-circle">
            @else
            <img src="{{$message->user->avatar}}" alt="user"
                    width="50" height="50" class="rounded-circle">
            @endif
                <div class="media-body ml-3">
                    <div class="bg-light rounded py-2 px-3 mb-2">
                        <p class="text-small mb-0 text-muted">{{$message->message}}</p>
                    </div>
                    <p class="small text-muted">{{date("H:i | F d, Y", strtotime($message->created_at))}}</p>
                </div>
            </div>
            @endif
            @endforeach

        </div>
        <!-- Typing area -->
     
            <div class="input-group pl-4 pr-2 py-3">
                <input id="typing-area" type="text" placeholder="Type a message" aria-describedby="button-addon2"
                    autofocus class="form-control rounded-0 border-0 py-4 bg-light">
                <div class="input-group-append pl-1">
                    <button id="button-addon2" class="btn btn-link" onClick="sendMessageOnClick();"><i
                            class="fa fa-paper-plane"></i></button>
                </div>
            </div>
      

    </div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.14.1/moment.min.js">

    </script>
    <script>
// make a function to scroll down auto
// var objDiv = document.getElementById("chat-box");
// objDiv.scrollTop = objDiv.scrollHeight;


// $(document).on("keypress", function() {
//     $("#typing-area").focus();
// });
    </script>