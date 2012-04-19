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
		
		// Get the number of seconds since 12am
		$start_seconds = ($start_date->format('h') * 3600) 
							+ ($start_date->format('i') * 60) 
							+ $start_date->format('s');

		// Running time in seconds
		$running_seconds = $end_date->getTimestamp() - $start_date->getTimestamp();

		// Calculate percentages
		$start_time_percentage = ceil($start_seconds / 86400 * 100);
		$running_time_percentage = ceil($running_seconds / 86400 * 100);

		// Vars
		return $this->EE->TMPL->parse_variables($this->EE->TMPL->tagdata, array(
			array(
				'start_time_percentage' => $start_time_percentage,
				'running_time_percentage' => $running_time_percentage,
			)
		));

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