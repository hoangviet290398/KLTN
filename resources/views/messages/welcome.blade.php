<!DOCTYPE html>
<html lang="en">

<head>

    @include('messages.messagecss')
    @yield('messagespublic/css')
</head>

<body>
    <div class="circles">
        <p>Welcome to chat!<br>
            <small>Choose a user to send message.</small>
        </p>
        <span class="circle big"></span>
        <span class="circle med"></span>
        <span class="circle small"></span>
    </div>
</body>