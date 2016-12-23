function roditeljRed(input) {
    var red = input;

    while (!imaKlasu(red, 'red')) {
        red = red.parentElement;
    }

    return red;
}

function dodajGresku(element, tekst) {
    red = roditeljRed(element);
    elementi = red.getElementsByClassName('detaljno');

    if (elementi.length === 0) {
        detaljno = document.createElement('span');
        detaljno.className = 'detaljno';
        red.getElementsByTagName('div')[0].appendChild(detaljno);
    } else {
        detaljno = elementi.item(0);
    }

    detaljno.innerHTML = tekst;
    dodajKlasu(red, 'neispravan');
}

function ukloniGresku(element) {
    red = roditeljRed(element);
    elementi = red.getElementsByClassName('detaljno');

    for (var i = 0; i < elementi.length; i++) {
        elementi.item(i).remove();
    }

    ukloniKlasu(red, 'neispravan');
}

function validirajPotrebno(element) {
    if (element.value.length === 0) {
        dodajGresku(element, 'Polje ne smije biti izostavljeno.');
        return false;
    } else {
        ukloniGresku(element);
        return true;
    }
}

function validirajDuzinu(element, min) {
    if (element.value.length < min) {
        dodajGresku(element, 'Unos mora biti dug barem ' + min + ' znakova.');
        return false;
    } else {
        ukloniGresku(element);
        return true;
    }
}

function validirajRegex(element, regex) {
    if (!element.value.match(regex)) {
        return false;
    } else {
        return true;
    }
}

function validirajIme() {
    return validirajPotrebno(document.getElementById('ime'));
}

function validirajPrezime() {
    return validirajPotrebno(document.getElementById('prezime'));
}

function validirajEmail() {
    var element = document.getElementById('email'),
        regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    if (!validirajPotrebno(element)) {
        return false;
    }

    if (!validirajRegex(element, regex)) {
        dodajGresku(element, 'Email adresa nije ispravna.');
        return false;
    } else {
        ukloniGresku(element);
        return true;
    }
}

function validirajLozinku(zanemariPotvrdu) {
    // Defaultne vrijednosti
    zanemariPotvrdu = zanemariPotvrdu || false;

    var lozinka = document.getElementById('lozinka');

    if (!validirajPotrebno(lozinka) || !validirajDuzinu(lozinka, 6)) {
        return false;
    }

    if (zanemariPotvrdu) {
        return true;
    }
    
    if (lozinka.value !== document.getElementById('potvrda-lozinke').value) {
        dodajGresku(lozinka, 'Potvrda se ne poklapa sa unesenom lozinkom!');
        return false;
    } else {
        ukloniGresku(lozinka);
        return true;
    }
}