console.log('yeahh boiiiii');

window.onload = () => {
    
    // Page Loader
    let pageLoader = document.getElementById('rks-page-loader')
    pageLoader.style.opacity = 0;
    setTimeout(function(){  
        pageLoader.style.display = 'none';
    }, 1500);

    // Init Particles JS
    Particles.init({
        selector: '.particle-js',
        color: '#ffffff40',
        maxParticles: 50,
        speed: .9
    });


    // Mobile Menu
    function closeMenu(){

        menuToggle.classList.remove('on');
        this.style.opacity = 0;
        let elClass = '.' + this.className;
        setTimeout(()=> {
            let target = document.querySelector(elClass);
            target.style.display = 'none';
        },300);
    }

    function openMenu(){
        menuToggle.classList.add('on');
        mobileMenu.style.display = 'flex';
        mobileMenu.style.opacity = 0;
        setTimeout(()=> {
            setTimeout(()=> {
                mobileMenu.style.opacity = 1;
            },1);
        },1);
    }

    let mobileMenu = document.querySelector('.rks-header__mobile-menu');
    let menuToggle = document.querySelector('.rks-header__menu-toggle');

    menuToggle.onclick = openMenu;
    mobileMenu.onclick = closeMenu;
};