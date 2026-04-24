<?php

namespace App\Supports;

use App\NoSqlModels\Message;
use Illuminate\Support\Collection;

class MessageListSupport
{
    private Collection $list;
    
    public function __construct()
    {
        $this->list = new Collection();
    }
    
    public function add(Message $message): void
    {
        $this->list->push($message);
    }
    
    /**
     * 
     * @return Collection|Message[]
     */
    public function getList(): Collection
    {
        return $this->list;
    }
}
