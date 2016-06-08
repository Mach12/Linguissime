export default Vue.extend({
    template: "@",
    name: "Register",
    data: function () {
        return {
            username: "",
            email: "",
            password: ""
        }
    },
    methods: {
        onSubmit: function() {
            Vue.http.post("api/web/app_dev.php/register", {email: this.email, username: this.username, plainPassword: this.password})
            .then(function(response) {
                alert("Woot! Data obtained: " + response.data)
            }, function(response) {
                alert("Something went wrong: " + response.data)
            });
        }
    }
})