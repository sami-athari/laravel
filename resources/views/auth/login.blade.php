<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Reset browser's default margin/padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f7f7f7;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 360px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            box-sizing: border-box;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 8px;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 14px;
            margin-bottom: 6px;
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            color: #333;
            transition: border 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border: 1px solid #007bff;
            outline: none;
        }

        button {
            padding: 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        p {
            text-align: center;
            font-size: 12px;
            margin-top: 15px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Login</h1>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Identifier (Email or Name) -->
            <div>
                <label for="identifier">Email or Name</label>
                <input id="identifier" type="text" name="identifier" value="{{ old('identifier') }}" required autofocus>
                @error('identifier')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit">Login</button>

            <p>Don't have an account? <a href="{{ route('register') }}">Register</a></p>
        </form>
    </div>

</body>
</html>
