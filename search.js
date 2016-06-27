
// instantsearch.js - Algolia


// config

var search = instantsearch({
  appId: 'xx',
  apiKey: 'xx',
  indexName: 'Indexname',
  urlSync: true
});


// search input

search.addWidget(
    instantsearch.widgets.searchBox({
        container: '#search-box',
        placeholder: 'Search for products...'
      })
);

// results display in a container

search.addWidget(
    instantsearch.widgets.hits({
        container: '#hits-container',
        templates: {
            item: 'Hit {{objectID}}: FIXME'
        }
    })
);

// pagination

search.addWidget(
    instantsearch.widgets.pagination({
        container: '#pagination-container'
    })
);

search.start();



                            


                                  