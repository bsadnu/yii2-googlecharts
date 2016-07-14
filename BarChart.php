<?php

namespace bsadnu\googlecharts;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use bsadnu\googlecharts\GoogleJsApiAsset;

/**
 * Bar chart widget.
 * A bar graph is a chart that uses horizontal bars to show comparisons among categories.
 * One axis of the chart shows the specific categories being compared, and the other axis represents a discrete value.
 * Like all Google charts, column charts display tooltips when the user hovers over the data.
 * By default, text labels are hidden, but can be turned on in chart settings.
 * 
 * @author Stanislav Bannikov <bsadnu@gmail.com>
 */
class BarChart extends Widget
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
     *     ['2004',  1000,      400],
     *     ['2005',  1170,      460],
     *     ['2006',  660,       1120],
     *     ['2007',  1030,      540]
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
            google.setOnLoadCallback(drawBar". $uniqueInt .");
        ";
        $js .= "
            function drawBar". $uniqueInt ."() {

                var data". $uniqueInt ." = google.visualization.arrayToDataTable(". Json::encode($this->data) .");

                var options_bar". $uniqueInt ." = ". Json::encode($this->options) .";

                var bar". $uniqueInt ." = new google.visualization.BarChart($('#". $this->id ."')[0]);
                bar". $uniqueInt .".draw(data". $uniqueInt .", options_bar". $uniqueInt .");
            }
        ";        
        $js .= "
            $(function () {

                $(window).on('resize', resize);
                $('.sidebar-control').on('click', resize);

                function resize() {
                    drawBar". $uniqueInt ."();
                }
            });
        ";

        return $js;
    }   
}
