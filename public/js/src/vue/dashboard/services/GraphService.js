 const GraphService = function() {

    this.buildDataValues = function(graphData)
    {
        let colours = {
            red: 'rgba(255, 99, 132, 0.2)',
            blue: 'rgba(54, 162, 235, 0.2)'
        };

        let dataValues = [];
        let xLabels = [];
        let graphColours = [];
        for (let i = 0; i < graphData["periods"].length; i++) {
            dataValues.push(graphData["periods"][i]["value"]);
            xLabels.push(graphData["periods"][i]["period"]);
            if (i % 2 === 0) {
                graphColours.push(colours.red);
            } else {
                graphColours.push(colours.blue);
            }
        }
        return {
            dataValues: dataValues,
            xLabels: xLabels,
            graphColours: graphColours
        };
    },

    this.buildURL = function(yearSelected, daysOnVRFISelected, nowMoment) {
        let yearNum = yearSelected;
        let from = yearNum + "-01-01 00:00:00";
        let to = yearNum + "-12-31 23:59:59";

        if (yearSelected === "Last 12 months") {
            // This would be the normal case
            let yearAgo = nowMoment.subtract(1, "years");
            yearNum = yearAgo.format('YYYY');
            from = yearNum + "-01-01 00:00:00";
            to = yearNum + "-12-31 23:59:59";

            // This is just for testing
            from = "2019-02-01 00:00:00";
            to = "2020-01-31 23:59:59";
        }

        let url = "/dashboard/graph?date_from=" + from + "&date_to=" + to + "&daysOnVRFISelected=" + daysOnVRFISelected;
        return url;
    }

    this.setGraphConfig = function(graphType, graphVals) {
        return {
            type: graphType, // bar or line
            data: {
                labels: graphVals.xLabels,
                datasets: [{
                    label: 'Days',
                    data: graphVals.dataValues,
                    backgroundColor: graphVals.graphColours,
                    borderColor: graphVals.graphColours,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        }
    }
};

export default new GraphService();

// module.exports.default = new GraphService();

