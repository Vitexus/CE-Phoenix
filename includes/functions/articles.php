<?php
/*
  $Id: articles.php, v1.0 2003/12/04 12:00:00 ra Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

/************************************************************
Callback to ensure all parts of an array are integers
************************************************************/  
function StringToInt($string) {
  return (int)$string;
}

// Parse and secure the tPath parameter values
  function tep_parse_topic_path($tPath) {
    // make sure the topic IDs are integers
    $tPath_array = array_map('StringToInt', explode('_', $tPath));

// make sure no duplicate topic IDs exist which could lock the server in a loop
    $tmp_array = [];
    $n = (is_array($tPath_array) ? sizeof($tPath_array) : 0);
    for ($i=0; $i<$n; $i++) {
      if (!in_array($tPath_array[$i], $tmp_array)) {
        $tmp_array[] = $tPath_array[$i];
      }
    }

    return $tmp_array;
  }

////
// Generate an array of all topics
// TABLES: topics
  function tep_get_topics_tree($parent_id = '0', $spacing = '', $exclude = '', $tPath_array = '', $include_itself = false) {

    if (!is_array($tPath_array)) $tPath_array = array();

    if ($include_itself) {
      $topic_query = tep_db_query("select td.topics_name from topics_description td where td.language_id = '" . (int)$_SESSION['languages_id'] . "' and td.topics_id = '" . (int)$parent_id . "'");
      $topic = tep_db_fetch_array($topic_query);
      $tPath_array[] = array('id' => $parent_id, 'text' => $topic['topics_name']);
    }

    $topics_query = tep_db_query("select t.topics_id, td.topics_name, t.parent_id from topics t, topics_description td where t.topics_id = td.topics_id and td.language_id = '" . (int)$_SESSION['languages_id'] . "' and t.parent_id = '" . (int)$parent_id . "' order by t.sort_order, td.topics_name");
    while ($topics = tep_db_fetch_array($topics_query)) {
      if ($exclude != $topics['topics_id']) $tPath_array[] = array('id' => $topics['topics_id'], 'text' => $spacing . $topics['topics_name']);
      $tPath_array = tep_get_topics_tree($topics['topics_id'], $spacing . '&nbsp;&nbsp;&nbsp;', $exclude, $tPath_array);
    }

    return $tPath_array;
  }
  
////
// Return the number of articles in a topic
// TABLES: articles, articles_to_topics, topics
  function tep_count_articles_in_topic($topic_id, $include_inactive = false) {
    $articles_count = 0;
    if ($include_inactive == true) {
      $articles_query = tep_db_query("SELECT COUNT(*) as total from articles a, articles_to_topics a2t where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_id = a2t.articles_id and a2t.topics_id = '" . (int)$topic_id . "'");
    } else {
      $articles_query = tep_db_query("SELECT COUNT(*) as total from articles a, articles_to_topics a2t where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_id = a2t.articles_id and a.articles_status = '1' and a2t.topics_id = '" . (int)$topic_id . "'");
    }
    $articles = tep_db_fetch_array($articles_query);
    $articles_count += $articles['total'];

    $child_topics_query = tep_db_query("select topics_id from topics where parent_id = '" . (int)$topic_id . "'");
    if (tep_db_num_rows($child_topics_query)) {
      while ($child_topics = tep_db_fetch_array($child_topics_query)) {
        $articles_count += tep_count_articles_in_topic($child_topics['topics_id'], $include_inactive);
      }
    }

    return $articles_count;
  }

////
// Return true if the topic has subtopics
// TABLES: topics
  function tep_has_topic_subtopics($topic_id) {
    $child_topic_query = tep_db_query("SELECT COUNT(*) as count from topics where parent_id = '" . (int)$topic_id . "'");
    $child_topic = tep_db_fetch_array($child_topic_query);

    if ($child_topic['count'] > 0) {
      return true;
    } else {
      return false;
    }
  }

