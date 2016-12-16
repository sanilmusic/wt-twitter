<?php view('Partials/header', ['akcija' => 'nalog']) ?>
<div class="kontejner">
    <div class="red">
        <div class="kolona kolona-2 strana prijavljeni-korisnik">
            <img class="moja-slika" src="images/user.png" alt="Korisnik">
            <h1 class="ime-prezime">Ime Prezime</h1>
            <span class="korisnicko-ime">korisnik</span>
            <p class="kratak-opis">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis vulputate urna, et finibus risus. Donec tristique, augue ac dictum luctus, leo elit tristique augue, nec porttitor quam dui id justo. Sed lacus neque, accumsan in dolor eget, posuere scelerisque orci. Pellentesque nisl turpis, tempor at urna non, pharetra venenatis nunc. Nam velit est, malesuada at ante at, pellentesque tincidunt risus. Suspendisse pulvinar metus quis nibh ultricies, non dictum felis convallis. Integer neque odio, rhoncus ac pharetra sed, sodales sed nibh.
            </p>
        </div>
        <div class="kolona kolona-4">
            <form action="#" method="post" class="forma-max forma-nalog" id="nalog-forma">
                <div class="red">
                    <label for="ime" class="kolona kolona-2">Ime</label>
                    <div class="kolona kolona-4">
                        <input type="text" name="ime" id="ime">
                        <span class="detaljno">Ime ne smije biti prazno!</span>
                    </div>
                </div>
                <div class="red">
                    <label for="prezime" class="kolona kolona-2">Prezime</label>
                    <div class="kolona kolona-4">
                        <input type="text" name="prezime" id="prezime">
                        <span class="detaljno">Prezime ne smije biti prazno!</span>
                    </div>
                </div>
                <div class="red">
                    <label for="email" class="kolona kolona-2">Email adresa</label>
                    <div class="kolona kolona-4">
                        <input type="text" name="email" id="email">
                        <span class="detaljno">Neispravna email adresa!</span>
                    </div>
                </div>
                <div class="red">
                    <label for="opis" class="kolona kolona-2">O meni</label>
                    <div class="kolona kolona-4">
                        <textarea rows="5" name="opis" id="opis"></textarea>
                    </div>
                </div>
                <div class="red">
                    <label for="lozinka" class="kolona kolona-2">Nova lozinka</label>
                    <div class="kolona kolona-4">
                        <input type="text" name="lozinka" id="lozinka">
                        <span class="detaljno">Lozinka ne smije biti kraća od 6 znakova!</span>
                    </div>
                </div>
                <div class="red">
                    <label for="lozinka-potvrda" class="kolona kolona-2">Potvrda lozinke</label>
                    <div class="kolona kolona-4">
                        <input type="text" name="lozinka-potvrda" id="lozinka-potvrda">
                        <span class="detaljno">Potvrda se ne poklapa sa unesenom lozinkom!</span>
                    </div>
                </div>
                <hr>
                <div class="red">
                    <label for="trenutna-lozinka" class="kolona kolona-2">Trenutna lozinka</label>
                    <div class="kolona kolona-4">
                        <input type="text" name="trenutna-lozinka" id="trenutna-lozinka">
                    </div>
                </div>
                <div class="tekst-desno">
                    <button type="submit">Sačuvaj</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php view('Partials/footer') ?>