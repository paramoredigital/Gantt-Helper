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
	 */
	public function __construct() {
		$this->EE =& get_instance();
	}
	
	// ----------------------------------------------------------------
	
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