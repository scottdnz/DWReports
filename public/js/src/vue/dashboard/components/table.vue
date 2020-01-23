<template>
    <div class="col-md-10">
        <div class="row">

            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ tableTitle }}</h4>
                        <br>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th v-for="col in tableColumns">{{ col }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="row in tableRows">
                                    <td v-for="col in tableColumns">{{ row[col] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <br>
                <h4>Filters</h4>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <label class="filterLabel">Month: </label>
                    </div>
                    <select v-model="monthSelected">
                        <option v-for="option in months" v-bind:value="option.value">
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
    export default {
        data() {
            return {
                tableTitle: 'Days on VRFI for Applications',
                tableColumns: [
                    "CreationDate",
                    "JID",
                    "SiteAddress",
                    "EstimatedValue",
                    "DaysOnRFI"
                ],
                tableRows: [],
                // the values in here need to come from an algorithm using the Moment endOf function.
                // This is just test data
                monthSelected: '2019-02-01 00:00:00|2020-01-31 23:59:59',
                months: [
                    {text: 'All for Last 12 Months', value: '2019-02-01 00:00:00|2020-01-31 23:59:59'},
                    {text: 'January 2020', value: '2020-01-01 00:00:00|2020-01-31 23:59:59'},
                    {text: 'February 2019', value: '2019-02-01 00:00:00|2019-02-28 23:59:59'},
                    {text: 'March 2019', value: 'March'},
                    {text: 'April 2019', value: 'April'},
                    {text: 'May 2019', value: 'May'},
                    {text: 'June 2019', value: 'June'},
                    {text: 'July 2019', value: 'July'},
                    {text: 'August 2019', value: 'August'},
                    {text: 'September 2019', value: 'September'},
                    {text: 'October 2019', value: 'October'},
                    {text: 'November 2019', value: '2019-11-01 00:00:00|2019-11-30 23:59:59'},
                    {text: 'December 2019', value: '2019-12-01 00:00:00|2021-12-31 23:59:59'},
                ],
            }
        },
        mounted() {
            this.applyFilters()
        },
        props: ["Axios", "Moment", "TabularService"],
        methods: {
            loadTable: function(tblData) {
                this.tableRows = tblData.rows;
            },

            applyFilters: function() {
                let url  =this.TabularService.buildURL(this.monthSelected);
                var self = this;
                self.Axios.get(url)
                    .then(function (response) {
                        if (response.data.status === "ok") {
                            let result = JSON.parse(response.data.res);
                            self.loadTable(result);
                        }
                    })
                    .catch(function (error) {
                        console.log("Status error: " + error);
                    });

            }
        }
    }
</script>