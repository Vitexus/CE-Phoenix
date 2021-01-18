<?php

  $breadcrumb->add(NAVBAR_TITLE, tep_href_link('articles.php'));

  require $oscTemplate->map_to_template('template_top.php', 'component');
  
  if ($topic_depth == 'nested') {
      $topic_query = tep_db_query("select td.topics_name, td.topics_heading_title, td.topics_description from topics t, topics_description td where t.topics_id = '" . (int)$current_topic_id . "' and td.topics_id = '" . (int)$current_topic_id . "' and td.language_id = '" . (int)$_SESSION['languages_id'] . "'");
      $topic = tep_db_fetch_array($topic_query);
      $heading = (tep_not_null($topic['topics_heading_title']) ? $topic['topics_heading_title'] : HEADING_TITLE);
  } elseif ($topic_depth == 'articles' || isset($_GET['authors_id'])) {
      $topic_query = tep_db_query("select td.topics_name, td.topics_heading_title, td.topics_description from topics t, topics_description td where t.topics_id = '" . (int)$current_topic_id . "' and td.topics_id = '" . (int)$current_topic_id . "' and td.language_id = '" . (int)$_SESSION['languages_id'] . "'");
      $topic = tep_db_fetch_array($topic_query);
      $heading = ( tep_not_null($topic['topics_heading_title']) ? $topic['topics_heading_title'] : HEADING_TITLE);
  } else {
      $showBlogArticles = ((isset($_GET['showblogarticles']) && $_GET['showblogarticles'] == 'true') ? ' and a.articles_is_blog = 1 ' : ' and a.articles_is_blog = 0');
      $heading = ((isset($_GET['showarticles'])) ? HEADING_TITLE : HEADING_TITLE_BLOG);
  }      
?>

<h1 class="display-4"><?php echo $heading; ?></h1>

