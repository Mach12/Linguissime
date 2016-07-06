import selectTranslation    from './selecttranslation/selecttranslation';
import fillTheBlanks        from './filltheblanks/filltheblanks';
import wording              from './wording/wording';
import irregularVerbs       from './irregularverbs/irregularverbs';

export default Vue.extend({
    template: "@",
    props: {
        type: {
            required: true
        },
        data: {
            type: Object,
            required: true
        }
    },
    components: {
        selectTranslation,
        fillTheBlanks,
        wording,
        irregularVerbs
    }
})