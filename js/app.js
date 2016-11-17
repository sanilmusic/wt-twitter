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
window.onload = parsirajUrl;