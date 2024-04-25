<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class news_slave extends Model
{
    use HasFactory;
    protected $table = 'news_slave';

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(News::class);
    }
}
