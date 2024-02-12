<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'uri',
        'name',
        'description',
        'type',
        'link',
        'player_embed_url',
        'duration',
        'pictures',
        'thumb_image',
        'direct_url'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',  'id'
    ];
}