////
// Return all topics
// TABLES: topics, topic_descriptions
  function tep_get_topics($topics_array = '', $parent_id = '0', $indent = '') {
    global $languages_id;

    if (!is_array($topics_array)) $topics_array = array();

    $topics_query = tep_db_query("select t.topics_id, td.topics_name from topics t, topics_description td where parent_id = '" . (int)$parent_id . "' and t.topics_id = td.topics_id and td.language_id = '" . (int)$_SESSION['languages_id'] . "' order by sort_order, td.topics_name");
    while ($topics = tep_db_fetch_array($topics_query)) {
      $topics_array[] = array('id' => $topics['topics_id'],
                              'text' => $indent . $topics['topics_name'],
                              'parent' => $parent_id
                              );

      if ($topics['topics_id'] != $parent_id) {
        $topics_array = tep_get_topics($topics_array, $topics['topics_id'], $indent);
      }
    }

    return $topics_array;
  }

////
// Return all authors
// TABLES: authors
  function tep_get_authors($authors_array = '') {
    if (!is_array($authors_array)) $authors_array = array();

    $authors_query = tep_db_query("select authors_id, authors_name from authors order by authors_name");
    while ($authors = tep_db_fetch_array($authors_query)) {
      $authors_array[] = array('id' => $authors['authors_id'], 'text' => $authors['authors_name']);
    }

    return $authors_array;
  }

////
// Return all subtopic IDs
// TABLES: topics
  function tep_get_subtopics(&$subtopics_array, $parent_id = 0) {
    $subtopics_query = tep_db_query("select topics_id from topics where parent_id = '" . (int)$parent_id . "'");
    while ($subtopics = tep_db_fetch_array($subtopics_query)) {
      $subtopics_array[sizeof($subtopics_array)] = $subtopics['topics_id'];
      if ($subtopics['topics_id'] != $parent_id) {
        tep_get_subtopics($subtopics_array, $subtopics['topics_id']);
      }
    }
  }

////
// Recursively go through the topics and retreive all parent topic IDs
// TABLES: topics
  function tep_get_parent_topics(&$topics, $topics_id) {
    $parent_topics_query = tep_db_query("select parent_id from topics where topics_id = '" . (int)$topics_id . "'");
    while ($parent_topics = tep_db_fetch_array($parent_topics_query)) {
      if ($parent_topics['parent_id'] == 0) return true;
      $topics[sizeof($topics)] = $parent_topics['parent_id'];
      if ($parent_topics['parent_id'] != $topics_id) {
        tep_get_parent_topics($topics, $parent_topics['parent_id']);
      }
    }
  }

////
// Construct a topic path to the article
// TABLES: articles_to_topics
  function tep_get_article_path($articles_id) {
    $tPath = '';

    $topic_query = tep_db_query("select a2t.topics_id from articles a, articles_to_topics a2t where a.articles_id = '" . (int)$articles_id . "' and a.articles_status = '1' and a.articles_id = a2t.articles_id limit 1");
    if (tep_db_num_rows($topic_query)) {
      $topic = tep_db_fetch_array($topic_query);

      $topics = array();
      tep_get_parent_topics($topics, $topic['topics_id']);

      $topics = array_reverse($topics);

      $tPath = implode('_', $topics);

      if (tep_not_null($tPath)) $tPath .= '_';
      $tPath .= $topic['topics_id'];
    }

    return $tPath;
  }

////
// Return an article's name
// TABLES: articles
  function tep_get_articles_name($article_id, $language = '') {
    global $languages_id;

    if (empty($language)) $language = $languages_id;

    $article_query = tep_db_query("select articles_name from articles_description where articles_id = '" . (int)$article_id . "' and language_id = '" . (int)$language . "'");
    $article = tep_db_fetch_array($article_query);

    return $article['articles_name'];
  }

////
//! Cache the articles box
// Cache the articles box
  function tep_cache_topics_box($auto_expire = false, $refresh = false) {
    global $tPath, $language, $languages_id, $tree, $tPath_array, $topics_string;

    if (($refresh == true) || !read_cache($cache_output, 'topics_box-' . $language . '.cache' . $tPath, $auto_expire)) {
      ob_start();
      include(DIR_WS_BOXES . 'articles.php');
      $cache_output = ob_get_contents();
      ob_end_clean();
      write_cache($cache_output, 'topics_box-' . $language . '.cache' . $tPath);
    }

    return $cache_output;
  }

