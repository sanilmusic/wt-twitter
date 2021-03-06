<?php view('Partials/header', ['akcija' => (korisnik() ? 'indexPrijavljen' : 'indexOdjavljen')]) ?>
<?php if (!korisnik()): ?>
    <div class="kontejner">
        <div class="red">
            <div class="kolona kolona-3">
                <?php view('Partials/posljednjePoruke') ?>
            </div>
            <div class="kolona kolona-3">
                <h3>Novi nalog?</h3>
                <form action="index.php?sta=registracija" method="post" class="forma-max" id="novi-nalog-forma">
                    <div class="red <?= ($fGreske->ima('ime') ? 'neispravan' : '') ?>">
                        <label for="ime" class="kolona kolona-2">Ime</label>
                        <div class="kolona kolona-4">
                            <input type="text" name="ime" id="ime" value="<?= e($fData->daj('ime')) ?>">
                            <?= $fGreske->formatiranaGreska('ime') ?>
                        </div>
                    </div>
                    <div class="red <?= ($fGreske->ima('prezime') ? 'neispravan' : '') ?>">
                        <label for="prezime" class="kolona kolona-2">Prezime</label>
                        <div class="kolona kolona-4">
                            <input type="text" name="prezime" id="prezime" value="<?= e($fData->daj('prezime')) ?>">
                            <?= $fGreske->formatiranaGreska('prezime') ?>
                        </div>
                    </div>
                    <div class="red <?= ($fGreske->ima('email') ? 'neispravan' : '') ?>">
                        <label for="email" class="kolona kolona-2">Email adresa</label>
                        <div class="kolona kolona-4">
                            <input type="text" name="email" id="email" value="<?= e($fData->daj('email')) ?>">
                            <?= $fGreske->formatiranaGreska('email') ?>
                        </div>
                    </div>
                    <div class="red <?= ($fGreske->ima('lozinka') ? 'neispravan' : '') ?>">
                        <label for="lozinka" class="kolona kolona-2">Lozinka</label>
                        <div class="kolona kolona-4">
                            <input type="password" name="lozinka" id="lozinka">
                            <?= $fGreske->formatiranaGreska('lozinka') ?>
                        </div>
                    </div>
                    <div class="red">
                        <label for="potvrda-lozinke" class="kolona kolona-2">Potvrda lozinke</label>
                        <div class="kolona kolona-4">
                            <input type="password" name="potvrda_lozinke" id="potvrda-lozinke">
                        </div>
                    </div>
                    <button type="submit">Napravi nalog</button>
                </form>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="kontejner">
        <div class="red">
            <div class="kolona kolona-2 strana">
                <div class="prijavljeni-korisnik">
                    <img class="moja-slika" src="images/user.png" alt="Korisnik">
                    <h1 class="ime-prezime"><?= e(korisnik()->dajPunoIme()) ?></h1>
                </div>
            </div>
            <div class="kolona kolona-4">
                <?php foreach ($porukeOstalih as $poruka): ?>
                    <div class="clearfix poruka">
                        <img class="slika-profila" src="images/user.png" alt="Korisnik">
                        <div class="balon">
                            <?= e($poruka->tekst); ?>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
<?php endif ?>
<?php view('Partials/footer') ?>