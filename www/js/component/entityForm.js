$(document).ready(function ()
{
    var formValues = [];
    var span = '<span class="form-success">Successfully Submitted</span>';

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
        $('#person_subform').hide();
        $('#pseudonym_subform').hide();
        $('#band_subform').hide();
    });
    $.nette.ext('snippets').before(function (el)
    {
        storeValues();
    });
    $.nette.load();

    $('#add_person').click(function()
    {
        $('#person_subform').toggle();
        $('#pseudonym_subform').hide();
        $('#band_subform').hide();
    });

    $('#add_pseudonym').click(function()
    {
        $('#person_subform').hide();
        $('#pseudonym_subform').toggle();
        $('#band_subform').hide();
    });

    $('#add_band').click(function()
    {
        $('#person_subform').hide();
        $('#pseudonym_subform').hide();
        $('#band_subform').toggle();
    });
});
