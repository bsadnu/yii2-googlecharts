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
     * Example:
     * [
     *  ['Year', 'Sales', 'Expenses'],
     *  ['2013',  1000,      400],
     *  ['2014',  1170,      460],
     *  ['2015',  660,       1120],
     *  ['2016',  1030,      540]
     * ]
     */
    public $data = [];

    /**
     * @var array options
     * Example:
     * [
     * 'fontName' => 'Verdana',
     * 'height' => 400,
     * 'fontSize' => 12,
     * 'chartArea' => [
     *  'left' => '5%',
     *  'width' => '90%',
     *  'height' => 350
     * ],
     * 'tooltip' => [
     *  'textStyle' => [
     *      'fontName' => 'Roboto',
     *      'fontSize' => 13
     *  ]
     * ],
     * 'vAxis' => [
     *  'title' => 'Sales and Expenses',
     *  'titleTextStyle' => [
     *      'fontSize' => 13,
     *      'italic' => false
     *  ],
     *  'gridlines' => [
     *      'color' => '#e5e5e5',
     *      'count' => 10
     *  ],
     *  'minValue' => 0
     * ],
     * 'legend' => [
     *  'position' => 'top',
     *  'alignment' => 'center',
     *  'textStyle' => [
     *      'fontSize' => 12
     *  ]
     * ]
     * ]
     */
    public $options = [];

    /**
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
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
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        GoogleJsApiAsset::register($view);
    }    

    private function getJs() {
        $js = "
            google.load('visualization', '1', {packages:['corechart']});
            google.setOnLoadCallback(drawColumn);
        ";
        $js .= "
            function drawColumn() {

                var data = google.visualization.arrayToDataTable(". Json::encode($this->data) .");

                var options_column = ". Json::encode($this->options) .";

                var column = new google.visualization.ColumnChart($('#". $this->id ."')[0]);
                column.draw(data, options_column);
            }
        ";        
        $js .= "
            $(function () {

                $(window).on('resize', resize);
                $('.sidebar-control').on('click', resize);

                function resize() {
                    drawColumn();
                }
            });
        ";

        return $js;
    }   
}
