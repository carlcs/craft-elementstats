<?php
namespace Craft;

class ElementStats_ChartsController extends BaseController
{
    // Public Methods
    // =========================================================================

    /**
     * Returns the data needed to display a stats chart.
     */
    public function actionGetStatsData()
    {
        $statHandle = craft()->request->getRequiredPost('statHandle');
        $startDateParam = craft()->request->getRequiredPost('startDate');
        $endDateParam = craft()->request->getRequiredPost('endDate');

        $stat = craft()->elementStats_stats->getStatByHandle($statHandle);

        if (!$stat) {
            $this->returnErrorJson(Craft::t('Could not find the selected stat.'));
        }

        if (!$stat->elementType || !$stat->dateColumn) {
            $this->returnErrorJson(Craft::t('The stat does not support chart view.'));
        }

        // Prep the query
        try {
            $criteria = $stat->getCriteria();
        } catch (\Exception $e) {
            ElementStatsPlugin::log('There was an error while generating the stats. '.$e->getMessage(), LogLevel::Error);
            $this->returnErrorJson(Craft::t('There was an error while generating the stats.'));
        }

        $query = craft()->elements->buildElementsQuery($criteria);

        $query->select('COUNT(*) as value');

        // Query debugging
        // ElementStatsPlugin::log(print_r($query->getText(), true), LogLevel::Info, true);

        // Prep the dates
        $startDate = DateTime::createFromString($startDateParam, craft()->timezone);
        $endDate = DateTime::createFromString($endDateParam, craft()->timezone);
        $endDate->modify('+1 day');

        $intervalUnit = 'day';

        // Get the chart data table
        $dataTable = ChartHelper::getRunChartDataFromQuery($query, $startDate, $endDate, $stat->dateColumn, [
            'intervalUnit' => $intervalUnit,
            'valueLabel' => Craft::t('Value'),
        ]);

        // Get the total number of elements
        $total = 0;

        foreach($dataTable['rows'] as $row) {
            $total = $total + $row[1];
        }

        // Return everything
        $this->returnJson([
            'dataTable' => $dataTable,
            'total' => $total,
            'formats' => ChartHelper::getFormats(),
            'orientation' => craft()->locale->getOrientation(),
            'scale' => $intervalUnit,
        ]);
    }
}
