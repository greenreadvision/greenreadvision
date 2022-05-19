var $header = document.getElementById('header');
var $nav = document.getElementsByClassName('nav_cover');
var $nav_b = document.getElementsByClassName('nav_b');
var $windowHeight = window.innerHeight;
var $headerHeight;
var navState=[0,0,0,0,0,0];
if(window.innerWidth<=1024){
    $headerHeight=72;
}
else{
    $headerHeight=93;
}
var changeStyle = function (index) {
    document.getElementById('nav_logo').style.opacity = '1';
    document.getElementById('nav2').style.color = "#514F4E";
    $header.style.background = "rgba(253, 253, 253, 1)";
    $header.style["boxShadow"] = "0px 2px 10px rgba(0, 0, 0, .3)"
    if (window.innerWidth >= 1024) {
        for (var i = 0; i < $nav.length; i++) {
            if (i == index) {
                navState[i]=1;
                $nav[i].style.color = "#DC8749";
                $nav_b[i].style.color = "#DC8749";
            } else {
                
                    navState[i]=0;
                
                if(navState[i]==0){
                    
                    $nav[i].style.color = "#514F4E";
                    $nav_b[i].style.color = "#514F4E";
                }
            }
        }
    }
}
window.onresize = (function(){
    $windowHeight = window.innerHeight;
    docTop=[$('news-board').offset().top,$('#about-as').offset().top,$('#event').offset().top,$('#design').offset().top,$('#video').offset().top,$('#contact').offset().top];
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
    document.getElementById('nav_logo').style.opacity = '1';
    document.getElementById('nav2').style.color = "#1d1d1d";
    $header.style.background = "rgba(253, 253, 253, 1)";
    $header.style["boxShadow"] = "0px 2px 10px rgba(0, 0, 0, .3)";
    if (window.innerWidth >= 1024) {
        for (var i = 0; i < $nav.length; i++) {
            $nav[i].style.color = "#514F4E";
            $nav_b[i].style.color = "#514F4E";
        }
    }
    if (window.innerWidth <= 1024) {
        document.getElementById('nav_logo').style.display = 'none';
    }

    // window.onbeforeunload = function(e) {
    //     var dialogText = 'Dialog text here';
    //     e.returnValue = dialogText;
    //     console.log('hello')
    //     window.localStorage.setItem("id", "");
    // };
    
    if(location.pathname!='/'){
        $('#nav_top').click(function () { // When arrow is clicked
            // window.localStorage.setItem("id", "");
            window.location.assign('/')
        });

        $('#go-news').click(function () { // When arrow is clicked
            // window.localStorage.setItem("id", "go-news");
            window.location.assign('/#news-board')
        });

        $('#go-about').click(function () { // When arrow is clicked
            // window.localStorage.setItem("id", "go-about");
            window.location.assign('/#about-as')
        });

        $('#go-event').click(function () { // When arrow is clicked
            // window.localStorage.setItem("id", "go-event");
            window.location.assign('/#event')
        });

        $('#go-design').click(function () { // When arrow is clicked
            // window.localStorage.setItem("id", "go-design");
            window.location.assign('/#design')
        });

        $('#go-video').click(function () { // When arrow is clicked
            // window.localStorage.setItem("id", "go-video");
            window.location.assign('/#video')
        });

        $('#go-contact').click(function () { // When arrow is clicked
            // window.localStorage.setItem("id", "go-contact");
            window.location.assign('/#contact')
        });
    }else{
        $('#nav_top').click(function () { // When arrow is clicked
            $('body,html').animate({
                scrollTop: 0 // Scroll to top of body
            }, 750);
        });
        
        // $('#go-news').click(function () { // When arrow is clicked
        //     $('body,html').animate({
        //         scrollTop: $('#news-board').offset().top - $headerHeight// Scroll to top of body
        //     }, 750);
        //     console.log($('#news-board').offset().top - $headerHeight)
        // });

        // $('#go-about').click(function () { // When arrow is clicked
        //     $('body,html').animate({
        //         scrollTop: $('#about-as').offset().top - $headerHeight// Scroll to top of body
        //     }, 750);
        //     console.log($('#about-as').offset().top - $headerHeight)
        // });
        
        // $('#go-event').click(function () { // When arrow is clicked
        //     $('body,html').animate({
        //         scrollTop: $('#event').offset().top - $headerHeight // Scroll to top of body
        //     }, 750);
        //     console.log($('#event').offset().top - $headerHeight)
        // });

        // $('#go-design').click(function () { // When arrow is clicked
        //     $('body,html').animate({
        //         scrollTop: $('#design').offset().top - $headerHeight  // Scroll to top of body
        //     }, 750);
        //     console.log($('#design').offset().top - $headerHeight)
        // });

        // $('#go-video').click(function () { // When arrow is clicked
        //     $('body,html').animate({
        //         scrollTop: $('#video').offset().top - $headerHeight // Scroll to top of body
        //     }, 750);
        //     console.log($('#video').offset().top - $headerHeight)
        // });

        // $('#go-contact').click(function () { // When arrow is clicked
        //     $('body,html').animate({
        //         scrollTop: $('#contact').offset().top - $headerHeight // Scroll to top of body
        //     }, 750);
        //     console.log($('#contact').offset().top - $headerHeight)
        // });

        // if(window.localStorage.getItem("id") =='go-news'){
        //     $('body,html').animate({
        //         scrollTop: 661.3645629882812 // Scroll to top of body
        //     }, 750);
        //     window.localStorage.setItem("id", "");
        // }
    
        // if(window.localStorage.getItem("id") =='go-about'){
        //     $('body,html').animate({
        //         scrollTop: 1267.2708129882812// Scroll to top of body
        //     }, 750);
        //     window.localStorage.setItem("id", "");
        // }
    
        // if(window.localStorage.getItem("id") =='go-event'){
        //     $('body,html').animate({
        //         scrollTop: 1961.5728759765625 // Scroll to top of body
        //     }, 750);
        //     window.localStorage.setItem("id", "");
        // }
    
        // if(window.localStorage.getItem("id") =='go-design'){
        //     $('body,html').animate({
        //         scrollTop: 2819.0521240234375  // Scroll to top of body
        //     }, 750);
        //     window.localStorage.setItem("id", "");
        // }
    
        // if(window.localStorage.getItem("id") =='go-video'){
        //     $('body,html').animate({
        //         scrollTop: 3335.4584350585938 // Scroll to top of body
        //     }, 750);
        //     window.localStorage.setItem("id", "");
        // }
    
        // if(window.localStorage.getItem("id") =='go-contact'){
        //     $('body,html').animate({
        //         scrollTop: 3887.1978759765625 // Scroll to top of body
        //     }, 750);
        //     window.localStorage.setItem("id", "");
        // }
    }    
});

