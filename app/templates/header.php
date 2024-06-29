<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stuff, Community, Fun | Mad Splash!</title>

    <link rel="stylesheet" href="/assets/css/MadSplash_v3.css" type="text/css" />
    <link rel="stylesheet" href="/assets/css/CustomFonts.css" type="text/css" />

    <script src="/assets/scripts/latestTweet.js"></script>
</head>

<body id="index" class="home">
    <?= render('supernav') ?>

    <header>
        <img class="Logo" src="/assets/images/Logos/LogoV7.png" alt="Mad Splash" title="Mad Splash!" />

        <nav>
            <ul>
                <li><a class="navLink" href="/">Home</a></li>
                <li><a class="navLink" href="/blog">Blog</a></li>
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
