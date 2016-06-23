import selectTranslation    from './selecttranslation/selecttranslation';
import fillTheBlanks        from './filltheblanks/filltheblanks';
import wording              from './wording/wording';

export default Vue.extend({
    template: "@",
    props: ['type', 'data'],
    components: {
        selectTranslation,
        fillTheBlanks,
        wording
    }
})