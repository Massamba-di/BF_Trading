const button = document.querySelector('#btn');
const input = document.querySelector('#inputsearch');

button.addEventListener('click', function (event) {
    const articles = document.querySelectorAll('article[data-nom][data-categorie]');

    for (const article of articles) {

        const nom = article.getAttribute('data-nom').toLowerCase();
        const categorie = article.getAttribute('data-categorie').toLowerCase();

        const recherche = input.value.toLowerCase().trim();

        // Vérifier si la recherche correspond au nom OU à la catégorie
        if (nom.includes(recherche) || categorie.includes(recherche)) {
            article.style.display = "block";
        } else {
            article.style.display = "none";
        }
    }
});
