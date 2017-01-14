<?php if(!empty($korisnici)): ?>
<div class="red">
    <?php for ($i = 0; $i < count($korisnici); $i++): ?>
        <?php if ($i % 2 == 0): ?>
            </div><div class="red">
        <?php endif ?>
        <div class="kolona kolona-3">
            <div class="korisnik clearfix">
                <img class="slika" src="images/user.png" alt="Korisnik">
                <h3><a href="index.php?sta=profil&id=<?= $korisnici[$i]->id ?>"><?= e($korisnici[$i]->dajPunoIme()) ?></a></h3>
            </div>
        </div>
    <?php endfor ?>
    </div>
</div>
<?php endif ?>