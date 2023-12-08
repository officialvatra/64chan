<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"] ?? '';
    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';

    $sql = "INSERT INTO bruker (brukernavn, passord, email) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sss", $username, $password, $email);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION["idbruker"] = $stmt->insert_id;
            $_SESSION["username"] = $username;

            header("Location: forum.php");
            exit();
        } else {
            $error_message = "Error creating user: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>64chan - Sign Up</title>
    <style>
        body {
            background-color: #f7f0e3;
            color: #333;
            font-family: 'Arial', sans-serif;
        }

        h2 {
            color: #d9534f;
            display: inline-block;
        }

        div {
            background-color: #fff;
            border: 1px solid #e4d7cb;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
        }

        form {
            margin-top: 10px;
        }

        label {
            color: #d9534f;
        }

        input[type="text"],
        input[type="password"],
        input[type="submit"] {
            background-color: transparent;
            color: #d9534f;
            padding: 10px;
            border: 2px solid #d9534f;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="text"],
        input[type="password"] {
            width: 200px;
            margin-right: 10px;
        }

        input[type="text"]:focus,
        input[type="password"]:focus,
        input[type="submit"]:hover {
            background-color: #d9534f;
            color: #fff;
        }

        a.button {
            background-color: #d9534f;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-right: 10px;
        }

        a.button:hover {
            background-color: #c9302c;
        }
    </style>
</head>

<body>
    <h2>64chan - Sign Up</h2>

    <div>
        <form action="" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <br>
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <input type="submit" value="Sign Up">
        </form>
    </div>

    <a href="login.php" class="button">Log In</a>
</body>

</html>
