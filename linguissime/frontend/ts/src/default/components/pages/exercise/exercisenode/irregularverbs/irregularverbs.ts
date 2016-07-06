export default Vue.extend({
    template: "@",
    data: function () {
        return {
            SPInput: "",
            PPInput: "",
            SPResultCache: false,
            PPResultCache: false,
            showResults: false
        }
    },
    props: {
        questionData: {
            required: true,
            type: Object
        }
    },
    computed: {
        clear: function () {
            return (this.SPInput == this.questionData.simplePast
                && this.PPInput == this.questionData.pastParticiple)
        }
    },
    methods: {
        onSubmit() {
            if (this.clear) this.$dispatch('finished-question')
            else {
                this.SPResultCache = (this.SPInput == this.questionData.simplePast)
                this.PPResultCache = (this.PPInput == this.questionData.pastParticiple)
                this.showResults = true
                this.$dispatch('failed-question')
            }
        }
    },
    watch: {
        'SPInput': function (oldVal, newVal) {
            this.showResults = false
        },
        'PPInput': function (oldVal, newVal) {
            this.showResults = false
        }
    }
})