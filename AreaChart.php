<?php

namespace bsadnu\googlecharts;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use bsadnu\googlecharts\GoogleJsApiAsset;

/**
 * Area chart widget.
 * An area chart or area graph displays graphically quantitive data. It is based on the line chart.
 * The area between axis and line are commonly emphasized with colors, textures and hatchings.
 * Commonly one compares with an area chart two or more quantities.
 * An area chart that is rendered within the browser using SVG or VML. Displays tips when hovering over points.
 * 
 * @author Stanislav Bannikov <bsadnu@gmail.com>
 */
class AreaChart extends Widget
{
    /**
     * @var string unique id of chart
     */
    public $id;

    /**
     * @var array table of data
     * Example:
     * [
     *     ['Year', 'Sales', 'Expenses'],
     *     ['2004', 1000, 400],
     *     ['2005', 1170, 460],
     *     ['2006', 660, 1120],
     *     ['2007', 1030, 540]
     * ]
     */
    public $data = [];

    /**
     * @var array options
     * Example:
     * [
     *     'fontName' => 'Verdana',
     *     'height' => 400,
     *     'curveType' => 'function',
     *     'fontSize' => 12,
     *     'areaOpacity' => 0.4,
     *     'chartArea' => [
     *         'left' => '5%',
     *         'width' => '90%',
     *         'height' => 350
     *     ],
     *     'pointSize' => 4,
     *     'tooltip' => [
     *         'textStyle' => [
     *             'fontName' => 'Verdana',
     *             'fontSize' => 13
     *         ]
     *     ],
     *     'vAxis' => [
     *         'title' => 'Sales and Expenses',
     *         'titleTextStyle' => [
     *             'fontSize' => 13,
     *             'italic' => false
     *         ],
     *         'gridarea' => [
     *             'color' => '#e5e5e5',
     *             'count' => 10
     *         ],
     *         'minValue' => 0
     *     ],
     *     'legend' => [
     *         'position' => 'top',
     *         'alignment' => 'end',
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
            google.setOnLoadCallback(drawAreaChart". $uniqueInt .");
        ";
        $js .= "
            function drawAreaChart". $uniqueInt ."() {

                var data". $uniqueInt ." = google.visualization.arrayToDataTable(". Json::encode($this->data) .");

                var options". $uniqueInt ." = ". Json::encode($this->options) .";

                var area_chart". $uniqueInt ." = new google.visualization.AreaChart($('#". $this->id ."')[0]);
                area_chart". $uniqueInt .".draw(data". $uniqueInt .", options". $uniqueInt .");
            }
        ";        
        $js .= "
            $(function () {

                $(window).on('resize', resize);
                $('.sidebar-control').on('click', resize);

                function resize() {
                    drawAreaChart". $uniqueInt ."();
                }
            });
        ";

        return $js;
    }   
}
