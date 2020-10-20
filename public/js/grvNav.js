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
var changeStyle = function (index) {
    document.getElementById('nav_logo').style.opacity = '1';
    document.getElementById('nav2').style.color = "#1d1d1d";
    $header.style.background = "rgba(253, 253, 253, 1)";
    $header.style["boxShadow"] = "0px 2px 10px rgba(0, 0, 0, .3)"
    if (window.innerWidth >= 1024) {
        for (var i = 0; i < $nav.length; i++) {
            if (i == index) {
                navState[i]=1;
                $nav[i].style.color = "#58c1c4";
                $nav_b[i].style.color = "#58c1c4";
            } else {
                
                    navState[i]=0;
                
                if(navState[i]==0){
                    
                    $nav[i].style.color = "#1d1d1d";
                    $nav_b[i].style.color = "#1d1d1d";
                }
            }
        }
    }
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
    if ($(this).scrollTop() >= 50){
        document.getElementById('nav2').style.color = "#1d1d1d";
    }
    else{
        document.getElementById('nav2').style.color = "#fff";
    }
    var docTop=[$('#about-as').offset().top,$('#event').offset().top,$('#design').offset().top,$('#video').offset().top,$('#contact').offset().top];
    if (window.innerWidth <= 1024) {
        document.getElementById('nav_logo').style.display = 'none';
    }
    // if($('#about-as').offset().top-$(this).scrollTop()<=$windowHeight /2){
    //     $(title[0]).addClass("leftIn");
    //     setTimeout('$("#about-content").addClass("leftIn");',1000)
    // }
    // if($('#contact').offset().top-$(this).scrollTop()<=$windowHeight /2){
    //     $(title[4]).addClass("titleIn");
    //     setTimeout('$("#contact-information").addClass("leftIn");$("#contact-map").addClass("rightIn");',500)
    // }
    // if($('#video').offset().top-$(this).scrollTop()<=$windowHeight /2){
    //     $(title[3]).addClass("titleIn");
    //     setTimeout(' $("#video-mp4").addClass("videoMp4");$("#video-content").addClass("videoMp4")',500)
    // }
    
});
$(window).scroll(function () {
    var title=document.getElementsByClassName('title-style')
    if ($(this).scrollTop() >= 50 && $(this).scrollTop() <=  $('#about-as').offset().top - $windowHeight / 4) { // If page is scrolled more than 50px
        document.getElementById('nav_logo').style.opacity = '1';
        document.getElementById('nav2').style.color = "#1d1d1d";
        $header.style.background = "rgba(253, 253, 253, 1)";
        $header.style["boxShadow"] = "0px 2px 10px rgba(0, 0, 0, .3)";
        if (window.innerWidth >= 1024) {
            for (var i = 0; i < $nav.length; i++) {
                $nav[i].style.color = "#1d1d1d";
                $nav_b[i].style.color = "#1d1d1d";
            }
        }
    } else if ($(this).scrollTop() > $('#about-as').offset().top - $windowHeight / 4 && $(this).scrollTop() <= ($('#event').offset().top - $windowHeight / 4)) { // If page is scrolled more than 50px
        changeStyle(0);
        $(title[0]).addClass("titleIn");
        setTimeout('$("#about-content").addClass("leftIn")',500)
        
    } else if ($(this).scrollTop() > ($('#event').offset().top - $windowHeight / 4) && $(this).scrollTop() <= ($('#design').offset().top - $windowHeight / 4)) { // If page is scrolled more than 50px
        changeStyle(1);
        $(title[1]).addClass("titleIn");
        setTimeout('$(".hakka,.operation,.read,.child").addClass("scaleIn")',500)

    } else if ($(this).scrollTop() > ($('#design').offset().top - $windowHeight / 4) && $(this).scrollTop() <= ($('#video').offset().top - $windowHeight / 4)) { // If page is scrolled more than 50px
        changeStyle(2);
        $(title[2]).addClass("titleIn");
        setTimeout('$("#swiper2").addClass("upIn")',500)

    } else if ($(this).scrollTop() >($('#video').offset().top - $windowHeight / 4) && $(this).scrollTop()+ $windowHeight <=$('#footer').offset().top) { // If page is scrolled more than 50px
        changeStyle(3);
        $(title[3]).addClass("titleIn");
        setTimeout(' $("#video-mp4,#video-content").addClass("upIn")',500)
        // setTimeout('$("#video-content").addClass("leftIn")',1000)
    } else if ($(this).scrollTop()+ $windowHeight >$('#footer').offset().top) { // If page is scrolled more than 50px
        changeStyle(4);
        $(title[4]).addClass("titleIn");
        setTimeout('$("#contact-information").addClass("leftIn");$("#contact-map").addClass("rightIn");',500)
    } else {
        document.getElementById('nav2').style.color = "#fff";
        document.getElementById('nav_logo').style.opacity = '0';
        $header.style.background = "rgba(255, 255, 255, 0)";
        $header.style["boxShadow"] = "0px 0px 0px rgba(0, 0, 0, .5)";
        if (window.innerWidth >= 1024) {
            for (i = 0; i < $nav.length; i++) {
                $nav[i].style.color = "white";
                $nav_b[i].style.color = "white";
                navState[i]=0;
            }
        }
    }

});
var hoverChange = function (index) {
    if ($(this).scrollTop() >= 50) {
        $nav[index].style.color = "#58c1c4";
        $nav_b[index].style.color = "#58c1c4";
    }
}
var hoverReapet = function (index) {
    if ($(this).scrollTop() >= 50 && navState[index]==0) {
        if (!($(this).scrollTop() > $windowHeight - $windowHeight / 4 && $(this).scrollTop() <= ($windowHeight + ($windowHeight - $headerHeight) - $windowHeight / 4) && index == 0)) {
            $nav[index].style.color = "#1d1d1d";
            $nav_b[index].style.color = "#1d1d1d";
        } else if (!($(this).scrollTop() > ($windowHeight + ($windowHeight - $headerHeight) * index - $windowHeight / 4) && $(this).scrollTop() <= ($windowHeight + ($windowHeight - $headerHeight) * (index + 1) - $windowHeight / 4))) {
            $nav[index].style.color = "#1d1d1d";
            $nav_b[index].style.color = "#1d1d1d";
        }

    }
}
$('#nav_top').click(function () { // When arrow is clicked

    $('body,html').animate({
        scrollTop: 0 // Scroll to top of body
    }, 750);
});
$('#go-about').click(function () { // When arrow is clicked
    $('body,html').animate({
        scrollTop: $('#about-as').offset().top - $headerHeight// Scroll to top of body
    }, 750);
});
$('#go-about').hover(function () {
    hoverChange(0)
}, function () {
    hoverReapet(0)
});

