var amountOptions = {
    type: 'bar',
    data: {
        labels: ["Movie", "Series", "Season", "Book", "Music", "Game"],
        datasets: [{
            label: 'Number of elements',
            data: elementData,
            backgroundColor: chartBackgroundColors,
            borderColor: chartBorderColors,
            borderWidth: 1
        }]
    },
    options: {
        title: {
            text: 'Number of elements by type'
        }
    }
};
var distributionOptions = {
    type: 'line',
    data: {
        labels: ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10"],
        datasets: [{
            label: 'Number of ratings',
            data: null,
            backgroundColor: chartBackgroundColors,
            borderColor: chartBorderColors,
            borderWidth: 1
        }]
    },
    options: {
        title: {
            text: null
        }
    }
};

$(document).ready(function()
{
    var canvas = document.getElementById("elementCountChart");
    var chart = new Chart(canvas, amountOptions);

    $('#plotElement').click(function() {
        chart.destroy();
        amountOptions.data.datasets[0].data = elementData;
        amountOptions.options.title.text = 'Number of elements by type';
        chart = new Chart(canvas, amountOptions);
    });
    $('#plotRating').click(function() {
        chart.destroy();
        amountOptions.data.datasets[0].data = ratingData;
        amountOptions.options.title.text = 'Number of ratings by type';
        chart = new Chart(canvas, amountOptions);
    });
    $('.plotEntity').click(function() {
        chart.destroy();
        const eType = $(this).data('type');
        console.log(eType);
        distributionOptions.data.datasets[0].data = entityData[eType];
        distributionOptions.options.title.text = 'Distribution of ' + eType +' ratings';
        chart = new Chart(canvas, distributionOptions);
    });
});
