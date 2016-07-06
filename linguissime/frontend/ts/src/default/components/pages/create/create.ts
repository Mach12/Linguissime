import {difficulty as difficultyScale, exerciseTypes as types} from '../../../utilities/util'
import exerciseNode from './exercisenode/exercisenode'

import {getTokenHeader} from '../../vuex/getters'

export default Vue.extend({
    template: "@",
    data: () => {
        return {
            name: "",
            description: "",
            difficulty: 0,
            duration: 1,
            exercises: [],
            typeToCreate: 1,
            difficultyScale,
            types,
            sending: false,
            failed: false,
            showMessage: false,
            message: "",
            showDump: false
        }
    },
    computed: {
        JSONDump() {
            return {
                name: this.name,
                description: this.description,
                difficulty: this.difficulty,
                duration: this.duration,
                exercises: this.exercises
            }
        }
    },
    methods: {
        addExercise() {
            this.exercises.push({ type: this.typeToCreate, data: [] })
        },
        removeExercise(index: number) {
            this.exercises.splice(index, 1)
        },
        addQuestionToExercise(index: number) {
            this.exercises[index].data.push(<any>{})
        },
        removeQuestionFromExercise(eindex: number, qindex: number) {
            this.exercises[eindex].data.splice(qindex, 1)
        },
        submit() {
            this.sending = true
            this.$http.post((this.$store.state.serverURI + '/api/user/settings/exercise'),
                this.JSONDump,
                { emulateJSON: false, headers: { 'Authorization': this.getTokenHeader } })
                .then(function (response) {
                    this.sending = false
                    this.$router.go("/")
                }, function (response) {
                    this.sending = false
                    if (response.status == 401) {
                        this.$store.dispatch('INVALIDATE_TOKEN')
                        this.$router.go({ name: 'login' })
                        this.showMessage = true
                        this.failed = true
                        this.message = "Exercice créé avec succès!"
                    }
                    else {
                        this.failed = true
                        this.showMessage = true
                        this.message = "Erreur " + response.status + ' : ' + JSON.stringify(response.data)
                    }
                })
        }
    },
    watch: {
        'duration': function(old, newValue) {
            var theValue:number = parseFloat(old)
            if (theValue < 1 || isNaN(theValue))
                this.duration = 1
        }
    },
    components: {
        exerciseNode
    },
    vuex: {
        getters: {
            getTokenHeader
        }
    }
})