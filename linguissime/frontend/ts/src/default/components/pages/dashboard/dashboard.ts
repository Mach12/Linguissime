import {getTokenHeader} from '../../vuex/getters'

export default Vue.extend({
    template: "@",
    data: function () {
        return {
            ready: false,
            data: {},
            emailOutput: "",
            emailSuccess: true,
            inviteMail: ""
        }
    },
    computed: {
        username: function () {
            return this.data.name || this.data.userName || 'Anon'
        }
    },
    methods: {
        sendMail() {
            this.$http.post((this.$store.state.serverURI + '/api/invitation'),
                { 'email': this.inviteMail },
                { emulateJSON: true, headers: { 'Authorization': this.getTokenHeader } })
                .then(function (response) {
                    this.emailSuccess = true
                    this.emailOutput = response.data
                }, function (response) {
                    if (response.status == 401) {
                        this.$store.dispatch('INVALIDATE_TOKEN')
                        this.$router.go({ name: 'login' })
                    }
                    else {
                        this.emailSuccess = false
                        this.emailOutput = response.data
                    }
                })
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