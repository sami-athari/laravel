<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        /* Resetting some styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 400px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            box-sizing: border-box;
        }

        h1 {
            text-align: center;
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 14px;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"],
        select {
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            color: #333;
            transition: border 0.3s ease;
        }

        input:focus {
            border-color: #007BFF;
            outline: none;
        }

        button {
            padding: 12px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        p {
            text-align: center;
            font-size: 14px;
            margin-top: 15px;
        }

        a {
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Register</h1>

        {{-- Menampilkan error message jika ada --}}
        @if ($errors->any())
            <div class="error-message">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            {{-- Name Input --}}
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required>

            {{-- Email Input --}}
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>

            {{-- Gender Input --}}
            <label for="gender">Gender:</label>
            <select name="gender" id="gender" required>
                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
            </select>

            {{-- Date of Birth Input --}}
            <label for="dob">Date of Birth:</label>
            <input type="date" name="dob" id="dob" value="{{ old('dob') }}" required>

            {{-- Password Input --}}
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            {{-- Confirm Password Input --}}
            <label for="password_confirmation">Confirm Password:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>

            {{-- Submit Button --}}
            <button type="submit">Register</button>
        </form>

        <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
    </div>
</body>
</html>
