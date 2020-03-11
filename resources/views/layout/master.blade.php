<!DOCTYPE html>
<html>
<head>
    @include('layout.css')
    @yield('css')
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body class="main-background">

    @include('layout.header')

    {{--  <a href="{{route('aboutUs')}}" type="button" class="btn btn-outline-info btn-about-us" style="z-index: 1;">About us</a> --}}
    
    @yield('content')

    @include('layout.js')
    @yield('js')

    <script>
      

       $('#search').keyup(function () {
        var keyword = $(this).val();
        if (keyword != '') {
            $.ajax({
                url: "{{ route('ajaxSearch') }}",
                method: "GET",
                data: {
                    keyword
                },
                success: function (data) {
                  if(data!=""){
                    $('#result_list').empty();
                    $('#result_list').html(data);
                    $('#result_list').show();
                }
                else{
                    $('#result_list').hide();
                }
            }
        })
        }
        else{
            $('#result_list').hide();
        }
    });

       $('#searchTags').keyup(function () {
        var keyword = $(this).val();
        if (keyword != '') {
            $.ajax({
                url: "{{ route('ajaxSearchTags') }}",
                method: "GET",
                data: {
                    keyword
                },
                success: function (data) {
                    if(data!=""){
                        $('#allTags').empty();
                        $('#allTags').html(data);
                        $('#allTags').show();
                    }
                    else{
                        $('#allTags').hide();
                    }
                }
            })
        }
        else{
            $.ajax({
                url: "{{ route('ajaxSearchTags1') }}",
                method: "GET",
                data: {
                    keyword
                },
                success: function (data) {
                    if(data!=""){
                        $('#allTags').empty();
                        $('#allTags').html(data);
                        $('#allTags').show();
                    }
                    else{
                        $('#allTags').hide();
                    }
                }
            })
        }
    });

       $('#searchUsers').keyup(function () {
        var keyword = $(this).val();
        if (keyword != '') {
            $.ajax({
                url: "{{ route('ajaxSearchUsers') }}",
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
                url: "{{ route('ajaxSearchUsers1') }}",
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


       function submit_search(){
        if($('#search').val()!='') $('#searchform').submit();
    }
    @if(Auth::check())
    function read_notification(){
        $.ajax({
            url: "{{ route('readNotification') }}",
            method: "GET"
        })
        $("#notification_bell").removeClass("text-danger");
        $("#unread_notification").remove();
    }
    @endif


</script>
</body>
@include('layout.footer')
</html>
