<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $list=  Message::orderBy("id","desc")->paginate(25);
        return view("messages.index",compact('list'));
    }
}
