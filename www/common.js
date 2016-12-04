var chosenOptions =
{
    disable_search_threshold: 12,
    no_results_text: "Oops, nothing found!",
    width: '50%'
};

$(document).ready(function ()
{
    $('select').chosen(chosenOptions);
});
