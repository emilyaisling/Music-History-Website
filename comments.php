<?php
session_start();
date_default_timezone_set('GMT');
$error = '';
$load = true;

$DATABASE_HOST = 'sql2.freesqldatabase.com';
$DATABASE_USER = 'sql2346597';
$DATABASE_PASS = 'rV4*bD1*';
$DATABASE_NAME = 'sql2346597';

try 
{
    $pdo = new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
} 
catch (PDOException $exception) 
{
    exit('Failed to connect to database!');
}

function time_elapsed_string($datetime, $full = false) 
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
    $string = array('y' => 'year', 'm' => 'month', 'w' => 'week', 'd' => 'day', 'h' => 'hour', 'i' => 'minute', 's' => 'second');
    foreach ($string as $k => &$v) 
    {
        if ($diff->$k) 
        {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } 
        else 
        {
            unset($string[$k]);
        }
    }
    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

if (isset($_POST['username'], $_POST['rating'], $_POST['content']))
{
    $selectedUsername = $_POST['username'];
    if ($stmt = $pdo->prepare('SELECT id, password FROM accounts WHERE username = :username')) 
    {
        $stmt->bindParam(':username', $selectedUsername);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result)
        {
            if ($selectedUsername == $_SESSION['name'])
            {
                $user = $_SESSION['id'];
                $stmt = $pdo->prepare("INSERT INTO comments (user_id, username, content, rating, submit_date) VALUES ($user,?,?,?,NOW())");
                $stmt->execute([$_POST['username'], $_POST['content'], $_POST['rating']]);
                $error = false;
                $load = false;
                echo 'Your comment has been submitted';
            }
            else
            {
                $error = true;
            }
        }
        else
        {
            $error = true;
        }
    }
    else
    {
        echo 'Failed to prepare statement';
    }
}
if ($load == true)
{
    $stmt = $pdo->prepare('SELECT * FROM comments ORDER BY submit_date DESC');
    $stmt->execute();
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare('SELECT AVG(rating) AS overall_rating, COUNT(*) AS total_comments FROM comments');
    $stmt->execute();
    $comments_info = $stmt->fetch(PDO::FETCH_ASSOC);
    $display = $comments_info['total_comments'] > 1 ? ' comments' : ' comment';
}
elseif($error == false)
{
    $stmt = $pdo->prepare("SELECT TOP 1 * FROM Table ORDER BY id DESC");
    $stmt->execute();
    $comments = $stmt->fetch(PDO::FETCH_ASSOC);

}
?>

<?php if ($error == false && $load == true): ?>
<section class="overall_rating">
    <span class="num"><?=number_format($comments_info['overall_rating'], 1)?></span>
    <span class="stars"><?=str_repeat('&#9733;', round($comments_info['overall_rating']))?></span>
    <span class="total"><?=$comments_info['total_comments'], $display?> </span>
</section>
<a href="#" class="write_comment_btn">Write Comment</a>
<section class="write_comment">
    <form>
        <input type="text" name="username" placeholder="Username" required>
        <input type="number" name="rating" min="1" max="5" placeholder="Rating (1-5)" required>
        <textarea name="content" placeholder="Write your comment here..." required></textarea>
        <button type="submit">Post Comment</button>
    </form>
</section>

<?php foreach ($comments as $comment): ?>
<section class="comment">
    <h3 class="username"><?=htmlspecialchars($comment['username'], ENT_QUOTES)?></h3>
    <section>
        <span class="rating"><?=str_repeat('&#9733;', $comment['rating'])?></span>
        <span class="date"><?=time_elapsed_string($comment['submit_date'])?></span>
    </section>
    <p class="contents"><?=htmlspecialchars($comment['content'], ENT_QUOTES)?></p>
</section>
<?php endforeach ?>
<?php $load = false?>
<?php elseif ($error == true): ?>
    <p class="error"><?php echo htmlspecialchars('Incorrect username.')?><p>
    <?php header('Location: comments.php')?>
<?php endif ?>
