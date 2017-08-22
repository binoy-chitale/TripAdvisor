@extends('layouts.app')
@section('content')
<div class="container">
        <div class="row" style="display:flex;flex-wrap:wrap; justify-content:flex-start;">
                @foreach($dests as $dest)
                <div onclick="window.location.href = '/view/{{$dest->name}}';" class="panel panel-default tile" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5),rgba(0, 0, 0, 0.5)),url(&quot;/images/{{$dest->name}}.jpg&quot;);">
                <p class="title" align="center">{{$dest->name}}</p>
            	</div>
                @endforeach
        </div>
</div>
@endsection
