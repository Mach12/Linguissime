export default Vue.extend({
    template: "@",
    computed: {
        query: {
            get() {
                return this.$store.state.searchQuery
            },
            set(newValue: string) {
                this.$store.dispatch('SET_SEARCH_QUERY', newValue)

                if (!this.$store.state.showSearch && newValue.length !== 0)
                    this.$store.dispatch('SET_SEARCH_SHOW', true)
            }
        },
        showCancelButton() {
            return this.$store.state.showSearch
        }
    },
    methods: {
        cancelSearch() {
            this.$store.dispatch('SET_SEARCH_QUERY', "")
            this.$store.dispatch('SET_SEARCH_SHOW', false)
        }
    }
})