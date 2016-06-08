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
            console.log("Do the register thing here.")
        }
    }
})