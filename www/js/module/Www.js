$(document).ready(function(){
    $('#menu-button').click(function(){
        $('div.body').toggleClass('transition');
    });

    const content = $('.content-item');
    const back = $('#back');
    const forward = $('#forward');

    function swapContent(target)
    {
        content.filter(':visible').addClass('d-none');
        target.removeClass('d-none');

        if (!target.prev('.content-item').length)
        {
            back.addClass('unavailable');
        }
        else
        {
            back.removeClass('unavailable');
        }

        if (!target.next('.content-item').length)
        {
            forward.addClass('unavailable');
        }
        else
        {
            forward.removeClass('unavailable');
        }

        window.location.hash = '#' + target.attr('class').split(' ').pop();
    }

    const hash = window.location.hash.substr(1);
    if (hash)
    {
        const hashSection = $('.content-item.' + hash);

        if (hashSection.length)
        {
            swapContent(hashSection);
        }
    }

    back.click(function(){
        if ($(this).hasClass('unavailable'))
        {
            return;
        }

        swapContent(content.filter(':visible').prev('.content-item'));
    });

    forward.click(function(){
        if ($(this).hasClass('unavailable'))
        {
            return;
        }

        swapContent(content.filter(':visible').next('.content-item'));
    });
});
