export default Vue.extend({
    template: "@",
    name: "Login",
    data: function() {return {
        email: "",
        password: "",
        remember: false
    }},
    methods: {
        onSubmit: function() {
            console.log("Do the login thing here.")
        }
    }
});