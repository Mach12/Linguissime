declare function require(name:string);
var bootstrap = require('bootstrap');
Vue.use(require('vue-resource'));

import router   from '../router.config';
import navbar   from './navbar/navbar';
import exercise from './exercise/exercise';
import login    from './login/login';

var app = Vue.extend( {
    template: "@", //Means that the HTML is located at ./app.html
    name: "App",
    data: function(){return {
        showNavbar: true
    }},
    components: {
        navbar,
        exercise,
        login
    },
    methods: {
        toggleNavbar: function(){
            this.showNavbar = !this.showNavbar;
        }
    }
});

//bootstrap the application using the router on the app component
router.start(app, "app");