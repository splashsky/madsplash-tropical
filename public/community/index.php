<?php

require '../app/bootstrap.php';

const PAGES = ['login', 'verify', 'register'];

echo render('header');

$page = !empty($_GET['page']) && in_array($_GET['page'], PAGES) ? $_GET['page'] : 'home';

echo render("community/$page");

echo render('footer');
