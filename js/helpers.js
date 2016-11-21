function nizKlasa(element) {
    return element.className.match(/\S+/g) || [];
}

function imaKlasu(element, klasa) {
    return nizKlasa(element).indexOf(klasa) !== -1;
}

function dodajKlasu(element, klasa) {
    if (!imaKlasu(element, klasa)) {
        var klase = nizKlasa(element);

        klase.push(klasa);

        element.className = klase.join(' ');
    }
}

function ukloniKlasu(element, klasa) {
    if (imaKlasu(element, klasa)) {
        var klase = nizKlasa(element);

        klase.splice(klase.indexOf(klasa), 1);

        element.className = klase.join(' ');
    }
}