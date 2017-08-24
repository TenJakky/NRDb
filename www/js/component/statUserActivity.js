$(document).ready(function()
{
    var canvas = document.getElementById("userActivityChart");
    var chart = new Chart(canvas, {
        type: 'radar',
        data: {
            labels: ["Movie", "Series", "Season", "Book", "Music", "Game"],
            datasets: datasetData
        },
        options: {
            legend: {
                display: true
            },
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
                        var text = 'User '+data.datasets[label.datasetIndex].label+' has rated '+statData[label.datasetIndex][label.index]+' '+data.labels[label.index]+' elements, ';
                        if (label.yLabel === 1)
                        {
                            return text + 'he is currently the best user in this category.';
                        }
                        else
                        {
                            return text + 'that is ' + label.yLabel * 100 + '% of ratings by the best user.';
                        }
                    },
                    title: function(title, data)
                    {
                        return data.labels[title[0].index]+' - '+data.datasets[title[0].datasetIndex].label;
                    }
                }
            }
        }
    });
});
