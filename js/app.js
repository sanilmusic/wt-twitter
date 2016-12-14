function loadingAnimation(action) {
    document.getElementById('loading').style.display = (action === 'hide' ? 'none' : 'block');
}

function ajaxRequest(method, url, callback) {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState === 4 && request.status === 200) {
            callback(request.responseText);
        }
    };

    request.open(method, url, true);
    request.send();
}

TWITTER = {
    common: function() {
        var obavijesti = document.getElementById('obavijesti');

        if (obavijesti) {
            obavijesti.addEventListener('click', function(e) {
                e.preventDefault();
            });
        }

        // Meni
        var toggle = document.getElementById('toggle-menu');

        if (toggle) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();

                var meni = document.getElementById('max-640-meni');
                meni.style.display = (meni.style.display === 'block' ? 'none' : 'block');
            });
        }
    },
    index: function() {
        var forma = document.getElementById('novi-nalog-forma');

        forma.addEventListener('submit', function(e) {
            var zaustavi = false;

            zaustavi |= !validirajIme();
            zaustavi |= !validirajPrezime();
            zaustavi |= !validirajEmail();
            zaustavi |= !validirajLozinku();
            
            if (zaustavi) {
                e.preventDefault();
            }
        });
    },
    izgubljenaLozinka: function() {
        var forma = document.getElementById('izgubljena-lozinka-forma');

        forma.addEventListener('submit', function(e) {
            if (!validirajEmail()) {
                e.preventDefault();
            }
        });
    },
    nalog: function() {
        var forma = document.getElementById('nalog-forma');

        forma.addEventListener('submit', function(e) {
            var zaustavi = false;

            zaustavi |= !validirajIme();
            zaustavi |= !validirajPrezime();
            zaustavi |= !validirajEmail();
            zaustavi |= !validirajLozinku();
            
            if (zaustavi) {
                e.preventDefault();
            }
        });
    },
    profil: function() {
        document.getElementById('galerija-fullscreen').addEventListener('keydown', function(e) {
            if (e.keyCode === 27) {
                this.style.display = 'none';
            }
        });

        var roditelj = document.getElementById('galerija');

        roditelj.getElementsByClassName('prethodna').item(0).addEventListener('click', function(e) {
            e.preventDefault();

            var aktivna = roditelj.getElementsByClassName('aktivna').item(0),
                nova = aktivna.previousElementSibling;

            if (!nova || nova.tagName !== 'IMG') {
                // Pomjeramo se do posljednje slike
                nova = aktivna;
                while (nova.nextElementSibling && nova.nextElementSibling.tagName === 'IMG') {
                    nova = nova.nextElementSibling;
                }
            }

            aktivna.className = '';
            nova.className = 'aktivna';
        });

        roditelj.getElementsByClassName('naredna').item(0).addEventListener('click', function(e) {
            e.preventDefault();

            var aktivna = roditelj.getElementsByClassName('aktivna').item(0),
                nova = aktivna.nextElementSibling;

            if (!nova || nova.tagName !== 'IMG') {
                // Pomjeramo se do prve slike
                nova = aktivna;
                while (nova.previousElementSibling && nova.previousElementSibling.tagName === 'IMG') {
                    nova = nova.previousElementSibling;
                }
            }

            aktivna.className = '';
            nova.className = 'aktivna';
        });

        var slike = roditelj.getElementsByTagName('img');
        for (var i = 0; i < slike.length; i++) {
            slike.item(i).addEventListener('click', function(e) {
                var fullscreen = document.getElementById('galerija-fullscreen');

                fullscreen.innerHTML = '';

                var nova = fullscreen.appendChild(this.cloneNode(true)),
                    sirina = Math.max(document.documentElement.clientWidth, window.innerWidth || 0),
                    visina = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);

                nova.style.maxWidth = (sirina - 20) + 'px';
                nova.style.maxHeight = (visina - 20) + 'px';

                fullscreen.style.display = 'block';
                fullscreen.focus();
            });
        }
    }
};

UTIL = {
    exec: function(sta) {
        var ns = TWITTER;

        if (ns['common'] && typeof ns['common'] === 'function') {
            ns['common']();
        }

        if (sta !== '' && ns[sta] && typeof ns[sta] === 'function') {
            ns[sta]();
        }
    },
};

function ucitajStranicu(ime) {
    loadingAnimation('show');
    ajaxRequest('GET', 'index.php?sta=partials/' + ime, function(html) {
        document.getElementById('sadrzaj').innerHTML = html;
        loadingAnimation('hide');
        UTIL.exec(ime);
    });
}

function parsirajUrl() {
    var hash = null;

    if (location.hash === '' || location.hash === '#') {
        hash = 'index';
    } else {
        hash = location.hash.substr(1);
    }

    ucitajStranicu(hash);
}

window.onhashchange = parsirajUrl;
window.onload = parsirajUrl;