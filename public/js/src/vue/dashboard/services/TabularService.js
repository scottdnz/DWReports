const TabularService = function() {

    this.buildURL = function(monthSelected)
    {
        let splitVal = monthSelected.split("|");
        let from = splitVal[0];
        let to = splitVal[1];
        let url = "/dashboard/table?date_from=" + from + "&date_to=" + to;

        console.log("url: " + url);
        return url;
    }

};

export default new TabularService();
