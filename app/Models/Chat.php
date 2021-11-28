<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'username',
        'chat_text'
    ];

    public function group(){
        return $this->belongsTo(Group::class);
    }
}
