<?php

/*
///
// This is the bootstrap file; grabs all the important things the library
// used to but needed separated.
///
*/

ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

session_start();

require_once('../app/library.php');

// ---------------------------------------------------------------------------- //
// ---------------------------------------------------------------------------- //
/// Autoloader to get all our classes.

const MAP = [
    'Article' => 'classes/Article.php',
    'ArticleComment' => 'classes/ArticleComment.php',
    'EpisodeComment' => 'classes/EpisodeComment.php',
    'Project' => 'classes/Project.php',
    'Show' => 'classes/Show.php',
    'User' => 'classes/User.php',

    'DatabaseModule' => 'modules/DatabaseModule.php',
    'CommunityModule' => 'modules/CommunityModule.php',
    'DisplayModule' => 'modules/DisplayModule.php',
    'ParserModule' => 'modules/ParserModule.php',

    'CommunityHub' => 'hubs/CommunityHub.php'
];

spl_autoload_register(function ($class) {
    if (!isset(MAP[$class])) return false;
    require_once '../app/' . MAP[$class];
    return true;
});
