<div class="row col-sm-12 bg-light py-3" style="">
    <div class="col-sm-3 px-1">
        <div class="border rounded text-muted bg-white text-center px-1">
            <i class="fa fa-thumbs-up"></i>
            {{$question->total_like}} likes
        </div>
    </div>
    <div class="col-sm-3 px-1">
        <div class="border rounded text-muted bg-white text-center">
            <i class="fa fa-thumbs-down"></i>
            {{$question->total_dislike}} dislikes
        </div>
    </div>

    <div class="col-sm-3 px-1">
        <div class="border rounded text-muted bg-white text-center">
            <i class="fa fa-comment"></i>
            {{$question->total_answer}} answers
        </div>
    </div>


    <div class="col-sm-3">
        @if(Auth::check())
        <a href="{{ route('viewTopic', ['id' => $question->id]) }}" class="border rounded text-light bg-dark text-center px-4 text-decoration-none" style="font-size:18px">Answer</a>
        @else
        <a href="/signin" class="border rounded text-light bg-dark text-center px-4 text-decoration-none" style="font-size:18px">Answer</a>
        @endif

    </div>

</div>