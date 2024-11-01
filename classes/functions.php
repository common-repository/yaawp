<?php

if ( ! function_exists('str_replace_assoc') ) {

	function str_replace_assoc ( $replace, $subject ) {

		if (is_array($replace)) {
			foreach($replace as $k => $v) {
				$subject = str_replace("[[$k]]",$v,$subject);
			}
		}

	   return $subject;    
	}
}

if ( ! function_exists('replace_mutations') ) {

    function replace_mutations ( $input ) {

      $search = array('ä', 'Ä', 'ö', 'Ö', 'ü', 'Ü', 'ß', '\\xC3');
      $replace = array('&auml;', '&Auml;', '&ouml;', '&Ouml;', '&uuml;', '&Uuml;', '&szlig;', '&uuml;');

      return str_replace($search, $replace, $input); 
    }
}

if ( ! function_exists('notice') ) {

    function notice ( $msg, $typ = null ){
      switch( $typ ) {
      	case 'error':
      		echo "<div class='error'><p>{$msg}</p></div>";
      	break;
      	default:
      		echo "<div class='updated'><p>{$msg}</p></div>";
      	break;
      }

    }
}

if ( ! function_exists('error_handler') ) {

	function error_handler ( $output ) {
	  
	  /*
	    [type] => 8
	    [message] => Undefined variable: a
	    [file] => D:\xammp\index.php
	    [line] => 2
	  */
	 
	  $error = error_get_last();
	  return $error['message'];  
	}
}

if ( ! function_exists('compress_html') ) {

	function compress_html ( $compress ) {
		$search = array(
		    '/\>[^\S ]+/s',
		    '/[^\S ]+\</s',
		    '/(\s)+/s'
		    );
		$replace = array(
		    '>',
		    '<',
		    '\\1'
		    );
		$buffer = preg_replace($search, $replace, $compress);

		return $buffer;
    }
}

if ( ! function_exists('density') ) {

    function density ( $input, $max = 3 ) {

      $total = 0;
      $data_1 = array();
      $datas = explode(' ', $input);
      for ($i=0; $i < count($datas) ; $i++) {
        if( !empty($datas[$i]) ) {
          $keyword = strtolower($datas[$i]); $total++;
        }
        $_t = isset($data_1[$keyword]) ? ($data_1[$keyword]+1) : 1;
        $data_1[$keyword] = $_t;
      }

      arsort($data_1);

      $data_2 = array();
      $datas = explode(' ', $input);
      for ($i=0; $i < count($datas) ; $i++) {
        if( !empty($datas[$i]) && !empty($datas[++$i]) ) {
          $keyword1 = strtolower($datas[$i]);
          $keyword2 = strtolower($datas[++$i]);
        }
        $keyword = $keyword1.' '.$keyword2;
        $_t = isset($data_2[$keyword]) ? ($data_2[$keyword]+1) : 1;
        $data_2[$keyword] = $_t;
      }

      arsort($data_2);

      $_d1 = '';      
      $i = 0;
      foreach ( $data_1 as $k => $v ) {
        if ( $i < 5 ) {
          $_d1 .= $k.','; $i++;
        }
      }

      $_d2 = '';
      $i = 0;
      foreach ( $data_2 as $k => $v ) {
        if ( $i < 5 ) {
          $_d2 .= $k.','; $i++;
        }
      }

      return array(
        '1-Wort-Phrase'=>substr($_d1,0,-1),
        '2-Wort-Phrasen'=>substr($_d2,0,-1),
        'Total-Words'=>$total
      );

    }
 }

 if ( ! function_exists('yaawp_sidebar_terms') ) {

    function yaawp_sidebar_terms ( $parent = 0 ) {

	    $mylinks_categories = get_terms('shop_category', 'orderby=count&hide_empty=0&parent='.$parent);
	    $count = count($mylinks_categories);

	    if ( $count > 0 ) {

	        echo '<ul>';
	        foreach ( $mylinks_categories as $k => $term ) {

	            $mylinks_scategories = get_terms('shop_category', 'orderby=count&hide_empty=0&parent='.$term->term_id);
	            $counts = count($mylinks_scategories);

	            if ( $count > 0 ) {

	                echo '<li><a href="'.get_term_link($term->slug, 'shop_category').'" title="'.$term->name.'">'.$term->name.'</a><ul>';

	                foreach ( $mylinks_scategories as $k => $sterm ) {

	                    echo '<li><a href="'.get_term_link($sterm->slug, 'shop_category').'" title="'.$sterm->name.'">'.$sterm->name.'</a></li>';

	                }

	                echo '</ul></li>';

	            } else {

	                echo '<li><a href="'.get_term_link($term->slug, 'shop_category').'" title="'.$term->name.'">'.$term->name.'</a></li>';

	            }

	        }

	        echo '</ul>';

	    }

    }
 }

if ( ! function_exists('yaawp_terms_dropdown_options') ) {

    function yaawp_terms_dropdown_options ( $parent = 0 ) {

	    $mylinks_categories = get_terms('shop_category', 'orderby=count&hide_empty=0&parent='.$parent);
	    $count = count($mylinks_categories);

	    if ( $count > 0 ) {

	        foreach ( $mylinks_categories as $k => $term ) {

	            $mylinks_scategories = get_terms('shop_category', 'orderby=count&hide_empty=0&parent='.$term->term_id);
	            $counts = count($mylinks_scategories);

	            if ( $count > 0 ) {

	                echo '<option value="'.$term->term_id.'">'.utf8_decode($term->name).'</option>';

	                foreach ( $mylinks_scategories as $k => $sterm ) {

	                   echo '<option value="'.$sterm->term_id.'">---'.utf8_decode($sterm->name).'</option>';

	                }

	            } else {

	                echo '<option value="'.$term->term_id.'">'.utf8_decode($term->name).'</option>';

	            }

	        }

	    }

    }
}

?>