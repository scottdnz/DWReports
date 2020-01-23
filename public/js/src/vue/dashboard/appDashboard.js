const Vue = require('vue/dist/vue.js');
const Axios = require("axios/dist/axios.js");
const VueRouter = require("vue-router/dist/vue-router.js");
const Moment = require("moment/min/moment.min.js");
const Chartjs = require('chart.js/dist/Chart.min.js');
const GraphService = require("./services/GraphService.js").default;
Vue.use(VueRouter);

// Define route components.
const graphBarTemplate = require("./components/graphBar.vue").default; // note default!
// const surveyListTemplate = require("./components/list.vue").default;

// Define some routes. Each map to a component
const routes = [
    { path: '/graph-bar',
        component: graphBarTemplate,
        props: (route) => ({Axios: Axios, //pass Axios as a property to the child component (template)
            Moment: Moment,
            Chartjs: Chartjs,
            // GraphService: GraphService
        })
    },
    // { path: '/survey-list',
    //     component: surveyListTemplate,
    //     props: {Axios: Axios, //pass Axios as a property to the child component (template)
    //         // AdderService: AdderService
    //     }
    // },
    { path: '*', redirect: '/graph-bar' } // set a default route to display
];

const router = new VueRouter({
    routes // short for `routes: routes`
})

// Create and mount the root instance.
const app = new Vue({
    router
}).$mount('#appDashboard');

