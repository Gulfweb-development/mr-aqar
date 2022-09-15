<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArchiveAdvertisingController extends Controller
{
    public function store()
    {
        $user=Auth::user();
        $user->archiveAdvertising()->attach([\request('advertising_id')]);
        return $this->success('success');

    }

    public function destroy()
    {
        $user=Auth::user();
        $user->archiveAdvertising()->detach(\request('advertising_id'));
        return $this->success('success');

    }
}
