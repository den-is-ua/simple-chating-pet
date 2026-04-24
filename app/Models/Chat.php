<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasUuids;

    protected $table = 'chat';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['sender_id', 'recipient_id', 'last_message'];
}
