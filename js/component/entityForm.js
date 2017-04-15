$(document).ready(function ()
{
    var formValues = [];

    var formInputs =
        $('form')
        .filter(':first')
        .find('input, textarea, select')
        .not('input[type="button"], input[type="submit"], input[name="_do"]');

    function storeValues()
    {
        formInputs.each(function()
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
        formInputs.each(function()
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
        if ($(el).attr('id') === 'snippet-entityForm-formSnippet')
        {
            restoreValues();
            refreshPlugins(el);
            $('#artist_subform').hide();
            return;
        }

        if ($(el).attr('id') === 'snippet-entityForm-artistFormSnippet')
        {
            refreshPlugins(el);
        }
    });
    $.nette.ext('snippets').before(function (el)
    {
        if ($(el).attr('id') === 'snippet-entityForm-formSnippet')
        {
            storeValues();
            return;
        }
    });
    $.nette.load();

    $('#add_artist').click(function()
    {
        $('#artist_subform').toggle().find('form').trigger('reset');;
    });
});
