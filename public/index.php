<?php
    require '../app/bootstrap.php';

    $DM = new DisplayModule();

    echo render('header');

	if (!empty($_GET['page'])) {
		$page = "home";

		$TmpPage = basename($_GET['page']);

		// If it's not a disallowed path, and if the file exists, update $page
		if (!in_array($TmpPage, $LockedPages) && file_exists("Pieces/{$TmpPage}.htm")) {
			$page = $TmpPage;
		}
	} else {
		$page = "home";
	}

	if($page == "home") {
        echo render('slider');
	}

	// Include $page
    echo render($page);

	echo render('footer');
