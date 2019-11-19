$(document).ready(function() {

    $("#CottonRanking .col-md-3 .content").stick_in_parent();
    $("#CottonRanking .col-md-8 .header-table").stick_in_parent();

    // var lastScrollTop = 0;
    // $(window).scroll(function(event){
    //    var st = $(this).scrollTop();
    //    // console.log(st);
    //    if (st > lastScrollTop && st > $('header').height()){
    //       $('.is_stuck').removeClass('scrollUp');
    //    } else {
    //        // $('is_stuck').addClass('scrollUp');
    //       if($('.is_stuck').css('position') == 'fixed'){
    //        $('.is_stuck').addClass('scrollUp');
    //       }else{
    //        $('.is_stuck').removeClass('scrollUp');
    //       }

    //       if(st <= $('#CottonRanking .container').offset().top){
    //         $('.scrollUp').removeClass('scrollUp');
    //       }
    //    }
    //    lastScrollTop = st;
    // });

    //   function sticky($entry){
    //       $entry.addClass('sticky');
    //       $entry.css('top', 0);
    //       // $('#CottonRanking .col-md-3').css('left', .offset().left);

    //   }
    //   function isPartlyInViewPort($entry){
    //       var windowScrollTop = $(window).scrollTop();
    //       var entryTop = $entry.offset().top;
    //       var isBelowViewPort = (windowScrollTop) >= entryTop;

    //       return isBelowViewPort;
    //   }

    // $grid = $('ul.twocolumns').masonry({
    //   itemSelector: 'li',
    //   percentPosition: true
    // });
});