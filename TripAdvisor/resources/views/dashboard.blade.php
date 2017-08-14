@extends('layouts.app')
@section('content')
@php ($i=0)

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{$name}}</div>
                    <div class="panel-body">
                        @foreach($attractions as $attr)
                            <div class="list-group">
                                <p class="list-group-item">
                                    {{$attr->name}}
                                    <?php 
                                        $attri = (json_decode($attr));
                                        $images = (unserialize($attri->images));
                                    ?>
                                    @foreach ($images as $image)
                                        <img src="{{$image}}" class="image-city ">
                                    @endforeach        
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection