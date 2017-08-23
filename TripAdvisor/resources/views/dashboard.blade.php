@extends('layouts.app')
@section('content')
<body>
    <div>
        <div class="container">
            @foreach($attractions as $attr)
            <div class="col-md-3 col-sm-6 img__wrap search" id="card">
                <div onclick="window.location.href = '/dest/{{$name}}/{{$attr->name}}';" class="card hvrbox">
                    <div class="container">    
                        <?php
                            $attri = (json_decode($attr));
                            $images = (unserialize($attri->images));
                        ?>
                        @foreach ($images as $image)
                            <img src="{{$image}}" class="card-img-top image-city hvrbox-layer_bottom">
                            <?php break;?>
                        @endforeach
                        <?php
                            $maxPos = 39;
                            $flag=1;
                            $text=$attr->name;
                            if (strlen($text) > $maxPos){
                                $lastPos = ($maxPos - 3) - strlen($text);
                                $text = substr($text, 0, strrpos($text, ' ', $lastPos)) . '...';
                            }
                        ?>
                        <p id="text">{{$text}}</p>
                        <div class="hvrbox-layer_top">
                            <?php 
                            if(!preg_match('/ *reviews$/', $attr->description)){
                                $maxPos = 150;
                                $text=$attr->description;
                                if (strlen($attr->description) > $maxPos){
                                    $lastPos = ($maxPos - 3) - strlen($text);
                                    $text = substr($text, 0, strrpos($text, ' ', $lastPos)) . '...';
                                }   
                                echo '<p class=" hvrbox-text">'.$text.'</p>';
                            }
                            else{
                                echo '<p class=" hvrbox-text">'.$attr->name.'</p>';
                            }
                            ?>
                        </div>
                    </div>    
                </div>
             </div>                          
            @endforeach
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/search.js') }}"></script>
</body>
@endsection
