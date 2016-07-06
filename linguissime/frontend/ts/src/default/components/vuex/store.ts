declare function require(name: string);
var Vuex = require('vuex')

const state = {
  serverURI: "api/web/app_dev.php",
  token: "",
  searchQuery: "",
  showSearch: false
}

const mutations = {
  SET_TOKEN(state, token) {
    state.token = token
  },
  INVALIDATE_TOKEN(state) {
    state.token = ""
  },
  SET_SEARCH_QUERY(state, query) {
    state.searchQuery = query
  },
  SET_SEARCH_SHOW(state, value) {
    state.showSearch = value
  }
}

export default new Vuex.Store({
  state,
  mutations
})
