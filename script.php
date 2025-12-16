<?php
/**
 * @package     PKG_JCE_Dynamic_Links_Search
 * @copyright   Copyright (C) 2025 Ponto Mega. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Installer\InstallerAdapter;
use Joomla\CMS\Installer\InstallerScriptInterface;
use Joomla\CMS\Language\Text;

/**
 * Installation script for JCE Dynamic Links Search Package
 */
class pkg_jce_dynamic_links_searchInstallerScript implements InstallerScriptInterface
{
    /**
     * Minimum Joomla version required to install the package
     *
     * @var    string
     */
    protected $minimumJoomla = '4.0';

    /**
     * Minimum PHP version required to install the package
     *
     * @var    string
     */
    protected $minimumPhp = '7.4';

    /**
     * Function called before extension installation/update/removal procedure commences
     *
     * @param   string            $type    The type of change (install or discover_install, update, uninstall)
     * @param   InstallerAdapter  $parent  The class calling this method
     *
     * @return  boolean  True on success
     */
    public function preflight($type, $parent)
    {
        // Check minimum Joomla version
        if (version_compare(JVERSION, $this->minimumJoomla, '<')) {
            Factory::getApplication()->enqueueMessage(
                sprintf(
                    Text::_('PKG_JCE_DYNAMIC_LINKS_SEARCH_JOOMLA_VERSION_ERROR'),
                    $this->minimumJoomla
                ),
                'error'
            );
            return false;
        }

        // Check minimum PHP version
        if (version_compare(PHP_VERSION, $this->minimumPhp, '<')) {
            Factory::getApplication()->enqueueMessage(
                sprintf(
                    Text::_('PKG_JCE_DYNAMIC_LINKS_SEARCH_PHP_VERSION_ERROR'),
                    $this->minimumPhp
                ),
                'error'
            );
            return false;
        }

        return true;
    }

    /**
     * Function called after extension installation/update/removal procedure commences
     *
     * @param   string            $type    The type of change (install, update or discover_install)
     * @param   InstallerAdapter  $parent  The class calling this method
     *
     * @return  boolean  True on success
     */
    public function postflight($type, $parent)
    {
        $app = Factory::getApplication();

        if ($type === 'install' || $type === 'update') {
            $app->enqueueMessage(
                Text::_('PKG_JCE_DYNAMIC_LINKS_SEARCH_INSTALLATION_SUCCESS'),
                'message'
            );
            
            $app->enqueueMessage(
                Text::_('PKG_JCE_DYNAMIC_LINKS_SEARCH_NEXT_STEPS'),
                'info'
            );
        }

        return true;
    }

    /**
     * Runs right after any installation action
     *
     * @param   InstallerAdapter  $adapter  Adapter object calling object
     *
     * @return  bool True on success
     */
    public function install(InstallerAdapter $adapter): bool
    {
        return true;
    }

    /**
     * Runs right after any update action
     *
     * @param   InstallerAdapter  $adapter  Adapter object calling object
     *
     * @return  bool True on success
     */
    public function update(InstallerAdapter $adapter): bool
    {
        return true;
    }

    /**
     * Runs right after any uninstall action
     *
     * @param   InstallerAdapter  $adapter  Adapter object calling object
     *
     * @return  bool True on success
     */
    public function uninstall(InstallerAdapter $adapter): bool
    {
        return true;
    }
}
