<?php
/**
 *
 * @author Oakensoul (http://www.oakensoul.com/)
 * @link https://github.com/oakensoul/Cornerstone for the canonical source repository
 * @copyright Copyright (c) 2013 Robert Gunnar Johnson Jr.
 * @license http://opensource.org/licenses/BSD-2-Clause BSD-2-Clause
 * @package Cornerstone
 */
namespace Cornerstone\Http\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class ExceptionController extends AbstractActionController
{

    public function indexAction ()
    {
        throw new \Exception('This is an example exception.');
    }
}