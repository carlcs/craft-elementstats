<?php
namespace Craft;

class ElementStats_StatsWidget extends BaseWidget
{
    // Public Methods
    // =========================================================================

    public function getName()
    {
        return Craft::t('Element Stats');
    }

    public function getTitle()
    {
        $settings = $this->getSettings();

        return Craft::t($settings->title);
    }

    public function getBodyHtml()
    {
        $widgetId = $this->model->id;
        $settings = $this->getSettings();

        switch ($settings->view) {
            case 'grid':
            case 'list':
                return $this->getListHtml($widgetId, $settings);
            case 'single':
                return $this->getSingleHtml($widgetId, $settings);
            case 'chart':
                return $this->getChartHtml($widgetId, $settings);
        }
    }

    public function getSettingsHtml()
    {
        craft()->templates->includeCssResource('elementstats/css/widgets.css');

        craft()->templates->includeJsResource('elementstats/js/widgets.js');
        craft()->templates->includeJs('new Craft.ElementStats.WidgetSettings();');

        $statsOptions = [];

        foreach (craft()->elementStats_stats->getStatsConfig() as $stat) {
            $statsOptions[] = ['label' => Craft::t($stat['name']), 'value' => $stat['handle']];
        }

        return craft()->templates->render('elementstats/widgets/stats/settings', [
            'settings' => $this->getSettings(),
            'statsOptions' => $statsOptions,
            'isAdmin' => craft()->userSession->isAdmin(),
        ]);
    }

    // Protected Methods
    // =========================================================================

    protected function getListHtml($widgetId, $settings)
    {
        $stats = [];

        if (!empty($settings->statHandles)) {
            $stats = craft()->elementStats_stats->getStats();

            $stats = array_filter($stats, function($stat) use ($settings) {
                return in_array($stat->handle, $settings->statHandles);
            });
        }

        $error = false;
        $totals = [];

        foreach ($stats as $stat) {
            $totals[$stat->handle] = $stat->getTotal();

            if ($totals[$stat->handle] === null) {
                $error = true;
            }
        }

        return craft()->templates->render('elementstats/widgets/stats/list', [
            'stats' => $stats,
            'totals' => $totals,
            'error' => $error,
            'settings' => $settings,
        ]);
    }

    protected function getSingleHtml($widgetId, $settings)
    {
        $stat = craft()->elementStats_stats->getStatByHandle($settings->statHandle);

        $total = $stat ? $stat->getTotal() : null;

        return craft()->templates->render('elementstats/widgets/stats/single', [
            'stat' => $stat,
            'total' => $total,
            'error' => (!empty($stat) && $total === null),
            'settings' => $settings,
        ]);
    }

    protected function getChartHtml($widgetId, $settings)
    {
        $options = $settings->getAttributes();
        $options['orientation'] = craft()->locale->getOrientation();

        craft()->templates->includeJs('new Craft.ElementStats.ChartWidget('.$widgetId.', '.JsonHelper::encode($options).');');

        return '<div></div>';
    }

    protected function defineSettings()
    {
        return [
            'title'       => [AttributeType::String, 'required' => true, 'default' => $this->getName()],
            'view'        => [AttributeType::String],
            'statHandles' => [AttributeType::Mixed],
            'statHandle'  => [AttributeType::String],
            'dateRange'   => [AttributeType::String],
        ];
    }
}
