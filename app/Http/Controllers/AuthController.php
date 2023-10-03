<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $request->validate(['initData' => 'required|string']);

        if (!$this->service->isInitDataValid($request->initData)) {
            abort(403);
        }

        parse_str($request->initData, $initData);
        $tgUserData = json_decode($initData['user'] ?? '', true);

        if (!isset($tgUserData['id']) || empty($tgUserData['id'])) {
            abort(403);
        }

        $user = $this->service->createOrGetExistingUser((string)$tgUserData['id']);
        Auth::login($user);

        return redirect(route('tasks.index'));
    }
}
