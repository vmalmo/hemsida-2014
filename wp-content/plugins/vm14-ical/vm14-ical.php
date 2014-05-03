<?php
/*
  Plugin Name: VM14 iCal Endpoint
  Description: Adds an endpoint for suscribing to calendar event using the ICS format.
  Version: 0.1
  Author: Vänsterpartiet Malmö tech
  Author URI: http://www.vmalmo.se/
*/

class VM14_ICal_Endpoint{
	
    const DATE_FORMAT = 'Ymd\THis';
	
	/** Hook WordPress
	*	@return void
	*/
	public function __construct(){
        $this->domain = preg_replace('/^www\./', '', $_SERVER['SERVER_NAME']);

        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));

        add_action('save_post', array($this, 'save_post'));
		add_filter('query_vars', array($this, 'add_query_vars'), 0);
		add_action('parse_request', array($this, 'sniff_requests'), 0);

        add_action('admin_init', array($this, 'register_settings'), 0);
        add_action('admin_menu', array($this, 'admin_menu'), 0);
	}	
	
    public function activate() {
        add_rewrite_rule('^calendar.ics','index.php?__vm14_ics=1','top');
        flush_rewrite_rules();
    }

    public function deactivate() {
    }

    public function register_settings() {
        register_setting('vm14-ics', 'vm14_ics_cal_title');
        register_setting('vm14-ics', 'vm14_ics_cal_description');
    }

    public function admin_menu() {
        add_submenu_page('options-general.php', 'ICS endpoint settings', 'ICS endpoint', 'administrator', __FILE__, array($this, 'admin_page'));
    }

    public function admin_page() {
        include(dirname(__FILE__).'/admin.php');
    }

	/** Add public query vars
	*	@param array $vars List of current public query vars
	*	@return array $vars 
	*/
	public function add_query_vars($vars){
		$vars[] = '__vm14_ics';
		return $vars;
	}

    public function save_post($id) {
        $post = get_post($id);
        if ($post->post_type == 'calendar_event') {
            $seq = get_post_meta($id, 'ics_sequence', true);
            if ($seq) {
                update_post_meta($id, 'ics_sequence', (int)$seq+1);
            }
            else {
                add_post_meta($id, 'ics_sequence', 1);
            }
        }
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
        $this->printl('X-WR-CALNAME:%s', get_option('vm14_ics_cal_title', ''));
        $this->printl('X-WR-CALDESC:%s', get_option('vm14_ics_cal_description', ''));
        $this->printl('X-PUBLISHED-TTL:PT30M');

        // Timezone. TODO: Don't hardcode timezone?
        $this->printl('BEGIN:VTIMEZONE');
        $this->printl('TZID:Europe/Stockholm');
        $this->printl('TZURL:http://tzurl.org/zoneinfo-outlook/Europe/Stockholm');
        $this->printl('X-LIC-LOCATION:Europe/Stockholm');
        $this->printl('BEGIN:DAYLIGHT');
        $this->printl('TZOFFSETFROM:+0100');
        $this->printl('TZOFFSETTO:+0200');
        $this->printl('TZNAME:CEST');
        $this->printl('DTSTART:19700329T020000');
        $this->printl('RRULE:FREQ=YEARLY;BYMONTH=3;BYDAY=-1SU');
        $this->printl('END:DAYLIGHT');
        $this->printl('BEGIN:STANDARD');
        $this->printl('TZOFFSETFROM:+0200');
        $this->printl('TZOFFSETTO:+0100');
        $this->printl('TZNAME:CET');
        $this->printl('DTSTART:19701025T030000');
        $this->printl('RRULE:FREQ=YEARLY;BYMONTH=10;BYDAY=-1SU');
        $this->printl('END:STANDARD');
        $this->printl('END:VTIMEZONE');

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
        $seq = get_post_meta($event->id, 'ics_sequence', true);
        if (!$seq)
            $seq = 0;

        $this->printl('BEGIN:VEVENT');
        $this->printl('UID:%d@%s', $event->id, $this->domain);
        $this->printl('DTSTAMP;TZID=Europe/Stockholm:%s', $event->date(self::DATE_FORMAT));
        $this->printl('ORGANIZER;CN=John Doe:MAILTO:john.doe@example.com');
        $this->printl('SEQUENCE:%s', $seq);
        $this->printl('DTSTART;TZID=Europe/Stockholm:%s', $event->start_datetime(self::DATE_FORMAT));
        $this->printl('DTEND;TZID=Europe/Stockholm:%s', $event->end_datetime(self::DATE_FORMAT));
        $this->printl('URL:%s', $event->permalink());
        $this->printl('SUMMARY:'.$event->title);
        $this->printl('END:VEVENT');
    }
}
new VM14_ICal_Endpoint();
