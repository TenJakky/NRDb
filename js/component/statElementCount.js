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
    $('#plotMovie').click(function() {
        chart.destroy();
        distributionOptions.data.datasets[0].data = movieData;
        distributionOptions.options.title.text = 'Distribution of movie ratings';
        chart = new Chart(canvas, distributionOptions);
    });
    $('#plotSeries').click(function() {
        chart.destroy();
        distributionOptions.data.datasets[0].data = seriesData;
        distributionOptions.options.title.text = 'Distribution of series ratings';
        chart = new Chart(canvas, distributionOptions);
    });
    $('#plotSeason').click(function() {
        chart.destroy();
        distributionOptions.data.datasets[0].data = seasonData;
        distributionOptions.options.title.text = 'Distribution of season ratings';
        chart = new Chart(canvas, distributionOptions);
    });
    $('#plotBook').click(function() {
        chart.destroy();
        distributionOptions.data.datasets[0].data = bookData;
        distributionOptions.options.title.text = 'Distribution of book ratings';
        chart = new Chart(canvas, distributionOptions);
    });
    $('#plotMusic').click(function() {
        chart.destroy();
        distributionOptions.data.datasets[0].data = musicData;
        distributionOptions.options.title.text = 'Distribution of music ratings';
        chart = new Chart(canvas, distributionOptions);
    });
    $('#plotGame').click(function() {
        chart.destroy();
        distributionOptions.data.datasets[0].data = gameData;
        distributionOptions.options.title.text = 'Distribution of game ratings';
        chart = new Chart(canvas, distributionOptions);
    });
});