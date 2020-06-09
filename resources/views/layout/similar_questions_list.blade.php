<?php 
$url = explode("/",$value->url);
?>
<a href="/topic/{{ $url[4] }}" class="dropdown-item"><small>{{ $value->title }}</small></a>