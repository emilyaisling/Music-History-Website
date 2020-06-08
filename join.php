<?php
session_start();

$DATABASE_HOST = 'remotemysql.com:3306';
$DATABASE_USER = 'IAz9y1cPIk';
$DATABASE_PASS = 'WSQcp8qrga9';
$DATABASE_NAME = 'IAz9y1cPIk';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) 
{
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
if (!isset($_POST['email'])) 
{
    exit('Please fill in the required field.');
}

if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE email = ?'))
{
    $stmt->bind_param('s', $_POST['email']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0)
    {
        $userID = $_SESSION['id'];
        $stmt = $con->prepare("UPDATE accounts SET mailing_list = 'Y' WHERE id = $userID AND mailing_list != 'Y'"); 
        $stmt->execute();
        if (mysqli_affected_rows($con) == 1)
        {
            echo '<script>alert("Thank you for joining!");document.location="home.php"</script>';
        }
        else if (mysqli_affected_rows($con) == 0)
        {
            echo '<script>alert("You have already signed up.");document.location="home.php"</script>';
        }
    }
    else
    {
        echo '<script>alert("Invalid email adress.");document.location="home.php"</script>';
    }
}
?>