<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Usamamuneerchaudhary\Commentify\Traits\Commentable;


class Design extends Model
{
    use HasFactory, Commentable;

    protected $fillable = [
        'name', 'thumbnail', 'marla', 'no_of_rooms', 'no_of_floors', 'description', 'type', 'category_id','price'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function requests()
{
    return $this->hasMany(Request::class);
}

}
