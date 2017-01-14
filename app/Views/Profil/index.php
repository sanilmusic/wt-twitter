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
            <h1 class="ime-prezime"><?= e($trenutni->dajPunoIme()) ?></h1>
            <?php if ($korisnik && $korisnik->id != $trenutni->id): ?>
                <button type="button" class="prati-btn" id="prati-toggle" data-id="<?= $trenutni->id ?>">
                    <?php if ($korisnik->daLiPrati($trenutni->id)): ?>
                        Prestani pratiti
                    <?php else: ?>
                        Prati
                    <?php endif ?>
                </button>
            <?php endif ?>
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
                    <?= count($prati) ?>
                </a>
                <a href="#" class="podatak" data-tab="pratitelji">
                    <i class="fa fa-user-circle"></i>
                    Pratitelja<br>
                    <?= count($pratitelji) ?>
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
                        <?php view('Partials/listaKorisnika', ['korisnici' => $prati]) ?>
                    </div>
                </div>
                <div id="tab-pratitelji" class="skriven">
                    <div class="profil-prati">
                        <?php view('Partials/listaKorisnika', ['korisnici' => $pratitelji]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php view('Partials/footer') ?>