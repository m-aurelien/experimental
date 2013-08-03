<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
    <title><?php echo (!isset($title)) ? "Unknow Title" : $title; ?></title>

    <meta http-equiv="Content-type" content="text/html; charset=iso-8859-1" />

    <?php echo $this->css()->render(); ?>
    <?php echo $this->js()->render(); ?>
</head>

<body>
    <div id="wrap">
        <div id="header">
            <h1 id="logo-text"><a href="/">Le Logo</a></h1>
            <p id="slogan">Le Slogan</p>
        </div>

        <div id="menu">
            <ul>
                <li><a href="/">Accueil</a></li>
                <?php if ($this->backbone()->app()->user()->isAuthenticated()) { ?>
                    <li><a href="/admin/">Admin</a></li>
                    <li><a href="/admin/news-insert.html">Ajouter une news</a></li>
                <?php } ?>
            </ul>
    </div>

    <div id="content-wrap">
        <div id="main">
            <?php if ($this->backbone()->app()->user()->hasFlash()) echo '<p style="text-align: center;">', $this->backbone()->app()->user()->flash(), '</p>'; ?>

            <?php echo $content; ?>
        </div>
    </div>

    <div id="footer"></div>
    </div>
</body>
</html>