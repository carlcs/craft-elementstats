<?php
namespace Craft;

class ElementStats_StatModel extends BaseModel
{
    public function getTotal()
    {
        $total = $this->total;

        if ($total === null) {
            try {
                $criteria = $this->getCriteria();
            } catch (\Exception $e) {
                ElementStatsPlugin::log('There was an error while generating the stats. '.$e->getMessage(), LogLevel::Error);
                return null;
            }

            $total = $criteria->total();
        }

        if ($this->numberFormat !== false) {
            $numberFormat = $this->numberFormat ?: craft()->config->get('defaultNumberFormat', 'elementstats');

            try {
                $total = craft()->templates->renderString($numberFormat, ['total' => $total]);
            } catch (\Exception $e) {
                ElementStatsPlugin::log('Couldn’t render template. '.$e->getMessage(), LogLevel::Error);
                return null;
            }
        }

        return $total;
    }

    public function getCriteria($additionalCriteria = null)
    {
        $criteria = craft()->elements->getCriteria($this->elementType);

        $criteria->limit = null;
        $criteria->setAttributes($this->criteria);
        $criteria->setAttributes($additionalCriteria);

        // TODO: prevent fatal errors thrown by buildElementsQuery
        if (!craft()->elements->buildElementsQuery($criteria)) {
            throw new \Exception(Craft::t('Couldn’t find any elements with the given parameters.'));
        }

        return $criteria;
    }

    // Protected Methods
    // =========================================================================

    /**
     * Defines this model's attributes.
     *
     * @return array
     */
    protected function defineAttributes()
    {
        return [
            'handle'         => [AttributeType::String],
            'name'           => [AttributeType::String],
            'elementType'    => [AttributeType::String],
            'criteria'       => [AttributeType::String],
            'dateColumn'     => [AttributeType::String],
            'total'          => [AttributeType::String],
            'numberFormat'   => [AttributeType::String],
            'link'           => [AttributeType::String],
        ];
    }
}
