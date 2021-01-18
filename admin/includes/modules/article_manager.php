<?php
  require('includes/functions/articles.php');

  //$tPath = ($_GET['tPath'] ?? '');
  $tPath = (isset($_GET['tPath']) ? $_GET['tPath'] : '');
  
  if (tep_not_null($tPath)) {
      $tPath_array = tep_parse_topic_path($tPath);
      $tPath = implode('_', $tPath_array);
      $current_topic_id = $tPath_array[(sizeof($tPath_array)-1)];
  } else {
      $current_topic_id = 0;
  }