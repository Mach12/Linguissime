import {getTokenHeader} from '../../vuex/getters'

export default Vue.extend({
    template: "@",
    ready: function () {
        this.$http.get((this.$store.state.serverURI + '/api/user/dashboard'),
            { '_username': this.email, '_password': this.password },
            { emulateJSON: true, headers: { 'Authorization': this.getTokenHeader } })
            .then(function (response) {
                console.log(response.data)
            }, function (response) {
                console.log(response.data)
            })
    },
    vuex: {
        getters: {
            getTokenHeader
        }
    }
})