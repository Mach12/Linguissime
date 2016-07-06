export default Vue.extend({
    template: "@",
    props: {
        questionData: {
            required: true,
            type: Object
        }
    },
    methods: {
        addSegment() {
            this.questionData.text.push("")
            this.questionData.blanks.push("")
        },
        removeSegment(index:number) {
            this.questionData.text.splice(index + 1, 1)
            this.questionData.blanks.splice(index, 1)
        }
    },
    beforeCompile: function() {
        this.questionData = {
            text: ["",""],
            blanks: [""]
        }
    }
})