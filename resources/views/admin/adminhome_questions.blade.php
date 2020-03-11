<!DOCTYPE html>
<html lang="en">

<head>

    @include('admin.admincss')
    @yield('adminpublic/css')
</head>

<body>
    <div class="wrapper">
        <div class="row">
            <div class="col-sm-2">
                @include('admin.layout.adminsidebar')

            </div>

            <div class="col-sm-10">
                @include('admin.layout.adminheader_questions')
            </div>

        </div>
    </div>
    

</body>

</html>