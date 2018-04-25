<?php

namespace bsadnu\googlecharts;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use bsadnu\googlecharts\GoogleJsApiAsset;

/**
 * Geo chart widget.
 * A geochart is a map of a country, a continent, or a region with areas identified in one of three ways: region mode, markers mode and text mode.
 * A geochart is rendered within the browser using SVG or VML. Note that the geochart is not scrollable or draggable, and it's a line drawing rather than a terrain map.
 * The regions style fills entire regions (typically countries) with colors corresponding to the values that you assign.
 * 
 * @author Stanislav Bannikov <bsadnu@gmail.com>
 */
class GeoChart extends Widget
{
    /**
     * @var string unique id of chart
     */
    public $id;

    /**
     * @var array table of data
     * Example:
     * [
     *     ['Country', 'Popularity'],
     *     ['Germany', 200],
     *     ['United States', 300],
     *     ['Brazil', 400],
     *     ['Canada', 500],
     *     ['France', 600],
     *     ['RU', 700]
     * ]
     */
    public $data = [];

    /**
     * @var array options
     * Example:
     * [
     *     'fontName' => 'Verdana',
     *     'height' => 500,
     *     'width' => '100%',
     *     'fontSize' => 12,
     *     'tooltip' => [
     *         'textStyle' => [
     *             'fontName' => 'Verdana',
     *             'fontSize' => 13
     *         ]
     *     ]
     * ]
     */
    public $options = [];


    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
        $view = Yii::$app->getView();
        $this->registerAssets();
        $view->registerJs($this->getJs(), View::POS_END);
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $content = Html::tag('div', null, ['id'=> $this->id]);

        return $content;
    }

    /**
     * Registers necessary assets.
     */
    public function registerAssets()
    {
        $view = $this->getView();
        GoogleJsApiAsset::register($view);
    }

    /**
     * Return necessary javascript.
     */
    private function getJs()
    {
        $uniqueInt = mt_rand(1, 999999);

        $js = "
            google.load('visualization', '1', {packages:['geochart']});
            google.setOnLoadCallback(drawMap". $uniqueInt .");
        ";
        $js .= "
            function drawMap". $uniqueInt ."() {

                var data". $uniqueInt ." = google.visualization.arrayToDataTable(". Json::encode($this->data) .");

                var options". $uniqueInt ." = ". Json::encode($this->options) .";

                var chart". $uniqueInt ." = new google.visualization.GeoChart($('#". $this->id ."')[0]);
                chart". $uniqueInt .".draw(data". $uniqueInt .", options". $uniqueInt .");
            }
        ";        

        return $js;
    }   
}
