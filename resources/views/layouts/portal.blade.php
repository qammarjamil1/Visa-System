<!DOCTYPE html>
<html>
<head>
    <title>Travel Visa System</title>

    <style>
        body { margin:0; font-family:Arial; background:#f5f7fb; }

        .navbar {
            background:white;
            padding:15px;
            display:flex;
            justify-content:space-between;
            box-shadow:0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar a {
            margin:0 10px;
            text-decoration:none;
            color:#333;
            font-weight:bold;
        }

        .container {
            width:90%;
            margin:auto;
            padding:20px;
        }

        .btn {
            padding:10px 20px;
            background:#3490dc;
            color:white;
            text-decoration:none;
            border-radius:5px;
        }
    </style>
</head>

<body>

<div class="navbar">
    <div>
        <a href="/">Home</a>
        <a href="/about">About</a>
        <a href="/services">Services</a>
        <a href="/contact">Contact</a>
    </div>

    <div>
        <a class="btn" href="/visa/create">Apply Visa</a>
    </div>
</div>

<div class="container">
    @yield('content')
</div>

</body>
</html>