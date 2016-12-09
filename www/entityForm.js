$(document).ready(function ()
{
    var formValues = [];

    $.nette.ext('snippets').after(function (el)
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

        $(el).find('select').chosen(chosenOptions);
    });

    $.nette.init();

    $('input[name="add_person"]').click(function()
    {
        $('#person_form').toggle();
    });

    $('input[name="submit_person"]').click(function()
    {
        var name = $('input[name="name"]');
        var surname = $('input[name="surname"]');
        var country_id = $('select[name="country_id"]');

        if (name.val() == 0)
        {
            alert("This field is required.");
            name.focus();
            return;
        }
        if (surname.val() == 0)
        {
            alert("This field is required.");
            surname.focus();
            return;
        }
        if (country_id.val() == 0)
        {
            alert("This field is required.");
            country_id.trigger('chosen:activate');
            return;
        }

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

        $.nette.ajax(
        {
            url: addPersonLink,
            method: 'POST',
            data:
            {
                name: name.val(),
                    surname: surname.val(),
                country_id: country_id.val()
            },
            success: function(result)
            {
                alert('Successfully submitted.');
                name.val('');
                surname.val('');
                country_id.val(0);
                country_id.trigger('chosen:updated');
            }
        });
    });
});