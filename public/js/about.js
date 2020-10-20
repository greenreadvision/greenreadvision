$(document).ready(function() {
                  $(window).scroll( function(){
                                   
                    $('.RWDr').each( function(i){
                                                      var helper=$(this).style.width;
                                                      var bottom_of_object = $(this).offset().top + ($(this).outerHeight()/2);
                                                      var bottom_of_window = $(window).scrollTop() + $(window).height();
                                                      if( bottom_of_window > bottom_of_object && helper!=85  ){
                                                      helper=1;
                                                      $(this).delay( 100 );
                                                      $(this).animate({'opacity':'1',width: '85%'},1000);
                                                      }
                                                      
                                                      });
                                   
                                   
                  $('.hideme').each( function(i){
                                    var bottom_of_object = $(this).offset().top + ($(this).outerHeight()/2);
                                    var bottom_of_window = $(window).scrollTop() + $(window).height();
                                    /* If the object is completely visible in the window, fade it it */
                                    if( bottom_of_window > bottom_of_object ){
                                    helper=1;
                                    $(this).animate({'opacity':'1'},750);
                                    }
                                    
                                    });
                                   $('.hideme2').each( function(i){
                                     var bottom_of_object = $(this).offset().top + ($(this).outerHeight()/2);
                                     var bottom_of_window = $(window).scrollTop() + $(window).height();
                                     /* If the object is completely visible in the window, fade it it */
                                     if( bottom_of_window > bottom_of_object ){
                                     helper=1;
                                     $(this).delay( 100 );
                                     $(this).animate({'opacity':'1',width: '40%',left:'0%'},1000);
                                     }
                                     });
                                   $('.hideme3').each( function(i){
                                     var bottom_of_object = $(this).offset().top + ($(this).outerHeight()/2);
                                     var bottom_of_window = $(window).scrollTop() + $(window).height();
                                     /* If the object is completely visible in the window, fade it it */
                                     if( bottom_of_window > bottom_of_object  ){
                                     helper=1;
                                     $(this).delay( 100 );
                                     $(this).animate({'opacity':'1',width: '40%'},1000);
                                     }
                                     });
                  });
                  });



