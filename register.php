<?php

$DATABASE_HOST = 'sql2.freesqldatabase.com';
$DATABASE_USER = 'sql2346597';
$DATABASE_PASS = 'rV4*bD1*';
$DATABASE_NAME = 'sql2346597';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) 
{
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) 
{
    exit('Please complete the registration form');
}
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) 
{
    exit('Please complete the registration form');
}
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
{
    exit('Email is not valid');  
}
if (preg_match('/[A-Za-z0-9]+/', $_POST['username'])==0)
{
    exit('Username is not valid');
}
if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) 
{
    exit('Password must be between 5 and 20 characters long!');
}

if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?'))
{
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0)
    {
        echo 'Username exists, please choose another';
    }
    else
    {
        if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email) VALUES (?, ?, ?)'))
        {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);
            $stmt->execute();
            echo '<script>alert("You have successfully registered.");document.location="index.php"</script>';
        }
        else
        {
            echo 'Could not prepare statement';
        }
    }
    $stmt->close();
}
else
{
    echo 'Could not prepare statement';
}
$con->close();
?>