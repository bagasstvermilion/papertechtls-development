<!DOCTYPE html>
<html>

<head>
    <title>Login | Sonoco E-Logbook</title>
    <style>
        body {
            background-color: #f8f9fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial;
        }

        .login-box {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
        }

        .login-box img {
            width: 140px;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            margin-bottom: 20px;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #003366;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="login-box">
        <img src="<?php echo base_url(); ?>/assets/images/sonoco_logo.png" alt="Sonoco Logo">
        <h2 style="color: #003366; margin-top:0;">TLS Login Portal</h2>





        <form action="<?php echo base_url(); ?>index.php/login/prslogin" method="post">
            <input type="hidden" name="csrf_token" value="Ijg1NWY1ZWM0NDRjNjRkY2RiYzUyM2MzMzA5MDc5ZDQxMGIxYmVmYjci.aifTzA.JdQizMXIXph5Ke47MGygcoNAGOs">

            <input type="text" name="username" id="username" placeholder="Masukan Username" required>
            <input type="password" name="passwrd" placeholder="Masukan Password" required>
            <button type="submit">MASUK</button>
        </form>
    </div>
</body>

<script>
    setTimeout(function() {
        document.getElementById('username').focus();
    }, 500);
</script>

</html>