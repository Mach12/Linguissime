export function isTokenValid(state) {
    return  state.token !== ""
         && state.token !== "null"
         && state.token !== null
}
export function getTokenHeader(state) {
    return 'Bearer ' + state.token
}
export function getSearchQuery(state) {
    return state.searchQuery
}