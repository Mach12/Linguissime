declare function require(name: string);
var algoliasearch = require('algoliasearch');
var algoliasearchHelper = require('algoliasearch-helper');

import {getTokenHeader, getSearchQuery} from '../vuex/getters'

export default Vue.extend({
    template: "@",
    data: () => {
        return {
            show: false,
            resultData: {},
            client: algoliasearch('appId', 'apiKey'),
            helper: algoliasearchHelper(this.client, 'indexName', {})
        }
    },
    vuex: {
        getters: {
            getTokenHeader,
            getSearchQuery
        }
    }
})