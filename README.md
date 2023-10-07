## About
This is a [Telegram Mini App](https://core.telegram.org/bots/webapps) which is a simple To-Do with user authentication and the ability to notify the user about tasks. 

You can see an example [here](https://t.me/todoomer_bot).

### Technologies
The backend is written in [Laravel](https://laravel.com/) using [Inertia](https://inertiajs.com/). Frontend is written in [Vue 3](https://vuejs.org/). [Telegraph](https://github.com/defstudio/telegraph) is used as a framework for writing the bot.

## Structure
[Here's more](https://laravel.com/docs/10.x/lifecycle) about architecture and lifecycle in Laravel.

The main things in this app are:
- Communication between the user and the bot is done using a webhook in `app/Http/Webhooks/TelegramBotHandler.php`.
- The frontend is located in `resources/js`.

## How to Deploy
Depending on your server environment, the settings may vary. [Here's Laravel deploy instruction](https://laravel.com/docs/10.x/deployment#main-content).

Steps which are important to this project:
1. You need an SSL certificate to interact with Telegram Webhooks.
2. For notifications to work, you need to [set up a cron](https://laravel.com/docs/10.x/scheduling#running-the-scheduler)
3. Rename `.env.example` in the root of the project to `.env`, fill it out (`APP_URL`, database login data, `BOT_TOKEN` and `BOT_USERNAME`) and run these commands:
    ```
    php artisan key:generate
    php artisan migrate
    ```
4. To add your bot to app run this command ([here's telegraph instructions](https://defstudio.github.io/telegraph/quickstart/register-new-bot)):
    ```
    php artisan telegraph:new-bot
    ```
5. Setup a webhook for your bot (for this step `APP_URL` in `.env` should be correct):
    ```
    php artisan telegraph:set-webhook
    ```
6. Now build the frontend:
    ```
    nvm use
    npm ci
    npm run build
    ```
7. Link your domain to the bot: send `/setdomain` to [@Botfather](https://t.me/botfather) in Telegram.
8. Using [@Botfather](https://t.me/botfather) customize a menu button (`/mybots` > Select your bot > "Bot Settings" > "Menu Button" > "Configure Menu Button") with this link: `https://YOUR_APP_LINK.com/auth`.

That's it!

## Local Development
1. Clone this project.
2. Install backend dependencies:
   ```
   composer install
   ```
3. Rename `.env.example` in the root of the project to `.env` and run this command:
   ```
   php artisan key:generate
   ```
4. [Laravel Sail](https://laravel.com/docs/10.x/sail#installing-sail-into-existing-applications) is used for local development, so to start backend run this command:
   ```
   php artisan sail:install
   ./vendor/bin/sail up
   ```
5. And to build frontend:
   ```
   nvm use
   npm ci
   npm run dev
   ```

You should now be able to go to http://localhost/auth, but for now it will render an error, because Telegram data is sabotaged. To fix this, you need to create a fake user.

To create a fake user you can use [Tinker](https://laravel.com/docs/10.x/artisan#tinker). Step into your docker container and run these commands:
```
php artisan tinker

> \App\Models\User::create(['telegram_user_id' => 'test']);
> quit
```
To authenticate under this user you can use this hack: in `app/Http/Controllers/AuthController.php` add this line to `prepare()` method:
```
Auth::loginUsingId(1); // Or use any other existing user's ID
```

## Potential Problems
- With a large number of task entries, the frontend can lag. To fix this, virtual scroll need to be added to the list view.
