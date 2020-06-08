<?php
session_start();
if (!isset($_SESSION['loggedin'])) 
{
	header('Location: index.php');
	exit;
}
$DATABASE_HOST = 'sql2.freesqldatabase.com';
$DATABASE_USER = 'sql2346597';
$DATABASE_PASS = 'rV4*bD1*';
$DATABASE_NAME = 'sql2346597';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) 
{
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$stmt = $con->prepare('SELECT password, email FROM accounts WHERE id = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="stylesheet.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="extraStyle.css">
    <title>Music History</title>
</head>

<body>
    <header>
        <h1>Music History</h1>
        <section class='buttons'>
            <br>
            <a href="index.php"><i class="fas fa-home"></i>Home</a>
            <a href="comments.html"><i class="fas fa-comment"></i>Comments</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
        </section>
    </header>

    <section class="banner">
        <img src="images/webBanner.jpg" alt="Butterfly and clock">
        <div class="title">
            <h2>Profile Page</h2>
        </div>
    </section>

    <nav class="home-nav">
        <ul>
            <li><a id="r" href="/Website/renaissance.php">Renaissance</a></li>
            <li><a id="b" href="/Website/baroque.php">Baroque</a></li>
            <li><a id="c" href="/Website/classical.php">Classical</a></li>
            <li><a id="ro" href="/Website/romantic.php">Romantic</a></li>
            <li><a id="t" href="/Website/twentiethcentury.php">Twentieth Century</a></li>
        </ul>
    </nav>

    <main class="contents">
        <article class="content">
            <h2>Your account details are below:</h2><br>
                <table>
                    <tr>
                        <td>Username: </td>
                        <td><?=$_SESSION['name']?></td>
                    </tr>
                    <tr>
                        <td>Password: </td>
                        <td><?=$password?></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><?=$email?></td>
                    </tr>
                </table>
        </article>
    </main>
</body>