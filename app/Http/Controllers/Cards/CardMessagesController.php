<?php

namespace App\Http\Controllers\Cards;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CardMessagesController extends Controller
{
    public array $messages;

    public function addMessage ($type, $key, $value)
    {
        $this->messages[$type] [$key] = $value;
    }
}
