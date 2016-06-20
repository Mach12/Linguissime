export default Vue.extend({
    template: "@",
    data: function () {
        return {
            show: false,
            links: {
                "Login": "login",
                "Register": "register",
                "Exercise": "exercise",
                "Dashboard": "dashboard",
                "Stats": "statistics",
                "Badge list": "badges",
                "Change password": "changepassword",
                "Profile": "profile",
                "Create exercise": "create"
            }
        }
    },
    methods: {
        disconnect() {
            this.$store.dispatch('INVALIDATE_TOKEN')
            this.$router.go('/login')
        }
    }
})