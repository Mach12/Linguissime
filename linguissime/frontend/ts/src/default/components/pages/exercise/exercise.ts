import {difficulty, exerciseTypes as types} from '../../../utilities/util'
import exerciseNode from './exercisenode/exercisenode'

import {getTokenHeader} from '../../vuex/getters'

export default Vue.extend({
    template: "@",
    name: "ExerciseDisplay",
    data: function () {
        return {
            exerciseData: {},
            loaded: false,
            failed: false,
            errorMessage: "",
            currentEIndex: 0,
            currentQIndex: 0,
            score: 0,
            failedCurrentQuestion: false,
            displayScore: false,
            showDumps: false
        }
    },
    computed: {
        difficulty() {
            return difficulty[this.exerciseData.difficulty]
        },
        currentExercise() {
            return this.exerciseData.exercises[this.currentEIndex]
        },
        currentQuestion() {
            return (this.endReached ? null : this.currentExercise.data[this.currentQIndex])
        },
        endReached() {
            return (this.loaded?this.currentEIndex >= this.exerciseData.exercises.length:false)
        }
    },
    methods: {
        next() {
            this.currentQIndex += 1
            while (!this.endReached && this.currentQIndex >= this.currentExercise.data.length) {
                this.currentQIndex = 0
                this.currentEIndex += 1
            }

            if (this.failedCurrentQuestion == true)
                this.score += 0.5
            else this.score += 1

            this.failedCurrentQuestion = false

            if (this.endReached) this.done()
        },
        done() {
            this.$http.put((this.$store.state.serverURI + '/api/user/settings/stats'),
                { 'name': this.exerciseData.name, 'points': this.score },
                { emulateJSON: true, headers: { 'Authorization': this.getTokenHeader } })
                .then(function (response) {
                    this.displayScore = true
                    setTimeout(function () {
                        this.$router.go('/')
                    }.bind(this), 5000)
                }, function (response) {
                    if (response.status == 401) {
                        this.$store.dispatch('INVALIDATE_TOKEN')
                        this.$router.go({ name: 'login' })
                    }
                    else {
                        this.failed = true
                        this.errorMessage = "Erreur " + response.status + " : " + response.data
                        setTimeout(function () {
                            this.$router.go('/')
                        }.bind(this), 5000)
                    }
                })
        }
    },
    events: {
        'failed-question': function () { this.failedCurrentQuestion = true },
        'finished-question': function () { this.next() }
    },
    ready: function () {
        this.$http.get((this.$store.state.serverURI + '/api/exercise/' + this.$route.params.slug),
            {},
            { emulateJSON: false, headers: { 'Authorization': this.getTokenHeader } })
            .then(function (response) {
                this.exerciseData = response.data[0].data
                this.loaded = true
            }, function (response) {
                if (response.status == 401) {
                    this.$store.dispatch('INVALIDATE_TOKEN')
                    this.$router.go({ name: 'login' })
                }
                else {
                    this.failed = true
                    this.errorMessage = "Erreur " + response.status + " : " + response.data
                    setTimeout(function () {
                        this.$router.go('/')
                    }.bind(this), 5000)
                }
            })
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