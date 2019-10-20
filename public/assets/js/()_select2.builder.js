var AdminTR = AdminTR || {};

// Select 2 builder for "tags" or "pages" varsion

AdminTR.select2Builder = function($_target, action, type, is_filter = false, is_tags = false, hasMinInputLength = false, has_placeholder = false, is_grouped = false) { 

  var settings = {

    ajax: {

      url: function (params) {
        
        return `${ $(this).data(action) }/${ params.term || 'null' }`;
      }, 

      dataType: 'json', 

      delay: 250, 

      data: function (params) {

        return queryParameters(params); // Return an empty object {} to remove query parameters ('term', '_type', 'q', 'page') from URL
      }, 

      processResults: function (response) {

        return results(response);
      },

      cache: true
    }
  }

  // Set tags parameter if is_tags true

  if (is_tags)

    settings.tags = true;

  // Set minimumInputLength parameter if hasMinInputLength true

  if (hasMinInputLength)

    settings.minimumInputLength = 3;

  // Set placeholder parameter if has_placeholder true

  if (has_placeholder)

    settings.placeholder = $_target.data('placeholder');

  // Initialize Select2

  $_target.select2(settings);

  // Private Methods

  function queryParameters(params) {

    var query = {
      is_filter : is_filter, 
      term      : params.term, 
      _type     : params._type, 
      q         : params.term
    };

    switch (type) {

      case 'tags':
        
        return query;

      case 'pages':

        query.page = params.page || 1;
        
        return query;
    }
  }

  function results(response) {

    switch (type) {

      case 'tags':

        if (is_grouped)

          return {

            results: $.each(response, function (index, element) {

              return {
                text: element.text,
                children:$.map(element.children, function (item) {

                  return { id: item.id, text: item.text };
                })
              };
            })
          };
        
        return {

          results: $.map(response, function (item) {

            return { id: item.id, text: item.text };
          })
        };

      case 'pages':
        
        return {

          results: $.map(response.data, function (item) {

            return { id: item.id, text: item.text };
          }),

          pagination: {

            more: (response.current_page * 25) < response.total
          }
        };
    }
  }
};