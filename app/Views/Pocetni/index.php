<?php view('Partials/header', ['akcija' => 'index']) ?>
<?php if (!korisnik()): ?>
    <div class="kontejner">
        <div class="red">
            <div class="kolona kolona-3">
                <h3>Posljednje poruke</h3>
                <div class="posljednje-poruke">
                    <div class="clearfix poruka">
                        <img class="slika-profila" src="images/user.png" alt="Korisnik">
                        <div class="balon">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec est justo, fringilla sed ornare quis, consectetur vel odio. Sed purus risus, porta a orci non, elementum accumsan nisi. Duis ultrices aliquet hendrerit. Aliquam erat volutpat.
                        </div>
                    </div>
                    <div class="clearfix poruka">
                        <img class="slika-profila" src="images/user.png" alt="Korisnik">
                        <div class="balon">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec est justo, fringilla sed ornare quis, consectetur vel odio. Sed purus risus, porta a orci non, elementum accumsan nisi. Duis ultrices aliquet hendrerit. Aliquam erat volutpat.
                        </div>
                    </div>
                </div>
            </div>
            <div class="kolona kolona-3">
                <h3>Novi nalog?</h3>
                <form action="#" method="post" class="forma-max" id="novi-nalog-forma">
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
                        <label for="lozinka" class="kolona kolona-2">Lozinka</label>
                        <div class="kolona kolona-4">
                            <input type="password" name="lozinka" id="lozinka">
                            <span class="detaljno">Lozinka ne smije biti kraća od 6 znakova!</span>
                        </div>
                    </div>
                    <div class="red">
                        <label for="potvrda-lozinke" class="kolona kolona-2">Potvrda lozinke</label>
                        <div class="kolona kolona-4">
                            <input type="password" name="potvrda-lozinke" id="potvrda-lozinke">
                            <span class="detaljno">Potvrda se ne poklapa sa unesenom lozinkom!</span>
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
                    <h1 class="ime-prezime">Ime Prezime</h1>
                    <span class="korisnicko-ime">korisnik</span>
                </div>
                <div class="trendovi">
                    <h3>O čemu se piše?</h3>
                    <hr>
                    <ul>
                        <li>
                            Lorem ipsum
                            <span class="broj-poruka">10 poruka</span>
                        </li>
                        <li>
                            Lorem ipsum
                            <span class="broj-poruka">10 poruka</span>
                        </li>
                        <li>
                            Lorem ipsum
                            <span class="broj-poruka">10 poruka</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="kolona kolona-4">
                <div class="clearfix poruka">
                    <img class="slika-profila" src="images/user.png" alt="Korisnik">
                    <div class="balon">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec est justo, fringilla sed ornare quis, consectetur vel odio. Sed purus risus, porta a orci non, elementum accumsan nisi. Duis ultrices aliquet hendrerit. Aliquam erat volutpat.
                    </div>
                </div>
                <div class="clearfix poruka">
                    <img class="slika-profila" src="images/user.png" alt="Korisnik">
                    <div class="balon">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec est justo, fringilla sed ornare quis, consectetur vel odio. Sed purus risus, porta a orci non, elementum accumsan nisi. Duis ultrices aliquet hendrerit. Aliquam erat volutpat.
                    </div>
                </div>
                <div class="clearfix poruka">
                    <img class="slika-profila" src="images/user.png" alt="Korisnik">
                    <div class="balon">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec est justo, fringilla sed ornare quis, consectetur vel odio. Sed purus risus, porta a orci non, elementum accumsan nisi. Duis ultrices aliquet hendrerit. Aliquam erat volutpat.
                    </div>
                </div>
                <div class="clearfix poruka">
                    <img class="slika-profila" src="images/user.png" alt="Korisnik">
                    <div class="balon">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec est justo, fringilla sed ornare quis, consectetur vel odio. Sed purus risus, porta a orci non, elementum accumsan nisi. Duis ultrices aliquet hendrerit. Aliquam erat volutpat.
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>
<?php view('Partials/footer') ?>