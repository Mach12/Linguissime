import {isTokenValid} from '../../vuex/getters'
import {difficulty as difficultyScale} from '../../../utilities/util'

export default Vue.extend({
    template: "@",
    props: {
        hitData: {
            required: true
        }
    },
    data: function () {
        return {
            difficultyScale
        }
    },
    computed: {
        textDifficulty: function() {
            return this.difficultyScale[this.hitData.difficulty] || 'de difficulté inconnue'
        }
    },
    methods: {
        onClick() {
            if (this.isTokenValid) {
                this.$router.go("/exercise/" + this.hitData.slug)
                this.$store.dispatch('SET_SEARCH_QUERY', "")
                this.$store.dispatch('SET_SEARCH_SHOW', false)
            }
            else alert("Connectez-vous pour accéder aux exercices!")
        }
    },
    vuex: {
        getters: {
            isTokenValid
        }
    }
})