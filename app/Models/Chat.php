<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'chat';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['sender_id', 'recipient_id', 'last_message'];
}
