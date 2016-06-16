import connected        from './connected/connected'
import disconnected     from './disconnected/disconnected'
import {isTokenValid}   from '../vuex/getters'

export default Vue.extend({
    template: "@",
    name: "Navbar",
    components: {
        connected,
        disconnected
    },
    vuex: {
        getters: {
            isTokenValid
        }
    }
});