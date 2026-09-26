<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Personal Task Manager</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f3ff;
            color: #29213d;
        }

        .navbar {
            background: #6d28d9;
            color: white;
            padding: 18px 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 21px;
            font-weight: bold;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            margin-left: 20px;
        }

        .container {
            width: 86%;
            max-width: 1200px;
            margin: 35px auto;
        }

        .welcome {
            margin-bottom: 25px;
        }

        .welcome h1 {
            font-size: 30px;
            color: #4c1d95;
            margin-bottom: 8px;
        }

        .welcome p {
            color: #6b6478;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 35px;
        }

        .stat-card {
            background: white;
            padding: 22px;
            border-radius: 14px;
            box-shadow: 0 4px 15px rgba(76, 29, 149, 0.08);
            border-left: 5px solid #7c3aed;
        }

        .stat-card h3 {
            color: #756d83;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .stat-number {
            font-size: 30px;
            font-weight: bold;
            color: #5b21b6;
        }

        .tasks-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .tasks-header h2 {
            color: #4c1d95;
        }

        .btn {
            display: inline-block;
            padding: 10px 17px;
            border-radius: 8px;
            border: none;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-primary {
            background: #7c3aed;
            color: white;
        }

        .btn-primary:hover {
            background: #6d28d9;
        }

        .btn-edit {
            background: #ede9fe;
            color: #5b21b6;
        }

        .btn-delete {
            background: #fee2e2;
            color: #b91c1c;
        }

        .task-list {
            background: white;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(76, 29, 149, 0.08);
        }

        .task {
            padding: 22px;
            border-bottom: 1px solid #eee9f5;
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        .task:last-child {
            border-bottom: none;
        }

        .task-info h3 {
            color: #3b0764;
            margin-bottom: 7px;
        }

        .task-info p {
            color: #756d83;
            margin-bottom: 8px;
        }

        .due-date {
            font-size: 13px;
            color: #8b7f96;
        }

        .task-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .pending {
            background: #fef3c7;
            color: #92400e;
        }

        .completed {
            background: #dcfce7;
            color: #166534;
        }

        .alert {
            background: #dcfce7;
            color: #166534;
            padding: 13px 17px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .form-card {
            max-width: 700px;
            background: white;
            padding: 30px;
            margin: auto;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(76, 29, 149, 0.08);
        }

        .form-card h2 {
            color: #4c1d95;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
            color: #4b4454;
        }

        .form-control {
            width: 100%;
            padding: 11px;
            border: 1px solid #d8d1e2;
            border-radius: 8px;
            font-size: 14px;
        }

        .form-control:focus {
            outline: none;
            border-color: #7c3aed;
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 5px;
        }

        .empty {
            text-align: center;
            padding: 50px;
            color: #81778d;
        }

        @media (max-width: 700px) {
            .stats {
                grid-template-columns: 1fr;
            }

            .task {
                flex-direction: column;
            }

            .task-actions {
                align-items: flex-start;
            }

            .navbar {
                padding: 18px 5%;
            }

            .container {
                width: 92%;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <div class="logo">Personal Task Manager</div>

        <div>
            <a href="{{ route('tasks.index') }}" class="nav-link">
                Dashboard
            </a>

            <a href="{{ route('tasks.create') }}" class="nav-link">
                Add Task
            </a>
        </div>
    </nav>

    <main class="container">
        @if(session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>