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

$sql = "SELECT threads.*, bruker.brukernavn 
        FROM threads
        LEFT JOIN bruker ON threads.idbruker = bruker.idbruker
        ORDER BY threads.timestamp DESC";

$result = $conn->query($sql);

if ($result) {
    $threads = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "Error fetching threads from the database: " . $conn->error;
    $threads = array();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>64chan</title>
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
        input[type="submit"] {
            background-color: transparent;
            color: #d9534f;
            padding: 10px;
            border: 2px solid #d9534f;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="text"] {
            width: 200px;
            margin-right: 10px;
        }

        input[type="text"]:focus,
        input[type="submit"]:hover {
            background-color: #d9534f;
            color: #fff;
        }

        .login {
            display: inline-block;
            margin-left: 20px;
        }
    </style>
</head>

<body>
    <h2>64chan</h2>
    
    <?php if (isset($_SESSION["username"])): ?>
        <div class="login">Logged in as <?= $_SESSION["username"] ?></div>
    <?php else: ?>
        <div class="login">
            <a href="login.php">
                <input type="submit" value="Log In">
            </a>
        </div>
    <?php endif; ?>

    <div>
        <?php foreach ($threads as $thread): ?>
            <div>
                <h3><?= $thread['tittel'] ?? 'No Title' ?></h3>
                <p>Posted by <?= $thread['brukernavn'] ?? 'Unknown User' ?> on <?= $thread['timestamp'] ?></p>
                <?php if (isset($thread['innhold'])): ?>
                    <p><?= $thread['innhold'] ?></p>
                <?php else: ?>
                    <p>No content available</p>
                <?php endif; ?>
                <a href="view_thread.php?idthread=<?= $thread['idthread'] ?>">View Thread</a>
            </div>
        <?php endforeach; ?>
    </div>

    <div>
        <h3>Create New Thread</h3>
        <form action="create_thread.php" method="post">
            <label for="thread_title">Title:</label>
            <input type="text" id="thread_title" name="thread_title" required>
            <br>
            <label for="thread_content">Content:</label>
            <input type="text" id="thread_content" name="thread_content" required>
            <br>
            <input type="submit" value="Create Thread">
        </form>
    </div>
</body>

</html>
