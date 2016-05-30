import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

require('bootstrap-loader')

import App from './App'
import Hello from './components/Hello'
import Empty from './components/Empty'
import Navbar from './components/Navbar'

/* eslint-disable no-new */
new Vue({
  el: 'body',
  components: {
    Navbar
  }
})

/* eslint-disable no-new */
var router = new VueRouter()

router.map({
  '/': {
    component: App
  },
  '/hello': {
    component: Hello
  }
})

router.start(Empty, 'body')
