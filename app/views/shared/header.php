<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Frank-James T">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=(!is_null($title)) ? $title : 'TradeWell'?></title>
    <link rel="stylesheet" href="<?=SITE_URL?>styles/style.css">
    <link rel="stylesheet" href="<?=SITE_URL?>styles/media.css">
    <link rel="stylesheet" href="<?=SITE_URL?>styles/hover.css">
</head>
<body>
    <header>
        <nav class="mobile-links">
            <a href="<?=SITE_URL?>" class="logo"><h3>Trader<span>Desk</span></h3></a>
            <img src="<?=SITE_URL?>icons/bars.svg" alt="menu_bar" width="28px" height="28px" id="toggle">
            <aside class="container" id="container">
                <ul class="list">
                    <li><a href="<?=SITE_URL?>#about">How it Works</a></li>
                    <li><a href="<?=SITE_URL?>#services">Services</a></li>
                    <?php if($user->isLoggedIn()):  ?>
                    <li><a href="<?=SITE_URL?>user-dashboard" class="">Dashboard</a></li>
                    <?php else: ?>
                    <li><a href="<?=SITE_URL?>login" class="login">Log In</a></li>
                    <li><a href="<?=SITE_URL?>signup" class="joinus">Join Us</a></li>
                    <?php endif; ?>
                </ul>
            </aside>
        </nav>
        <nav class="desktop-links">
            <a href="<?=SITE_URL?>" class="logo"><h3>Trader<span>Desk</span></h3></a>
            <ul class="list">
                <li><a href="<?=SITE_URL?>#about">How it Works</a></li>
                <li><a href="<?=SITE_URL?>#services">Services</a></li>
                <div class="btn-group">
                    <?php if($user->isLoggedIn()):  ?>
                    <li><a href="<?=SITE_URL?>user-dashboard" class="">Dashboard</a></li>  
                    <?php else: ?>
                    <li><a href="<?=SITE_URL?>login"><button class="login">Log In</button></a></li>
                    <li><a href="<?=SITE_URL?>signup"><button class="joinus">Join Us</button></a></li>
                    <?php endif; ?>
                </div>
            </ul>
        </nav>
    </header>