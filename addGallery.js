const addButton = document.getElementById('addDiv');
const container = document.getElementById('galeria');
var number_of_photos = 9;
addDiv(number_of_photos);

// Funkcja dodająca diva
function addDiv(ileZdjec) {
    for (let i = 1; i <= ileZdjec; i++) {
        const div_col = document.createElement('div');
        const div_image = document.createElement('div');
        div_col.classList.add('col-md-4');
        div_image.classList.add('thumbnail')
        var link = 'img/koty/kot' + i + '.jpeg';
        var data = 'Kot no.' + i;
        const a_img = document.createElement('a');
        a_img.href = link;
        a_img.setAttribute('data-lightbox', 'mygallery');
        a_img.setAttribute('data-title', data);

        const newImage = document.createElement('img');
        newImage.src = link;
        newImage.alt = 'kitty ' + 1;
        
        a_img.appendChild(newImage);
        div_image.appendChild(a_img);
        div_col.appendChild(div_image);
        container.appendChild(div_col);
    } 
}