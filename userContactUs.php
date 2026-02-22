<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="images/Favicon.png">
    <link rel="stylesheet" href="css/AdminDashboard.css">
    <title>Contact Us</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js -->
    <style>
        main {
            text-align: center;
            display: flex;
        }

        .signup-form {
            background: linear-gradient(135deg, #2196F3, #4CAF50);
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            color: white;
            margin: 2rem auto;
            text-align: left;
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

        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ffffff;
            border-radius: 4px;
            box-sizing: border-box;
            height: 8em;

        }
    </style>
</head>

<body>

    <?php include('usersidebar.php'); ?>
    <?php include('topbar.php'); ?>

    <main>

        <div class="signup-container">
            <form class="signup-form" method="post" action="actions/post_contact.php">

                <h2>Contact Us</h2>

                <!-- <div class="form-group">
            <label for="registrationNumber">Registration Number</label>
            <input type="text" id="registrationNumber" placeholder="DEH/IT/2324/F/xxxx" value="DEH/IT/2324/F/" name="regno" required/>
            </div> -->

                <!-- <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" placeholder="admin@gmail.com" name="email" required/>
            </div>

            <div class="form-group">
            <label for="whatsapp">WhatsApp Number</label>
            <input type="tel" id="whatsapp" name="whatsappno" required/>
            </div> -->

                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" required />
                </div>

                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea name="message" required></textarea>
                </div>

                <button type="submit" name="submit">Submit</button>
            </form>
        </div>
    </main>



</body>

</html>