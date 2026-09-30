Project Code: WST21 -12:00-1:30pm-2026-MW
Student Name: Andrew A. Debuayan
Course & Year: BSIT-2
Database Used: MYSQL
Features:
- Add Task
<img width="1838" height="938" alt="{1E67D5F8-5E6F-4CF6-B612-0DD9E267D4A0}" src="https://github.com/user-attachments/assets/1a66b74c-a332-4430-9b77-b7fcb101b8b7" />
- View Tasks
<img width="1907" height="973" alt="{03AC1157-1E8A-4ADC-B0B6-610A15AEE316}" src="https://github.com/user-attachments/assets/d54f66e9-5e28-422b-9c5b-a32f1caa1009" />
- Edit Task
<img width="1920" height="937" alt="{A3F96A36-B8A2-47C9-B9C8-AF4F08EA2CAF}" src="https://github.com/user-attachments/assets/6a427b6a-1bd3-4ff9-a176-5cb10fa53f05" />
- Delete Task
<img width="1903" height="842" alt="{58DDF270-6FBE-4277-8B87-804ECC44B21A}" src="https://github.com/user-attachments/assets/eb68d811-f7c6-40e9-a254-33101e811077" />
<img width="1920" height="937" alt="{E70D6EE1-B0B0-4A28-ACE6-925864E8344A}" src="https://github.com/user-attachments/assets/2d56dc6c-c429-458c-92d2-363a78c94c95" />
- Update Status
<img width="1920" height="958" alt="{4B67D389-01FD-4679-B708-CB31224DC24E}" src="https://github.com/user-attachments/assets/73ab2a34-82c2-4624-ab0a-482c4eb70591" />

# Personal Task Manager: Step-by-Step Project Guide

This guide describes the current code, not earlier versions of the project. The active task experience is a Laravel MVC application: routes dispatch requests to a controller, Eloquent reads and writes SQLite, and Blade renders HTML.

**A. What the Application Does**

The task manager lets a visitor view all tasks, add a task, edit its fields and status, and delete it. The task list also shows total, pending, and completed counts. The current implementation stores tasks in a shared table; it does not associate tasks with individual users.

**B. Main Request Flow**

1. A browser requests `/`. The closure in `routes/web.php` redirects to the named `tasks.index` route.
2. Laravel matches that route to `TaskController::index()`.
3. The controller loads all tasks, newest first, and separately counts all, pending, and completed tasks.
4. The controller passes those values to `resources/views/tasks/index.blade.php`.
5. The view extends `resources/views/layouts/app.blade.php`, which supplies the navigation, shared CSS, success-message area, and content slot.
6. The browser renders the resulting HTML. The task list offers links to create or edit tasks and a form to delete each task.

The task pages are server-rendered. A form submission goes back to Laravel, changes the database, and usually redirects to the task list; the browser then makes a new GET request and receives fresh data.

**C. Task Routes**

`routes/web.php` redirects `/` to the task list and declares `Route::resource('tasks', TaskController::class)->except(['show'])`. The resource declaration maps to these six actions:

| Method | URL | Route name | Controller action |
| --- | --- | --- | --- |
| GET | `/tasks` | `tasks.index` | List tasks and counts |
| GET | `/tasks/create` | `tasks.create` | Show the new-task form |
| POST | `/tasks` | `tasks.store` | Validate and insert a task |
| GET | `/tasks/{task}/edit` | `tasks.edit` | Show the edit form |
| PUT or PATCH | `/tasks/{task}` | `tasks.update` | Validate and update a task |
| DELETE | `/tasks/{task}` | `tasks.destroy` | Delete a task |

The omitted `show` action would normally display one task on its own page; this project has no such page. Laravel's route model binding resolves `{task}` to a `Task` model for `edit`, `update`, and `destroy`. An unknown ID results in a 404 response.

**D. What Happens When a Task Is Added**

1. The Add Task link requests `GET /tasks/create`; `create()` returns `tasks.create`.
2. The form sends `task_name`, `description`, `status`, and `due_date` to `POST /tasks`. `@csrf` adds Laravel's cross-site request forgery token.
3. `store()` validates the name, optional description, status (`Pending` or `Completed`), and optional date.
4. If validation succeeds, `Task::create($request->all())` inserts a row. The model's `$fillable` list permits only the four task fields to be mass-assigned.
5. The controller redirects to `tasks.index` with a one-request success message. The shared layout displays that message after the redirect.

If validation fails, Laravel redirects back with validation errors and old form input. The form views render field errors with `@error` and repopulate most fields with `old(...)`.

**E. What Happens When a Task Is Edited or Deleted**

Editing follows the same server round trip. The edit link requests `/tasks/{task}/edit`; Laravel loads the task and injects it into `edit(Task $task)`. The form submits a POST with `@method('PUT')`, which Laravel interprets as an update. `update()` validates the submitted fields, updates the existing row, and redirects with a success message. Changing the status is done through this edit form; there is no separate status-toggle route.