$('#go-event').click(function () { // When arrow is clicked
    $('body,html').animate({
        scrollTop: $('#event').offset().top - $headerHeight // Scroll to top of body
    }, 750);
});
$('#go-event').hover(function () {
    hoverChange(1)
}, function () {
    hoverReapet(1)
});
$('#go-design').click(function () { // When arrow is clicked
    $('body,html').animate({
        scrollTop: $('#design').offset().top - $headerHeight  // Scroll to top of body
    }, 750);
});
$('#go-design').hover(function () {
    hoverChange(2)
}, function () {
    hoverReapet(2)
});
$('#go-video').click(function () { // When arrow is clicked
    $('body,html').animate({
        scrollTop: $('#video').offset().top - $headerHeight // Scroll to top of body
    }, 750);
});
$('#go-video').hover(function () {
    hoverChange(3)
}, function () {
    hoverReapet(3)
});

$('#go-contact').click(function () { // When arrow is clicked
    $('body,html').animate({
        scrollTop:  $('#contact').offset().top - $headerHeight // Scroll to top of body
    }, 750);
});
$('#go-contact').hover(function () {
    hoverChange(4)
}, function () {
    hoverReapet(4)
});
$('#nav-panel-open').click(function () { // When arrow is clicked
    document.getElementById('nav-panel').style.transform='translateX(-100vw)'
});
$('#nav-panel-close').click(function () { // When arrow is clicked
    document.getElementById('nav-panel').style.transform='translateX(100vw)'
});
$('#nav-panel-go-about').click(function () { // When arrow is clicked
    document.getElementById('nav-panel').style.transform='translateX(100vw)'
    $('body,html').animate({
        scrollTop: $('#about-as').offset().top - $headerHeight// Scroll to top of body
    }, 750);
});
$('#nav-panel-go-event').click(function () { // When arrow is clicked
    document.getElementById('nav-panel').style.transform='translateX(100vw)'
    $('body,html').animate({
        scrollTop: $('#event').offset().top - $headerHeight// Scroll to top of body
    }, 750);
});
$('#nav-panel-go-design').click(function () { // When arrow is clicked
    document.getElementById('nav-panel').style.transform='translateX(100vw)'
    $('body,html').animate({
        scrollTop: $('#design').offset().top - $headerHeight// Scroll to top of body
    }, 750);
});
$('#nav-panel-go-video').click(function () { // When arrow is clicked
    document.getElementById('nav-panel').style.transform='translateX(100vw)'
    $('body,html').animate({
        scrollTop: $('#video').offset().top - $headerHeight// Scroll to top of body
    }, 750);
});
$('#nav-panel-go-contact').click(function () { // When arrow is clicked
    document.getElementById('nav-panel').style.transform='translateX(100vw)'
    $('body,html').animate({
        scrollTop: $('#contact').offset().top - $headerHeight// Scroll to top of body
    }, 750);
});
$('#nav-panel-go-home').click(function () { // When arrow is clicked
    document.getElementById('nav-panel').style.transform='translateX(100vw)'
    $('body,html').animate({
        scrollTop: 0// Scroll to top of body
    }, 750);
});