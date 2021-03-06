<?php
/**
 *
 * @author Oakensoul (http://www.oakensoul.com/)
 * @link https://github.com/oakensoul/Cornerstone for the canonical source repository
 * @copyright Copyright (c) 2013 Robert Gunnar Johnson Jr.
 * @license http://opensource.org/licenses/BSD-2-Clause BSD-2-Clause
 * @package Cornerstone
 */
namespace Cornerstone\Http\Listener;

use Exception;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\Console;
use Zend\Mvc\Router\Console\RouteMatch;

class Theme extends AbstractListenerAggregate
{

    protected $mServiceLocator;

    /**
     * {@inheritDoc}
     */
    public function attach (EventManagerInterface $events)
    {
        /**
         * add onDispatch event to Dispatcher
         */
        $options = array ();
        $options[] = $this;
        $options[] = 'onRender';

        $this->listeners[] = $events->attach(MvcEvent::EVENT_RENDER, $options, 100);
    }

    public function onRender (MvcEvent $pEvent)
    {
        $request = $pEvent->getRequest();

        // Make sure that we are not running in a console
        if ($request instanceof Console\Request)
        {
            return;
        }

        $application = $pEvent->getApplication();

        // Getting the view helper manager from the application service manager
        $view_helper_manager = $application->getServiceManager()->get('viewHelperManager');

        /* @var $match RouteMatch */
        $match = $pEvent->getRouteMatch();

        if ( false === is_object($match))
        {
            /** if there's no route match, we're in a 404 state, abort */
            return;
        }

        $theme = $match->getParam('theme');

        /**
         * This code basically just makes sure that when we dispatch
         * a route the user is forced to SSL if the route is configured
         * to enable the feature
         */
        if (false === empty($theme))
        {
            $partial = $view_helper_manager->get('partial');



            // @todo should be grabbing the "layout/theme" path from config maybe?
            // or... could allow "theme" to be the full piece from module config...

            // it could be fine since we're already in the listener / strategy, and
            // if someone doesn't like it, they can override it... think about it
            // more when its not 1 am


            $partial('layout/theme/' . $theme);
        }
    }
}