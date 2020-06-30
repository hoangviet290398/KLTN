
<?php
    $url = explode("/",$question->url)[4];
?>

<ul class="list-group list-group-flush">
    <li class="list-group-item">
        <div class="row">
            <div class="col-2">
                <div class="card border-success mt-1 mb-4 mx-3" style="">
                    <div class="card-body text-success">
                        <p class="card-text text-center">0 <br>Answer</br></p>
                    </div>
                </div>
            </div>
            <div class="col-10">
                <a href="/topic/{{ $url}}" class="">{{ $question->title }}
                </a>
                <p class="card-text pv-archiveText1">{{ $question->body }}</p>
                <footer class="blockquote-footer text-right">Asked by <cite
                        title="Source Title"><a href="#">Quy Tran</a></cite>
                </footer>

            </div>
        </div>

    </li>

</ul>