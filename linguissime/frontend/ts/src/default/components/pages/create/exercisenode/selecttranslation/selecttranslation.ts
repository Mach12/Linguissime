export default Vue.extend({
    template: "@",
    props: {
        questionData: {
            required: true,
            type: Object
        }
    },
    methods: {
        addBadTranslation() {
            this.questionData.badTranslations.push("")
        },
        removeBadTranslation(index:number) {
            this.questionData.badTranslations.splice(index,1)
        }
    },
    ready: function() {
        this.questionData = {
            text: "",
            goodTranslation: "",
            badTranslations: [""]
        }
    }
})