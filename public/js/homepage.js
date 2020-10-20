$(function () {
    $(window).scroll(function () {
        var y = $(this).scrollTop();
        var width = window.innerWidth
        if (y > 500 && width> 980) {
            $('#animate1').attr('id', 'title');
            $('#animate2').attr('id', 'content');
        };
    });
});
