<?php
session_start();

$DATABASE_HOST = 'sql2.freesqldatabase.com:3306';
$DATABASE_USER = 'sql2346597';
$DATABASE_PASS = 'rV4*bD1*';
$DATABASE_NAME = 'sql2346597';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) 
{
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if (!isset($_POST['username'], $_POST['password'])) 
{
    exit('Please fill both the username and password fields');
}

if ($stmt = $con->prepare('SELECT id, password, email FROM accounts WHERE username = ?')) 
{
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) 
    {
        $stmt->bind_result($id, $password, $email);
        $stmt->fetch();
        if (password_verify($_POST['password'], $password)) 
        {
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            $_SESSION['email'] = $email;
            header('Location: index.php');
        } 
        else 
        {
            echo 'Incorrect password!';
        }
    } 
    else 
    {
        echo 'Incorrect username!';
    }

    $stmt->close();
}

?>