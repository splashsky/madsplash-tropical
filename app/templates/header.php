<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stuff, Community, Fun | Mad Splash!</title>

    <link rel="stylesheet" href="Resources/CSS/MadSplash_v3.css" type="text/css" />
    <link rel="stylesheet" href="../Resources/CSS/CustomFonts.css" type="text/css" />

    <script src="Resources/Scripts/JavaScript/latestTweet.js"></script>
</head>

<body id="index" class="home">
    <?php require_once '../app/supernav.php'; ?>

    <header>
        <img class="Logo" src="Resources/Images/Logos/LogoV7.png" alt="Mad Splash" title="Mad Splash!" />

        <nav>
            <ul>
                <li><a class="navLink" href="index.php">Home</a></li>
                <li><a class="navLink" href="blog/blog.php">Blog</a></li>
                <li><a class="navLink" href="http://forums.madsplash.net/">Forums</a></li>

                <li class="dropdown">
                    <a class="dropLink" href="projects.php">Projects</a>

                    <div class="drop">
                        <section>
                            <a style="font: bold 18px Arial, Geneva, sans-serif;" href="projects.php?a=main&type=game">Games</a>
                            <a style="font: bold 18px Arial, Geneva, sans-serif;" href="projects.php?a=main&type=book">Books</a>
                            <a style="font: bold 18px Arial, Geneva, sans-serif;" href="projects.php?a=main&type=show">Shows</a>
                        </section>

                        <div class="clear"> </div>
                    </div>
                </li>
            </ul>
        </nav>
    </header>
