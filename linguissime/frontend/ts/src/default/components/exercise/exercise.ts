export default Vue.extend({
    template: "@",
    name: "ExerciseDisplay",
    data: function () {
        return {
            exerciseData: {}
        }
    },
    ready: function () {
        console.log("Cannot fetch exercise data: query not ready.")
    }
})