import {getTokenHeader} from '../../vuex/getters'

export default Vue.extend({
    template: "@",
    data: function () {
        return {
            stats: [],
            loading: true
        }
    },
    methods: {
        colorFromScore(score:number) : string {
            if (score >= 30)
                return "green";
            else if (score >= 20)
                return "orange";
            else return "red";
        }
    },
    ready: function () {
        this.$http.get((this.$store.state.serverURI + '/api/user/stats'),
            {},
            { emulateJSON: false, headers: { 'Authorization': this.getTokenHeader } })
            .then(function (response) {
                this.loading = false
                this.stats = response.data
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