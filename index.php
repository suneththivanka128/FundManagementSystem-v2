<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="images/Favicon.png">
    <title>Fund Management System</title>
    <style>
        body {
            margin: 5% 20% 5% 20%;
            display: flex;
            font-family: sans-serif;
            background-color: #ffffff;
        }

        main {
            flex: 1;
            padding: 10px;
            background-color: #ffffff;
            text-align: left;
            display: flex;
        }

        .share-btn {
            margin-top: 10px;
            padding: 10px 15px;
            width: 100%;
            background-color: #ff9800;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        .share-btn:hover {
            background-color: #e68900;
        }

        form {
            background: linear-gradient(135deg, #2196F3, #4CAF50);
            color: white;
            padding: 5%;
            text-align: left;
            border-radius: 0 10px 10px 0;
            font-size: 1.0em;
            font-weight: bold;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
            width: 35%;
            padding-top: 12%;
            padding-bottom: 10%;
            margin: auto;
            float: right;
        }

        .textbox {
            border: 0;
            border-radius: 6px;
            margin: auto;
            margin-top: 2%;
            width: 100%;
            height: 35px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        p {
            font-size: 15px;
            font-weight: 70;
            margin-top: -10px;
            text-align: right;
        }

        .logo {
            background: rgb(236, 236, 236);
            color: #0d75cb;
            text-align: left;
            border-radius: 10px 0 0 10px;
            font-size: 2em;
            font-weight: bold;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
            width: 55%;
            float: left;
            justify-content: center;
            align-items: center;
            display: flex;
            flex-direction: column;
        }

        .logo p {
            text-align: center;
            font-size: 2em;
            font-weight: bold;
        }

        a {
            color: rgb(255, 232, 86);
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <main>
        <div class="logo">
            <img src="Images/logo.png" width="40%" alt="Logo">
            <h2>Welcome Back!</h2>
        </div>
        <form method="post" action="actions/auth_login.php">
            <p>Sign in</p>
            <?php if (isset($_GET['error'])): ?>
                <div
                    style="color:red; text-align:center; margin-bottom:10px; background: rgba(255,255,255,0.8); border-radius: 4px; padding: 5px;">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_GET['success'])): ?>
                <div
                    style="color:green; text-align:center; margin-bottom:10px; background: rgba(255,255,255,0.8); border-radius: 4px; padding: 5px;">
                    <?php echo htmlspecialchars($_GET['success']); ?>
                </div>
            <?php endif; ?>
            <label for="regName">User Name</label><br>
            <input class="textbox" type="text" name="userName" required><br><br>

            <label for="email">Password</label><br>
            <input class="textbox" type="password" name="password" required><br><br>

            <input class="share-btn" name="login" value="login" type="submit"> <br><br>
            <h5>Don't have an account? <a href="register.php">Register Now!</a></h5>
        </form>
    </main>
</body>

</html>
