@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" style="text-align:center;"><h1>{{$name}}</h1> </div>
                	{!!Form::open(array('action' => 'CategoryController@getCategories', 'url'=>'/plan/'.$name))!!}
                	<div class="panel-body">
                        <div style="display:flex;">
                            <input type="date" name="start_date" class="datepick"><input type="date" name="end_date" class="datepick"><br>
                        </div><br>
                        @foreach($categories as $category)
						            <label for="btn_{{$category->name}}">{{$category->name}}</label> 
                                    <input class="cbox" id="btn_{{$category->name}}"type="checkbox" value="{{$category->name}}" name= "catvalues[]"/>
                    	@endforeach
						 <br><button type="submit" class="btn btn-plan" >Plan!</button>         
                    </div>
                    <?php 
                    $attractions = serialize($attractions); 
                    ?>

                    {!!Form::hidden('attractions',  $attractions)!!}
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('js/catview.js') }}"></script>
@endsection