////
//! Cache the authors box
// Cache the authors box
  function tep_cache_authors_box($auto_expire = false, $refresh = false) {
    global $_GET, $language;

    $authors_id = '';
    if (isset($_GET['authors_id']) && tep_not_null($_GET['authors_id'])) {
      $authors_id = $_GET['authors_id'];
    }

    if (($refresh == true) || !read_cache($cache_output, 'authors_box-' . $language . '.cache' . $authors_id, $auto_expire)) {
      ob_start();
      include(DIR_WS_BOXES . 'authors.php');
      $cache_output = ob_get_contents();
      ob_end_clean();
      write_cache($cache_output, 'authors_box-' . $language . '.cache' . $authors_id);
    }

    return $cache_output;
  }
   
  function GetArticleLinks($box_id = 999) {
      global $languages_id;
      
      $which_box = ($box_id == 999 ? '' : "a.box_id = '" . (int)$box_id . "' and ");
      $articles_query = tep_db_query("SELECT a.articles_id, ad.articles_name, a.articles_is_blog from 
       articles a left join 
       articles_description ad on a.articles_id = ad.articles_id
        where  a.articles_status = '1' and 
               " . $which_box . "
               ad.language_id = '" . (int)$_SESSION['languages_id'] . "'");
               
      $aLinks = '';           
      while ($db = tep_db_fetch_array($articles_query)) {
          $locn = ($db['articles_is_blog'] ? 'article_blog.php' : 'article_info.php');
          $aLinks .= '<li><a href="' . tep_href_link($locn, 'articles_id='.$db['articles_id']) . '">' . $db['articles_name'] . '</a></li>';
      }   
      
      return $aLinks;
  }   
  
  function GetArticleLinsByTopic($topic) {
      global $languages_id;
      
      $articles_query = tep_db_query("SELECT a.articles_id, ad.articles_name, a.articles_is_blog, td.topics_name from 
       articles a left join 
       articles_description ad on a.articles_id = ad.articles_id left join 
       articles_to_topics a2t on a.articles_id = a2t.articles_id left join  
       topics_description td on a2t.topics_id = td.topics_id 
        where  a.articles_status = '1' and 
               td.topics_name = '" . tep_db_input($topic) . "' and
               ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and 
               td.language_id = '" . (int)$_SESSION['languages_id'] . "'");
               
      $aLinks = '';           
      while ($db = tep_db_fetch_array($articles_query)) {
          $locn = ($db['articles_is_blog'] ? 'article_blog.php' : 'article_info.php');
          $aLinks .= '<li><a href="' . tep_href_link($locn, 'articles_id='.$db['articles_id']) . '">' . $db['articles_name'] . '</a></li>';
      }   
      
      return $aLinks;
  } 
  
  function IsValidImageFile($imgName) {
      $fileTypesArray = array('jpg', 'jpeg', 'gif', 'png');
      $fileType = pathinfo($imgName);  
      return (in_array($fileType['extension'], $fileTypesArray));
  }

/********************************************************
Limit the length of displayed text while leaving all
html tags. Source at
https://stackoverflow.com/questions/38548358/cut-html-input-while-preserving-tags-with-php
********************************************************/  
function TruncateHTML($html, $limit = 20) {
    static $wrapper = null;
    static $wrapperLength = 0;

    // trim unwanted CR/LF characters
    $html = trim($html);

    // Remove HTML comments
    $html = preg_replace("~<!--.*?-->~", '', $html);

    // If $html in in plain text
    if ((strlen(strip_tags($html)) > 0) && strlen(strip_tags($html)) == strlen($html))  {
        return substr($html, 0, $limit);
    }
    // If $html doesn't have a root element
    elseif (is_null($wrapper)) {
        if (!preg_match("~^\s*<[^\s!?]~", $html)) {
            // Defining a tag as our HTML wrapper
            $wrapper = 'div';
            $htmlWrapper = "<$wrapper></$wrapper>";
            $wrapperLength = strlen($htmlWrapper);
            $html = preg_replace("~><~", ">$html<", $htmlWrapper);
        }
    }

    // Calculating total length
    $totalLength = strlen($html);

    // If our input length is less than limit, we are done.
    if ($totalLength <= $limit) {
        if ($wrapper) {
            return preg_replace("~^<$wrapper>|</$wrapper>$~", "", $html);
        }
        return strlen(strip_tags($html)) > 0 ? $html : '';
    }

    // Initializing a DOM object to hold our HTML
    $dom = new DOMDocument;
    $dom->loadHTML($html,  LIBXML_HTML_NOIMPLIED  | LIBXML_HTML_NODEFDTD);
    // Initializing a DOMXPath object to query on our DOM
    $xpath = new DOMXPath($dom);
    // Query last node (this does not include comment or text nodes)
    $lastNode = $xpath->query("./*[last()]")->item(0);

    // While manipulating, when there is no HTML element left
    if ($totalLength > $limit && is_null($lastNode)) {
        if (strlen(strip_tags($html)) >= $limit) {
            $textNode = $xpath->query("//text()")->item(0);
            if ($wrapper) {
                $textNode->nodeValue = substr($textNode->nodeValue, 0, $limit );
                $html = $dom->saveHTML();
                return preg_replace("~^<$wrapper>|</$wrapper>$~", "", $html);
            } else {
                $lengthAllowed = $limit - ($totalLength - strlen($textNode->nodeValue));
                if ($lengthAllowed <= 0) {
                    return '';
                }
                $textNode->nodeValue = substr($textNode->nodeValue, 0, $lengthAllowed);
                $html = $dom->saveHTML();
                return strlen(strip_tags($html)) > 0 ? $html : '';
            }
        } else {
            $textNode = $xpath->query("//text()")->item(0);
            $textNode->nodeValue = substr($textNode->nodeValue, 0, -(($totalLength - ($wrapperLength > 0 ? $wrapperLength : 0)) - $limit));
            $html = $dom->saveHTML();
            return strlen(strip_tags($html)) > 0 ? $html : '';
        }
    }
    // If we have a text node after our last HTML element
    elseif ($nextNode = $lastNode->nextSibling) {
        if ($nextNode->nodeType === 3 /* DOMText */) {
            $nodeLength = strlen($nextNode->nodeValue);
            // If by removing our text node total length will be greater than limit
            if (($totalLength - ($wrapperLength > 0 ? $wrapperLength : 0)) - $nodeLength >= $limit) {
                // We should remove it
                $nextNode->parentNode->removeChild($nextNode);
                $html = $dom->saveHTML();
                return truncateHTML($html, $limit);
            }
            // If by removing our text node total length will be less than limit
            else {
                // We should truncate our text to fit the limit
                $nextNode->nodeValue = substr($nextNode->nodeValue, 0, ($limit - (($totalLength - ($wrapperLength > 0 ? $wrapperLength : 0)) - $nodeLength)));
                $html = $dom->saveHTML();
                // Caring about custom wrapper
                if ($wrapper) {
                    return preg_replace("~^<$wrapper>|</$wrapper>$~", "", $html);
                }
                return $html;
            } 
        }
    }
    // If current node is an HTML element 
    elseif ($lastNode->nodeType === 1 /* DOMElement */) {
        $nodeLength = strlen($lastNode->nodeValue);
        // If by removing current HTML element total length will be greater than limit
        if (($totalLength - ($wrapperLength > 0 ? $wrapperLength : 0)) - $nodeLength >= $limit) {
            // We should remove it
            $lastNode->parentNode->removeChild($lastNode);
            $html = $dom->saveHTML();
            return truncateHTML($html, $limit);
        }
        // If by removing current HTML element total length will be less than limit
        else {
            // We should truncate our node value to fit the limit
            $lastNode->nodeValue = substr($lastNode->nodeValue, 0, ($limit - (($totalLength - ($wrapperLength > 0 ? $wrapperLength : 0)) - $nodeLength)));
            $html = $dom->saveHTML();
            if ($wrapper) {
                return preg_replace("~^<$wrapper>|</$wrapper>$~", "", $html);
            }
            return $html;
        }
    }
}  
