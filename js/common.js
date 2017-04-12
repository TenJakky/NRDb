const selectizeOptions =
{
    delimiter: ', ',
    create: false,
    plugins: ['clear_selection']
};

Chart.defaults.global.legend.display = false;
Chart.defaults.global.title.display = true;
const chartBackgroundColors =
[
    'rgba(255, 99, 132, 0.2)',
    'rgba(54, 162, 235, 0.2)',
    'rgba(255, 206, 86, 0.2)',
    'rgba(75, 192, 192, 0.2)',
    'rgba(153, 102, 255, 0.2)',
    'rgba(255, 159, 64, 0.2)'
];
const chartBorderColors =
[
    'rgba(255,99,132, 1)',
    'rgba(54, 162, 235, 1)',
    'rgba(255, 206, 86, 1)',
    'rgba(75, 192, 192, 1)',
    'rgba(153, 102, 255, 1)',
    'rgba(255, 159, 64, 1)'
];

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
    $('select').selectize(selectizeOptions);

    $.nette.ext('flash', {
        complete: function () {
            $('.flash').animate({
                opacity: 1.0
            }, 2000).fadeOut(1000);
        }
    });
    $.nette.init();
});
