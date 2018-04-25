<?php

namespace bsadnu\googlecharts;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use bsadnu\googlecharts\GoogleJsApiAsset;

/**
 * Line chart widget.
 * A line chart or line graph is a type of chart which displays information as a series of data points called 'markers' connected by straight line segments.
 * Line Charts show how a particular data changes at equal intervals of time.
 * A line chart is rendered within the browser using SVG or VML. Displays tips when hovering over points.
 * 
 * @author Stanislav Bannikov <bsadnu@gmail.com>
 */
class LineChart extends Widget
{
    /**
     * @var string unique id of chart
     */
    public $id;

    /**
     * @var boolean whether chart is interval-style.
     * Below is an example of line intervals.
     * Intervals around a series might be used to portray confidence intervals, minimum and maximum values around a value, percentile sampling,
     * or anything else that requires a varying margin around a series.
     * Line intervals are sometimes used to show the raw data from which a trendline was extracted.
     * To draw a trendline on a chart, use the trendlines option and specify which data series to use.
     * 
     * An area interval renders interval data as a set of nested shaded areas.
     * Nesting of pairs of columns is similar to that of box intervals, except that an even number of columns is required.
     * This is accomplished by setting style to 'area'.
     * There are six styles of interval: line, bar, box, stick, point, and area.
     * For even greater customization, intervals styles can be combined inside one chart.
     * 
     * <?= LineChart::widget([
     *     'id' => 'my-line-intervals-id',
     *     'isIntervalType' => true,
     *     'data' => [
     *         ['a', 100, 90, 110, 85, 96, 104, 120],
     *         ['b', 120, 95, 130, 90, 113, 124, 140],
     *         ['c', 130, 105, 140, 100, 117, 133, 139],
     *         ['d', 90, 85, 95, 85, 88, 92, 95],
     *         ['e', 70, 74, 63, 67, 69, 70, 72],
     *         ['f', 30, 39, 22, 21, 28, 34, 40],
     *         ['g', 80, 77, 83, 70, 77, 85, 90],
     *         ['h', 100, 90, 110, 85, 95, 102, 110]
     *     ],
     *     'options' => [
     *         'fontName' => 'Verdana',
     *         'height' => 400,
     *         'curveType' => 'function',
     *         'fontSize' => 12,
     *         'chartArea' => [
     *             'left' => '5%',
     *             'width' => '90%',
     *             'height' => 350
     *         ],
     *         'lineWidth' => 3,
     *         'tooltip' => [
     *             'textStyle' => [
     *                 'fontName' => 'Verdana',
     *                 'fontSize' => 13
     *             ]
     *         ],
     *         'series' => [
     *             [
     *                 'color' => '#EF5350'
     *             ]
     *         ],
     *         'intervals' => [
     *             'style' => 'line' //you may use six styles of interval: line, bar, box, stick, point, and area
     *         ],
     *         'pointSize' => 5,
     *         'vAxis' => [
     *             'title' => 'Number values',
     *             'titleTextStyle' => [
     *                 'fontSize' => 13,
     *                 'italic' => false
     *             ],
     *             'gridlines' => [
     *                 'color' => '#e5e5e5',
     *                 'count' => 10
     *             ],
     *             'minValue' => 0
     *         ],
     *         'legend' => 'none'
     *     ]
     * ]) ?>
     */
    public $isIntervalType = false;

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
     *     'curveType' => 'function',
     *     'fontSize' => 12,
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
            google.setOnLoadCallback(drawLineChart". $uniqueInt .");
        ";
        if (!$this->isIntervalType) {
            $js .= "
                function drawLineChart". $uniqueInt ."() {

                    var data". $uniqueInt ." = google.visualization.arrayToDataTable(". Json::encode($this->data) .");

                    var options". $uniqueInt ." = ". Json::encode($this->options) .";

                    var line_chart". $uniqueInt ." = new google.visualization.LineChart($('#". $this->id ."')[0]);
                    line_chart". $uniqueInt .".draw(data". $uniqueInt .", options". $uniqueInt .");
                }
            ";
        } else {
            $js .= "
                function drawLineChart". $uniqueInt ."() {
                    var data". $uniqueInt ." = new google.visualization.DataTable();
                        data". $uniqueInt .".addColumn('string', 'x');
                        data". $uniqueInt .".addColumn('number', 'values');
                        data". $uniqueInt .".addColumn({id:'i0', type:'number', role:'interval'});
                        data". $uniqueInt .".addColumn({id:'i1', type:'number', role:'interval'});
                        data". $uniqueInt .".addColumn({id:'i2', type:'number', role:'interval'});
                        data". $uniqueInt .".addColumn({id:'i2', type:'number', role:'interval'});
                        data". $uniqueInt .".addColumn({id:'i2', type:'number', role:'interval'});
                        data". $uniqueInt .".addColumn({id:'i2', type:'number', role:'interval'});                

                    data". $uniqueInt .".addRows(". Json::encode($this->data) .");

                    var options". $uniqueInt ." = ". Json::encode($this->options) .";

                    var line_chart". $uniqueInt ." = new google.visualization.LineChart($('#". $this->id ."')[0]);
                    line_chart". $uniqueInt .".draw(data". $uniqueInt .", options". $uniqueInt .");
                }
            ";
        }
        $js .= "
            $(function () {

                $(window).on('resize', resize);
                $('.sidebar-control').on('click', resize);

                function resize() {
                    drawLineChart". $uniqueInt ."();
                }
            });
        ";

        return $js;
    }   
}
