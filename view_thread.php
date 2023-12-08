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

$thread_id = $_GET['idthread'];
$thread = getThreadDetails($conn, $thread_id);
$posts = getThreadReplies($conn, $thread_id);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>64chan - View Thread</title>
    <style>
        body {
            background-color: #f7f0e3;
            color: #333;
            font-family: 'Arial', sans-serif;
        }

        h2 {
            color: #d9534f;
        }

        .button {
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

        .button:hover {
            background-color: #c9302c;
        }

        .thread-container {
            background-color: #fff;
            border: 1px solid #e4d7cb;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
        }

        .reply-container {
            background-color: #fff;
            border: 1px solid #e4d7cb;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
        }

        .show-replies {
            background-color: #d9534f;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 10px;
        }

        .replies-container {
            display: none;
        }

        .reply-form {
            margin-top: 10px;
        }

        label {
            color: #d9534f;
        }

        textarea,
        input[type="submit"] {
            background-color: #d9534f;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        textarea {
            width: 100%;
            margin-bottom: 10px;
        }

        input[type="submit"]:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>
    <h2>64chan - View Thread</h2>

    <a href="forum.php" class="button">Back to Forum</a>

    <div class="thread-container">
        <h3><?= $thread['tittel'] ?? 'Thread not found'; ?></h3>
        <p>Posted by <?= $thread['username'] ?? 'Unknown User'; ?> on <?= $thread['timestamp'] ?? 'Unknown Date'; ?></p>
        <p><?= $thread['innhold'] ?? 'No content available'; ?></p>
    </div>

    <button class="show-replies" onclick="toggleReplies()">Show Replies</button>

    <div class="replies-container">
        <?php foreach ($posts as $post): ?>
            <div class="reply-container">
                <p>Posted by <?= $post['brukernavn'] ?? 'Unknown User'; ?> on <?= $post['timestamp'] ?? 'Unknown Date'; ?></p>
                <p><?= $post['innhold'] ?? 'No content available'; ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="reply-form">
        <h3>Reply to Thread</h3>
        <form action="create_reply.php" method="post">
            <input type="hidden" name="idthread" value="<?= $thread_id; ?>">
            <textarea id="reply_content" name="reply_content" rows="4" cols="50" required></textarea>
            <br>
            <input type="submit" value="Post Reply">
        </form>
    </div>

    <script>
        function toggleReplies() {
            var repliesDiv = document.querySelector('.replies-container');
            repliesDiv.style.display = (repliesDiv.style.display === 'none' || repliesDiv.style.display === '') ? 'block' : 'none';
        }
    </script>
</body>
</html>

<?php
function getThreadDetails($connection, $threadId) {
    $sql = "SELECT * FROM threads WHERE idthread = $threadId";
    $result = $connection->query($sql);

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return [];
    }
}

function getThreadReplies($connection, $threadId) {
    $sql = "SELECT replies.*, bruker.brukernavn
            FROM replies
            LEFT JOIN bruker ON replies.idbruker = bruker.idbruker
            WHERE idthread = $threadId
            ORDER BY replies.timestamp DESC";

    $result = $connection->query($sql);

    if ($result) {
        $replies = [];
        while ($row = $result->fetch_assoc()) {
            $replies[] = $row;
        }
        return $replies;
    } else {
        return [];
    }
}
?>
