<template>
    <div class="col-md-10">
        <div class="row">

            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ graphTitle }}</h4>

                        <canvas id="mainChart" ></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <br>
                <h4>Filters</h4>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <label class="filterLabel">Year: </label>
                    </div>
                    <select v-model="yearSelected">
                        <option v-for="option in years" v-bind:value="option.value">
                            {{ option.text }}
                        </option>
                    </select>
                </div>

                <br>
                <div class="row">
                    <div class="col-md-6">
                        <label class="filterLabel">Days on VRFI: </label>
                    </div>

                    <select v-model="daysOnVRFISelected">
                        <option v-for="option in daysOnVRFI" v-bind:value="option.value">
                            {{ option.text }}
                        </option>
                    </select>
                </div>

                <br>
                <div class="row">
                    <div class="col-md-6">
                        <label class="filterLabel">Chart Type: </label>
                    </div>

                    <select v-model="graphType">
                        <option v-for="option in graphTypes" v-bind:value="option.value">
                            {{ option.text }}
                        </option>
                    </select>
                </div>

                <br>
                <div class="row">
                    <div class="col-md-6">
                        <label class="filterLabel"></label>
                    </div>
                    <button class="btn btn-primary" v-on:click="applyFilters">Apply Filters</button>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
// If you can't inject this via router:
// const GraphService = require("../services/GraphService.js").default;

export default {
    data () {
        return {
            graphTitle: 'Days on VRFI for Applications',
            yearSelected: 'Last 12 months',
            years: [
                { text: 'Last 12 months', value: 'Last 12 months' },
                { text: '2019', value: '2019'}
            ],
            daysOnVRFISelected: '1|All',
            daysOnVRFI: [
                { text: 'All', value: '1|All'},
                { text: '1 - 10', value: '1|10'},
                { text: '11 - 15', value: '11|15'},
                { text: '16 - 20', value: '16|20'},
                { text: '21+', value: '21|All'},
            ],
            graphType: 'bar',
            graphTypes: [
                { text: 'Bar', value: 'bar'},
                { text: 'Line', value: 'line'},
            ],
            mainChart: null
        }
    },
    props: ["Axios", "Moment", "Chartjs", "GraphService"],
    mounted() {
        this.applyFilters()
    },
    methods: {
        loadGraph: function(graphData) {
            if (this.mainChart !== null) {
                this.mainChart.destroy();
            }

            this.graphTitle = graphData.title;
            let graphVals = this.GraphService.buildDataValues(graphData);

            var ctx = document.getElementById('mainChart').getContext('2d');
            let graphConfig = this.GraphService.setGraphConfig(this.graphType, graphVals);
            this.mainChart = new Chart(ctx, graphConfig);
        },

        applyFilters: function() {
            let url = this.GraphService.buildURL(this.yearSelected, this.daysOnVRFISelected, this.Moment());

            var self = this;
            self.Axios.get(url)
                .then(function (response) {
                    if (response.data.status === "ok") {
                        let result = JSON.parse(response.data.res);
                        // console.log("title: " + result.title);
                        self.loadGraph(result);
                        // console.log("Status: " + response.data.status);
                    }
                })
                .catch(function (error) {
                    console.log("Status error: " + error);
                });

        },

    }
}
</script>
