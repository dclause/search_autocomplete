
* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*
*            Welcome to Search Autocomplete v6.x-1.0 !
* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*

    !! This module has just change maintener. Let's give it a second life !!
 
 ***
 * Search Autocomplete
 * Enables autocomplete functionality on search fields.
 ***
 
 @authors
 D5 version by Arnaud Bonnevigne <http://www.bonvga.net/contact>
 D6 port by Joakim Stai, NodeOne <http://drupal.org/user/88701>
 Bug fixes and code review by Dominique CLAUSE, Miroslav <http://www.axiomcafe.fr/contact>
    # fixes: search form autocompletion: wrong callback.
    # fixes: choosen autocomplete forms did not validate: all search forms where autocompleted.
    # fixes: module administration link did not appear in admin panel.
    # minor changes: best practice code management to validate CODER module review.
    # postponed: removed block search to conform with a strict port (block support will be added later)
 
 Sponsored by:
 www.axiomcafe.fr
 
Known Issue:
This module uses drupal core autocompletion which is known to have a popup 
position issue. You may consider patching core to fix it:
  http://drupal.org/node/625170

--------------------------------------------------------------------------------- 
-- 1.  Installing Search Autocomplete:

Place the entirety of this directory in sites/all/modules/search_autocomplete 
or in the equivalent directory of your Drupal installation.

Navigate to administer >> build >> modules. Enable Search Autocomplete.

If you're having trouble installing this module, please ensure that your tar 
program is not flattening the directory tree, truncating filenames or losing 
files.

---------------------------------------------------------------------------------
-- 2.  Setting Search Autocomplete

Navigate to /admin/build/search_autocomplete

The configuration options are quite easy to understand. However, a documentation
will soon be released for your convenience.

---------------------------------------------------------------------------------
-- 3.  Translating Search Autocomplete

French translation is given as a .po file in search_autocomplete/translations
A .pot translation file is also given for you convenience to help translating 
the module.

Please refer to section 4 (Helping) for typo, grammar or langage issues.

---------------------------------------------------------------------------------
-- 4.  Helping and complaining on Search Autocomplete

To help this module live, please post your issues, ideas and comments at:
http://drupal.org/node/add/project-issue/search_autocomplete
and view issues at:
http://drupal.org/project/issues/search_autocomplete?categories=All


The new maintener: Miroslav