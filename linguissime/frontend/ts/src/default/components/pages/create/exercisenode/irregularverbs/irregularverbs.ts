export default Vue.extend({
    template: "@",
    props: {
        questionData: {
            required: true,
            type: Object
        }
    },
    beforeCompile: function() {
        this.questionData = {
            infinitive: "",
            simplePast: "",
            pastParticiple: ""
        }
    }
})