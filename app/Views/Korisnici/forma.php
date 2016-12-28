<?php view('Partials/header', ['akcija' => 'adminKorisnici']) ?>
<div class="kontejner">
    <?php view('Partials/Admin/meni') ?>
    <div class="red">
        <form method="post" action="index.php?sta=admin/korisnici/sacuvaj" class="forma-max">
            <?php if ($fData->ima('id')): ?>
                <input type="hidden" name="id" value="<?= $fData->daj('id') ?>">
            <?php endif ?>
            <div class="red <?= ($fGreske->ima('ime') ? 'neispravan' : '') ?>">
                <label for="ime" class="kolona kolona-1">Ime</label>
                <div class="kolona kolona-5">
                    <input type="text" name="ime" id="ime" value="<?= $fData->daj('ime') ?>">
                    <?= $fGreske->formatiranaGreska('ime') ?>
                </div>
            </div>
            <div class="red <?= ($fGreske->ima('prezime') ? 'neispravan' : '') ?>">
                <label for="prezime" class="kolona kolona-1">Prezime</label>
                <div class="kolona kolona-5">
                    <input type="text" name="prezime" id="prezime" value="<?= $fData->daj('prezime') ?>">
                    <?= $fGreske->formatiranaGreska('prezime') ?>
                </div>
            </div>
            <div class="red <?= ($fGreske->ima('email') ? 'neispravan' : '') ?>">
                <label for="email" class="kolona kolona-1">Email adresa</label>
                <div class="kolona kolona-5">
                    <input type="text" name="email" id="email" value="<?= $fData->daj('email') ?>">
                    <?= $fGreske->formatiranaGreska('email') ?>
                </div>
            </div>
            <div class="red <?= ($fGreske->ima('lozinka') ? 'neispravan' : '') ?>">
                <label for="lozinka" class="kolona kolona-1">Lozinka</label>
                <div class="kolona kolona-5">
                    <input type="password" name="lozinka" id="lozinka">
                    <?= $fGreske->formatiranaGreska('lozinka') ?>
                </div>
            </div>
            <button type="submit">Sačuvaj</button>
        </form>
    </div>
</div>