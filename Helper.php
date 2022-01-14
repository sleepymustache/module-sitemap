<?php
/**
 * The Sitemap Helper
 *
 * PHP version 7.0.0
 *
 * @category Module
 * @package  Module/Sitemap
 * @author   Jaime Rodriguez <hi.i.am.jaime@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @version  GIT: 1.0.0
 * @link     http://sleepymustache.com
 */

namespace Module\Sitemap;

use Sleepy\Core\Module;

/**
 * The Sitemap class
 *
 * PHP version 7.0.0
 *
 * @category Module
 * @package  Module/Sitemap
 * @author   Jaime Rodriguez <hi.i.am.jaime@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     http://sleepymustache.com
 */
class Helper
{
    /**
     * JSON Sitemap data
     *
     * @var string
     */
    public static $data = SITEMAP;

    /**
     * Decoded self::$data
     *
     * @var object
     */
    private static $_data;

    /**
     * Helper variable for storing search results
     *
     * @var object
     */
    private static $_result;

    /**
     * Initialized the sitemap
     *
     * @return void
     */
    private static function _initialize()
    {
        if (empty(self::$_data)) {
            self::$_data = json_decode(self::$data);
        }
    }

    /**
     * Helper method to traverse the self::$_data tree
     *
     * @param object $tree A JSON tree
     * @param string $id   The sitemap ID
     *
     * @return object       A JSON tree
     */
    private static function _getPageHelper($tree, $id)
    {
        $leaf = array_pop($tree);

        if ($leaf === null || isset(self::$_result)) {
            return;
        }

        if ($leaf->id == $id) {
            self::$_result = $leaf;
            return;
        }

        if (isset($leaf->pages)) {
            self::_getPageHelper($leaf->pages, $id);
        }

        return self::_getPageHelper($tree, $id);
    }

    /**
     * Gets a page and children based on it's ID
     *
     * @param string $id The page ID
     *
     * @return object     A JSON tree
     */
    private static function _getPage($id)
    {
        self::$_result = null;

        self::_getPageHelper(self::$_data->pages, $id);

        if (!isset(self::$_result)) {
            throw new \Exception('Sitemap: Page not found.');
        }

        return self::$_result;
    }

    /**
     * Returns a link from a page in the JSON tree
     *
     * @param string $id The sitemap ID
     *
     * @return string     The link for the page
     */
    public static function link($id)
    {
        self::_initialize();
        $page = self::_getPage($id);

        return $page->link;
    }

    /**
     * Returns a target from a page in the JSON tree
     *
     * @param string $id The sitemap
     *
     * @return string     The target for the page
     */
    public static function target($id)
    {
        self::_initialize();
        $page = self::_getPage($id);

        return $page->target;
    }

    /**
     * Returns a title from a page in the JSON tree
     *
     * @param string $id The sitemap ID
     *
     * @return string     The title for the page
     */
    public static function title($id)
    {
        self::_initialize();
        $page = self::_getPage($id);

        return $page->title;
    }

    /**
     * Returns a page and its children from the JSON tree
     *
     * @param string $id The sitemap ID
     *
     * @return string     A JSON tree
     */
    public static function getNav($id)
    {
        self::_initialize();
        $page = self::_getPage($id);

        return $page;
    }
}
