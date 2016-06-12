export default Vue.extend({
    template: "@",
    data: function() {return {
        show: true,
        links: {
            "Login" : "login",
            "Register" : "register",
            "Exercise" : "exercise",
            "Dashboard" : "dashboard"
        }
    }}
})