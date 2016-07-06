import connected        from './connected/connected'
import disconnected     from './disconnected/disconnected'
import searchBox        from './searchbox/searchbox'
import {isTokenValid}   from '../vuex/getters'

export default Vue.extend({
    template: "@",
    name: "Navbar",
    components: {
        connected,
        disconnected,
        searchBox
    },
    vuex: {
        getters: {
            isTokenValid
        }
    }
});