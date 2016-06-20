export default Vue.extend({
    template: "@",
    props: ['questionData'],
    methods: {
        addBadTranslation() {
            this.questionData.badTranslations.push("")
        },
        removeBadTranslation(index:number) {
            this.questionData.badTranslations.splice(index)
        }
    },
    ready: () => {
        this.questionData.text = ""
        this.questionData.goodTranslation = ""
        this.questionData.badTranslations = []
    }
})