<div class="row">
  <div class="col">
  <?php
  if ($topic_depth == 'nested') {
    if ( tep_not_null($topic['topics_description']) ) { ?>
       <div><h2><?php echo $topic['topics_description']; ?></h2></div>

       <?php
       if (isset($tPath) && strpos('_', $tPath) !== FALSE) {
       // check to see if there are deeper topics within the current topic
         $topic_links = array_reverse($tPath_array);
         for($i=0, $n=sizeof($topic_links); $i<$n; $i++) {
           $topics_query = tep_db_query("SELECT COUNT(*) as total from topics t left join topics_description td on t.topics_id = td.topics_id where t.parent_id = '" . (int)$topic_links[$i] . "' and td.language_id = '" . (int)$_SESSION['languages_id'] . "'");
           $topics = tep_db_fetch_array($topics_query);
           if ($topics['total'] > 0) {
             $topics_query = tep_db_query("select t.topics_id, td.topics_name, t.parent_id from topics t left join topics_description td on t.topics_id = td.topics_id where t.parent_id = '" . (int)$topic_links[$i] . "' and td.language_id = '" . (int)$_SESSION['languages_id'] . "' order by sort_order, td.topics_name");
             break; // we've found the deepest topic the customer is in
           }
         }
       } else {
          $topics_query = tep_db_query("select t.topics_id, td.topics_name, t.parent_id from topics t left join topics_description td on t.topics_id = td.topics_id where t.parent_id = '" . (int)$current_topic_id . "' and td.language_id = '" . (int)$_SESSION['languages_id'] . "' order by sort_order, td.topics_name");
       }

       if (tep_db_num_rows($topics_query) > 0) {
           while ($topics = tep_db_fetch_array($topics_query)) {
             $articles_query = tep_db_query("select count(*) as ttl from articles_to_topics where topics_id = '" . (int)$topics['topics_id'] . "'");
             $articles = tep_db_fetch_array($articles_query);
             echo '<div class="main"><a href="' . tep_href_link('articles.php', 'tPath='.$topics['topics_id']) . '"><b>' . $topics['topics_name'] . '</b></a> ( ' . $articles['ttl'] . ' )</div>';
             echo '<div class="smallText">' . $topics['topics_description'] . '</div>';
           } //end of while
        }
    }
    // needed for the new articles module shown below
        $new_articles_topic_id = $current_topic_id;

  } elseif ($topic_depth == 'articles' || isset($_GET['authors_id'])) {

    if (isset($_GET['authors_id'])) { // We are asked to show only a specific topic
      if (isset($_GET['filter_id']) && tep_not_null($_GET['filter_id'])) {
        $listing_sql = "select a.articles_id, a.authors_id, a.articles_date_added, a.articles_is_blog, ad.articles_name, au.authors_name, td.topics_name, ad.articles_description, a2t.topics_id from articles a left join authors au using(authors_id), articles_description ad, articles_to_topics a2t left join topics_description td using(topics_id) where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_status = '1' and au.authors_id = '" . (int)$_GET['authors_id'] . "' and a.articles_id = a2t.articles_id and ad.articles_id = a2t.articles_id and ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and td.language_id = '" . (int)$_SESSION['languages_id'] . "' and a2t.topics_id = '" . (int)$_GET['filter_id'] . "' order by a.articles_sort_order, a.articles_date_added desc, ad.articles_name";
      } else { // We show them all
        $listing_sql = "select a.articles_id, a.authors_id, a.articles_date_added, a.articles_is_blog, ad.articles_name, au.authors_name, td.topics_name, ad.articles_description, a2t.topics_id from articles a left join authors au using(authors_id), articles_description ad, articles_to_topics a2t left join topics_description td using(topics_id) where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_status = '1' and au.authors_id = '" . (int)$_GET['authors_id'] . "' and a.articles_id = a2t.articles_id and ad.articles_id = a2t.articles_id and ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and td.language_id = '" . (int)$_SESSION['languages_id'] . "' order by a.articles_sort_order, a.articles_date_added desc, ad.articles_name";
      }
    } else { // show the articles in a given category
      if (isset($_GET['filter_id']) && tep_not_null($_GET['filter_id'])) { // We are asked to show only specific catgeory
        $listing_sql = "select a.articles_id, a.authors_id, a.articles_date_added, a.articles_is_blog, ad.articles_name, au.authors_name, td.topics_name, ad.articles_description, a2t.topics_id from articles a left join authors au using(authors_id), articles_description ad, articles_to_topics a2t left join topics_description td using(topics_id) where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_status = '1' and a.articles_id = a2t.articles_id and ad.articles_id = a2t.articles_id and ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and td.language_id = '" . (int)$_SESSION['languages_id'] . "' and a2t.topics_id = '" . (int)$current_topic_id . "' and au.authors_id = '" . (int)$_GET['filter_id'] . "' order by a.articles_sort_order, a.articles_date_added desc, ad.articles_name";
      } else { // We show them all
        $listing_sql = "select a.articles_id, a.authors_id, a.articles_date_added, a.articles_is_blog, ad.articles_name, au.authors_name, td.topics_name, ad.articles_description, a2t.topics_id from articles a left join authors au using(authors_id), articles_description ad, articles_to_topics a2t left join topics_description td using(topics_id) where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_status = '1' and a.articles_id = a2t.articles_id and ad.articles_id = a2t.articles_id and ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and td.language_id = '" . (int)$_SESSION['languages_id'] . "' and a2t.topics_id = '" . (int)$current_topic_id . "' order by a.articles_sort_order, a.articles_date_added desc, ad.articles_name";
      }
    }

    if (isset($_GET['authors_id'])) {
      $author_query = tep_db_query("select au.authors_name, aui.authors_description, au.authors_image, aui.authors_url from authors au left join authors_info aui on au.authors_id = aui.authors_id where au.authors_id = '" . (int)$_GET['authors_id'] . "' and aui.languages_id = '" . (int)$_SESSION['languages_id'] . "'");
      $authors = tep_db_fetch_array($author_query);
      $author_name = $authors['authors_name'];
      $authors_description = $authors['authors_description'];
      $authors_url = $authors['authors_url'];

      echo '<div style="padding-bottom:10px;">' . TEXT_ARTICLES_BY . $author_name . '</div>';
    }
   
    $authorsImage = 'images/article_manager_uploads/' . $authors['authors_image'];
    if (file_exists($authorsImage) && is_file($authorsImage)) { ?>
     <div align="right"><h1><?php echo tep_image($authorsImage, HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></h1></div>
    <?php 
    }
  
    // optional Article List Filter
    if (ARTICLE_LIST_FILTER == 'true') {
      if (isset($_GET['authors_id'])) {
        $filterlist_sql = "select distinct t.topics_id as id, td.topics_name as name from articles a left join articles_to_topics a2t on a.articles_id = a2t.articles_id left join topics t on a2t.topics_id = t.topics_id left join topics_description td on a2t.topics_id = td.topics_id where a.articles_status = '1' and td.language_id = '" . (int)$_SESSION['languages_id'] . "' and a.authors_id = '" . (int)$_GET['authors_id'] . "' order by td.topics_name";
      } else {
        $filterlist_sql = "select distinct au.authors_id as id, au.authors_name as name from articles a left join articles_to_topics a2t on a.articles_id = a2t.articles_id left join authors au on a.authors_id = au.authors_id where a.articles_status = '1' and a2t.topics_id = '" . (int)$current_topic_id . "' order by au.authors_name";
      }
      $filterlist_query = tep_db_query($filterlist_sql);
      if (tep_db_num_rows($filterlist_query) > 1) {
        echo '<div align="right" class="main">' . tep_draw_form('filter', 'articles.php', 'get') . TEXT_SHOW . '&nbsp;';
        if (isset($_GET['authors_id'])) {
          echo tep_draw_hidden_field('authors_id', $_GET['authors_id']);
          $options = [['id' => '', 'text' => TEXT_ALL_TOPICS]];
        } else {
          echo tep_draw_hidden_field('tPath', $tPath);
          $options = [['id' => '', 'text' => TEXT_ALL_AUTHORS]];
        }
        echo tep_draw_hidden_field('sort', $_GET['sort']);
        while ($filterlist = tep_db_fetch_array($filterlist_query)) {
          $options[] = ['id' => $filterlist['id'], 'text' => $filterlist['name']];
        }
        echo tep_draw_pull_down_menu('filter_id', $options, (isset($_GET['filter_id']) ? $_GET['filter_id'] : ''), 'onchange="this.form.submit()"');
        echo '</form></div>';
      }
    }
   ?>
              <?php if ( tep_not_null($topic['topics_description']) ) { ?>
                <div align="left"><h2><?php echo $topic['topics_description']; ?></h2></div>
              <?php } ?>
              <?php if (tep_not_null($authors_description)) { ?>
                <div class="main" colspan="2" style="padding-bottom:10px;"><?php echo $authors_description; ?></div>
                <?php } ?>
                <?php if (tep_not_null($authors_url)) { ?>
                <div class="main"><?php echo sprintf(TEXT_MORE_INFORMATION, $authors_url); ?></div>
              <?php } ?>
         
          <div><?php include('includes/modules/article_manager/article_listing.php'); ?></div>
      
  <?php  
  } else { // default page
  ?>
     <div class="article-sub-title"><?php echo ((isset($_GET['showarticles'])) ? TEXT_CURRENT_ARTICLES : TEXT_CURRENT_BLOG_ARTICLES); ?></div>
     <?php
     $articles_all_array = [];
     $articles_all_query_raw = "select a.articles_id, a.articles_date_added, a.articles_is_blog, ad.articles_name, ad.articles_description, au.authors_id, au.authors_name, td.topics_id, td.topics_name from articles a left join articles_to_topics a2t on a.articles_id = a2t.articles_id left join topics_description td on a2t.topics_id = td.topics_id left join authors au on a.authors_id = au.authors_id left join articles_description ad on a.articles_id = ad.articles_id  where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_status = '1' " . $showBlogArticles . " and ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and td.language_id = '" . (int)$_SESSION['languages_id'] . "' order by a.articles_sort_order, a.articles_date_added desc, ad.articles_name";
     $listing_sql = $articles_all_query_raw;
     ?>
     <div><?php include('includes/modules/article_manager/article_listing.php'); ?></div>  
     <div><?php include('includes/modules/article_manager/articles_upcoming.php'); ?></div>
  <?php 
  } 
  ?>
  </div>
 </div>
 
 <div class="row">
  <div class="col buttonSet text-right">
    <?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'far fa-hand-point-right', tep_href_link('index.php')); ?>
  </div>
 </div>
 
<?php 
require $oscTemplate->map_to_template('template_bottom.php', 'component'); 
 
 
