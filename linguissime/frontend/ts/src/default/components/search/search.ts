declare function require(name: string);
//var algoliasearch = require('algoliasearch');
//var algoliasearchHelper = require('algoliasearch-helper');

export default Vue.extend({
    template: "@",
    data: () => {
        return {
            show: false,
            resultData: {}//,
            //client: algoliasearch('appId', 'apiKey'),
            //helper: algoliasearchHelper(this.client, 'indexName', {})
        }
    },
    computed: {
        show: function() {
            return this.$store.state.showSearch
        }
    },
    watch: {
        '$store.state.searchQuery' : function(oldValue, newValue) {
            // Do the search
        }
    }
})