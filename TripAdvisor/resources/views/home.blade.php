@extends('layouts.app')
@section('content')
<ol class="breadcrumb">
  <li class="active">Home</li>
</ol>
<div class="container">
        <div class="row" style="display:flex;flex-wrap:wrap; justify-content:flex-start;">
                @foreach($dests as $dest)
                <div class="panel panel-default tile" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5),rgba(0, 0, 0, 0.5)),url(&quot;/images/{{$dest->name}}.jpg&quot;);">
                <div class="button" ><button class="buttonleft" onclick="window.location.href = '/view/{{$dest->name}}';">PLAN</button></div>
                <div class="title">{{$dest->name}}</div>
	            <div class="button"><button class="buttonright" onclick="window.location.href = '/dest/{{$dest->name}}';"> VIEW </button></div>
                </div>
                @endforeach
        </div>
</div>
@endsection
