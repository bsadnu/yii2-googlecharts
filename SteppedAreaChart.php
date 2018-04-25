<?php

namespace bsadnu\googlecharts;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use bsadnu\googlecharts\GoogleJsApiAsset;

/**
 * Stepped area chart widget.
 * A stepped area chart is rendered within the browser using SVG or VML. Displays tips when hovering over steps.
 * The Step Area chart type is similar to the Line chart type, but it does not use the shortest distance to connect two data points.
 * Instead, this chart type uses vertical and horizontal lines to connect the data points in a series forming a step-like progression.
 * 
 * @author Stanislav Bannikov <bsadnu@gmail.com>
 */
class SteppedAreaChart extends Widget
{
    /**
     * @var string unique id of chart
     */
    public $id;

    /**
     * @var array table of data
     * Example:
     * [
     *     ['Director (Year)',  'Rotten Tomatoes', 'IMDB'],
     *     ['Alfred Hitchcock (1935)', 8.4,         7.9],
     *     ['Ralph Thomas (1959)',     6.9,         6.5],
     *     ['Don Sharp (1978)',        6.5,         6.4],
     *     ['James Hawes (2008)',      4.4,         6.2]
     * ]
     */
    public $data = [];

    /**
     * @var array options
     * Example:
     * [
     *     'fontName' => 'Verdana',
     *     'height' => 400,
     *     'isStacked' => true,
     *     'fontSize' => 12,
     *     'areaOpacity' => 0.4,
     *     'chartArea' => [
     *         'left' => '5%',
     *         'width' => '90%',
     *         'height' => 350
     *     ],
     *     'lineWidth' => 1,
     *     'tooltip' => [
     *         'textStyle' => [
     *             'fontName' => 'Verdana',
     *             'fontSize' => 13
     *         ]
     *     ],
     *     'pointSize' => 5,
     *     'vAxis' => [
     *         'title' => 'Accumulated Rating',
     *         'titleTextStyle' => [
     *             'fontSize' => 13,
     *             'italic' => false
     *         ],
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
            google.setOnLoadCallback(drawSteppedAreaChart". $uniqueInt .");
        ";
        $js .= "
            function drawSteppedAreaChart". $uniqueInt ."() {

                var data". $uniqueInt ." = google.visualization.arrayToDataTable(". Json::encode($this->data) .");

                var options_stepped_area". $uniqueInt ." = ". Json::encode($this->options) .";

                var stepped_area_chart". $uniqueInt ." = new google.visualization.SteppedAreaChart($('#". $this->id ."')[0]);
                stepped_area_chart". $uniqueInt .".draw(data". $uniqueInt .", options_stepped_area". $uniqueInt .");
            }
        ";        
        $js .= "
            $(function () {

                $(window).on('resize', resize);
                $('.sidebar-control').on('click', resize);

                function resize() {
                    drawSteppedAreaChart". $uniqueInt ."();
                }
            });
        ";

        return $js;
    }   
}
