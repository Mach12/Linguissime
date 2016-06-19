import {getTokenHeader} from '../../vuex/getters'

export default Vue.extend({
    template: "@",
    data: () => {
        return {
            success: false,
            failed: false,
            errorMessage: '',
            oldPasswd: '',
            newPasswd: '',
            confirmNewPasswd: '',
            working: false
        }
    },
    methods: {
        setError(message: string) {
            this.failed = true
            this.errorMessage = message
        },
        onSubmit() {
            if (this.newPasswd !== this.confirmNewPasswd)
                this.setError("Le nouveau mot de passe est différent de la confirmation")
            else {
                this.working = true
                this.$http.put((this.$store.state.serverURI + '/api/user/settings/password'),
                    { 'change_password[oldPassword]': this.oldPasswd, 'change_password[newPassword]': this.newPasswd },
                    { emulateJSON: true, headers: { 'Authorization': this.getTokenHeader } })
                    .then(function (response) {
                        this.oldPasswd = ''
                        this.newPasswd = ''
                        this.confirmNewPasswd = ''
                        this.working = false
                        this.failed = false
                        this.success = true
                    }, function (response) {
                        this.setError("Erreur " + response.status + ": " + response.data)
                        this.working = false
                    })
            }
        }
    },
    vuex: {
        getters: {
            getTokenHeader
        }
    }
})