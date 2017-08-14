@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{$name}}</div>
                	{!!Form::open(array('url'=>'/plan/'.$name))!!}
                    <div class="panel-body">
                		@foreach($categories as $category)
                            <?php
                                $catValue = str_replace(' ', '%20', $category->name);
                            ?>

						    <div class="list-group">
        	            	    <p class="list-group-item">
        	            	    	<input type="checkbox" value={{$catValue}} name= "catvalues[]"/>
										{{$category->name}}	
								</p>
                        	</div>
                    	@endforeach
						 <button type="submit" class="btn btn-default" >Plan!</button>         
                    </div>
                    {!!Form::hidden('attractions',$attractions)!!}
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection