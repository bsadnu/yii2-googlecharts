<?php

namespace bsadnu\googlecharts;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use bsadnu\googlecharts\GoogleJsApiAsset;

/**
 * Bubble chart widget.
 * A bubble chart is used to visualize a data set with two to four dimensions.
 * The first two dimensions are visualized as coordinates, the third as color and the fourth as size.
 * Bubble charts can be considered a variation of the scatter plot, in which the data points are replaced with bubbles.
 * By default all bubble charts display tips when hovering over bubbles.
 * 
 * @author Stanislav Bannikov <bsadnu@gmail.com>
 */
class BubbleChart extends Widget
{
    /**
     * @var string unique id of chart
     */
    public $id;

    /**
     * @var array table of data
     * Example:
     * [
     *     ['ID', 'Life Expectancy', 'Fertility Rate', 'Region'],
     *     ['CAN',    82.66,              1.67,      'North America'],
     *     ['DEU',    79.84,              1.36,      'Europe'],
     *     ['DNK',    70.6,               1.84,      'Europe'],
     *     ['EGY',    72.73,              2.78,      'Middle East'],
     *     ['GBR',    75.05,              2,         'Europe'],
     *     ['IRN',    72.49,              0.7,       'Middle East'],
     *     ['IRQ',    68.09,              4.77,      'Middle East'],
     *     ['ISR',    81.55,              3.96,      'Middle East'],
     *     ['RUS',    68.6,               1.54,      'Europe'],
     *     ['USA',    78.09,              3.05,      'North America']
     * ]
     */
    public $data = [];

    /**
     * @var array options
     * Example:
     * [
     *     'fontName' => 'Verdana',
     *     'height' => 450,
     *     'fontSize' => 12,
     *     'chartArea' => [
     *         'left' => '5%',
     *         'width' => '90%',
     *         'height' => 400
     *     ],
     *     'tooltip' => [
     *         'textStyle' => [
     *             'fontName' => 'Verdana',
     *             'fontSize' => 13
     *         ]
     *     ],
     *     'vAxis' => [
     *         'title' => 'Fertility Rate',
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
     *     'bubble' => [
     *         'textStyle' => [
     *             'auraColor' => 'none',
     *             'color' => '#fff'
     *         ],
     *         'stroke' => '#fff'
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
     * Registers necessary assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        GoogleJsApiAsset::register($view);
    }

    /**
     * Return necessary js script
     */
    private function getJs()
    {
        $uniqueInt = mt_rand(1, 999999);

        $js = "
            google.load('visualization', '1', {packages:['corechart']});
            google.setOnLoadCallback(drawBubbleChart". $uniqueInt .");
        ";
        $js .= "
            function drawBubbleChart". $uniqueInt ."() {

                var data". $uniqueInt ." = google.visualization.arrayToDataTable(". Json::encode($this->data) .");

                var options". $uniqueInt ." = ". Json::encode($this->options) .";

                var bubble". $uniqueInt ." = new google.visualization.BubbleChart($('#". $this->id ."')[0]);
                bubble". $uniqueInt .".draw(data". $uniqueInt .", options". $uniqueInt .");
            }
        ";        
        $js .= "
            $(function () {

                $(window).on('resize', resize);
                $('.sidebar-control').on('click', resize);

                function resize() {
                    drawBubbleChart". $uniqueInt ."();
                }
            });
        ";

        return $js;
    }   
}
