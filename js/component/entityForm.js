$(document).ready(function ()
{
    var formValues = [];

    function storeValues()
    {
        var form = $('main form').filter(':first');

        form.find('input[type="text"], textarea, select')
            .not('input[name="_do"]')
            .each(function()
        {
            if ($(this).parent().hasClass('selectize-input'))
            {
                return;
            }
            formValues.push($(this).val());
        });
    }

    function restoreValues()
    {
        var index = 0;
        var form = $('main form').filter(':first');

        form.find('input[type="text"], textarea, select')
            .not('input[name="_do"]')
            .each(function()
        {
            if ($(this).parent().hasClass('selectize-input'))
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
            $.magnificPopup.close();
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
        }
    });
    $.nette.load();

    $('#add_artist').magnificPopup({items: { src:'#artistSubform'}});
});
