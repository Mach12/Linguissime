import {getTokenHeader} from '../../vuex/getters'

export default Vue.extend({
    template: "@",
    data: function () {
        return {
            ready: false,
            data: {}
        }
    },
    computed: {
        username: function () {
            return this.data.name || this.data.userName || 'Anon'
        }
    },
    ready: function () {
        this.$http.get((this.$store.state.serverURI + '/api/user/dashboard'),
            { '_username': this.email, '_password': this.password },
            { emulateJSON: true, headers: { 'Authorization': this.getTokenHeader } })
            .then(function (response) {
                this.ready = true
                this.data = response.data
            }, function (response) {
                if (response.status = 401) {
                    this.$store.dispatch('INVALIDATE_TOKEN')
                    this.$router.go({ name: 'login' })
                }
                else alert("Erreur " + response.status + ' : ' + response.data)
            })
    },
    vuex: {
        getters: {
            getTokenHeader
        }
    }
})