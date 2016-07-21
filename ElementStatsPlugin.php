<?php
namespace Craft;

class ElementStatsPlugin extends BasePlugin
{
    public function getName()
    {
        return 'Element Stats Widget';
    }

    public function getVersion()
    {
        return '1.0.1';
    }

    public function getSchemaVersion()
    {
        return '1.0.0';
    }

    public function getDeveloper()
    {
        return 'carlcs';
    }

    public function getDeveloperUrl()
    {
        return 'https://github.com/carlcs';
    }

    public function getDocumentationUrl()
    {
        return 'https://github.com/carlcs/craft-elementstats';
    }

    public function getReleaseFeedUrl()
    {
        return 'https://github.com/carlcs/craft-elementstats/raw/master/releases.json';
    }

    // Public Methods
    // =========================================================================

    /**
     * Make sure requirements are met before installation.
     *
     * @throws Exception
     */
    public function onBeforeInstall()
    {
        if (version_compare(craft()->getVersion(), '2.6', '<')) {
            throw new Exception($this->getName().' plugin requires Craft 2.6 or later.');
        }

        if (!defined('PHP_VERSION') || version_compare(PHP_VERSION, '5.4', '<')) {
            throw new Exception($this->getName().' plugin requires PHP 5.4 or later.');
        }
    }
}
