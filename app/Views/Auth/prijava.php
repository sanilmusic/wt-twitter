<?php view('Partials/header', ['akcija' => 'prijava']) ?>
<div class="kontejner">
    <div class="red">
        <div class="kolona kolona-3">
            <?php view('Partials/posljednjePoruke') ?>
        </div>
        <div class="kolona kolona-3">
            <h3>Prijavi se</h3>
            <form action="index.php?sta=prijava" method="post" class="forma-max" id="prijava-forma">
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
                <button type="submit">Prijavi se</button>
            </form>
        </div>
    </div>
</div>
<?php view('Partials/footer') ?>