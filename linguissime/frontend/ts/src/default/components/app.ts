declare function require(name: string);
var bootstrap = require('bootstrap');
Vue.use(require('vue-resource'));

import store        from './vuex/store'

import router       from '../router.config';
import navbar       from './navbar/navbar';
import linklist     from './linklist/linklist';
import search       from './search/search';
import bottombar    from './bottombar/bottombar';

var app = Vue.extend({
    template: "@", //Means that the HTML is located at ./app.html
    name: "App",
    data: function () {
        return {
        }
    },
    components: {
        navbar,
        linklist,
        bottombar,
        search
    },
    computed: {
    },
    methods: {
        toggleNavbar: function () {
            this.showNavbar = !this.showNavbar;
        }
    },
    store
});

//bootstrap the application using the router on the app component
router.start(app, "app");