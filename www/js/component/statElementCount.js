var elementChartOptions = {
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
var ratingChartOptions = {
    type: 'bar',
    data: {
        labels: ["Movie", "Series", "Season", "Book", "Music", "Game"],
        datasets: [{
            label: 'Number of ratings',
            data: ratingData,
            backgroundColor: chartBackgroundColors,
            borderColor: chartBorderColors,
            borderWidth: 1
        }]
    },
    options: {
        title: {
            text: 'Number of ratings for type'
        }
    }
};
var movieChartOptions = {
    type: 'line',
    data: {
        labels: ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10"],
        datasets: [{
            label: 'Number of ratings',
            data: movieData,
            backgroundColor: chartBackgroundColors,
            borderColor: chartBorderColors,
            borderWidth: 1
        }]
    },
    options: {
        title: {
            text: 'Distribution of movie ratings'
        }
    }
};
var seriesChartOptions = {
    type: 'line',
    data: {
        labels: ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10"],
        datasets: [{
            label: 'Number of ratings',
            data: seriesData,
            backgroundColor: chartBackgroundColors,
            borderColor: chartBorderColors,
            borderWidth: 1
        }]
    },
    options: {
        title: {
            text: 'Distribution of series ratings'
        }
    }
};
var seasonChartOptions = {
    type: 'line',
    data: {
        labels: ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10"],
        datasets: [{
            label: 'Number of ratings',
            data: seasonData,
            backgroundColor: chartBackgroundColors,
            borderColor: chartBorderColors,
            borderWidth: 1
        }]
    },
    options: {
        title: {
            text: 'Distribution of season ratings'
        }
    }
};
var bookChartOptions = {
    type: 'line',
    data: {
        labels: ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10"],
        datasets: [{
            label: 'Number of ratings',
            data: bookData,
            backgroundColor: chartBackgroundColors,
            borderColor: chartBorderColors,
            borderWidth: 1
        }]
    },
    options: {
        title: {
            text: 'Distribution of book ratings'
        }
    }
};
var musicChartOptions = {
    type: 'line',
    data: {
        labels: ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10"],
        datasets: [{
            label: 'Number of ratings',
            data: musicData,
            backgroundColor: chartBackgroundColors,
            borderColor: chartBorderColors,
            borderWidth: 1
        }]
    },
    options: {
        title: {
            text: 'Distribution of music ratings'
        }
    }
};
var gameChartOptions = {
    type: 'line',
    data: {
        labels: ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10"],
        datasets: [{
            label: 'Number of ratings',
            data: gameData,
            backgroundColor: chartBackgroundColors,
            borderColor: chartBorderColors,
            borderWidth: 1
        }]
    },
    options: {
        title: {
            text: 'Distribution of game ratings'
        }
    }
};

$(document).ready(function()
{
    var canvas = document.getElementById("elementCountChart");
    var chart = new Chart(canvas, elementChartOptions);

    $('#plotElement').click(function() {
        chart.destroy();
        chart = new Chart(canvas, elementChartOptions);
    });
    $('#plotRating').click(function() {
        chart.destroy();
        chart = new Chart(canvas, ratingChartOptions);
    });
    $('#plotMovie').click(function() {
        chart.destroy();
        chart = new Chart(canvas, movieChartOptions);
    });
    $('#plotSeries').click(function() {
        chart.destroy();
        chart = new Chart(canvas, seriesChartOptions);
    });
    $('#plotSeason').click(function() {
        chart.destroy();
        chart = new Chart(canvas, seasonChartOptions);
    });
    $('#plotBook').click(function() {
        chart.destroy();
        chart = new Chart(canvas, bookChartOptions);
    });
    $('#plotMusic').click(function() {
        chart.destroy();
        chart = new Chart(canvas, musicChartOptions);
    });
    $('#plotGame').click(function() {
        chart.destroy();
        chart = new Chart(canvas, gameChartOptions);
    });
});