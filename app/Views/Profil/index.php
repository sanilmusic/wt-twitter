<?php view('Partials/header', ['akcija' => 'profil']) ?>
<div id="galerija-fullscreen" tabindex="-1"></div>
<div class="kontejner">
    <div class="red">
        <div class="kolona kolona-2 strana prijavljeni-korisnik">
            <div id="galerija">
                <a class="prethodna" href="#"><i class="fa fa-chevron-left"></i></a>
                <a class="naredna" href="#"><i class="fa fa-chevron-right"></i></a>
                <img class="aktivna" src="uploads/slika1.png" alt="Slika 1">
                <img src="uploads/slika2.png" alt="Slika 2">
                <img src="uploads/slika3.png" alt="Slika 3">
                <img src="uploads/slika4.jpg" alt="Slika 4">
            </div>
            <h1 class="ime-prezime"><?= e($korisnik->dajPunoIme()) ?></h1>
            <p class="kratak-opis">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis vulputate urna, et finibus risus. Donec tristique, augue ac dictum luctus, leo elit tristique augue, nec porttitor quam dui id justo. Sed lacus neque, accumsan in dolor eget, posuere scelerisque orci. Pellentesque nisl turpis, tempor at urna non, pharetra venenatis nunc. Nam velit est, malesuada at ante at, pellentesque tincidunt risus. Suspendisse pulvinar metus quis nibh ultricies, non dictum felis convallis. Integer neque odio, rhoncus ac pharetra sed, sodales sed nibh.
            </p>
        </div>
        <div class="kolona kolona-4">
            <div class="clearfix statistika">
                <a href="#" class="podatak" data-tab="poruke">
                    <i class="fa fa-comment"></i>
                    Poruke<br>
                    <?= count($poruke) ?>
                </a>
                <a href="#" class="podatak" data-tab="prati">
                    <i class="fa fa-check-circle"></i>
                    Prati<br>
                    10
                </a>
                <a href="#" class="podatak" data-tab="pratitelji">
                    <i class="fa fa-user-circle"></i>
                    Pratitelja<br>
                    10
                </a>
            </div>
            <hr>
            <div id="tabovi">
                <div id="tab-poruke">
                    <div class="profil-poruke">
                        <?php foreach ($poruke as $poruka): ?>
                            <div class="clearfix poruka">
                                <div class="balon">
                                    <?= e($poruka->tekst) ?>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
                <div id="tab-prati" class="skriven">
                    <div class="profil-prati">
                        <div class="red">
                            <div class="kolona kolona-3">
                                <div class="korisnik">
                                    <img class="slika" src="images/user.png" alt="Korisnik">
                                    <h3>Ime Prezime</h3>
                                    <span class="korisnicko-ime">korisnik</span>
                                    <button type="button">Prestani pratiti</button>
                                </div>
                            </div>
                            <div class="kolona kolona-3">
                                <div class="korisnik">
                                    <img class="slika" src="images/user.png" alt="Korisnik">
                                    <h3>Ime Prezime</h3>
                                    <span class="korisnicko-ime">korisnik</span>
                                    <button type="button">Prestani pratiti</button>
                                </div>
                            </div>
                        </div>
                        <div class="red">
                            <div class="kolona kolona-3">
                                <div class="korisnik">
                                    <img class="slika" src="images/user.png" alt="Korisnik">
                                    <h3>Ime Prezime</h3>
                                    <span class="korisnicko-ime">korisnik</span>
                                    <button type="button">Prestani pratiti</button>
                                </div>
                            </div>
                            <div class="kolona kolona-3">
                                <div class="korisnik">
                                    <img class="slika" src="images/user.png" alt="Korisnik">
                                    <h3>Ime Prezime</h3>
                                    <span class="korisnicko-ime">korisnik</span>
                                    <button type="button">Prestani pratiti</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tab-pratitelji" class="skriven">
                    <div class="profil-prati">
                        <div class="red">
                            <div class="kolona kolona-3">
                                <div class="korisnik">
                                    <img class="slika" src="images/user.png" alt="Korisnik">
                                    <h3>Ime Prezime</h3>
                                    <span class="korisnicko-ime">korisnik</span>
                                    <button type="button">Prestani pratiti</button>
                                </div>
                            </div>
                            <div class="kolona kolona-3">
                                <div class="korisnik">
                                    <img class="slika" src="images/user.png" alt="Korisnik">
                                    <h3>Ime Prezime</h3>
                                    <span class="korisnicko-ime">korisnik</span>
                                    <button type="button">Prestani pratiti</button>
                                </div>
                            </div>
                        </div>
                        <div class="red">
                            <div class="kolona kolona-3">
                                <div class="korisnik">
                                    <img class="slika" src="images/user.png" alt="Korisnik">
                                    <h3>Ime Prezime</h3>
                                    <span class="korisnicko-ime">korisnik</span>
                                    <button type="button">Prestani pratiti</button>
                                </div>
                            </div>
                            <div class="kolona kolona-3">
                                <div class="korisnik">
                                    <img class="slika" src="images/user.png" alt="Korisnik">
                                    <h3>Ime Prezime</h3>
                                    <span class="korisnicko-ime">korisnik</span>
                                    <button type="button">Prestani pratiti</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php view('Partials/footer') ?>