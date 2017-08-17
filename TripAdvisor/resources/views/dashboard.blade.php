@extends('layouts.app')
@php ($i=0)
<body>
    <div>
        <div class="container">
            @foreach($attractions as $attr)
            <div class="col-md-3 col-sm-6 img__wrap" >
                <div onclick="window.location.href = '/dest/{{$name}}/{{$attr->name}}';" class="card">
                    <div class="container" id ="flex-container">    
                        <?php
                            $attri = (json_decode($attr));
                            $images = (unserialize($attri->images));
                        ?>
                        @foreach ($images as $image)
                            <img src="{{$image}}" class="card-img-top image-city ">
                            <?php break;?>
                        @endforeach
                        <p>{{$attr->name}}</p>
                        <p class="img__description" style="opacity: 0.6; background-image=url('{{$image}}');">{{$attr->description}}</p>
                    </div>    
                </div>
             </div>                          
            @endforeach
        </div>
    </div>
</body>