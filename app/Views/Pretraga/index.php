<?php view('Partials/header', ['akcija' => 'pretraga']) ?>
<div class="profil-prati">
    <?php foreach ($rez as $blok): ?>
        <div class="red">
            <?php foreach ($blok as $korisnik): ?>
                <div class="kolona kolona-3">
                    <div class="korisnik">
                        <img class="slika" src="images/user.png" alt="Korisnik">
                        <h3><?= e($korisnik->dajPunoIme()) ?></h3>
                        <div class="clearfix"></div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php endforeach ?>
</div>
<?php view('Partials/footer') ?>