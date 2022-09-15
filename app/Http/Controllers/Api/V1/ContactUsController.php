<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ContactUs\Store;
use App\Models\Message;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function store(Store $request)
    {
        $message = Message::create($request->only('name', 'email', 'phone_number', 'message'));

        if ($message) return $this->success("Item Submit Successfully!");
        return $this->fail('something went wrong!');

    }
}
