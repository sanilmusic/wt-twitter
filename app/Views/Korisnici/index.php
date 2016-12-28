<?php view('Partials/header', ['akcija' => 'adminKorisnici']) ?>
<div class="kontejner">
    <?php view('Partials/Admin/meni') ?>
    <div class="red">
        <div class="kolona kolona-6">
            <a href="index.php?sta=admin/korisnici/export/csv" class="button">
                <i class="fa fa-file-excel-o"></i>
                Generiši CSV
            </a>
            <a href="index.php?sta=admin/korisnici/export/pdf" class="button">
                <i class="fa fa-file-pdf-o"></i>
                Generiši PDF
            </a>
            <a href="index.php?sta=admin/korisnici/novi" class="button">
                <i class="fa fa-plus"></i>
                Dodaj novog korisnika
            </a>
            <?php if ($dodatnaPoruka): ?>
                <p class="uspjeh"><?= $dodatnaPoruka ?></p>
            <?php endif ?>
            <table class="admin-korisnici">
                <tr>
                    <th class="id">#</th>
                    <th class="ime">Ime</th>
                    <th class="prezime">Prezime</th>
                    <th class="email">Email adresa</th>
                    <th class="akcije"></th>
                </tr>
                <?php foreach ($korisnici as $korisnik): ?>
                    <tr>
                        <td><?= $korisnik->id ?></td>
                        <td><?= e($korisnik->ime) ?></td>
                        <td><?= e($korisnik->prezime) ?></td>
                        <td><?= e($korisnik->email) ?></td>
                        <td>
                            <a href="index.php?sta=admin/korisnici/izmjena&id=<?= $korisnik->id ?>" class="button">
                                <i class="fa fa-pencil"></i>
                                Izmijeni
                            </a>
                            <a href="index.php?sta=admin/korisnici/obrisi&id=<?= $korisnik->id ?>" class="button">
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