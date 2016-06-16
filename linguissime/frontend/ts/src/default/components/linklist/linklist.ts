export default Vue.extend({
    template: "@",
    data: function() {return {
        show: false,
        links: {
            "Login" : "login",
            "Register" : "register",
            "Exercise" : "exercise",
            "Dashboard" : "dashboard",
            "Stats" : "statistics",
            "Badge list" : "badges",
            "Change password" : "changepassword",
            "Profile" : "profile"
        }
    }}
})