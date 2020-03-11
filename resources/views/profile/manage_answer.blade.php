@extends('layout.profile')

@section('title', 'Manage answer')

@section('contentprofile')
<h2 class="text-primary text-center">MANAGE ANSWERS</h2>
<hr class="my-3">
<div class="table-responsive">
    <table class="table table-hover" >
        <thead>
            <tr>
                <th scope="col">Question title - Answer content - Answer created time</th>
                <th scope="col" class="text-right">Edit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($answers as $answer)
            <tr style="line-height: 20px;">
                <th style="max-width: 700px;" class="">
                    {{$answer->question->title}}
                    <p class="font-weight-normal m-0 pv-archiveText">{{$answer->content}}</p>
                    <small class="text-muted m-0">{{$answer->created_at}}</small>
                </th>
                <td class="text-right">
                    <a href="/editanswer/{{ $answer->_id }}" class="btn btn-sm btn-outline-dark" title="Edit answer"><i class="fa fa-pencil"></i></a>
                    
                </td>

            </tr>
            @endforeach

        </tbody>
    </table>
</div>
<div class="row px-3 pt-3 justify-content-sm-center">{!! $answers->links() !!}</div>
@endsection
