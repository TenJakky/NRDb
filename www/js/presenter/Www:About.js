$('#menu-button').click(function(){
    $('body').toggleClass('transition');
});


$('#back').click(function(){
    if ($(this).hasClass('unavailable'))
    {
        return;
    }

    var content = $('.content-item').filter(':visible');
    var previous = content.prev('.content-item');

    content.hide();
    previous.show();

    if (!previous.prev('.content-item').length)
    {
        $(this).addClass('unavailable')
    }
    $('#forward').removeClass('unavailable');
});


$('#forward').click(function(){
    if ($(this).hasClass('unavailable'))
    {
        return;
    }

    var content = $('.content-item').filter(':visible');
    var next = content.next('.content-item');

    content.hide();
    next.show();

    if (!next.next('.content-item').length)
    {
        $(this).addClass('unavailable')
    }
    $('#back').removeClass('unavailable');
});
