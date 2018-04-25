<?php

namespace bsadnu\googlecharts;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use bsadnu\googlecharts\GoogleJsApiAsset;

/**
 * Column chart widget.
 * A column graph is a chart that uses vertical bars to show comparisons among categories.
 * One axis of the chart shows the specific categories being compared, and the other axis represents a discrete value.
 * Like all Google charts, column charts display tooltips when the user hovers over the data.
 * By default, text labels are hidden, but can be turned on in chart settings.
 * 
 * @author Stanislav Bannikov <bsadnu@gmail.com>
 */
class ColumnChart extends Widget
{
    /**
     * @var string unique id of chart
     */
    public $id;

    /**
     * @var array table of data
     * Counts as old or previos dataset in diff chart case
     * Example:
     * [
     *     ['Name', 'Popularity'],
     *     ['Cesar', 425],
     *     ['Rachel', 420],
     *     ['Patrick', 290],
     *     ['Eric', 620],
     *     ['Eugene', 520],
     *     ['John', 460],
     *     ['Greg', 420],
     *     ['Matt', 410]
     * ]
     */
    public $data = [];

    /**
     * @var array table of extra data necessary for diff chart types
     * Counts as new dataset in diff chart case
     * 
     * A diff chart is a chart designed to highlight the differences between two charts with comparable data.
     * By making the changes between analogous values prominent, they can reveal variations between datasets.
     * You create a diff chart by calling the computeDiff method with two datasets to generate a third dataset representing the diff, and then drawing that.
     * 
     * Example:
     * [
     *     ['Name', 'Popularity'],
     *     ['Cesar', 307],
     *     ['Rachel', 360],
     *     ['Patrick', 200],
     *     ['Eric', 550],
     *     ['Eugene', 460],
     *     ['John', 320],
     *     ['Greg', 390],
     *     ['Matt', 360]
     * ]
     */
    public $extraData = [];    

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
     *     'colors' => [
     *         '#4CAF50'
     *     ],
     *     'tooltip' => [
     *         'textStyle' => [
     *             'fontName' => 'Verdana',
     *             'fontSize' => 13
     *         ]
     *     ],
     *     'vAxis' => [
     *         'title' => 'Popularity',
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
            google.setOnLoadCallback(drawColumn". $uniqueInt .");
        ";
        if (!empty($this->extraData)) {
            $js .= "
                function drawColumn". $uniqueInt ."() {

                    var oldData". $uniqueInt ." = google.visualization.arrayToDataTable(". Json::encode($this->data) .");

                    var newData". $uniqueInt ." = google.visualization.arrayToDataTable(". Json::encode($this->extraData) .");

                    var options". $uniqueInt ." = ". Json::encode($this->options) .";

                    var column". $uniqueInt ." = new google.visualization.ColumnChart($('#". $this->id ."')[0]);

                    var diffData". $uniqueInt ." = column". $uniqueInt .".computeDiff(oldData". $uniqueInt .", newData". $uniqueInt .");

                    column". $uniqueInt .".draw(diffData". $uniqueInt .", options". $uniqueInt .");
                }
            ";
        } else {
            $js .= "
                function drawColumn". $uniqueInt ."() {

                    var data". $uniqueInt ." = google.visualization.arrayToDataTable(". Json::encode($this->data) .");

                    var options". $uniqueInt ." = ". Json::encode($this->options) .";

                    var column". $uniqueInt ." = new google.visualization.ColumnChart($('#". $this->id ."')[0]);

                    column". $uniqueInt .".draw(data". $uniqueInt .", options". $uniqueInt .");
                }
            ";            
        }        
        $js .= "
            $(function () {

                $(window).on('resize', resize);
                $('.sidebar-control').on('click', resize);

                function resize() {
                    drawColumn". $uniqueInt ."();
                }
            });
        ";

        return $js;
    }   
}
