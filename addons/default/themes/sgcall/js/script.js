$(document).ready(function() {
    $('.lazy').lazy({
        effect: "fadeIn",
        effectTime: 1000,
        threshold: 0
    });

    // $('.image-link').magnificPopup({type:'image'});
    
    $('p').filter(function () { return this.innerHTML == "" }).remove();
    
    $('#navbarNav a.nav-link').click(function(event) {
        var clickover = $(event.target);
        var _opened = $(".navbar-collapse").hasClass("show");
        if (_opened === true && !clickover.hasClass("navbar-toggler")) {
            $(".navbar-toggler").click();
        }
    });

    headerMan();
    $(window).scroll(function(event) {
        headerMan();
    });

    function headerMan() {
        if($(window).scrollTop() > 50){
            $('header').addClass('black');
        }else{
            $('header').removeClass('black');
        }
    }

      // Activate scrollspy to add active class to navbar items on scroll
    // $('body').scrollspy({
    //     target: '#navbarNav',
    //     offset: $('header').outerHeight()
    // });

});

