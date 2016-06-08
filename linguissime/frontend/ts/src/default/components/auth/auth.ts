export default Vue.extend({
    name: "AuthenticationManager",
    data: function() {return {
        token: ""
    }},
    methods: {
        connect: function(login:string, password:string) {
            // Imma need to setup vue-resource first
        }
    }
});