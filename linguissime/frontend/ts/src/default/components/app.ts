declare function require(name:string);
var bootstraploader = require('bootstrap-loader');

import router from '../router.config';
import navbar from './navbar/navbar';

var app = Vue.extend( {
    template: "@", //Means that the HTML is located at ./app.html
    components: {
        navbar
    }
});

//bootstrap the application using the router on the app component
router.start(app, "app");