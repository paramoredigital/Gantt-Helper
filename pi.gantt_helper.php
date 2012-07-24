<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2003 - 2011, EllisLab, Inc.
 * @license		http://expressionengine.com/user_guide/license.html
 * @link		http://expressionengine.com
 * @since		Version 2.0
 * @filesource
 */
 
// ------------------------------------------------------------------------

/**
 * Gantt Helper Plugin
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Plugin
 * @author		Jesse Bunch
 * @link		http://paramore.is/
 */

$plugin_info = array(
	'pi_name'		=> 'Gantt Helper',
	'pi_version'	=> '1.0',
	'pi_author'		=> 'Jesse Bunch',
	'pi_author_url'	=> 'http://paramore.is/',
	'pi_description'=> 'Helpful functions for facilitating a Gantt-style calendar.',
	'pi_usage'		=> Gantt_helper::usage()
);


class Gantt_helper {

	public $return_data;
    
	/**
	 * Constructor
	 * @author Jesse Bunch
	*/
	public function __construct() {
		$this->EE =& get_instance();
	}

	/**
	 * Calculates an event's running time as a
	 * percentage of one day
	 * @author Jesse Bunch
	*/
	public function percentage_of_single_day() {
		
		// Fetch times, in format %Y-%m-%d %g:%i %a
		$start_time = $this->EE->TMPL->fetch_param('start_time');
		$end_time = $this->EE->TMPL->fetch_param('end_time');
		$date_format = $this->EE->TMPL->fetch_param('format');
		$total_pixels = $this->EE->TMPL->fetch_param('total_pixels');

		// Parse Dates
		$start_date = DateTime::createFromFormat($date_format, $start_time);
		$end_date = DateTime::createFromFormat($date_format, $end_time);

		// If the days are the same, but the end hour is less
		// than the start hour, increment the end date. This deals
		// with a bug in the calendar module
		if (($start_date->format('d') == $end_date->format('d'))
			&& $end_date->format('G') < $start_date->format('G')) {
			$end_date->add(new DateInterval('P1D'));
		}

		// Some counters
		$day_start_hour = 7; // Day starts at xAM
		$hours_per_day = 24 - $day_start_hour + 1; // We include 12am here

		// Start and end hours
		$start_hour = $start_date->format('H') - $day_start_hour;
		$end_hour = $end_date->format('H') - $day_start_hour;

		// Add half hours
		$start_hour += ($start_date->format('i') < 30) ? 0 : 0.5;
		$end_hour += ($end_date->format('i') < 30) ? 0 : 0.5;

		// Account for 12am the next day
		if ($end_date->format('H') == 0) {
			$end_hour = $hours_per_day;
		}

		// Running time in seconds
		$running_seconds = $end_date->getTimestamp() - $start_date->getTimestamp();

		// Calculate Ratios
		if ($running_seconds == 0) {

			// "All Day" Event
			$start_time_ratio = 0;
			$running_time_ratio = 100;

		} else {
			
			// Intraday Event
			$start_time_ratio = $start_hour / $hours_per_day;
			$running_time_ratio = ($end_hour - $start_hour) / $hours_per_day;

		}

		// Vars
		return $this->EE->TMPL->parse_variables($this->EE->TMPL->tagdata, array(
			array(
				'start_time_percentage' => floor($start_time_ratio * 100),
				'running_time_percentage' => ceil($running_time_ratio * 100),
				'start_time_pixels' => floor($start_time_ratio * $total_pixels),
				'running_time_pixels' => ceil($running_time_ratio * $total_pixels),
			)
		));

	}

	/**
	 * Helper function that basically wraps PHP's strtotime function
	 * @author Jesse Bunch
	*/
	public function string_to_time() {

		$time_string = $this->EE->TMPL->fetch_param('string');
		$format = $this->EE->TMPL->fetch_param('format');
		$relative_date = $this->EE->TMPL->fetch_param('relative_date');

		if (!$relative_date) {
			$relative_date = time();
		} else {
			$relative_date = strtotime($relative_date);
		}

		$new_date = strtotime($time_string, $relative_date);

		return $this->EE->localize->decode_date($format, $new_date);

	}
	
	/**
	 * Plugin Usage
	 */
	public static function usage()
	{
		ob_start();
?>

 Since you did not provide instructions on the form, make sure to put plugin documentation here.
<?php
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}
}


/* End of file pi.gannt_helper.php */
/* Location: /system/expressionengine/third_party/gannt_helper/pi.gannt_helper.php */