@extends('layout.master')
@section('title','TechSolution - Connect, Learn and Share')
@section('content')

<main>

    <div class="mt-1 d-flex justify-content-center">
        @include('layout.leftpanel')
       <div class=" pt-5 pb-5 footer card col-7">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-xs-12 about-company">
                <h2>KẾT NỐI ĐẾN CHÚNG TÔI!</h2>
                <p class="pr-5 text-gray-50">Ghé thăm GitHub của chúng tôi để có project source code.</p>
                <p><a target="_blank" href="https://github.com/hoangviet290398/KLTN"><i class="fa fa-github-square fa-3x mr-1" style="color: black"></i></a></p>
            </div>
            <div class="col-lg-4 col-xs-12 links">
                <h4 class="mt-lg-0 mt-sm-3">Thành viên trong đội ngũ</h4>
                <ul class="m-0 p-0">
                    <h6>Quy Tran: </h6>
                    <li><a href="https://facebook.com/quytrandev" target="_blank"><i class="fa fa-facebook-square mr-3 pl-3"></i>Quy Tran</a></li>
                    <li>
                        <p class="mb-0"><i class="fa fa-phone mr-3 pl-3"></i> 038 5918 111</p>

                    </li>
                    <li>
                        <p><i class="fa fa-envelope-o mr-3 pl-3">
        
                                </i>quytrandev@gmail.com</p>
                    </li>
                    <h6>Hoang Viet: </h6>
                    <li><a href="https://facebook.com/hoangviet290398" target="_blank"><i class="fa fa-facebook-square mr-3 pl-3"></i>Hoang Viet</a></li>
                    <li>
                        <p class="mb-0"><i class="fa fa-phone mr-3 pl-3"></i> 0972 660 510</p>
                        <p><i class="fa fa-envelope-o mr-3 pl-3">
        
                        </i> phamviet2903@gmail.com</p>
                    </li>

                </ul>
            </div>
            <div class="col-lg-3 col-xs-12 location">
                <h4 class="mt-lg-0 mt-sm-4">Địa điểm</h4>
                <p><i class="fa fa-building mr-3"></i>TechSolution, Inc.</p>
                <p><i class="fa fa-home mr-3"></i>Số 01 Võ Văn Ngân, Quận Thủ Đức, Thành phố Hồ Chí Minh, Việt Nam, 700000</p>
                <p class="mb-0"><i class="fa fa-phone mr-3"></i>038 5918 111 - 0972 660 510</p>


            </div>
        </div>
        <div class="row mt-5">
            
        </div>
    </div>
</div>
        @include('layout.rightpanel')

</main>
@endsection