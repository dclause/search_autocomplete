/*
 * SEARCH AUTOCOMPLETE (version 7.3-x)
 *
 * @authors
 * Miroslav Talenberg (Dominique CLAUSE) <http://www.axiomcafe.fr/contact>
 *
 * Sponsored by:
 * www.axiomcafe.fr
 */
 
(function ($) {
  Drupal.behaviors.search_autocomplete = {
    attach: function(context) {
      if (Drupal.settings.search_autocomplete) {
        $.each(Drupal.settings.search_autocomplete, function(key, value) {
          $(Drupal.settings.search_autocomplete[key].selector).addClass('ui-autocomplete-processed').autocomplete({
            minLength: Drupal.settings.search_autocomplete[key].minChars,
            source: function(request, response) {
              if (Drupal.settings.search_autocomplete[key].type == 0) {
                $.getJSON(Drupal.settings.search_autocomplete[key].datas, { q: request.term }, response);
              } else if (Drupal.settings.search_autocomplete[key].type == 1) {
                $.getJSON(Drupal.settings.search_autocomplete[key].datas + '/' + request.term, { }, response);
              } else if (Drupal.settings.search_autocomplete[key].type == 2) {
                response( $.ui.autocomplete.filter( Drupal.settings.search_autocomplete[key].datas, request.term ) );
              }
            },
            open: function(event, ui) {
              $(".ui-autocomplete li.ui-menu-item:odd").addClass("ui-menu-item-odd");
              $(".ui-autocomplete li.ui-menu-item:even").addClass("ui-menu-item-even");
            },
            select: function(event, ui) { 
              if (Drupal.settings.search_autocomplete[key].auto_redirect == 1 && ui.item.link) {
                document.location.href = ui.item.link;
              } else if (Drupal.settings.search_autocomplete[key].auto_submit == 1) {
                  $(this).val(ui.item.label);
                  $(this).closest("form").submit();
              }
            }
          }).autocomplete("widget").attr("id", "ui-theme-" + Drupal.settings.search_autocomplete[key].theme);
        });
      }
    }
  };
})(jQuery);