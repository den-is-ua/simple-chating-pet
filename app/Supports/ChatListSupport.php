<?php

namespace App\Supports;

use App\Models\Chat;
use Illuminate\Support\Collection;

class ChatListSupport
{
    private Collection $list;
    
    public function __construct()
    {
        $this->list = new Collection();
    }
    
    public function add(Chat $chat): void
    {
        $this->list->push($chat);
    }
    
    public function getList(): Collection
    {
        return $this->list;
    }
}
