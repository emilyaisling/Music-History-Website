<?php
session_start();
if (!isset($_SESSION['loggedin'])) 
{
    header('Location: login.html');
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="stylesheet.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="buttonStyle.css">
    <title>Music History</title>
</head>

<body>
    
    <header>
        <h1>Music History</h1>
        <section class='buttons'>
            <br>
            <a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
        </section>
    </header>

    <section class="banner">
        <img src="images/webBanner.jpg" alt="Butterfly and clock">
        <div class="title">
            <h2>Timeline of Western Art Music</h2>
        </div>
    </section>

    <nav class="home-nav">
        <ul>
            <li><a id="r" href="/Website/renaissance.html">Renaissance</a></li>
            <li><a id="b" href="/Website/baroque.html">Baroque</a></li>
            <li><a id="c" href="/Website/classical.html">Classical</a></li>
            <li><a id="ro" href="/Website/romantic.html">Romantic</a></li>
            <li><a id="t" href="/Website/twentiethcentury.html">Twentieth Century</a></li>
        </ul>
    </nav>

    <main>
        <article>
            <h2>Introduction</h2>
            <p>Welcome to the history of western art music. Here you will find an overview of each era of music, including how the styles changed and the 
            development of new instruments. There is also a more in depth analysis of a key work from each of the five eras. Finally, you will find a short 
            personal history of one influential composer from each era, detailing why they were significant and including examples of their work fo you to go
            and listen to.</p>
        </article>

        <ul class="images">
            <li><img src="images/sheetmusic.png" alt="sheet music"></li>
            <li><img src="images/webViolins.jpg" alt="violins"></li>
        </ul>

        <br><br>

        <section class="slideshow">
            <a id="r" href="/Website/renaissance.html"><img src="images/palestrinaCrop.jpg" class="slide"></a>
            <a id="b" href="/Website/baroque.html"><img src="images/bachCrop.jpg" class="slide"></a>
            <a id="b" href="/Website/baroque.html"><img src="images/vivaldiCrop.jpg" class="slide"></a>
            <a id="c" href="/Website/classical.html"><img src="images/mozartCrop.jpg" class="slide"></a>
            <a id="c" href="/Website/classical.html"><img src="images/Joseph-HaydnCrop.jpg" class="slide"></a>
            <a id="ro" href="/Website/romantic.html"><img src="images/tchaikovskyCrop.jpg" class="slide"></a>
            <a id="ro" href="/Website/romantic.html"><img src="images/berliozCrop.jpg" class="slide"></a>
        </section>
    </main>

    <section class="mailing-list">
        <h2>Join the music community</h2>
        <p>Keep up to date with the latest research developments, historical findings, events and concert dates in our monthly magazine. Your first issue 
        includes a free download of our 'Best of the Romantic Era' mix with sheet music.</p>
        
        <form>
        <input type="email" name="email" placeholder="Enter your email" required>
        </form>
    </section>

    <footer>
        <p class="copyright">Copyright 2020 Emily Brown</p>
    </footer>

<script src="script.js"></script>
</body>

</html>