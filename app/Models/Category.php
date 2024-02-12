<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['videos'];

    protected $casts = [
        'video_id_array' => 'array',
    ];

    protected $hidden = [
        'created_at',
        'updated_at', 'order_index', 'status', 'video_id_array', 'id'
    ];

    public function getVideosAttribute()
    {
        if (empty($this->video_id_array)) {
            return collect();
        }

        return Video::whereIn('id', $this->video_id_array)->select('name as title', 'description', 'duration', 'pictures', 'thumb_image', 'direct_url', 'player_embed_url', 'link')->get();
    }
}
