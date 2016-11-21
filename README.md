# Basic Twitter Clone

Projekat se radi za potrebe kursa "Web tehnologije" na Elektrotehničkom fakultetu u Sarajevu.

Autor: Sanil Musić (16997)

#### Spirala 2
---

###### Šta je urađeno?
Sve forme (osim login forme gdje nema prostora za poruku) imaju validaciju i prikazuju eventualne greške ispod polja. Dropdown meni je implementiran u zoni za prijavljene korisnike i može se vidjeti hover-om iznad linka "Korisnik" u gornjem meniju. Galerija je implementirana na profilu korisnika, a fullscreen pogled se može otvoriti klikom na sliku. Konačno, sve podstranice se učitavaju AJAX-om, pri čemu je shema adresiranja promijenjena tako da koristi "#".

###### Šta nije urađeno?
/

# Bug-ovi
Nisu uočeni bug-ovi.

###### Lista fajlova
Izlistani su samo fajlovi dodani u sklopu ove spirale.
- ./partials: Parcijalni HTML fajlovi za učitavanje AJAX-om.
- ./uploads: Folder u kojem će biti smještene korisničke datoteke.
- ./js/app.js: Opšti JS kod koji se pokreće na svakoj podstranici.
- ./js/helpers.js: Pomoćne funkcije.
- ./js/validation.js: Validacijske funkcije.

#### Spirala 1
---

###### Šta je urađeno?

Napravljene su skice za uređaje većih rezolucija kao i za mobilne uređaje. Skice su pretvorene u stranice, koje su responzivne i koriste grid. U sklopu ovih stranica javljaju se i forme. Meni se nalazi u dijelu stranice za prijavljene korisnike.

###### Šta nije urađeno?

/

###### Bug-ovi

Nisu uočeni bug-ovi.

###### Lista fajlova

- ./skice/mobilni: Skice za mobilne uređaje.
- ./skice: Skice za uređaje veće rezolucije.
- ./css: CSS datoteke.
- ./fonts: Fontovi, trenutno samo font za ikone.
- ./images: Slike.
- index.html: Početna stranica koju vide neprijavljeni korisnici.
- izgubljenaLozinka.html: Forma preko koje se vrši reset izgubljene lozinke.
- prijavljen.html: Početna stranicu koju vide prijavljeni korisnici.
- profil.html: Profil nekog korisnika koji mogu vidjeti i prijavljeni i neprijavljeni korisnici.
- prati.html: Lista korisnika koje neki korisnik prati.
- nalog.html: Forma preko koje prijavljeni korisnik pravi izmjene svog naloga.