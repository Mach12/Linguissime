import {getTokenHeader} from '../../vuex/getters'

export default Vue.extend({
    template: "@",
    data: function () {
        return {
            badgeData: [],
            loading: true
        }
    },
    ready: function () {
        this.$http.get((this.$store.state.serverURI + '/api/user/badges'),
            {},
            { emulateJSON: false, headers: { 'Authorization': this.getTokenHeader } })
            .then(function (response) {
                this.loading = false
                this.badgeData = response.data
            }, function (response) {
                if (response.status == 401) {
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