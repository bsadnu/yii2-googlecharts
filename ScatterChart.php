<?php

namespace bsadnu\googlecharts;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use bsadnu\googlecharts\GoogleJsApiAsset;

/**
 * Scatter chart widget.
 * A scatter chart is a type of mathematical diagram using Cartesian coordinates to display values for two variables for a set of data.
 * The data is displayed as a collection of points,
 * each having the value of one variable determining the position on the horizontal axis and the value of the other variable determining the position on the vertical axis.
 * When the user hovers over the points, tooltips are displayed with more information.
 * 
 * @author Stanislav Bannikov <bsadnu@gmail.com>
 */
class ScatterChart extends Widget
{
    /**
     * @var string unique id of chart
     */
    public $id;

    /**
     * @var array table of data
     * Counts as old or previos dataset in diff scatter chart case
     * Example:
     * [
     *     ['', 'Medicine 1', 'Medicine 2'],
     *     [23, null, 12], [9, null, 39], [15, null, 28],
     *     [37, null, 30], [21, null, 14], [12, null, 18],
     *     [29, null, 34], [ 8, null, 12], [38, null, 28],
     *     [35, null, 12], [26, null, 10], [10, null, 29],
     *     [11, null, 10], [27, null, 38], [39, null, 17],
     *     [34, null, 20], [38, null,  5], [33, null, 27],
     *     [23, null, 39], [12, null, 10], [ 8, 15, null],
     *     [39, 15, null], [27, 31, null], [30, 24, null],
     *     [31, 39, null], [35,  6, null], [ 5,  5, null],
     *     [19, 39, null], [22,  8, null], [19, 23, null],
     *     [27, 20, null], [11,  6, null], [34, 33, null],
     *     [38,  8, null], [39, 29, null], [13, 23, null],
     *     [13, 36, null], [39,  6, null], [14, 37, null], [13, 39, null]
     * ]
     */
    public $data = [];

    /**
     * @var array table of extra data necessary for diff scatter chart types
     * Counts as new dataset in diff scatter chart case
     * 
     * A diff chart is a chart designed to highlight the differences between two charts with comparable data.
     * By making the changes between analogous values prominent, they can reveal variations between datasets.
     * You create a diff chart by calling the computeDiff method with two datasets to generate a third dataset representing the diff, and then drawing that.
     * Supports all scatter chart options, as it jsut combines 2 charts into 1.
     * 
     * Example:
     * [
     *     ['', 'Medicine 1', 'Medicine 2'],
     *     [22, null, 12], [7, null, 40], [14, null, 31],
     *     [37, null, 30], [18, null, 17], [9, null, 20],
     *     [26, null, 36], [5, null, 13], [36, null, 30],
     *     [35, null, 15], [24, null, 12], [7, null, 31],
     *     [10, null, 12], [24, null, 40], [37, null, 18],
     *     [32, null, 21], [35, null, 7], [31, null, 30],
     *     [21, null, 42], [12, null, 10], [10, 13, null],
     *     [40, 12, null], [28, 29, null], [32, 22, null],
     *     [31, 37, null], [38, 5, null], [6, 4, null],
     *     [21, 36, null], [22, 8, null], [21, 22, null],
     *     [28, 17, null], [12, 5, null], [37, 30, null],
     *     [41, 7, null], [41, 27, null], [15, 20, null],
     *     [14, 36, null], [42, 3, null], [14, 37, null], [15, 36, null]
     * ]
     */
    public $extraData = [];    

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
     *     'hAxis' => [
     *         'minValue' => 0
     *     ],
     *     'vAxis' => [
     *         'gridlines' => [
     *             'color' => '#e5e5e5',
     *             'count' => 5
     *         ],
     *         'minValue' => 0
     *     ],
     *     'legend' => [
     *         'position' => 'top',
     *         'alignment' => 'center',
     *         'textStyle' => [
     *             'fontSize' => 12
     *         ]
     *     ],
     *     'diff' => [
     *         'oldData' => [
     *             'opacity' => 0.5
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
            google.setOnLoadCallback(drawScatter". $uniqueInt .");
        ";
        if (!empty($this->extraData)) {
            $js .= "
                function drawScatter". $uniqueInt ."() {

                    var oldData". $uniqueInt ." = google.visualization.arrayToDataTable(". Json::encode($this->data) .");

                    var newData". $uniqueInt ." = google.visualization.arrayToDataTable(". Json::encode($this->extraData) .");

                    var options". $uniqueInt ." = ". Json::encode($this->options) .";

                    var scatter". $uniqueInt ." = new google.visualization.ScatterChart($('#". $this->id ."')[0]);

                    var diffData". $uniqueInt ." = scatter". $uniqueInt .".computeDiff(oldData". $uniqueInt .", newData". $uniqueInt .");

                    scatter". $uniqueInt .".draw(diffData". $uniqueInt .", options". $uniqueInt .");
                }
            ";
        } else {
            $js .= "
                function drawScatter". $uniqueInt ."() {

                    var data". $uniqueInt ." = google.visualization.arrayToDataTable(". Json::encode($this->data) .");

                    var options". $uniqueInt ." = ". Json::encode($this->options) .";

                    var scatter". $uniqueInt ." = new google.visualization.ScatterChart($('#". $this->id ."')[0]);

                    scatter". $uniqueInt .".draw(data". $uniqueInt .", options". $uniqueInt .");
                }
            ";            
        }
        $js .= "
            $(function () {

                $(window).on('resize', resize);
                $('.sidebar-control').on('click', resize);

                function resize() {
                    drawScatter". $uniqueInt ."();
                }
            });
        ";        

        return $js;
    }   
}
