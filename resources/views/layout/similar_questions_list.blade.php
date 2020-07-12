<ul class="list-group list-group-flush">
    <li class="list-group-item">
        <div class="row">
            <div class="col-2">
                <div class="card border-success mt-1 mb-4 mx-3" style="">
                    <div class="card-body text-success">
                        <p class="card-text text-center">{{ $question->total_answer}} <br>trả lời</br></p>
                    </div>
                </div>
            </div>
            <div class="col-10">
                <a href="/topic/{{ $question->_id}}" class="">{{ $question->title }}
                </a>

                <p class="card-text pv-archiveText1">{{ strip_tags($question->content) }}</p>
                <footer class="blockquote-footer text-right">
                    đã hỏi: {{$question->created_at->toDayDateTimeString()}} bởi <cite
                        title="Source Title"><a href="">{{ $question->user->fullname}}</a></cite>
                </footer>

            </div>
        </div>

    </li>

</ul>
