<?php 
$url = explode("/",$value->url);
?>

<ul class="list-group list-group-flush">
    <li class="list-group-item">
        <div class="row">
            <div class="col-2">
                <div class="card border-success mt-1 mb-4 mx-3" style="">
                    <div class="card-body text-success">
                        <p class="card-text text-center">0 <br>trả lời</br></p>
                    </div>
                </div>
            </div>
            <div class="col-10">
                <a href="/topic/{{ $url[4] }}" class="">{{ $value->title }}
                </a>
                <p class="card-text">{{ $value->body }}</p>
                <footer class="blockquote-footer text-right">đã hỏi: June 26th, 2019 at 17:02 bởi <cite
                        title="Source Title"><a href="">Quy Tran</a></cite>
                </footer>

            </div>
        </div>

    </li>

</ul>
