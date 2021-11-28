<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'desc',
    ];

    public function users(){
        return $this->belongsToMany(User::class)
        ->withTimestamps()
        ->wherePivot('status',1);
    }

    public function pending_users(){
        return $this->belongsToMany(User::class)
        ->withTimestamps()
        ->wherePivot('status',0);
    }

    public function owners(){
        return $this->belongsToMany(User::class)
        ->withTimestamps()
        ->wherePivot('is_owner',1);
    }

    public function chats(){
        return $this->hasMany(Chat::class);
    }
}
