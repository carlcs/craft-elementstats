<?php
namespace Craft;

class ElementStatsVariable
{
    // Public Methods
    // =========================================================================

    public function getStats()
    {
        return craft()->elementStats_stats->getStats();
    }

    public function getStatByHandle($handle)
    {
        return craft()->elementStats_stats->getStatByHandle($handle);
    }
}
