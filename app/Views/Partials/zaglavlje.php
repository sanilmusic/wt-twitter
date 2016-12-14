<?php if (!prijavljen()): ?>
    <header class="clearfix odjavljen">
        <div class="left">
            <a href="#"><img src="images/logo.png" alt="BTC"></a>
        </div>
        <div class="right">
            <form action="#" method="post">
                <input type="text" name="email" placeholder="Email adresa" autofocus>
                <input type="password" name="lozinka" placeholder="Lozinka">
                <a href="#izgubljenaLozinka">Izgubljena lozinka?</a>
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
                        <a href="#prijavljen">
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
                        <a href="#nalog">
                            <i class="fa fa-user-circle"></i>
                            Korisnik
                        </a>
                        <ul>
                            <li>
                                <a href="#nalog">
                                    <i class="fa fa-cogs"></i>
                                    Postavke
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-sign-out"></i>
                                    Odjavi se
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="logo">
                <a href="#prijavljen"><img src="images/logo.png" alt="BTC"></a>
            </div>
            <div class="pretraga">
                <form action="#" method="post">
                    <input type="text" name="sta" placeholder="Traži...">
                    <button type="submit">Traži</button>
                </form>
            </div>
        </div>
        <div class="max-640">
            <div class="hamburger-nav">
                <a href="#" id="toggle-menu"><i class="fa fa-bars"></i></a>
            </div>
            <div class="logo">
                <a href="#prijavljen"><img src="images/logo.png" alt="BTC"></a>
            </div>
            <div class="meni" id="max-640-meni">
                <ul>
                    <li>
                        <a href="#prijavljen">
                            <i class="fa fa-home"></i>
                            Početna
                        </a>
                    </li>
                    <li>
                        <a href="#nalog">
                            <i class="fa fa-user-circle"></i>
                            Moj nalog
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-sign-out"></i>
                            Odjavi se
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
<?php endif ?>