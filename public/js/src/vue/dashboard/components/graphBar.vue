<template>
    <div>
        <div id="app-graph-bar">
            <h2>Bar graph!</h2>

        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                msgSubmitStatus: "",
                iptName2: "",
                iptCreated: this.Moment().format('DD/MM/YYYY hh:mma')
            }
        },
        props: ["Axios", "Moment", "Chartjs"], //, "AdderService"],
        methods: {
        //     newSurveyFormSubmit: function() {
        //         let reqData = {
        //             title: this.iptName,
        //
        //         };
        //
        //         let url = "survey/insert";
        //         var self = this;
        //         self.Axios.post(url, reqData)
        //             .then(function (response) {
        //                 // alert(response.data);
        //                 self.msgSubmitStatus = "Status: " + response.data.status;
        //             })
        //             .catch(function (error) {
        //                 self.msgSubmitStatus = "Status error: " + error;
        //             });
        //
        //     }
        }
    }
</script>
