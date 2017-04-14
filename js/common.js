const selectizeOptions =
{
    delimiter: ', ',
    create: false,
    persist: false,
    preload: true,
    plugins: ['clear_selection']
};
const icheckOptions =
{
    checkboxClass: 'icheckbox_square-red',
    radioClass: 'iradio_square-red'
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
            $(elem).parent().find('input[type="text"]').trigger('click');
            return;
        }
        $(elem).focus();
    }
};

function debounce(func, wait, immediate) {
    var timeout;
    return function () {
        var context = this, args = arguments;
        var later = function () {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
}

function getCountryCode(code)
{
    switch(code)
    {
        case 'cs': return 'cz';
        case 'en': return 'gb';
        default: return code;
    }
}

$(document).ready(function ()
{
    $.nette.ext('flash', {
        complete: function () {
            $('.flash').animate({
                opacity: 1.0
            }, 2000).fadeOut(1000);
        }
    });
    $.nette.init();

    var radio = $('input[type="radio"]:not(.rating)');

    radio.iCheck(icheckOptions);
    radio.on('ifChanged', function (event) {

        event = document.createEvent('HTMLEvents');
        event.initEvent('change', true, true);
        event.eventName = 'change';

        this.dispatchEvent(event);
    });

    var searchInput = $('#searchInput');

    searchInput.keyup(
        debounce(function()
        {
            var value = $(this).val();

            $.nette.ajax(
            {
                traditional: true,
                url: searchUrl,
                method: 'GET',
                data:
                {
                    search: value
                }
            });
        }, 300));

    var langInput = $('#langInput');

    $('select:not(#langInput)').selectize(selectizeOptions);
    langInput.selectize({
        labelField: 'name',
        valueField: 'code',
        render: {
            item: function(item, escape) {
                return '<div><span class="flag-icon flag-icon-' + escape(getCountryCode(item.code)) + '"></span>&nbsp;' + escape(item.name) + '</div>';
            },
            option: function(item, escape) {
                return '<div><span class="flag-icon flag-icon-' + escape(getCountryCode(item.code)) + '"></span>&nbsp;' + escape(item.name) + '</div>';
            }
        },
    });

    langInput.change(function()
    {
        var array = window.location.pathname.split('/');
        array[1] = this.value;
        window.location.href = array.join('/');
    });
});
