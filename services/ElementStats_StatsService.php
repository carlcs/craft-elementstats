<?php
namespace Craft;

class ElementStats_StatsService extends BaseApplicationComponent
{
    // Properties
    // =========================================================================

    private $_statsConfig;

    // Public Methods
    // =========================================================================

    /**
     * Returns all stats.
     *
     * @return array
     */
    public function getStats()
    {
        $statsConfig = $this->getStatsConfig();

        return ElementStats_StatModel::populateModels($statsConfig);
    }

    /**
     * Returns a stat by its handle.
     *
     * @param int $handle
     *
     * @return ElementStats_StatModel
     */
    public function getStatByHandle($handle)
    {
        $statsConfig = $this->getStatsConfig();

        if (!empty($statsConfig[$handle])) {
            return ElementStats_StatModel::populateModel($statsConfig[$handle]);
        }
    }

    public function getStatsConfig()
    {
        if (!$this->_statsConfig) {
            $this->_statsConfig = craft()->config->get('stats', 'elementstats');

            foreach ($this->_statsConfig as $handle => &$attributes) {
                // Set the handle attribute
                $attributes['handle'] = $handle;

                // Set the dateColumn attribute if it's not set
                if (empty($attributes['dateColumn']) && !empty($attributes['elementType'])) {
                    $attributes['dateColumn'] = $this->getDefaultDateColumn($attributes['elementType']);
                }
            }
        }

        return $this->_statsConfig;
    }

    // Protected Methods
    // =========================================================================

    protected function getDefaultDateColumn($elementType)
    {
        $defaultDateColumns = craft()->config->get('defaultDateColumns', 'elementstats');

        if (!empty($defaultDateColumns[$elementType])) {
            return $defaultDateColumns[$elementType];
        }
    }
}
