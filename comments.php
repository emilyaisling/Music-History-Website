<?php
session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';

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
    foreach($string as $k => &$v)
    {
        if($diff->$k)
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

if (isset($_GET['page_id']))
{
    if (isset($_POST['username'], $_POST['rating'], $_POST['content']))
    {
        if ($stmt = $pdo->prepare('SELECT id, password FROM accounts WHERE username = ?')) 
        {
            $stmt->bind_param('s', $_POST['username']);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->row_count > 0)
            {
                $user = $_SESSION['id'];
                $stmt = $pdo->prepare("INSERT INTO comments (page_id, user_id, username, content, rating, submit_date) VALUES (?,$user,?,?,?,NOW())");
                $stmt->execute([$_GET['page_id'], $_POST['username'], $_POST['content'], $_POST['rating']]);
                exit('Your comment has been submitted!');
            }
        }
    }
    $stmt = $pdo->prepare('SELECT * FROM comments WHERE page_id = ? ORDER BY submit_date DESC');
    $stmt->execute([$_GET['page_id']]);
    $comments = $stmt->fetch_all(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare('SELECT AVG(rating) AS overall_rating, COUNT(*) AS total_comments FROM comments WHERE page_id = ?');
    $stmt->execute([$_GET['page_id']]);
    $comments_info = $stmt->fetch(PDO::FETCH_ASSOC);
}
else
{
    exit('Please provide the page ID');
}
?>

<div class="overall_rating">
    <span class="num"><?=number_format($comments_info['overall_rating'], 1)?></span>
    <span class="stars"><?=str_repeat('&#9733;', round($comments_info['overall_rating']))?></span>
    <span class="total"><?=$comments_info['total_comments']?> comments</span>
</div>
<a href="#" class="write_comment_btn">Write Comment</a>
<div class="write_comment">
    <form>
        <input type="text" name="username" placeholder="Username" required>
        <input type="number" name="rating" min="1" max="5" placeholder="Rating (1-5)" required>
        <textarea name="content" placeholder="Write your comment here..." required></textarea>
        <button type="submit">Post Comment</button>
    </form>
</div>

<?php foreach ($comments as $comment): ?>
<div class="comment">
    <h3 class="username"><?=htmlspecialchars($comment['username'], ENT_QUOTES)?></h3>
    <div>
        <span class="rating"><?=str_repeat('&#9733;', $comment['rating'])?></span>
        <span class="date"><?=time_elapsed_string($comment['submit_date'])?></span>
    </div>
    <p class="content"><?=htmlspecialchars($comment['content'], ENT_QUOTES)?></p>
</div>
<?php endforeach ?>