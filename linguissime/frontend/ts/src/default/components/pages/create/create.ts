import {difficulty as difficultyScale, exerciseTypes as types} from '../../../utilities/util'
import exerciseNode from './exercisenode/exercisenode'

export default Vue.extend({
    template: "@",
    data: () => {
        return {
            name: "",
            description: "",
            difficulty: 0,
            length: 1,
            exercises: [],
            typeToCreate: 1,
            difficultyScale,
            types
        }
    },
    computed: {
        JSONDump () {
            return {
                name: this.name,
                description: this.description,
                difficulty: this.difficulty,
                length: this.length,
                exercises: this.exercises
            }
        }
    },
    methods: {
        addExercise() {
            this.exercises.push({type: this.typeToCreate, data: []})
        },
        removeExercise(index:number) {
            this.exercises.splice(index, 1)
        },
        addQuestionToExercise(index:number) {
            this.exercises[index].data.push(<any>{})
        },
        removeQuestionFromExercise(eindex:number, qindex:number) {
            this.exercises[eindex].data.splice(qindex, 1)
        }
    },
    components: {
        exerciseNode
    }
})