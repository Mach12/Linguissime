
// instantsearch.js - Algolia


// config

<script src="//cdn.jsdelivr.net/instantsearch.js/1/instantsearch.min.js"></script>


<script>

<input type="text" id="search"/>
<div id="hits"></div>
<div id="pagination"></div>

var search = instantsearch({
  appId: 'DWDOUHY22N',
  apiKey: 'be8495506adaf17411ef2e6bf33b9b84',
  indexName: 'Exercise',
  urlSync: true
});


// search input

search.addWidget(
    instantsearch.widgets.searchBox({
        container: '#search',
        placeholder: 'Search...'
      })
);

// results display in a container

search.addWidget(
    instantsearch.widgets.hits({
        container: '#hits',
        templates: {
            item: 'Hit {{objectID}}: FIXME'
        }
    })
);

// pagination

search.addWidget(
    instantsearch.widgets.pagination({
        container: '#pagination'
    })
);

search.start();




                            


                                  