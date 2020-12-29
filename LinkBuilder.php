<?php
/**
 * LinkBuilder class create linking across the site using the defined sitemap
 * in settings.php
 *
 * PHP version 7.0.0
 *
 * @category Navigation
 * @package  Module/Sitemap
 * @author   Jaime Rodriguez <hi.i.am.jaime@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  GIT: 1.0.0
 * @link     http://sleepymustache.com
 */

namespace Module\Sitemap;

use Sleepy\Core\Hook;
use Sleepy\Core\Module;

/**
 * LinkBuilder Module
 *
 * @category Navigation
 * @package  Module/Sitemap
 * @author   Jaime Rodriguez <hi.i.am.jaime@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     http://sleepymustache.com
 */
class LinkBuilder extends Module
{
    /**
     * Define the hook points
     */
    public $hooks = [
        'linkbuilder_preprocess'    => 'setup',
        'render_placeholder_smlink' => 'createLink',
        'render_placeholder_smlink.title' => 'getTitle',
        'render_placeholder_smlink.link' => 'getLink',
        'render_placeholder_smlink.target' => 'getTarget',
    ];

    /**
     * Setup the Environment settings
     *
     * @return void
     */
    public function setup() 
    {
        // Sitemap data is defined in settings.php as a global
        $this->sitemap = new \Module\Sitemap\Helper();
    }
 
    /**
     * Starts the timer when the framework loads.
     *
     * @return void
     */
    public function createLink()
    {
        $args = func_get_args();
        $page_id = $args[1];
        // Remove the first two arguments
        array_shift($args);
        array_shift($args);

        // Clean surrounding quotes
        $title = count($args) ? trim(trim(implode(" ", $args), '"'), "'") : $this->sitemap->title($page_id);
        $link = $this->sitemap->link($page_id);
        $target = $this->sitemap->target($page_id);

        return "<a href=\"{$link}\" target=\"{$target}\">{$title}</a>";
    }

    /**
     * Starts the timer when the framework loads.
     *
     * @return void
     */
    public function getLink()
    {
        $args = func_get_args();
        $page_id = $args[1];
        return $this->sitemap->link($page_id);
    }

    /**
     * Starts the timer when the framework loads.
     *
     * @return void
     */
    public function getTarget()
    {
        $args = func_get_args();
        $page_id = $args[1];
        return $this->sitemap->target($page_id);
    }

    /**
     * Starts the timer when the framework loads.
     *
     * @return void
     */
    public function getTitle()
    {
        $args = func_get_args();
        $page_id = $args[1];
        
        // Remove the first two arguments
        array_shift($args);
        array_shift($args);

        // Clean surrounding quotes
        return count($args) ? trim(trim(implode(" ", $args), '"'), "'") : $this->sitemap->title($page_id);
    }
}

Hook::register(new LinkBuilder());