<?php view('Partials/header', ['akcija' => 'adminPoruke']) ?>
<div class="kontejner">
    <?php view('Partials/Admin/meni') ?>
    <div class="red">
        <form method="post" action="index.php?sta=admin/poruke/sacuvaj" class="forma-max">
            <?php if ($fData->ima('id')): ?>
                <input type="hidden" name="id" value="<?= e($fData->daj('id')) ?>">
            <?php endif ?>
            <div class="red <?= ($fGreske->ima('korisnik') ? 'neispravan' : '') ?>">
                <label for="korisnik" class="kolona kolona-1">Korisnik</label>
                <div class="kolona kolona-5">
                    <select name="korisnik" id="korisnik">
                        <?php foreach ($korisnici as $korisnik): ?>
                            <option value="<?= $korisnik->id ?>" <?= ($korisnik->id == $fData->daj('korisnik') ? 'selected' : '') ?>><?= e($korisnik->dajPunoIme()) ?></option>
                        <?php endforeach ?>
                    </select>
                    <?= $fGreske->formatiranaGreska('korisnik') ?>
                </div>
            </div>
            <div class="red <?= ($fGreske->ima('tekst') ? 'neispravan' : '') ?>">
                <label for="tekst" class="kolona kolona-1">Tekst</label>
                <div class="kolona kolona-5">
                    <textarea name="tekst"><?= e($fData->daj('tekst')) ?></textarea>
                    <?= $fGreske->formatiranaGreska('tekst') ?>
                </div>
            </div>
            <button type="submit">Sačuvaj</button>
        </form>
    </div>
</div>