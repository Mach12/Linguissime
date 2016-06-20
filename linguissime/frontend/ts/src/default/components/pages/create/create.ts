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
    methods: {
        addExercise() {
            this.exercises.push({type: this.typeToCreate, data: []})
        },
        removeExercise(index:number) {
            this.exercises.splice(index)
        },
        addQuestionToExercise(index:number) {
            this.exercises[index].data.push(<any>{})
        }
    },
    components: {
        exerciseNode
    }
})