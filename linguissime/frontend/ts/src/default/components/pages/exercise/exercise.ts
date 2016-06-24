import {getTokenHeader} from '../../vuex/getters'

export default Vue.extend({
    template: "@",
    name: "ExerciseDisplay",
    data: function () {
        return {
            exerciseData: {},
            loaded: false
        }
    },
    ready: function () {
        this.$http.get((this.$store.state.serverURI + '/api/exercise/' + this.$route.params.slug),
            {},
            { emulateJSON: false, headers: { 'Authorization': this.getTokenHeader } })
            .then(function (response) {
                this.exerciseData = response.data[0]
                this.loaded = true
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