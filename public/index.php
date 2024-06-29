<?php
    require '../app/bootstrap.php';

    $DM = new DisplayModule();

    const PAGES = ['home', 'tandc', 'privacy', 'tictactoe'];

    echo render('header');

    $page = !empty($_GET['page']) && in_array($_GET['page'], PAGES) ? $_GET['page'] : 'home';

	if($page == "home") {
        echo render('slider');
	}

    echo render($page);

	echo render('footer');
