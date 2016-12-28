<?php view('Partials/header', ['akcija' => 'adminPoruke']) ?>
<div class="kontejner">
    <?php view('Partials/Admin/meni') ?>
    <div class="red">
            <a href="index.php?sta=admin/poruke/nova" class="button">
                <i class="fa fa-plus"></i>
                Dodaj novu poruku
            </a>
            <?php if ($dodatnaPoruka): ?>
                <p class="uspjeh"><?= $dodatnaPoruka ?></p>
            <?php endif ?>
            <table class="admin-poruke">
                <tr>
                    <th class="id">#</th>
                    <th class="korisnik">Korisnik</th>
                    <th class="tekst">Tekst</th>
                    <th class="akcije"></th>
                </tr>
                <?php foreach ($poruke as $poruke): ?>
                    <tr>
                        <td><?= $poruke->id ?></td>
                        <td><?= e($poruke->dajImeKorisnika()) ?></td>
                        <td><?= e($poruke->dajSkracenTekst()) ?></td>
                        <td>
                            <a href="index.php?sta=admin/poruke/izmjena&id=<?= $poruke->id ?>" class="button">
                                <i class="fa fa-pencil"></i>
                                Izmijeni
                            </a>
                            <a href="index.php?sta=admin/poruke/obrisi&id=<?= $poruke->id ?>" class="button">
                                <i class="fa fa-trash"></i>
                                Obriši
                            </a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </table>
        </div>
    </div>
</div>
<?php view('Partials/footer') ?>