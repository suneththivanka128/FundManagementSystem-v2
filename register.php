<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="images/Favicon.png">
    <title>Member Registration</title>
    <style>
        .signup-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #ffffff;
            font-family: sans-serif;
        }

        .signup-form {
            background: linear-gradient(135deg, #2196F3, #4CAF50);
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 30%;
            color: white;
        }

        .signup-form h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #ffffff;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #ffffff;
            font-weight: 600;
            font-size: 13px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ffffff;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .name-fields {
            display: flex;
            gap: 10px;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: #ffffff;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="signup-container">
        <div class="signup-form">
            <h2>Member Registration</h2>
            <?php if (isset($_GET['error'])): ?>
                <div
                    style="color:red; text-align:center; margin-bottom:10px; background: rgba(255,255,255,0.8); border-radius: 4px; padding: 5px;">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>
            <form method="post" action="actions/auth_register.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="studentName">Member Name</label>
                    <div class="name-fields">
                        <input type="text" id="studentName" placeholder="First Name" name="firstName" required />
                        <input type="text" placeholder="Last Name" name="lastName" required />
                    </div>
                </div>

                <div class="form-group">
                    <label for="registrationNumber">Registration Number</label>
                    <label for="registrationNumber"
                        style="color:#ffffff; font-size: 11px;font-weight: normal; font-style: normal;">(eg-:
                        DEH/IT/2324/F/0001)</label>
                    <input type="text" id="registrationNumber" name="regNo" required />
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" placeholder="admin@gmail.com" name="email" required />
                </div>

                <div class="form-group">
                    <label for="nic">NIC Number</label>
                    <input type="text" id="nic" name="nic" required />
                </div>

                <div class="form-group">
                    <label for="dateofbirth">Date Of Birth</label>
                    <input type="date" id="dateofbirth" name="dateofbirth" required />
                </div>

                <div class="form-group">
                    <label for="whatsapp">WhatsApp Number</label>
                    <input type="tel" id="whatsapp" name="whatsappNo" required />
                </div>

                <div class="form-group">
                    <label for="username">Create User Name</label>
                    <input type="text" id="username" name="userName" required />
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" placeholder="8-12 characters" name="password" required />
                </div>

                <div class="form-group">
                    <label for="passwordCom">Confirm Password</label>
                    <input type="password" id="passwordCom" placeholder="Confirm password" name="passwordCom"
                        required />
                </div>

                <div class="form-group">
                    <label for="profilePhoto">Upload Profile Photo</label>
                    <input type="file" id="profilePhoto" accept="image/jpg, image/jpeg, image/png"
                        name="profilePhoto" />
                </div>

                <button type="submit" name="memberregistration">Register</button>
                <p style="text-align: center; color: #ffffff; margin-top: 20px;">Already have an account? <a
                        href="index.php" style="color: #ffffff; text-decoration: underline;">Login</a></p>
            </form>
        </div>
    </div>
</body>

</html>