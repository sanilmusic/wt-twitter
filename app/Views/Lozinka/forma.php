<?php view('Partials/header', ['akcija' => 'lozinka']) ?>
<div class="kontejner">
    <div class="red">
        <div class="kolona kolona-3">
            <?php view('Partials/posljednjePoruke') ?>
        </div>
        <div class="kolona kolona-3">
            <h3>Izgubljena lozinka?</h3>
            <form action="#" method="post" class="forma-max" id="izgubljena-lozinka-forma">
                <div class="red">
                    <label for="email" class="kolona kolona-2">Email adresa</label>
                    <div class="kolona kolona-4">
                        <input type="text" name="email" id="email">
                        <span class="detaljno">Neispravna email adresa!</span>
                    </div>
                </div>
                <button type="submit">Resetuj</button>
            </form>
        </div>
    </div>
</div>
<?php view('Partials/footer') ?>