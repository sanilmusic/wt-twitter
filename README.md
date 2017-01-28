# Basic Twitter Clone

Projekat se radi za potrebe kursa "Web tehnologije" na Elektrotehničkom fakultetu u Sarajevu.

Autor: Sanil Musić (16997)

#### Napomene
---
 - Automatski update na Openshift platformi je privremeno pokvario deployment. Baza je ponovo popunjena 25. januara 2017. godine i time su greške otklonjene. Kao rezultat update-a, Spirala 3 više nije dostupna na originalnom linku.
 - Nalog na Openshift-u je istekao 27. januara 2017. godine. Novi deployment se nalazi na sljedećem URL-u: http://default-main.44fs.preview.openshiftapps.com/index.php

#### Spirala 4
---

###### Šta je urađeno?
 - Napravljena je baza podataka, čiji dump i ERD su uključeni u repozitorij.
 - U meni admin dijela stranice je dodano novo dugme koje pokreće skriptu za transfer podataka iz postojećih XML datoteka u bazu podataka. Prenose se isključivo podaci koji već ne postoje u bazi (ispitivanje se vrši na osnovu email adrese kod korisnika, odnosno korisničkog ID-a i teksta kod poruka). Dodatno, transfer će očuvati integritet podataka, u smislu da će autor poruke ostati isti nakon transfera.
 - Svi podaci se dobavljaju iz baze podataka. Postoji mogućnost da se jednostavno vrati na korištenje XML datoteka.
 - Spirala 3 je još uvijek dostupna na starom URL-u. Spirala 4 se može pogledati na sljedećem URL-u: http://new-default-wt.44fs.preview.openshiftapps.com/.
 - Napravljen je web servis kojem se može pristupiti preko "index.php?sta=api/korisnici". Web servis podržava dobavljanje svih korisnika i pojedinačnih korisnika. Osjetljivi podaci (poput lozinke) su isključeni iz prikaza. Detalji korištenja web servisa mogu se uočiti iz screenshot-a koji su smješteni u /screenshots direktorij.

###### Šta nije urađeno?
/

###### Bug-ovi
Nisu uočeni bug-ovi.

#### Spirala 3
---

###### Šta je urađeno?
Svi podaci koji se prikazuju na stranici su spremljeni u XML datoteke. Napravljen je poseban dio stranice za admin korisnike preko kojeg se mogu dodavati, mijenjati i brisati podaci. Sa iste lokacije se također mogu i generisati CSV i PDF datoteke. Svaki prijavljeni korisnik može koristiti polje za pretragu koje se nalazi u vrhu stranice. Prijedlozi se prikazuju bez da se osvježava stranica, a svaki od prijedloga vodi do profila odgovarajućeg korisnika. Konačno, stranica je postavljena na OpenShift platformu.

###### Šta nije urađeno?
/

###### Bug-ovi
Nisu uočeni bug-ovi.

###### Deployment
Stranici se može pristupi preko sljedećeg URL-a: http://default-wt.44fs.preview.openshiftapps.com/.

#### Spirala 2
---

###### Šta je urađeno?
Sve forme (osim login forme gdje nema prostora za poruku) imaju validaciju i prikazuju eventualne greške ispod polja. Dropdown meni je implementiran u zoni za prijavljene korisnike i može se vidjeti hover-om iznad linka "Korisnik" u gornjem meniju. Galerija je implementirana na profilu korisnika, a fullscreen pogled se može otvoriti klikom na sliku. Konačno, sve podstranice se učitavaju AJAX-om, pri čemu je shema adresiranja promijenjena tako da koristi "#".

###### Šta nije urađeno?
/

###### Bug-ovi
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
