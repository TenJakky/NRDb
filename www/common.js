var chosenOptions =
{
    disable_search_threshold: 12,
    no_results_text: "Oops, nothing found!",
    width: '50%'
};

Nette.showFormErrors = function (form, errors)
{
    $(form).find('span.form-error').remove();

    for (var i = 0; i < errors.length; i++)
    {
        $(errors[i].element).parent().append('<span class="form-error">' + errors[i].message + '</span>');
    }

    if (errors.length > 0)
    {
        var elem = errors[0].element;

        if (elem.nodeName == 'SELECT')
        {
            $(elem).trigger('chosen:activate');
            return;
        }
        $(elem).focus();
    }
};

$(document).ready(function ()
{
    $('select').chosen(chosenOptions);

    $.nette.ext('flash', {
        complete: function () {
            $('.flash').animate({
                opacity: 1.0
            }, 2000).fadeOut(1000);
        }
    });
    $.nette.init();

    $('#search').keyup(function()
    {
        var value = $(this).val();

        $.nette.ajax(
        {
            traditional: true,
            url: searchUrl,
            method: 'POST',
            data:
            {
                search: value
            },
            success: function()
            {
                return;
            }
        });
    });

    $('#search').focus(function()
    {
        //$(this).next().toggle();
    });
});
