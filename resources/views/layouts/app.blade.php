<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grand Prix SENAI- Sistema de Votação</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --bg-color: #0f172a;
            --surface: rgba(30, 41, 59, 0.7);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --accent: #38bdf8;
            --gold: #fbbf24;
            --success: #10b981;
            --danger: #ef4444;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
            color: var(--text-main);
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* Glassmorphism Navbar */
        .navbar {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-main);
            text-decoration: none;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo span {
            color: var(--accent);
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
        }

        .nav-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            position: relative;
            padding: 0.5rem 0;
        }

        .nav-links a:hover, .nav-links a.active {
            color: var(--text-main);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent);
            transition: width 0.3s ease;
        }

        .nav-links a:hover::after, .nav-links a.active::after {
            width: 100%;
        }

        .admin-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            color: var(--text-main) !important;
        }

        .admin-btn:hover {
            background: var(--primary);
            border-color: var(--primary);
        }

        .admin-btn::after {
            display: none;
        }

        main {
            flex: 1;
            padding: 3rem 1.5rem;
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            box-sizing: border-box;
            animation: fadeIn 0.6s ease-out;
        }

        /* Glassmorphism Cards */
        .glass-card {
            background: var(--surface);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        /* Typography */
        h1, h2, h3 {
            margin-top: 0;
            letter-spacing: -0.5px;
        }

        .page-title {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 2rem;
            background: linear-gradient(to right, #fff, var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--text-muted);
        }

        input[type="text"], input[type="number"], select, textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.2);
        }

        /* Buttons */
        .btn {
            display: inline-block;
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.4);
        }

        .btn:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.5);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--text-main);
        }

        .btn-outline:hover {
            background: rgba(37, 99, 235, 0.1);
        }

        /* Alerts */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            font-weight: 600;
            animation: slideDown 0.4s ease-out;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid var(--success);
            color: #34d399;
        }
        
        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid var(--danger);
            color: #f87171;
        }

        /* Tables */
        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 1rem;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        th {
            background: rgba(255, 255, 255, 0.05);
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        th:first-child { border-top-left-radius: 8px; }
        th:last-child { border-top-right-radius: 8px; }

        tbody tr {
            transition: all 0.2s ease;
        }

        tbody tr:hover {
            background: rgba(255, 255, 255, 0.02);
        }

        .winner-row {
            background: rgba(251, 191, 36, 0.1) !important;
        }

        .winner-row td {
            color: var(--gold);
            font-weight: 600;
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.1);
        }
        
        .badge-active {
            background: rgba(16, 185, 129, 0.2);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.5);
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-content {
                flex-direction: column;
                gap: 1rem;
            }
            .nav-links {
                flex-wrap: wrap;
                justify-content: center;
                gap: 1rem;
            }
            .glass-card {
                padding: 1.5rem;
            }
            main {
                padding: 1.5rem 1rem;
            }
            .page-title {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 480px) {
            .nav-links {
                gap: 0.5rem;
            }
            .nav-links a {
                font-size: 0.85rem;
                padding: 0.3rem 0;
            }
            .admin-btn {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-content">
            <a href="{{ route('home') }}" class="logo">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--accent);"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                Grand<span>Prix</span>
            </a>
            <div class="nav-links">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                <a href="{{ route('votacao') }}" class="{{ request()->routeIs('votacao') ? 'active' : '' }}">Votação</a>
                <a href="{{ route('resultados') }}" class="{{ request()->routeIs('resultados') ? 'active' : '' }}">Resultados</a>
                <a href="{{ route('historico') }}" class="{{ request()->routeIs('historico*') ? 'active' : '' }}">Histórico</a>
                <a href="/admin" class="admin-btn" target="_blank">Admin</a>
            </div>
        </div>
    </nav>

    <main>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
