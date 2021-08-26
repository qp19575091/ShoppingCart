<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'price', 'quantity_left'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function($model) {
	        $model->name = Str::random(5);
	    });
        static::created(function ($model) {
            $model->name = Str::random(10);
        });
    }

    public function scopeUserProduct($query)
    {
        return $query->where('id', $this->id)->where('user_id', auth()->user()->id);
    }

    public function carts()
    {
        return $this->belongsTo(Cart::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
