$(document).ready(function()
{
    var canvas = document.getElementById("userRadarChart");
    var chart = new Chart(canvas, {
        type: 'radar',
        data: {
            labels: ["Movie", "Series", "Season", "Book", "Music", "Game"],
            datasets: [{
                label: 'Number of elements',
                data: percentData,
                backgroundColor: chartBackgroundColors,
                borderColor: chartBorderColors,
                borderWidth: 1
            }]
        },
        options: {
            scale: {
                ticks: {
                    beginAtZero: true,
                    suggestedMax: 1
                }
            },
            tooltips: {
                callbacks: {
                    label: function (label, data)
                    {
                        var text = 'User has rated '+statData[label.index]+' '+data.labels[label.index]+'  elements, ';
                        if (label.yLabel === 1)
                        {
                            return text + 'he is currently the best user in this category.';
                        }
                        else
                        {
                            return text + 'that is ' + label.yLabel * 100 + '% of ratings by the best user.';
                        }
                    }
                }
            }
        }
    });
});
