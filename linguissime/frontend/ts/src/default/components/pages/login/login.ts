export default Vue.extend({
    template: "@",
    name: "Login",
    data: function () {
        return {
            email: "",
            password: "",
            remember: false,
            failed: false,
            errorMessage: "",
            trying: false
        }
    },
    methods: {
        onSubmit: function () {
            this.trying = true

            this.$http.post((this.$store.state.serverURI + '/api/login_check'),
                { '_username': this.email, '_password': this.password },
                { emulateJSON: true })
                .then(function (response) {
                    this.$router.go({ name: 'dashboard' })
                    this.$store.dispatch('SET_TOKEN', response.data.token)
                    this.trying = false
                }, function (response) {
                    this.failed = true
                    this.errorMessage = "Erreur " + response.status + ": " + response.data
                    this.trying = false
                })
        }
    }
});