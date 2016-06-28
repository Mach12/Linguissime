export default Vue.extend({
    template: "@",
    data: function () {
        return {
            inputs: [],
            answerCache: [],
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
        allClear: function () {
            for (var i = 0; i < this.inputs.length; ++i) {
                var value = this.inputs[i]
                var valid = this.checkInput(i)
                if (valid === false) return false;
            }

            return true;
        }
    },
    methods: {
        checkInput(index: number) {
            var returnValue = <boolean>(this.inputs[index] === this.questionData.blanks[index])
            return returnValue
        },
        onSubmit() {
            var clear = this.allClear
            if (clear) this.$dispatch('finished-question')
            else {
                for (var i = 0; i < this.inputs.length; ++i)
                    this.answerCache[i] = this.checkInput(i)
                this.showResults = true
                this.$dispatch('failed-question')
            }
        }
    },
    watch: {
        'inputs': function(oldVal, newVal) {
            this.showResults = false
        }
    },
    ready: function () {
        function repeat(num, whatTo) {
            var arr = [];
            for (var i = 0; i < num; i++) {
                arr.push(whatTo);
            }
            return arr;
        }

        // Create an array filled with as many empty strings as there are blanks to fill
        this.inputs = Array(this.questionData.blanks.length).join(".").split(".")
        this.answerCache = Array(this.inputs.length)
        for (var i = 0; i < this.inputs.length; ++i) this.answerCache[i] = false;
    }
})