/**
 * @file
 * SEARCH AUTOCOMPLETE (version 6.x-4-x)
 * 
 * @author
 * Miroslav Talenberg (Dominique CLAUSE) <http://www.axiomcafe.fr/contact>
 */

/*
 * Sponsored by:
 * www.axiomcafe.fr
 */


  // Autocomplete
  $.myUI.autocomplete.prototype._renderItem = function (ul, item) {
    var term = this.term;
    var first = ("group" in item)  ? 'first' : '';
    var innerHTML = '<div class="myUI-autocomplete-fields ' + first + '">';
    if ("group" in item) {
    	innerHTML += ('<div class="myUI-autocomplete-field-group ' + item.group.group_id + '">' + item.group.group_name + '</div>');
    }
    if (item.fields) {
      $.each( item.fields, function( key, value ) {
    	var output  = value.replace($.trim(term), "<span class='myUI-autocomplete-field-term'>" + term + "</span>");
        innerHTML += ('<div class="myUI-autocomplete-field-' + key + '">' + output + '</div>');
      });
    } else {
    	// Case no results :
    	innerHTML += ('<div class="myUI-autocomplete-field-noresult">' + item.label + '</div>');
    }
    innerHTML += '</div>';

    return $( "<li></li>" )
        .data( "item.autocomplete", item )
        .append( "<a>" + innerHTML + "</a>" )
        .appendTo( ul );
  };
  
  $.myUI.autocomplete.prototype._resizeMenu = function() {
    var ul = this.menu.element; 
    ul.outerWidth( Math.max( ul.width("").outerWidth() + 5, this.options.position.of == null ? this.element.outerWidth() : this.options.position.of.outerWidth()));
  };
  
  Drupal.behaviors.search_autocomplete = function(context) {
	  if (Drupal.settings.search_autocomplete) {
	    $.each(Drupal.settings.search_autocomplete, function(key, value) {
	      var NoResultsLabel = Drupal.settings.search_autocomplete[key].no_results;
	      $(Drupal.settings.search_autocomplete[key].selector).addClass('myUI-theme-' + Drupal.settings.search_autocomplete[key].theme).autocomplete({
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
	          // Internal URL or view :
	          else if (Drupal.settings.search_autocomplete[key].type == 1 || Drupal.settings.search_autocomplete[key].type == 3) {
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
	            var results = $.myUI.autocomplete.filter(Drupal.settings.search_autocomplete[key].datas, request.term);
	                if (!results.length && NoResultsLabel) {
	                results = [NoResultsLabel];
	            }
	            // Only return the number of values set in the settings.
	            response(results.slice(0, Drupal.settings.search_autocomplete[key].max_sug));
	          }
	        },
	        open: function(event, myUI) {
	          $(".myUI-autocomplete li.myUI-menu-item:odd").addClass("myUI-menu-item-odd");
	          $(".myUI-autocomplete li.myUI-menu-item:even").addClass("myUI-menu-item-even");
	        },
	        select: function(event, myUI) {
	          if (myUI.item.label === NoResultsLabel) {
	            event.preventDefault();
	          } else if (Drupal.settings.search_autocomplete[key].auto_redirect == 1 && myUI.item.link) {
	            document.location.href = myUI.item.link;
	          } else if (Drupal.settings.search_autocomplete[key].auto_submit == 1) {
	              $(this).val(myUI.item.label);
	              $(this).closest("form").submit();
	          }
	        },
	        focus: function (event, myUI) {
	          if (myUI.item.label === NoResultsLabel) {
	              event.preventDefault();
	          }
	        },
	      }).autocomplete("widget").attr("id", "myUI-theme-" + Drupal.settings.search_autocomplete[key].theme).offset({ top: "20px", left: $(this.selector).left});
	    });
	  }
  };