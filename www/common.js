$(document).ready(function ()
{
    $('select').chosen(
        {
            disable_search_threshold: 12,
            no_results_text: "Oops, nothing found!",
            width: '50%'
        }
    );
});
