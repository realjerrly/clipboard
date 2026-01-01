<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Paste extends Model {
    use HasFactory;
    protected $fillable = ['title', 'content', 'slug', 'views', 'expiration_date', 'user_id'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot() {
        parent::boot();
        static::creating(function ($paste) {
            if (empty($paste->slug)) {
                $paste->slug = Str::random(10);
            }
        });
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}