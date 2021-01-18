<?php
// calculate topic path
  $tPath = '';
  if (isset($_GET['tPath'])) {
      $tPath = $_GET['tPath'];
  } elseif (isset($_GET['articles_id']) && !isset($_GET['authors_id'])) {
      $tPath = tep_get_article_path($_GET['articles_id']);
  }

  $current_topic_id = 0;
  if (tep_not_null($tPath)) {
      $tPath_array = tep_parse_topic_path($tPath);
      $tPath = implode('_', $tPath_array);
      $current_topic_id = $tPath_array[(sizeof($tPath_array)-1)];
  }

  if (isset($_GET['articles_id']) && ENABLE_HEADER_TAGS_SEO == 'True') {
      $articlesPage = 'article_info.php?articles_id=' . $_GET['articles_id'];
      $pageTags_query = tep_db_query("select page_name, page_title from headertags where page_name like '" . tep_db_input($articlesPage) . "' and language_id = '" . (int)$_SESSION['languages_id'] . "' LIMIT 1");
      if (tep_db_num_rows($pageTags_query) == 1) {
          global $breadcrumb;
          $pageTags = tep_db_fetch_array($pageTags_query);
          $breadcrumb->add('Articles', tep_href_link('articles.php'));
          $breadcrumb->add($pageTags['page_title'], tep_href_link($articlesPage));
      }
  }