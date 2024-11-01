<?php

if( ! class_exists( 'yaawp_amazon' ) ) {

  class yaawp_amazon extends yaawp {

    private $request = '';

    function __construct () {

      parent::__construct();

      $this->yaawp_amazon_int();

    }

    function yaawp_amazon_int() {

      $this->table_name = $this->yaawp_db->prefix."yaawp_nodes";

    }

    function ItemSearch($Keywords, $SearchIndex, $ItemPage, $ResponseGroup, $BrowseNode = NULL) {

      $eingang  = array('%C3%84','%C3%A4','%C3%96','%C3%B6','%C3%9C','%C3%BC','%C3%9F','%3C','%3E','%28','%29','%7B','%7D','%5B','%5D','%2F','%5C%5C','%2B',' ');         
      $ausgang  = array('Ae','ae','Oe','oe','Ue','ue','ss','no','nie','nicht','nein','na','nae','nee','nu','lr','rl','+','+');
      $Keyword  = str_replace($eingang,$ausgang,$Keywords);
  
      $url_params = array(
        'Keywords'      => urlencode($Keyword),
        'SearchIndex'   => urlencode($SearchIndex),
        'ItemPage'      => $ItemPage,
        'ResponseGroup' => $ResponseGroup,
        'Operation'     => 'ItemSearch'
      );

      if ($BrowseNode) {
        $url_params['BrowseNode'] = $BrowseNode;
      }

      return ($this->buildRequest($url_params))?$this->sendRequest():false;
    }

    function BrowseNodeLookup ($BrowseNodeId) {

      $url_params = array(
        'BrowseNodeId'  => $BrowseNodeId,
        'Operation'     => 'BrowseNodeLookup'
      );
      
      return ($this->buildRequest($url_params))?$this->sendRequest():false;
    }

    function ItemLookup ($asin, $ResponseGroup = 'Large') {

      $url_params = array(
        'ItemId'        => $asin,
        'ResponseGroup' => $ResponseGroup,
        'Operation'     => 'ItemLookup'
      );
      
      return ($this->buildRequest($url_params))?$this->sendRequest():false;
    }

    private function buildRequest ($url_params) {

      if( empty($url_params) || !is_array($url_params) ) return false;

      if ( ! get_option('yaawp_secret_access_key') || ! get_option('yaawp_access_key_id') || ! get_option('yaawp_associate_id') ) {
        return false;
      }

      $secret_access_key = get_option('yaawp_secret_access_key');
      $access_key_id = get_option('yaawp_access_key_id');
      $associate_id = get_option('yaawp_associate_id');

      $basic_url_params = array(
        'AWSAccessKeyId'  => $access_key_id,
        'AssociateTag'    => $associate_id,
        'Service'         => 'AWSECommerceService',
        'Timestamp'       => urlencode(gmdate('Y-m-d\TH:i:s\Z'))
      );

      $final_url_params = array_merge($basic_url_params,$url_params);

      $url_parts = array();
      foreach(array_keys($final_url_params) as $key) $url_parts[] = $key.'='.$final_url_params[$key];
      sort($url_parts);
        
      $alleparameter = implode('&',$url_parts);

      $stringsignr  = "GET\n"."ecs.amazonaws.de"."\n"."/onca/xml"."\n".$alleparameter;
      $signature1   = base64_encode(hash_hmac("sha256", $stringsignr, $secret_access_key, true));
      $signature2   = urlencode($signature1);

      $this->request = "http://ecs.amazonaws.de/onca/xml?".$alleparameter."&Signature=".$signature2;
      return true;
    }

    private function sendRequest () {

      if($this->request === '') return false;
      $c = curl_init($this->request);
      curl_setopt($c, CURLOPT_HEADER, false);
      curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
      $response = curl_exec($c);
      curl_close($c);

      return simplexml_load_string($response);
    }
  }
}

?>