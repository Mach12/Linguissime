export default Vue.extend({
    template: "@",
    props: {
        questionData: {
            required: true,
            type: Object
        }
    },
    methods: {
        addBadSentence() {
            this.questionData.badSentences.push("")
        },
        removeBadSentence(index:number) {
            this.questionData.badSentences.splice(index,1)
        }
    },
    ready: function() {
        this.questionData = {
            goodSentence: "",
            badSentences: [""]
        }
    }
})