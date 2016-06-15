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
            this.$http.post('/api/web/app_dev.php/register',
            {'register[email]': this.email, 'register[username]': this.username, 'register[plainPassword]': this.password},
            {emulateJSON: true})
            .then(function(response){
                console.log(response)
            },function(response){
                console.log(response)
            })
        }
    }
})