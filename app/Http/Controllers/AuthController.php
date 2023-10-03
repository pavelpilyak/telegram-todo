<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class AuthController extends Controller
{
    protected AuthService $service;

    public function __construct()
    {
        $this->service = new AuthService();
    }

    public function prepare()
    {
        return Inertia::render('Auth/Login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'initData' => 'required|string',
            'chatId' => 'required|numeric',
        ]);

        dd($request->initData);
        dd($this->service->isInitDataValid($request->initData));

        abort(403);
    }
}
