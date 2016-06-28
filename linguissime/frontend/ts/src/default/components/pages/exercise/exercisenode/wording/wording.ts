export default Vue.extend({
    template: "@",
    props: {
        questionData: {
            required: true,
            type: Object
        }
    },
    computed: {
        allOptions: function () {
            var returnValue = this.questionData.badSentences.slice(0)
            returnValue.push(this.questionData.goodSentence)
            return returnValue
        },
        shuffledOptions: function () {
            var a = this.allOptions.slice(0)

            // Shuffling function from StackOverflow
            var j, x, i;
            for (i = a.length; i; i -= 1) {
                j = Math.floor(Math.random() * i);
                x = a[i - 1];
                a[i - 1] = a[j];
                a[j] = x;
            }
            
            return a
        }
    },
    methods: {
        checkWording(wording, index) {
            if (wording == this.questionData.goodSentence)
                this.$dispatch('finished-question')
            else {
                $("#option"+index)
                .css({borderColor: "red"})
                this.$dispatch('failed-question')
            }
        }
    }
})