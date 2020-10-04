# Group Calendar
A collaborative event planner and calendar website built with Laravel.

<p align="center"><a href="https://joshrosenhanst.com/groupcalendar/"><img src="https://joshrosenhanst.com/assets/img/groupcalendar/banner.png" width="400" alt="GroupCalendar Preview"></a></p>

## Requirements
- Laravel 5.7+ https://laravel.com/docs/5.7#server-requirements
- Composer
- NPM

## Dev Instructions
1. Clone Repo
2. Make a local copy of `.env.example` via `cp .env.example .env`. Edit the `.env` file with local settings.
3. Install the dependencies with `npm install` and `composer install`
4. Create an app key: `php artisan key:generate`
5. Create a symbolic link for the storage folder: `php artisan storage:link`
6. Create the `groupcalendar` database table (or whatever table name you set in the `.env` file)
7. Create the database table and seed the demo users/groups: `php artisan migrate:fresh --seed`
    - You may need to update Laravel permissions: https://laravel.com/docs/5.8/installation#configuration
    - You may need to create the following `/storage/app/public/` directories if they don't exist: 
        - `groups`
        - `events`
        - `avatars`
        - `flyers`
8. Generate the CSS and JS assets:
    - `npm run dev` - Dev assets including sourcemaps.
    - `npm run watch` - Update the dev assets when the source assets are updated.
    - `npm run prod` - Production assets including minification and version busting.
9. GroupCalendar uses a queue system to offload event flyer PDF generation. For dev you can use the default `sync` driver for the queue jobs to be processed immediately or you can use the `database` driver and Supervisor to manage the queues:
    1. Install [Supervisor](https://github.com/Supervisor/supervisor) to manage queue workers: `sudo apt-get install supervisor`
    2. Create `groupcalendar-worker.conf` file in the Supervisor config directory, usually found at `/etc/supervisor/conf.d` (replace the directory below with your dev directory): 
      ```
      [program:groupcalendar-worker]
      process_name=%(program_name)s_%(process_num)02d
      command=php /var/www/groupcalendar/artisan queue:work --sleep=3 --tries=5
      autostart=true
      autorestart=true
      user=www-data
      numprocs=8
      redirect_stderr=true
      stdout_logfile=/var/www/groupcalendar/log/worker.log
      ```
    3. Start the GroupCalendar queue processes:
      ```
      sudo supervisorctl reread
      sudo supervisorctl update
      sudo supervisorctl start groupcalendar-worker:*
      ```
10. If you are using the `database` driver, but not using Supervisor, you will need to run artisan queue commands:
    - `php artisan queue:work --tries=5` - Start working queue jobs, allow 5 attempts per job and then the job will be marked as failed.
    - `php artisan queue:restart` - Restart the queue worker, required after any change to the code as queue workers will not pick up any code changes without a restart.