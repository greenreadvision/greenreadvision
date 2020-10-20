$(document).ready(function() {
var setArea = $('.scrEvent'),
showHeight = 150;
setArea.css({display:'block', opacity:'0'});
$(window).on('load scroll resize', function(){
             setArea.each(function(){
                          var setThis = $(this),
                          areaTop = setThis.offset().top;
                          if ($(window).scrollTop() >
                              (areaTop + showHeight) - $(window).height()){
                          setThis.stop().animate({opacity:'1'}, 500);
                          } else {
                          setThis.stop().animate({opacity:'0'}, 500);
                          }
                          });
             });
 });
