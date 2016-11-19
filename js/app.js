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
    profil: function() {
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
        })
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
    ajaxRequest('GET', 'partials/' + ime + '.html', function(html) {
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