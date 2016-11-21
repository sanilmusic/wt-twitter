function roditeljRed(input) {
    var red = input;

    while (!imaKlasu(red, 'red')) {
        red = red.parentElement;
    }

    return red;
}

function validirajDuzinu(element, min) {
    if (element.value.length < min) {
        dodajKlasu(roditeljRed(element), 'neispravan');
        return false;
    } else {
        ukloniKlasu(roditeljRed(element), 'neispravan');
        return true;
    }
}

function validirajRegex(element, regex) {
    if (!element.value.match(regex)) {
        dodajKlasu(roditeljRed(element), 'neispravan');
        return false;
    } else {
        ukloniKlasu(roditeljRed(element), 'neispravan');
        return true;
    }
}

function validirajIme() {
    return validirajDuzinu(document.getElementById('ime'), 1);
}

function validirajPrezime() {
    return validirajDuzinu(document.getElementById('prezime'), 1);
}

function validirajEmail() {
    return validirajRegex(document.getElementById('email'), /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
}

function validirajLozinku() {
    var lozinka = document.getElementById('lozinka');
    var potvrda = document.getElementById('potvrda-lozinke');

    if (!validirajDuzinu(lozinka, 6)) {
        return false;
    }
    
    if (lozinka.value !== potvrda.value) {
        dodajKlasu(roditeljRed(potvrda), 'neispravan');
        return false;
    } else {
        ukloniKlasu(roditeljRed(potvrda), 'neispravan');
        return true;
    }
}