/**
 * @file
 * SEARCH AUTOCOMPLETE (version 7.3-x)
 */

/*
 * Sponsored by:
 * www.axiomcafe.fr
 */

(function ($) {
  
  // Autocomplete
  $.ui.autocomplete.prototype._renderItem = function (ul, item) {
    console.log(item);
    console.log(this.term);
    
    var innerHTML = '<div class="ui-autocomplete-fields">';
    if (item.fields) {
      $.each( item.fields, function( key, value ) {
        innerHTML += ('<div class="ui-autocomplete-field-' + key + '">' + value + '</div>');
      });
    } else {
      innerHTML += item.value;
    }
    innerHTML += '</div>';

    var itemLabel = innerHTML.replace(this.term, "<span class='ui-autocomplete-field-term'>" + this.term + "</span>");
    return $( "<li></li>" )
        .data( "item.autocomplete", item )
        .append( "<a>" + itemLabel + "</a>" )
        .appendTo( ul );
  };
  
  $.ui.autocomplete.prototype._resizeMenu = function() {
    var ul = this.menu.element; 
    ul.outerWidth( Math.max( ul.width("").outerWidth() + 5, this.options.position.of == null ? this.element.outerWidth() : this.options.position.of.outerWidth()));
  };
  
  Drupal.behaviors.search_autocomplete = {
    attach: function(context) {
      if (Drupal.settings.search_autocomplete) {
        $.each(Drupal.settings.search_autocomplete, function(key, value) {
          var NoResultsLabel = Drupal.settings.search_autocomplete[key].no_results;
          $(Drupal.settings.search_autocomplete[key].selector).addClass('ui-autocomplete-processed').autocomplete({
            minLength: Drupal.settings.search_autocomplete[key].minChars,
            source: function(request, response) {
              // External URL:
              if (Drupal.settings.search_autocomplete[key].type == 0) {
                $.getJSON(Drupal.settings.search_autocomplete[key].datas, { q: request.term }, function (results) {
                  // Only return the number of values set in the settings.
                  if (!results.length && NoResultsLabel) {
                      results = [NoResultsLabel];
                  }
                  response(results.slice(0, Drupal.settings.search_autocomplete[key].max_sug));
                });
              }
              // Internal URL:
              else if (Drupal.settings.search_autocomplete[key].type == 1) {
                $.getJSON(Drupal.settings.search_autocomplete[key].datas + request.term, { }, function (results) {
                  // Only return the number of values set in the settings.
                  if (!results.length && NoResultsLabel) {
                      results = [NoResultsLabel];
                  }
                  response(results.slice(0, Drupal.settings.search_autocomplete[key].max_sug));
                });
              }
              // Static resources:
              else if (Drupal.settings.search_autocomplete[key].type == 2) {
                var results = $.ui.autocomplete.filter(Drupal.settings.search_autocomplete[key].datas, request.term);
                    if (!results.length && NoResultsLabel) {
                    results = [NoResultsLabel];
                }
                // Only return the number of values set in the settings.
                response(results.slice(0, Drupal.settings.search_autocomplete[key].max_sug));
              }
            },
            open: function(event, ui) {
              $(".ui-autocomplete li.ui-menu-item:odd").addClass("ui-menu-item-odd");
              $(".ui-autocomplete li.ui-menu-item:even").addClass("ui-menu-item-even");
            },
            select: function(event, ui) {
              if (ui.item.label === NoResultsLabel) {
                event.preventDefault();
              } else if (Drupal.settings.search_autocomplete[key].auto_redirect == 1 && ui.item.link) {
                document.location.href = ui.item.link;
              } else if (Drupal.settings.search_autocomplete[key].auto_submit == 1) {
                  $(this).val(ui.item.label);
                  $(this).closest("form").submit();
              }
            },
            focus: function (event, ui) {
              if (ui.item.label === NoResultsLabel) {
                  event.preventDefault();
              }
            },
          }).autocomplete("widget").attr("id", "ui-theme-" + Drupal.settings.search_autocomplete[key].theme);
        });
      }
    }
  };
})(jQuery);
