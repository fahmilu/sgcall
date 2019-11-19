$(document).ready(function() {
    $('a.share').click(function(event) {
        event.preventDefault();
        $('header .share-area').addClass('active');
    });

    var lastScrollTop = 0;
    $(window).scroll(function(event){
       var st = $(this).scrollTop();
       // console.log(st);
       if (st > lastScrollTop && st > $('header').height()){
           $('header').addClass('scrollDown');
       } else {
           $('header').removeClass('scrollDown');
       }
       lastScrollTop = st;
    });

    $('a.page-scroll').bind('click', function(event) {
        var $anchor = $(this);
        var $gap = 0;
        if($(window).scrollTop() > $($anchor.attr('href')).offset().top){
          var $gap = $('header').height();
        }

        console.log($gap);
        $('html, body').stop().animate({
            scrollTop: ($($anchor.attr('href')).offset().top - $gap)
        }, 1000, 'easeInOutExpo');
        event.preventDefault();
    });

    $(document).mouseup(function(e) {
        var target = e.target; 
        if($(window).width() > 768){        
            if(!$(target).is('header .share-area') && $('header .share-area').hasClass('active')) {
            $('header .share-area').removeClass('active');
                // $toggleButton.toggleClass('button-open');
            }
        }
    });

    $("div.chck-green").mpmansory(
        {
            childrenClass: 'item',
            breakpoints:{
                lg: 6, 
                md: 6, 
                sm: 12,
                xs: 12
            }
        }
    );

    $('*[copyright="true"]').each(function(index, el) {
        $(this).addClass('with-copyright');
        var Text = $(this).attr('copyright-text'),
            Position = $(this).attr('copyright-position'),
            Orientation = $(this).attr('copyright-orientation'),
            Color = $(this).attr('copyright-color');

        $(this).prepend('<div class="c '+Position+' '+Orientation+'" style="color:'+Color+';">'+Text+'</div>');
    });
});