$(document).ready(function ()
{
    var formValues = [];

    function storeValues()
    {
        $('form')
        .filter(':first')
        .find('input, textarea, select')
        .not('input[type="button"], input[type="submit"], input[name="_do"]')
        .each(function()
        {
            if ($(this).parent().hasClass('search-field'))
            {
                return;
            }
            formValues.push($(this).val());
        });
    }

    function restoreValues()
    {
        var index = 0;
        $('form')
        .filter(':first')
        .find('input, textarea, select')
        .not('input[type="button"], input[type="submit"], input[name="_do"]')
        .each(function()
        {
            if ($(this).parent().hasClass('search-field'))
            {
                return;
            }
            $(this).val(formValues[index]);
            index++;
        });
    }

    $.nette.ext('snippets').after(function (el)
    {
        restoreValues();
        $(el).find('select').chosen(chosenOptions);
        $('#artist_subform').hide();
    });
    $.nette.ext('snippets').before(function (el)
    {
        storeValues();
    });
    $.nette.load();

    $('#add_artist').click(function()
    {
        $('#artist_subform').toggle();
    });
});
