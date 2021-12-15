var $header = document.getElementById('header');
var $nav = document.getElementsByClassName('nav_cover');
var $nav_b = document.getElementsByClassName('nav_b');
var $windowHeight = window.innerHeight;
var $headerHeight;
var navState=[0,0,0,0,0];
if(window.innerWidth<=1024){
    $headerHeight=72;
}
else{
    $headerHeight=93;
}
window.onresize = (function(){
    $windowHeight = window.innerHeight;
    docTop=[$('#about-as').offset().top,$('#event').offset().top,$('#design').offset().top,$('#video').offset().top,$('#contact').offset().top];

})
$(document).ready(function(){
    var title=document.getElementsByClassName('title-style')
    if (window.innerWidth > 1024) {
        // if($(this).scrollTop()<=$windowHeight /2){
            $("#home-img").addClass("homeImg");
            $("#home-content").addClass("homeContent");
        // }
        
    }else{
        $("#home-img").addClass("homeImg");
        $("#home-content").addClass("homeImg");
    }
        //document.getElementById('nav_logo').style.opacity = '1';
        document.getElementById('nav2').style.color = "#1d1d1d";
        $header.style.background = "rgba(253, 253, 253, 1)";
        $header.style["boxShadow"] = "0px 2px 10px rgba(0, 0, 0, .3)";
        if (window.innerWidth >= 1024) {
            for (var i = 0; i < $nav.length; i++) {
                $nav[i].style.color = "#514F4E";
                $nav_b[i].style.color = "#514F4E";
            }
        }
    var docTop=[$('#about-as').offset().top,$('#event').offset().top,$('#design').offset().top,$('#video').offset().top,$('#contact').offset().top];
    /*if (window.innerWidth <= 1024) {
        document.getElementById('nav_logo').style.display = 'none';
    }*/
    
});

$(window).scroll(function () {
    if($(this).scrollTop()>0){
        document.getElementById('band').classList.add('band-fixed');
        document.getElementById('band').classList.remove('band');
        document.getElementById('header').classList.add('header-fixed');
        document.getElementById('header').classList.remove('header');
    }else if ($(this).scrollTop() == 0){
        document.getElementById('band').classList.remove('band-fixed');
        document.getElementById('band').classList.add('band');
        document.getElementById('header').classList.remove('header-fixed');
        document.getElementById('header').classList.add('header');
    }
});

$('#menu_total').hover(
    function(){
        $('#menu_total').css('color','#fff');
        $('.band').addClass("showMenu");
        $('.band-fixed').addClass("showMenu");
        $('.band').removeClass("closeMenu");
        $('.band-fixed').removeClass("closeMenu");
            $('#header').addClass("showMenu");
            $('.sub-menu').addClass("showMenu");
            $('#header').removeClass("closeMenu");
            $('.sub-menu').removeClass("closeMenu");
        


    },function(){

        $('.sub-menu').addClass("closeMenu");
        $('#header').addClass("closeMenu");
        $('#header').removeClass("showMenu");
        $('.sub-menu').removeClass("showMenu");

        $('#menu_total').css('color','#000');
        
        
            $('.band').removeClass("showMenu");
            $('.band-fixed').removeClass("showMenu");
            $('.band').addClass("closeMenu");
            $('.band-fixed').addClass("closeMenu");
        
        

    }
)