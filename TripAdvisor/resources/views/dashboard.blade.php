@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Paris</div>
                <!-- @foreach ($attractions as $att) -->
                <div class="panel-body">
                    {{$attractions}}
                </div>
                <!-- @endforeach -->
            </div>
        </div>
    </div>
</div>
@endsection
