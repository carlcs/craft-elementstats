<?php
namespace Craft;

class ElementStatsVariable
{
    // Public Methods
    // =========================================================================

    /**
     * Returns all stats.
     *
     * @return array
     */
    public function getStats()
    {
        return craft()->elementStats_stats->getStats();
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
        return craft()->elementStats_stats->getStatByHandle($handle);
    }
}
