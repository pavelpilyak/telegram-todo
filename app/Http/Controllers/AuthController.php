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

    /**
     * Render page which gets Telegram data and sends it to `AuthController@login` method.
     */
    public function prepare()
    {
        return Inertia::render('Auth/Login');
    }

    /**
     * Authenticate user based on Telegram data.
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    public function login(Request $request)
    {
        // basic validation of Telegram's initData
        $request->validate(['initData' => 'required|string']);

        // checking initData validity
        if (!$this->service->isInitDataValid($request->initData)) {
            abort(403);
        }

        // parsing telegram's user data
        parse_str($request->initData, $initData);
        $tgUserData = json_decode($initData['user'] ?? '', true);

        if (!isset($tgUserData['id']) || empty($tgUserData['id'])) {
            abort(403);
        }

        // creating new user or getting existing one if it's not the first authorization attempt
        $user = $this->service->createOrGetExistingUser((string)$tgUserData['id']);
        Auth::login($user);

        return redirect(route('tasks.index'));
    }
}
