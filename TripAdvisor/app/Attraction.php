<?php

namespace TripAdvisor;

use Illuminate\Database\Eloquent\Model;

class Attraction extends Model
{
    protected $table = 'attractions'; 
    public $timestamps = false;
}
