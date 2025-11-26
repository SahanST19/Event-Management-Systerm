<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ST Event Management</title>
    <style>
        body{font-family:sans-serif;margin:0;padding:0;background-color:#f0f2f5;}
        
        /* Navigation Bar wala wenaskirim */
        .navbar{
            list-style-type:none;
            margin:0;
            padding:0;
            overflow:hidden;
            background-color: #2c3e50; /* <-- 1. Navigation Bar eke pata wenas karana thena */
        }

        .navbar li{float:left;}
        .navbar li a{display:block;color:white;text-align:center;padding:14px 16px;text-decoration:none;}
        
        .navbar li a:hover{
            background-color: #1df001ff; /* <-- 2. Mouse eka aran yana thena pta wenas karanna active buttorn eke*/
        }
        
        .navbar li.right{float:right;} /* loging eka signup eka dakunata aran yana eka */
        .form-container{width:90%;max-width:500px;margin:50px auto;text-align:center;}
        .page-container{max-width:1100px;margin:30px auto;padding:20px;background-color:#fff;border-radius:8px;box-shadow:0 4px 8px rgba(0,0,0,0.1);}
        .form-container h1, .page-container h1, .page-container h2{margin-bottom:20px;}
        form{border-radius:8px;background-color:#fff;padding:40px;box-shadow:0 4px 12px rgba(0,0,0,0.1);}
        input[type=text],input[type=password],input[type=email],input[type=date],input[type=time],input[type=number],select,textarea{width:100%;padding:12px;margin:8px 0;display:inline-block;border:1px solid #ccc;border-radius:4px;box-sizing:border-box;font-size:14px;}
        form label{display:block;text-align:left;margin-top:15px;margin-bottom:5px;font-weight:bold;color:#333;}
        button{width:100%;background-color:#4CAF50;color:white;padding:14px;margin:20px 0 8px 0;border:none;border-radius:4px;cursor:pointer;font-size:16px;}
        button:hover{background-color:#45a049;}
        .error-msg{color:#D8000C;background-color:#FFD2D2;padding:10px;border-radius:4px;margin-bottom:15px;border:1px solid #D8000C;}
        
        /* Dashbord wala ethi buttern saha style ethi kotasa */
        .btn {
            text-decoration: none;
            color: white !important;
            padding: 10px 15px;
            border-radius: 5px;
            display: inline-block;
            margin-right: 10px;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-blue { background-color: #008CBA; }
        .btn-green { background-color: #4CAF50; }
        .btn-red { background-color: #f44336; }
        .btn:hover { opacity: 0.9; }
    </style>
</head>


<body>
    <ul class="navbar">
		<?php if (basename($_SERVER['PHP_SELF']) !== 'index.php'): ?>
		<li><a href="index.php">Home</a></li>
		<?php endif; ?>
		<?php if (basename($_SERVER['PHP_SELF']) === 'index.php'): ?>
		<li class="right"><a href="loging.php">Login</a></li>
		<li class="right"><a href="signup.php">Signup</a></li>
		<?php else: ?>
		<li class="right"><a href="includes/logout.inc.php">Logout</a></li>
		<?php endif; ?>
    </ul>