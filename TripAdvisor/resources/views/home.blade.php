@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Destinations</div>
                <div class="panel-body">
                    @foreach($dests as $dest)
                    <div class="list-group">
                          <a href="#" class="list-group-item">
                            {{$dest->name}}
                          </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
