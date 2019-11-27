const $ = require('jquery');

require('adminator/src/assets/scripts/index.js');
require('../css/app.scss');

// Taken from template
window.addEventListener('load', () => {
    const loader = document.getElementById('loader');
    if (loader) {
        setTimeout(() => {
            loader.classList.add('fadeOut');
        }, 300);
    }
});
