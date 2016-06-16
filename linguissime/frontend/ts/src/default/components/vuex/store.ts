declare function require(name: string);
var Vuex = require('vuex')

const state = {
  serverURI: "api/web/app_dev.php",
  token: ""
}

const mutations = {
  SET_TOKEN(state, token) {
    state.token = token
  },
  INVALIDATE_TOKEN(state) {
    state.token = ""
  }
}

export default new Vuex.Store({
  state,
  mutations
})
