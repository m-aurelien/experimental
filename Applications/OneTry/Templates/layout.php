<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
<head>
    <title><?php echo (!isset($title)) ? "Unknow Title" : $title; ?></title>

    <meta http-equiv="Content-type" content="text/html; charset=iso-8859-1" />

    <?php echo $this->js()->render(); ?>
    <?php echo $this->css()->render(); ?>
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
                <?php if ($this->user()->isAuthenticated()) { ?>
                    <li><a href="/experimental/onetry/test/logout">Deconnexion</a></li>
                <?php } ?>
            </ul>
    </div>

    <div id="content-wrap">
        <div id="main">
            <?php if ($this->user()->hasFlash()) : ?>
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?php echo $this->user()->flash(); ?>
                </div>
            <?php endif; ?>

            <?php echo $content; ?>
        </div>
    </div>

    <div id="footer"></div>
    </div>
</body>
</html>