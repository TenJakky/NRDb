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

    function successSpan(form)
    {
        form.find('input[type="button"]').after( $(span).delay(2000).fadeOut(800) );
    }

    function validateSubform(form, inputs)
    {
        var errors = [];
        for (var i = 0; i < inputs.length; i++)
        {
            if (!$(inputs[i]).val())
            {
                var error = {
                    message: "This field is required.",
                    element: inputs[i]
                };
                errors.push(error);
            }
        }

        if (errors.length)
        {
            Nette.showFormErrors(form, errors);
            return false;
        }

        return true;
    }

    $.nette.ext('snippets').after(function (el)
    {
        restoreValues();
        $(el).find('select').chosen(chosenOptions);
    });
    $.nette.init();

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

    $('input[name="submit_person"]').click(function()
    {
        var form = $('#person_subform form');
        var name = form.find('input[name="name"]');
        var surname = form.find('input[name="surname"]');
        var countryId = form.find('select[name="country_id"]');

        if (validateSubform(form, [name, surname, countryId]))
        {
            storeValues();

            $.nette.ajax(
            {
                url: addPersonLink,
                method: 'POST',
                data: {
                    name: name.val(),
                    surname: surname.val(),
                    country_id: countryId.val()
                },
                success: function (result)
                {
                    name.val('');
                    surname.val('');
                    countryId.val(0);
                    countryId.trigger('chosen:updated');
                    successSpan(form);
                }
            });
        }
    });

    $('input[name="submit_pseudonym"]').click(function()
    {
        var form = $('#pseudonym_subform form');
        var name = form.find('input[name="name"]');
        var personId = form.find('select[name="person_id"]');

        if (validateSubform(form, [name, personId]))
        {
            storeValues();

            $.nette.ajax(
            {
                url: addPseudonymLink,
                method: 'POST',
                data:
                {
                    name: name.val(),
                    person_id: personId.val()
                },
                success: function(result)
                {
                    name.val('');
                    personId.val(0);
                    personId.trigger('chosen:updated');
                    successSpan(form);
                }
            });
        }
    });

    $('input[name="submit_band"]').click(function()
    {
        var form = $('#band_subform form');
        var name = form.find('input[name="name"]');

        if (validateSubform(form, [name]))
        {
            storeValues();

            $.nette.ajax(
            {
                url: addBandLink,
                method: 'POST',
                data: {
                    name: name.val()
                },
                success: function (result)
                {
                    name.val('');
                    successSpan(form);
                }
            });
        }
    });
});
