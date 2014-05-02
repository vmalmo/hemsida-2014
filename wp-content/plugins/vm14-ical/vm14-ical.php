<?php
/*
  Plugin Name: VM14 iCal Endpoint
  Description: Adds an endpoint for suscribing to calendar event using the ICS format.
  Version: 0.1
  Author: Vänsterpartiet Malmö tech
  Author URI: http://www.vmalmo.se/
*/

class VM14_ICal_Endpoint{
	
    const DATE_FORMAT = 'Ymd\THis\Z';
	
	/** Hook WordPress
	*	@return void
	*/
	public function __construct(){
        $this->domain = preg_replace('/^www\./', '', $_SERVER['SERVER_NAME']);

        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));

		add_filter('query_vars', array($this, 'add_query_vars'), 0);
		add_action('parse_request', array($this, 'sniff_requests'), 0);
	}	
	
    public function activate() {
        add_rewrite_rule('^calendar.ics','index.php?__vm14_ics=1','top');
        flush_rewrite_rules();
    }

    public function deactivate() {
        //flush_rewrite_rules();
    }

	/** Add public query vars
	*	@param array $vars List of current public query vars
	*	@return array $vars 
	*/
	public function add_query_vars($vars){
		$vars[] = '__vm14_ics';
		return $vars;
	}
	

	public function sniff_requests(){
		global $wp;
		if(isset($wp->query_vars['__vm14_ics'])){
			$this->handle_request();
			exit;
		}
	}
	
	/** Handle Requests
	*	@return void 
	*/
	protected function handle_request(){
        header('Content-Type: text/calendar;encoding=utf8');

        $this->printl('BEGIN:VCALENDAR');
        $this->printl('VERSION:2.0');
        $this->printl('PRODID:-//%s/calendar//NONSGML v1.0//EN', $this->domain);

        $posts = vm14_get_posts(array(
            'post_type' => 'calendar_event',
            'posts_per_page' => '-1',
        ));

        foreach ($posts as $post) {
            $this->printe($post);
        }

        $this->printl('END:VCALENDAR');
        exit;
	}

    private function printl($str) {
        $args = func_get_args();
        array_shift($args);
        vprintf($str."\n", $args);
    }

    private function printe($event) {
        $this->printl('BEGIN:VEVENT');
        $this->printl('UID:%d@%s', $event->id, $this->domain);
        $this->printl('DTSTAMP:%s', $event->date(self::DATE_FORMAT));
        $this->printl('ORGANIZER;CN=John Doe:MAILTO:john.doe@example.com');
        $this->printl('DTSTART:%s', $event->start_datetime(self::DATE_FORMAT));
        $this->printl('DTEND:%s', $event->end_datetime(self::DATE_FORMAT));
        $this->printl('SUMMARY:'.$event->title);
        $this->printl('END:VEVENT');
    }
}
new VM14_ICal_Endpoint();
