export default Vue.extend({
    template: "@",
    name: "Register",
    data: function () {
        return {
            username: "",
            email: "",
            password: "",
            failed: false,
            errorMessage: "",
            trying: false
        }
    },
    methods: {
        onSubmit: function () {
            this.trying = true

            this.$http.post((this.$store.state.serverURI + '/register'),
                { 'register[email]': this.email, 'register[username]': this.username, 'register[plainPassword]': this.password },
                { emulateJSON: true })
                .then(function (response) {
                    this.$router.go({ name: 'login' })
                    this.trying = false
                }, function (response) {
                    this.failed = true
                    this.errorMessage = "Erreur: " + response.data
                    this.trying = false
                })
        }
    }
})