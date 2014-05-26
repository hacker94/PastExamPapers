<?php


  // functions
  function wrap_ul($lis) {
    return '<ul class="nav nav-tabs">  '.$lis.'  </ul>';
  }

  function wrap_li($content, $act, $id) {
    if ($act) {
      return '<li id="'.$id.'" class="litab active">'.$content.'</li>';
    } else {
      return '<li id="'.$id.'" class="litab">'.$content.'</li>';
    }
  }
  
  function wrap_a($href, $toggle, $content) {
    if ($toggle) {
      return '<a href="'.$href.'" data-toggle="tab">'.$content.'</a>';
    } else {
      return '<a href="'.$href.'">'.$content.'</a>';
    }
  }
  
  function strip_suffix($name) {
    return substr($name, 0, strlen($name) - strlen(strrchr($name, '.')));
  }

  // vars
  $tabs = array();

  // build paper structure
  $paper_root = "../papers";
  $papers = dir($paper_root);
  while ($tab = $papers->read()) {
    if (is_dir($paper_root.'/'.$tab) && $tab != '.' && $tab != '..') {
      $tabs[] = $tab;
    }
  }
  sort($tabs);
  
  // nav
  $lis = '';
  if (isset($_COOKIE["lasttab"])) {
    $lasttab = $_COOKIE["lasttab"];
    foreach ($tabs as $tab) {
      if ($lasttab == 'tab'.$tab) {
        $act = true;
      } else {
        $act = false;
      }
      $lis = $lis.wrap_li(wrap_a('#'.$tab, true, $tab), $act, 'tab'.$tab);
    }
  } else {
    $first = true;
    foreach ($tabs as $tab) {
      $lis = $lis.wrap_li(wrap_a('#'.$tab, true, $tab), $first, 'tab'.$tab);
      $first = false;
    }
  }
  echo wrap_ul($lis);
  
  // table
  echo '<div class="tab-content">';
  $first = true;
  foreach ($tabs as $tab) {
    if (isset($_COOKIE["lasttab"])) {
      if ($lasttab == 'tab'.$tab) {
        echo '<div class="tab-pane fade in active" id="'.$tab.'">';
      } else {
        echo '<div class="tab-pane fade" id="'.$tab.'">';
      }
    } else {
      if ($first) {
        echo '<div class="tab-pane fade in active" id="'.$tab.'">';
      } else {
        echo '<div class="tab-pane fade" id="'.$tab.'">';
      }
      $first = false;
    }
    echo '<table class="table table-bordered table-hover"><tbody>';
    $year = dir($paper_root.'/'.$tab);
    $courses = array();
    while ($course = $year->read()) {
      if (is_dir($paper_root.'/'.$tab.'/'.$course) && $course != '.' && $course != '..') {
        $courses[] = $course;
        
      }
    }    
    sort($courses);
    
    foreach ($courses as $course) {
      $cou = dir($paper_root.'/'.$tab.'/'.$course);
      $paperarr = array();
      while ($paper = $cou->read()) {
        if ($paper != '.' && $paper != '..') {
          $paperarr[] = $paper;
        }
      }
      sort($paperarr);
      echo '<tr><th>'.$course.'</th><td>';
      $a = true;
      foreach ($paperarr as $paper) {
          if (!$a) {
            echo '&nbsp;/&nbsp;';
          }
          echo wrap_a($paper_root.'/'.$tab.'/'.$course.'/'.$paper, false, strip_suffix($paper));
          $a = false;
      }
      echo '</td></tr>';
    }                  
    echo '</tbody></table></div>';
    $first = false;
  }
  echo "</div>";


?>