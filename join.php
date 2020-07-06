<?php
session_start();

$DATABASE_HOST = 'u3r5w4ayhxzdrw87.cbetxkdyhwsb.us-east-1.rds.amazonaws.com';
$DATABASE_USER = 'lolhgl9tjsf486gu';
$DATABASE_PASS = 'asuakvmh3s3oeiiu';
$DATABASE_NAME = 'wxqnvf4km8yjpa2z';

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