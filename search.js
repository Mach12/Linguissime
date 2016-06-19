
// instantsearch.js - Algolia

var search = instantsearch({
  appId: 'xx',
  apiKey: 'xx',
  indexName: 'Indexname',
  urlSync: true
});


search.addWidget(
  instantsearch.widgets.hitsPerPageSelector({
    container: '#hits-per-page-selector',
    cssClasses: {
      root: 'form-control'
    },
    options: [
      {value: 6, label: '6 per page'},
      {value: 12, label: '12 per page'},
      {value: 24, label: '24 per page'}
    ]
  })
);


search.addWidget(
    instantsearch.widgets.searchBox({
      container: '#search-input'
    })
  );

search.addWidget(
  instantsearch.widgets.hits({
    container: '.hit',
    templates: {
      empty: 'No results',
      item: 'xxxx'
    },
    hitsPerPage: 6
  })
);

search.addWidget(
  instantsearch.widgets.pagination({
    container: '#pagination-container',
    maxPages: 20,
    scrollTo: false,

  })
);


search.addWidget(
  instantsearch.widgets.refinementList({
    container: '#categories',
    attributeName: 'category',
    operator: 'or',
    cssClasses: {
      count: 'hidden',
      active: 'active'
    },
    limit: 10,

    templates: {
      header: 'Catégories'
    }
  })
);

search.start();



                            


                                  