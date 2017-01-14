<?php if(!empty($korisnici)): ?>
<div class="red">
    <?php for ($i = 0; $i < count($korisnici); $i++): ?>
        <?php if ($i % 2 == 0): ?>
            </div><div class="red">
        <?php endif ?>
        <div class="kolona kolona-3">
            <div class="korisnik">
                <img class="slika" src="images/user.png" alt="Korisnik">
                <h3><?= e($korisnici[$i]->dajPunoIme()) ?></h3>
                <button type="button">Prestani pratiti</button>
            </div>
        </div>
    <?php endfor ?>
    </div>
</div>
<?php endif ?>