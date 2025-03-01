// window.alert('hi');

let successbox = document.querySelector('#signup-success_box');
let errorbox = document.querySelector('#signup-erro_box');
let switchBtn = document.querySelector('.switchBtn');
let switchBtnCon = document.querySelector('#switchBtnCon');
let aside = document.querySelector('aside');
let main = document.querySelector('main');
let header = document.querySelector('header');
let index = document.querySelector('#index');
let index_groo = document.querySelector('.index_groo');
let newvlog = document.querySelector('#newvlog');
let newvlog_grot = document.querySelector('#newvlog_grot');

switchBtn.addEventListener('click', function(){
    switchBtn.classList.toggle('moveBtn');
    switchBtnCon.classList.toggle('lightDarkBg');
    aside.classList.toggle('lightDarkBg');
    main.classList.toggle('DarkerBg');
    header.classList.toggle('lightDarkBg');
    index_groo.classList.toggle('lightDarkBg');
    index.classList.toggle('DarkerBg');
    newvlog.classList.toggle('DarkerBg');
    newvlog_grot.classList.toggle('lightDarkBg');

})
setTimeout(() => {
    successbox.style.display = 'none';
}, 8000);

setTimeout(() => {
    errorbox.style.display = 'none';
}, 8000);

document.addEventListener('DOMContentLoaded', () => {
    const menuToggle = document.getElementById('weep');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');

    menuToggle.addEventListener('click', () => {
        sidebar.classList.toggle('hidden');
        mainContent.classList.toggle('main-centered');
    });
});  

const links = document.querySelectorAll('.dash, .cret, .view, .pro');

// Function to set active link based on saved state
function setActiveLink() {
    const activeLink = localStorage.getItem('activeLink');
    if (activeLink) {
        links.forEach(link => {
            if (link.classList.contains(activeLink)) {
                link.classList.add('active');
            }
        });
    }
}

// Set active link on page load
setActiveLink();

links.forEach(link => {
    link.addEventListener('click', function() {
        // Remove 'active' class from all links
        links.forEach(link => link.classList.remove('active'));
        // Add 'active' class to the clicked link
        this.classList.add('active');
        // Save active link class to local storage
        localStorage.setItem('activeLink', this.classList[0]); // Assuming the class name is unique
    });
});
