<?php

namespace bsadnu\googlecharts;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use bsadnu\googlecharts\GoogleJsApiAsset;

/**
 * Combo chart widget.
 * A chart that lets you render each series as a different marker type from the following list: line, area, bars, candlesticks, and stepped area.
 * To assign a default marker type for series, specify the seriesType property.
 * Use the series property to specify properties of each series individually.
 * 
 * @author Stanislav Bannikov <bsadnu@gmail.com>
 */
class ComboChart extends Widget
{
    /**
     * @var string unique id of chart
     */
    public $id;

    /**
     * @var array table of data
     * Example:
     * [
     *     ['Month', 'Bolivia', 'Ecuador', 'Madagascar', 'Papua New Guinea', 'Rwanda', 'Average'],
     *     ['2004/05',  165,      938,         522,             998,           450,      614.6],
     *     ['2005/06',  135,      1120,        599,             1268,          288,      682],
     *     ['2006/07',  157,      1167,        587,             807,           397,      623],
     *     ['2007/08',  139,      1110,        615,             968,           215,      609.4],
     *     ['2008/09',  136,      691,         629,             1026,          366,      569.6]
     * ]
     */
    public $data = [];

    /**
     * @var array options
     * Example:
     * [
     *     'fontName' => 'Verdana',
     *     'height' => 400,
     *     'fontSize' => 12,
     *     'chartArea' => [
     *         'left' => '5%',
     *         'width' => '90%',
     *         'height' => 350
     *     ],
     *     'seriesType' => 'bars',
     *     'series' => [
     *         5 => [
     *             'type' => 'line',
     *             'pointSize' => 5
     *         ]
     *     ],
     *     'tooltip' => [
     *         'textStyle' => [
     *             'fontName' => 'Verdana',
     *             'fontSize' => 13
     *         ]
     *     ],
     *     'vAxis' => [
     *         'gridlines' => [
     *             'color' => '#e5e5e5',
     *             'count' => 10
     *         ],
     *         'minValue' => 0
     *     ],
     *     'legend' => [
     *         'position' => 'top',
     *         'alignment' => 'center',
     *         'textStyle' => [
     *             'fontSize' => 12
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
            google.load('visualization', '1', {packages:['corechart']});
            google.setOnLoadCallback(drawCombo". $uniqueInt .");
        ";
        $js .= "
            function drawCombo". $uniqueInt ."() {

                var data". $uniqueInt ." = google.visualization.arrayToDataTable(". Json::encode($this->data) .");

                var options_combo". $uniqueInt ." = ". Json::encode($this->options) .";

                var combo". $uniqueInt ." = new google.visualization.ComboChart($('#". $this->id ."')[0]);
                combo". $uniqueInt .".draw(data". $uniqueInt .", options_combo". $uniqueInt .");
            }
        ";        
        $js .= "
            $(function () {

                $(window).on('resize', resize);
                $('.sidebar-control').on('click', resize);

                function resize() {
                    drawCombo". $uniqueInt ."();
                }
            });
        ";

        return $js;
    }   
}
