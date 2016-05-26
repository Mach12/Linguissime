import App from './App'
import VueRouter from 'vue-router'

/* eslint-disable no-new */
var router = new VueRouter()

router.map({
  '/': {
    component: App
  }
})

router.start(App, 'body')

export default router
