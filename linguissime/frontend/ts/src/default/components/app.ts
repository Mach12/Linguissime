declare function require(name: string);
var bootstrap = require('bootstrap');
Vue.use(require('vue-resource'));

import router       from '../router.config';
import navbar       from './navbar/navbar';
import linklist     from './linklist/linklist'
import bottombar    from './bottombar/bottombar';
import exercise     from './pages/exercise/exercise';
import login        from './pages/login/login';

var app = Vue.extend({
    template: "@", //Means that the HTML is located at ./app.html
    name: "App",
    data: function () {
        return {
            token: ""
        }
    },
    components: {
        navbar,
        linklist,
        bottombar,
        exercise,
        login
    },
    computed: {
        isTokenValid: function () { return this.token !== "" },
    },
    methods: {
        toggleNavbar: function () {
            this.showNavbar = !this.showNavbar;
        },
        invalidateToken: function() { this.token = "" }
    }
});

//bootstrap the application using the router on the app component
router.start(app, "app");