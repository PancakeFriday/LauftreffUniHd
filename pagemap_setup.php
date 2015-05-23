<?php

    require_once(__DIR__.'/VIWebFramework/VIPagemap.php');

    VIPagemap::$main_title = 'Lauftreff Uni Heidelberg';

    VIPagemap::$baseurl = 'http://lauftreffunihd.square7.ch/lauftr';
    VIPagemap::$basedir = __DIR__;

    // Error Document

    $page = VIPagemap::addPage('404');
    $page->title = 'Seite nicht gefunden';
    $page->filename = 'placeholder.php';
    VIPagemap::$error_page = $page;

    // Navigation
    $home = 'Home';
    // $nav = Array( 'Infos', 'Aktuelles', 'Strecken');
    $nav = Array();

    $page = VIPagemap::addPage('home');
    $page->title = 'Home';
    VIPagemap::$default_page = $page;

    $page = VIPagemap::addPage('admin');
    $page->title = 'Administration';
    $page->options = Array( 'no_navigation' );

    foreach($nav as $n) {
        $page = VIPagemap::addPage(strtolower($n));
        $page->title = $n;
        $page->filename = 'home.php';
    }

    $page = VIPagemap::addPage('contact');
    $page->title = 'Kontakt';
    $page->options = Array( );

    $page = VIPagemap::addPage('impressum');
    $page->title = 'Impressum';
    $page->options = Array( );
?>
