<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category_slave extends Model
{
    use HasFactory;
    protected $table = 'category_slave';

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
