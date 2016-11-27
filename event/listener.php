<?php
/**
*
* HTTPS Redirection extension for the phpBB Forum Software package.
*
* @copyright (c) 2014 ErnadoO <http://www.phpbb-services.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace ernadoo\httpsredirection\event;

/**
* Event listener
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/** @var \phpbb\request\request */
	protected $request;

	/**
	* Constructor
	*
	* @param \phpbb\request\request	$request	Request object
	* @access public
	*/
	public function __construct(\phpbb\request\request $request)
	{
		$this->request = $request;
	}

	/**
	* Assign functions defined in this class to event listeners in the core
	*
	* @return	array
	* @static
	* @access	public
	*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.common'	=> 'set_header',
		);
	}

	public function set_header()
	{
		if (!$this->request->is_secure() && PHP_SAPI != 'cli')
		{
			header('Location: https://' . $this->request->server('HTTP_HOST') . $this->request->server('REQUEST_URI'), true, 301);
		}
	}
}