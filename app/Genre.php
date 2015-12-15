<?php

namespace App;

use App\Custom\Active\ActiveModel;

class Genre extends ActiveModel
{
    protected $table = 'genres';
    protected $fillable = ['name', 'alias'];

}