$(window).scroll(function () {
    var title=document.getElementsByClassName('title-style')

});
var hoverChange = function (index) {
    if ($(this).scrollTop() >= 50) {
        $nav[index].style.color = "#DC8749";
        $nav_b[index].style.color = "#DC8749";
    }
}
var hoverReapet = function (index) {
    if ($(this).scrollTop() >= 50 && navState[index]==0) {
        if (!($(this).scrollTop() > $windowHeight - $windowHeight / 4 && $(this).scrollTop() <= ($windowHeight + ($windowHeight - $headerHeight) - $windowHeight / 4) && index == 0)) {
            $nav[index].style.color = "#514F4E";
            $nav_b[index].style.color = "#514F4E";
        } else if (!($(this).scrollTop() > ($windowHeight + ($windowHeight - $headerHeight) * index - $windowHeight / 4) && $(this).scrollTop() <= ($windowHeight + ($windowHeight - $headerHeight) * (index + 1) - $windowHeight / 4))) {
            $nav[index].style.color = "#514F4E";
            $nav_b[index].style.color = "#514F4E";
        }

    }
}


// $('#nav-panel-open').click(function () { // When arrow is clicked
//     document.getElementById('nav-panel').style.transform='translateX(-100vw)'
// });
// $('#nav-panel-close').click(function () { // When arrow is clicked
//     document.getElementById('nav-panel').style.transform='translateX(100vw)'
// });
// $('#nav-panel-go-news').click(function () { // When arrow is clicked
//     document.getElementById('nav-panel').style.transform='translateX(100vw)'
//     $('body,html').animate({
//         scrollTop: $('#news-board').offset().top - $headerHeight// Scroll to top of body
//     }, 750);
//     console.log('hi')
// });
// $('#nav-panel-go-about').click(function () { // When arrow is clicked
//     document.getElementById('nav-panel').style.transform='translateX(100vw)'
//     $('body,html').animate({
//         scrollTop: $('#about-as').offset().top - $headerHeight// Scroll to top of body
//     }, 750);
// });
// $('#nav-panel-go-event').click(function () { // When arrow is clicked
//     document.getElementById('nav-panel').style.transform='translateX(100vw)'
//     $('body,html').animate({
//         scrollTop: $('#event').offset().top - $headerHeight// Scroll to top of body
//     }, 750);
// });
// $('#nav-panel-go-design').click(function () { // When arrow is clicked
//     document.getElementById('nav-panel').style.transform='translateX(100vw)'
//     $('body,html').animate({
//         scrollTop: $('#design').offset().top - $headerHeight// Scroll to top of body
//     }, 750);
// });
// $('#nav-panel-go-video').click(function () { // When arrow is clicked
//     document.getElementById('nav-panel').style.transform='translateX(100vw)'
//     $('body,html').animate({
//         scrollTop: $('#video').offset().top - $headerHeight// Scroll to top of body
//     }, 750);
// });
// $('#nav-panel-go-contact').click(function () { // When arrow is clicked
//     document.getElementById('nav-panel').style.transform='translateX(100vw)'
//     $('body,html').animate({
//         scrollTop: $('#contact').offset().top - $headerHeight// Scroll to top of body
//     }, 750);
// });
// $('#nav-panel-go-home').click(function () { // When arrow is clicked
//     document.getElementById('nav-panel').style.transform='translateX(100vw)'
//     $('body,html').animate({
//         scrollTop: 0// Scroll to top of body
//     }, 750);
// });

$('#go-news').hover(function () {
    hoverChange(0)
}, function () {
    hoverReapet(0)
});

$('#go-about').hover(function () {
    hoverChange(1)
}, function () {
    hoverReapet(1)
});

$('#go-event').hover(function () {
    hoverChange(2)
}, function () {
    hoverReapet(2)
});

$('#go-design').hover(function () {
    hoverChange(3)
}, function () {
    hoverReapet(3)
});

$('#go-video').hover(function () {
    hoverChange(4)
}, function () {
    hoverReapet(4)
});

$('#go-contact').hover(function () {
    hoverChange(5)
}, function () {
    hoverReapet(5)
});