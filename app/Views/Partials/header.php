<!DOCTYPE html>
<html>
<head>
    <title>BTC - Basic Twitter Clone</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/app.css" rel="stylesheet">
</head>
<body data-akcija="<?= $akcija ?>">
    <?php if (!korisnik()): ?>
        <header class="clearfix odjavljen">
            <div class="left">
                <a href="index.php"><img src="images/logo.png" alt="BTC"></a>
            </div>
            <div class="right">
                <form action="index.php?sta=prijava" method="post">
                    <input type="text" name="email" placeholder="Email adresa" autofocus>
                    <input type="password" name="lozinka" placeholder="Lozinka">
                    <a href="index.php?sta=lozinka">Izgubljena lozinka?</a>
                    <button type="submit">Prijavi se</button>
                </form>
            </div>
        </header>
    <?php else: ?>
        <header class="clearfix prijavljen">
            <div class="min-640">
                <div class="meni">
                    <ul>
                        <li>
                            <a href="index.php">
                                <i class="fa fa-home"></i>
                                Početna
                            </a>
                        </li>
                        <li>
                            <a href="#" id="obavijesti">
                                <i class="fa fa-bell"></i>
                                Obavijesti
                            </a>
                        </li>
                        <li>
                            <a href="index.php?sta=nalog">
                                <i class="fa fa-user-circle"></i>
                                <?= e(korisnik()->ime) ?>
                            </a>
                            <ul>
                                <?php if (korisnik()->admin()): ?>
                                    <li>
                                        <a href="index.php?sta=admin/korisnici">
                                            <i class="fa fa-lock"></i>
                                            Admin
                                        </a>
                                    </li>
                                <?php endif ?>
                                <li>
                                    <a href="index.php?sta=nalog">
                                        <i class="fa fa-cogs"></i>
                                        Postavke
                                    </a>
                                </li>
                                <li>
                                    <a href="index.php?sta=odjava">
                                        <i class="fa fa-sign-out"></i>
                                        Odjavi se
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="logo">
                    <a href="index.php"><img src="images/logo.png" alt="BTC"></a>
                </div>
                <div class="pretraga">
                    <form action="#" method="post">
                        <input type="text" name="sta" id="pretraga-korisnika" placeholder="Traži...">
                        <ul class="skriven" id="pretraga-prijedlozi"></ul>
                        <button type="submit">Traži</button>
                    </form>
                </div>
            </div>
            <div class="max-640">
                <div class="hamburger-nav">
                    <a href="#" id="toggle-menu"><i class="fa fa-bars"></i></a>
                </div>
                <div class="logo">
                    <a href="index.php"><img src="images/logo.png" alt="BTC"></a>
                </div>
                <div class="meni" id="max-640-meni">
                    <ul>
                        <li>
                            <a href="index.php">
                                <i class="fa fa-home"></i>
                                Početna
                            </a>
                        </li>
                        <li>
                            <a href="index.php?sta=nalog">
                                <i class="fa fa-user-circle"></i>
                                Moj nalog
                            </a>
                        </li>
                        <li>
                            <a href="index.php?sta=odjava">
                                <i class="fa fa-sign-out"></i>
                                Odjavi se
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
    <?php endif ?>