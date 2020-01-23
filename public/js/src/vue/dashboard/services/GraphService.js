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
    }
};

export default new GraphService();

// module.exports.default = new GraphService();

