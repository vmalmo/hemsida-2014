<?php
/*
  Plugin Name: VM14 API Endpoint
  Description: Adds an API endpoint for json paging
  Version: 0.1
  Author: Vänsterpartiet Malmö tech
  Author URI: http://malmo.vansterpartiet.se/
*/

class VM14_API_Endpoint{
	
	
	/** Hook WordPress
	*	@return void
	*/
	public function __construct(){
		add_filter('query_vars', array($this, 'add_query_vars'), 0);
		add_action('parse_request', array($this, 'sniff_requests'), 0);
		add_action('init', array($this, 'add_endpoint'), 0);
	}	
	
	/** Add public query vars
	*	@param array $vars List of current public query vars
	*	@return array $vars 
	*/
	public function add_query_vars($vars){
		$vars[] = '__vm14_api';
		$vars[] = 'page';
		$vars[] = 'custom_type';
		$vars[] = 'html';
		$vars[] = 'posts_per_page';
		return $vars;
	}
	
	/** Add API Endpoint
	*	@return void
	*/
	public function add_endpoint(){
   //TODO fix decent endpoint url
   // add_rewrite_rule('^api/vm14/?([0-9]+)?/?','index.php?__vm14_api=1&custom_type=$matches[1]','top');
	}

	public function sniff_requests(){
		global $wp;
		if(isset($wp->query_vars['__vm14_api'])){
			$this->handle_request();
			exit;
		}
	}
	
	/** Handle Requests
	*	@return void 
	*/
	protected function handle_request(){
		global $wp;
		$type = $wp->query_vars['custom_type'];
		$page = isset($wp->query_vars['page']) ? $wp->query_vars['page'] : 0;
    $size = isset($wp->query_vars['posts_per_page']) ? $wp->query_vars['posts_per_page'] : 200;
    $args = array(
      'post_type' => $type,
      'posts_per_page' => $size,
      'paged' => $page,
      'order'=>'ASC'
    );
    if ($type === 'contact_person') {
      $args['orderby'] = 'meta_value';
      $args['meta_key'] = 'contact_person_last_name';
    }
    else if($type === 'calendar_event') {
      $today = date('Ymd', strtotime(strtotime("now"). ' + 1 days'));
      $args['orderby'] = 'meta_value';
      $args['meta_key'] = 'calendar_event_start_date';
      $args['meta_query'] = array(
        array(
          'key' => 'calendar_event_end_date',
          'value' => $today,
          'type' => 'numeric',
          'compare' => '>='
        )
      );
    }
   $html = isset($wp->query_vars['html']) ? TRUE : FALSE;

    $posts = vm14_get_posts($args);
    $this->send_response($posts, $html);
	}
	
	/** Response Handler
	*	This sends a JSON response to the browser
	*/
	protected function send_response($msg, $html = FALSE){
		header('content-type: application/json; charset=utf-8');
    $response = array();
    foreach ($msg as $post) {
      if ($html) {
        $li = sprintf('<li class="filterable" data-tags="%s" data-categories="%s">%s</li>',
          $post->tags_as_string(),
          $post->categories_as_string(),
          $post->preview_html());
        array_push($response, $li);
      }
      else {
        // need post_data to be public to do tis
        //array_push($response, $post->post_data);
      }
    }
    echo json_encode($response);
    exit;

	}
}
new VM14_API_Endpoint();
