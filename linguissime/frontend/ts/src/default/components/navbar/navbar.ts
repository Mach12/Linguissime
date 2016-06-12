import connected    from './connected/connected'
import disconnected from './disconnected/disconnected'

export default Vue.extend({
    template: "@",
    name: "Navbar",
    components: {
        connected,
        disconnected
    }
});