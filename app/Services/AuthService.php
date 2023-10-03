<?php

namespace App\Services;

use App\Models\User;

class AuthService
{
    /**
     * Creates user or updates chat_id in user's entity.
     *
     * @param string $userId  User's ID in Telegram
     *
     * @return User           Created or updated user
     */
    public function createOrGetExistingUser(string $userId): User
    {
        return User::firstOrCreate(['telegram_user_id' => $userId]);
    }

    /**
     * Validates initData to ensure that it is valid initialization data.
     *
     * @param string $initData  Initialization data (`Telegram.WebApp.initData`)
     *
     * @return bool             True if data is valid and false otherwise
     */
    public function isInitDataValid(string $initData): bool
    {
        [$checksum, $sortedInitData] = $this->convertInitDataForValidCheck($initData);
        $secretKey = hash_hmac('sha256', config('auth.bot_token'), 'WebAppData', true);
        $hash = bin2hex(hash_hmac('sha256', $sortedInitData, $secretKey, true));

        return 0 === strcmp($hash, $checksum);
    }

    /**
     * Converts init data to `key=value` and sort it alphabetically.
     *
     * @param string $initData  Initialization data (`Telegram.WebApp.initData`)
     *
     * @return string[]         Hash and sorted init data
     */
    protected function convertInitDataForValidCheck(string $initData): array
    {
        $initData = explode('&', rawurldecode($initData));
        $needle = 'hash=';
        $hash = '';

        foreach ($initData as &$data) {
            if (substr($data, 0, strlen($needle)) === $needle) {
                $hash = substr_replace($data, '', 0, strlen($needle));
                $data = null;
            }
        }

        $initData = array_filter($initData);
        sort($initData);

        return [$hash, implode("\n", $initData)];
    }
}
