<?php
  $breadcrumb->add(NAVBAR_TITLE_DEFAULT, tep_href_link('article-topics.php'));

  require $oscTemplate->map_to_template('template_top.php', 'component');
?>

<h1 class="display-4"><?php echo HEADING_ARTICLE_TOPICS; ?></h1>

<div class="row">
  <div class="col">
   <?php
    $topics_array = array();
    $topics_array = tep_get_topics($topics_array);
    $totalTopics = count($topics_array);
 
    if ($totalTopics == 0) {
    ?>
       <div class="main" ><?php echo TEXT_ARTICLE_TOPICS_NOT_FOUND; ?></div>
    <?php
    } else { 
       for ($i = 0; $i < $totalTopics; ++$i) {
          $articles_query = tep_db_query("select a.articles_id, a.articles_is_blog, ad.articles_name, ad.articles_description from articles a left join articles_description ad on a.articles_id = ad.articles_id left join articles_to_topics a2t on a.articles_id = a2t.articles_id where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_status = '1'  and a2t.topics_id = " . tep_db_input($topics_array[$i]['id']) . " and ad.language_id = '" . (int)$languages_id . "' order by ad.articles_name");
    
          if ($topics_array[$i]['parent'] == 0) {
             echo '<div><hr style="border solid 2px;"></div>';
          }
          
          echo '<div class="main"><a href="' . tep_href_link('articles.php', 'tPath='.$topics_array[$i]['id']) . '"><b>' . $topics_array[$i]['text'] . '</b></a> ( ' . tep_count_articles_in_topic($topics_array[$i]['id']) . ' ) </div>';
          echo '<div>';
          
          while ($articles = tep_db_fetch_array($articles_query)) {
             $page = ($articles['articles_is_blog'] ? 'article_blog.php' : 'article_info.php');
             $shortDescr = substr($articles['articles_description'], 0, 40);
             echo '<div style="width:100%">'; 
             echo '<div class="smallText" style="display:inline-block; padding-left:6px"><a href="' . tep_href_link($page, 'articles_id='.$articles['articles_id']) . '">' . strip_tags($articles['articles_name']) . '</a> - ' . strip_tags($shortDescr). '<span style="color:#ff0000;">...more</span></div>';
             echo '</div>';
          }
          echo '</div>';
      }
   } // end of else
   ?> 

  </div>
</div>

<?php
  require $oscTemplate->map_to_template('template_bottom.php', 'component');
