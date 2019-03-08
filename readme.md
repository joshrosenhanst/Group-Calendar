# Group Calendar
A collaborative event planner and calendar website built with Laravel.

## Requirements
- Laravel 5.7 https://laravel.com/docs/5.7#server-requirements

## Dev Instructions
1. Clone Repo
2. Make a local copy of `.env.example` via `cp .env.example .env`. Edit the `.env` file with local settings.
3. Create an app key: `php artisan key:generate`
4. Create a symbolic link for the storage folder: `php artisan storage:link`
5. You may need to create the following `/storage/app/public/` folders: `groups`, `events`, `avatars`