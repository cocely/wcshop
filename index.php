<?php

require_once "libraries/Loader.php";

?>
<!DOCTYPE html>
<html lang="<?php echo Config::load("html_lang"); ?>">
<head>
    <meta charset="<?php echo Config::load("html_charset"); ?>">
    <meta name="viewport" content="<?php echo Config::load("html_viewport"); ?>">
    <meta name="description" content="<?php echo Config::load("html_description"); ?>">
    <meta name="keywords" content="<?php echo Config::load("html_keywords"); ?>">
    <meta name="author" content="<?php echo Config::load("html_author"); ?>">
    <meta name="robots" content="<?php echo Config::load("html_robots"); ?>">
    <title><?php echo Config::load("html_title"); ?></title>
    <link rel="icon" href="_public/img/favicon.png">
    <link rel="stylesheet" href="_public/css/main.css">
    <script type="text/javascript" src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="wctooltip/wctooltip.js"></script>
    <script src="_public/js/main.js"></script>
</head>
<body>
    <header>
        <section>
            <a href="/wcshop"><img src="_public/img/logo.jpg" alt="Logo"></a>
        </section>
    </header>
    <div class="box">
        <main>
            <?php Loader::init_view(); ?>
        </main>
        <footer>
            <p>Designed by <a href="http://www.wowcore.com.br" target="_blank">WoW Core</a>.</p>
            <p>WCShop - Online shop for World Of Warcraft private servers.</p>
        </footer>
    </div>
</body>
</html>
