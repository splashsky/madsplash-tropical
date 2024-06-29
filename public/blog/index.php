<?php

require '../app/bootstrap.php';

const PAGES = ['list', 'read'];

echo render('header');

$do = !empty($_GET['do']) && in_array($_GET['do'], PAGES) ? $_GET['do'] : 'list';

echo render("blog/$do");

echo render('footer');
