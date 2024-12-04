<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\HilirasasiInovasi;

class UserController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $draft = HilirasasiInovasi::where('user_id', $userId)->where('status', 'draft')->first();
        $data = $draft ? $draft->toArray() : [];
        return view('pages.user.index', compact('data'));
    }
}
