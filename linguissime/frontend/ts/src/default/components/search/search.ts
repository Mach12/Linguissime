declare function require(name: string);
var algoliasearch = require('/public/scripts/algoliasearch/algoliasearch');
var algoliasearchHelper = require('/public/scripts/algoliasearch.helper/algoliasearch.helper');

import {difficulty as difficultyScale} from '../../utilities/util'

import searchHit from './searchhit/searchhit'

export default Vue.extend({
    template: "@",
    data: function () {
        return {
            show: false,
            searchHits: [],
            client: {},
            helper: {},
            difficultyScale,
            difficultyOptions: [],
            minDuration: 0,
            maxDuration: 1,
            showDuration: false
        }
    },
    computed: {
        show: function () {
            return this.$store.state.showSearch
        },
        minTime: {
            get: function () {
                return this.minDuration
            },
            set: function (newValue: number) {
                this.minDuration = newValue
                this.maxDuration = Math.max(this.maxDuration, this.minDuration)
                this.durationBoundsChanged()
            }
        },
        maxTime: {
            get: function () {
                return this.maxDuration
            },
            set: function (newValue: number) {
                this.maxDuration = newValue
                this.minDuration = Math.min(this.maxDuration, this.minDuration)
                this.durationBoundsChanged()
            }
        }
    },
    methods: {
        durationBoundsChanged() {
            this.helper.removeNumericRefinement('duration')
            if (this.showDuration) {
                this.helper.addNumericRefinement('duration', '>=', this.minTime)
                this.helper.addNumericRefinement('duration', '<=', this.maxTime)
            }
            this.helper.search()
        }
    },
    watch: {
        '$store.state.searchQuery': function (oldValue, newValue) {
            this.helper.setQuery(newValue)
            this.helper.search()
        },
        'difficultyOptions': function (oldValue, newValue) {
            this.helper.clearRefinements('difficulty')
            for (var i = 0; i < newValue.length; ++i) {
                if (newValue[i]) this.helper.addDisjunctiveFacetRefinement('difficulty', i)
            }
            this.helper.search()
        },
        'showDuration': function() {
            this.durationBoundsChanged()
        }
    },
    ready: function () {
        // init algolia
        this.client = algoliasearch('DWDOUHY22N', 'be8495506adaf17411ef2e6bf33b9b84')
        this.helper = algoliasearchHelper(this.client, 'Exercise', {
            disjunctiveFacets: ['difficulty', 'duration']
        })
        this.helper.on('result', function (content) {
            this.searchHits = content.hits
        }.bind(this));
        // fill difficulty array
        var difficultyCount = Object.keys(this.difficultyScale).length
        this.difficultyOptions = Array(difficultyCount)
        for (var i = 0; i < difficultyCount; ++i) this.difficultyOptions[i] = false;
    },
    components: {
        searchHit
    }
})