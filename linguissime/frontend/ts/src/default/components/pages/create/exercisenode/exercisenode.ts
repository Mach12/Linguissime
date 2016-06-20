import selectTranslation    from './selecttranslation/selecttranslation';

export default Vue.extend({
    template: "@",
    props: ['type', 'data'],
    components: {
        selectTranslation
    }
})