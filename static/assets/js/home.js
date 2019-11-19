$(document).ready(function() {
    $(window).scroll(function() { 

        if(LegendShow()){
            $('#Legends').removeClass('slide-down');
        }else{
            $('#Legends').addClass('slide-down');
        }
        if(isPartlyInViewPort($('#OtherLink'))){
            $('#Legends').addClass('slide-down');
        }

    });

      function isPartlyInViewPort($entry){
          var windowScrollTop = $(window).scrollTop();
          var entryTop = $entry.offset().top - $(window).height();
          var isBelowViewPort = (windowScrollTop) >= entryTop;

          return isBelowViewPort;
      }

      function LegendShow(){
          var windowScrollTop = $(window).scrollTop();
          var entryTop = $('#CompanyList .row').offset().top + $('#CompanyList .row [class*="col-"]').outerHeight() - $(window).height();
          console.log(entryTop);
          var isBelowViewPort = (windowScrollTop) >= entryTop;

          return isBelowViewPort;
      }

      $('.hide-btn').click(function(event) {
        event.preventDefault();
         $('#Legends').addClass('slide-right');
      });

      $('.show-btn').click(function(event) {
        event.preventDefault();
         $('#Legends').removeClass('slide-right');
      });
});