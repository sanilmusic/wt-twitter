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

function ucitajStranicu(ime) {
    loadingAnimation('show');
    ajaxRequest('GET', 'partials/' + ime + '.html', function(html) {
        document.getElementById('sadrzaj').innerHTML = html;
        loadingAnimation('hide');
    });
}

function parsirajUrl() {
    if (location.hash === '' || location.hash === '#') {
        ucitajStranicu('index');
    } else {
        ucitajStranicu(location.hash.substr(1));
    }
}

window.onhashchange = parsirajUrl;
window.onload = function() {
    parsirajUrl();

    document.getElementsByTagName('body').item(0).addEventListener('click', function(e) {
        var el = e.target;
        while (el !== null && el.tagName !== 'A') {
            el = el.parentElement;
        }
        if (el === null) {
            return;
        } else if (el.dataset.traverse === 'false') {
            e.preventDefault();
        }

        // Meni
        if (el.id === 'toggle-menu') {
            var meni = document.getElementById('max-640-meni');
            meni.style.display = (meni.style.display === 'block' ? 'none' : 'block');
        }

        // Galerija
        if (el.className === 'prethodna' || el.className === 'naredna') {
            var roditelj = document.getElementById('galerija'),
                aktivna = roditelj.getElementsByClassName('aktivna').item(0),
                nova = null;
            
            if (el.className === 'prethodna') {
                nova = aktivna.previousElementSibling;

                if (nova === null || nova.tagName !== 'IMG') {
                    // Pomjeramo se do posljednje slike
                    nova = aktivna;

                    while (nova.nextElementSibling && nova.nextElementSibling.tagName === 'IMG') {
                        nova = nova.nextElementSibling;
                    }
                }
            } else if (el.className === 'naredna') {
                nova = aktivna.nextElementSibling;

                if (nova === null || nova.tagName !== 'IMG') {
                    // Pomjeramo se do prve slike
                    nova = aktivna;

                    while (nova.previousElementSibling && nova.previousElementSibling.tagName === 'IMG') {
                        nova = nova.previousElementSibling;
                    }
                }
            }

            aktivna.className = '';
            nova.className = 'aktivna';
        }
    });
}