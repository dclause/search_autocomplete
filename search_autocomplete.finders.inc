<?php

/**
 * @file
 * Search Autocomplete
 * Finder functions for suggestions.
 *
 * @authors
 * Miroslav Talenberg (Dominique CLAUSE) <http://www.axiomcafe.fr/contact>
 *
 * Sponsored by:
 * www.axiomcafe.fr
 */

/* ###################################################################################### *\
|*                            Search Items for autocompletion                             *|
\* ###################################################################################### */



/**
 * HELPER FOR AUTOCOMPLETE WORDS:
 * Return word terms
 */
function search_autocomplete_find_words($word = '', $limit = '', $order = '', $prefix = '', $order = 1) {
  $items = array();
  switch ($order) {
    case 1:
      $order = '';
      break;
    case 2:
      $order = ' ORDER BY s.word ASC';
      break;
    case 3:
      $order = ' GROUP BY s.word ORDER BY SUM(s.score) DESC';
      break;
    default:
      $order = '';
  }
  $result = db_query("SELECT DISTINCT s.word FROM {search_index} s, {node} n WHERE s.type = 'node' AND n.nid = s.sid AND n.status = 1 AND LOWER(s.word) LIKE LOWER('%%%s%%')" . $order . $limit, $word);
  while ($obj = db_fetch_object($result)) {
    $sug = trim($prefix) . ' ' . html_entity_decode(check_plain($obj->word), ENT_QUOTES);
  $items[trim($sug)] = trim($sug);
  }
  return $items;
}

/**
 * HELPER FOR AUTOCOMPLETE NODES:
 * Return nodes terms
 */
function search_autocomplete_find_nodes($word = '', $limit = 3, $order = '', $prefix = '', $order = 1) {
  $items = array();
    switch ($order) {
    case 1:
      $order = '';
      break;
    case 2:
      $order = ' ORDER BY n.title ASC';
      break;
    default:
      $order = '';
  }
  $result = db_query(db_rewrite_sql("SELECT n.title FROM {node} n WHERE n.status = 1 AND LOWER(n.title) LIKE LOWER('%%%s%%')". $order, 0, $limit), $word);
  while ($obj = db_fetch_object($result)) {
    $sug = trim($prefix) . ' ' . html_entity_decode(check_plain($obj->title), ENT_QUOTES);
  $items[trim($sug)] = trim($sug);
  }
  return $items;
}

/**
 * HELPER FOR AUTOCOMPLETE USERS:
 * Return user names
 */
function search_autocomplete_find_users($word = '', $limit = 3, $order = '', $prefix = '', $order = 1) {
  $items = array();
  switch ($order) {
    case 1:
      $order = '';
      break;
    case 2:
      $order = ' ORDER BY u.name ASC';
      break;
    default:
      $order = '';
  }
  $result = db_query(db_rewrite_sql("SELECT u.name FROM {users} u WHERE u.status = 1 AND LOWER(u.name) LIKE LOWER('%%%s%%')". $order, 0, $limit), $word);
  while ($obj = db_fetch_object($result)) {
    $sug = trim($prefix) . ' ' . html_entity_decode(check_plain($obj->name), ENT_QUOTES);
  $items[trim($sug)] = trim($sug);
  }
  return $items;
}

/**
 * HELPER FOR AUTOCOMPLETE TAXOS:
 * Return taxonomy terms
 */
function search_autocomplete_find_taxos($word = '', $limit = 3, $order = '', $prefix = '', $order = 1) {
  $items = array();
  switch ($order) {
    case 1:
      $order = '';
      break;
    case 2:
      $order = ' ORDER BY t.name ASC';
      break;
    default:
      $order = '';
  }
  $result = db_query(db_rewrite_sql("SELECT t.name FROM {term_data} t WHERE LOWER(t.name) LIKE LOWER('%%%s%%')". $order, 0, $limit), $word);
  while ($obj = db_fetch_object($result)) {
    $sug = trim($prefix) . ' ' . html_entity_decode(check_plain($obj->name), ENT_QUOTES);
  $items[trim($sug)] = trim($sug);
  }
  return $items;
}

/**
 * HELPER FOR AUTOCOMPLETE COMMENTS:
 * Return comment subjects
 */
function search_autocomplete_find_comments($word = '', $limit = '', $order = '', $prefix = '', $order = 1) {
  $items = array();
  switch ($order) {
    case 1:
      $order = '';
      break;
    case 2:
      $order = ' ORDER BY c.subject ASC';
      break;
    default:
      $order = '';
  }
  $result = db_query("SELECT c.subject FROM {comments} c WHERE c.subject LIKE LOWER('%%%s%%')". $order . $limit, $word);
  while ($obj = db_fetch_object($result)) {
    $sug = trim($prefix) . ' ' . html_entity_decode(check_plain($obj->subject), ENT_QUOTES);
  $items[trim($sug)] = trim($sug);
  }
  return $items;
}