Deleting uses a POST form with `@method('DELETE')` and `@csrf`. The browser's confirmation dialog is only a convenience; `destroy()` performs the actual deletion. The controller then redirects back to the task list.

**F. Data Model and Database**

`app/Models/Task.php` is an Eloquent model for the `tasks` table. Its `$fillable` attributes are `task_name`, `description`, `status`, and `due_date`. It does not define a date cast, so the list view parses a non-empty due date with Carbon before formatting it.

The migration `database/migrations/2026_09_22_174601_create_tasks_table.php` creates:

- An auto-incrementing integer ID.
- A required string task name.
- A nullable text description.
- A string status defaulting to `Pending`.
- A nullable date due date.
- `created_at` and `updated_at` timestamps.

Status is a string column, not a database enum. The controller's validation rule is what restricts normal form submissions to `Pending` or `Completed`.

The checked-in README mentions MySQL, but the current local `.env` selects SQLite. Laravel uses `database/database.sqlite` for that connection, and migrations create the schema from the migration files. A migration is the repeatable definition of a schema change; `php artisan migrate` applies migrations that have not run yet.

**G. Validation, Forms, and Rendering**

Both `store()` and `update()` apply the same rules:

```php
'task_name' => 'required|string|max:255',
'description' => 'nullable|string',
'status' => 'required|in:Pending,Completed',
'due_date' => 'nullable|date',
```

Blade's `{{ ... }}` syntax escapes displayed values. `@csrf` protects state-changing forms, while `@method('PUT')` and `@method('DELETE')` let HTML forms use Laravel's update and delete routes. The index uses `@forelse` to show either task rows or an empty state.

The controller calls `validate()` and then passes `$request->all()` to the model. `$fillable` prevents other request keys from becoming task columns, but passing the validated data returned by validation would make the allowed input explicit at the controller boundary.

**H. Authentication and Access Boundaries**

This repository also contains Laravel Fortify authentication features. `FortifyServiceProvider` connects login, registration, password reset, verification, two-factor, and passkey flows to their views and actions. `User` implements email verification and passkey support, and uses Laravel's two-factor authentication trait. The separate settings routes in `routes/settings.php` require authentication, and some also require verified email.

The task routes in `routes/web.php` are not inside an `auth` middleware group. As written, task list and task mutations are reachable without signing in. Tasks also have no `user_id` column or user relationship, so all visitors operate on the same task collection. This is an important distinction: the presence of login and account settings does not currently make the task data private.

**I. Important Files**

- `routes/web.php`: root redirect and task resource routes.
- `app/Http/Controllers/TaskController.php`: list, create, validate, update, and delete behavior.
- `app/Models/Task.php`: task table mapping and mass-assignment allowlist.
- `database/migrations/2026_09_22_174601_create_tasks_table.php`: task table schema.
- `resources/views/tasks/index.blade.php`: task list, counts, edit/delete controls, and empty state.
- `resources/views/tasks/create.blade.php`: new-task form.
- `resources/views/tasks/edit.blade.php`: task edit and status form.
- `resources/views/layouts/app.blade.php`: common task page layout and CSS.
- `app/Providers/FortifyServiceProvider.php`, `app/Models/User.php`, and `routes/settings.php`: authentication and account settings support.
- `.env`: local runtime configuration; do not commit secrets from this file.

The project also contains `resources/views/dashboard.blade.php`, but the active task controller never returns it and no registered `dashboard` route points to it. It expects a different data shape from the current controller, so treat it as inactive/leftover code rather than the working dashboard.

**J. Current Setup and Checks**

The project requires PHP `^8.3` in `composer.json`. The current lockfile includes packages that require PHP 8.4.1 or later. On this Windows setup, PHP 8.4.26 is available at `C:\tools\php-8.4.26`; if the `php` command resolves to PHP 8.2, prepend that directory to the PowerShell PATH for the current terminal:

```powershell
$env:PATH = 'C:\tools\php-8.4.26;' + $env:PATH
composer install
php artisan key:generate
php artisan migrate
php artisan serve
```

The local app currently uses SQLite. `php artisan route:list` shows the routes Laravel actually registered. On this machine, port 8000 did not allow the server to bind, so `php artisan serve` selected port 8001 instead.

The existing `tests/Feature/DashboardTest.php` refers to `route('dashboard')`, which is not registered. Running those two tests currently fails with `Route [dashboard] not defined`; it does not test the active `tasks.index` flow. There are no task-specific tests in the feature test shown for the task manager.

**K. Short Explanation to Give Someone**

"This is a Laravel task manager. The root URL redirects to the task resource. The controller loads tasks and counts from SQLite through Eloquent, then passes them to Blade templates. Forms submit back to named resource routes; Laravel validates the values, Eloquent writes the task, and the controller redirects to the list with a flash message. The task screens currently do not require authentication, even though the project also includes Fortify login and account settings."
