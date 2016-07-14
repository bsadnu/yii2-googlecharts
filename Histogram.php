<?php

namespace bsadnu\googlecharts;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use bsadnu\googlecharts\GoogleJsApiAsset;

/**
 * Histogram widget.
 * A histogram is a chart that groups numeric data into bins, displaying the bins as segmented columns.
 * They're used to depict the distribution of a dataset: how often values fall into ranges.
 * Google Charts automatically chooses the number of bins for you. All bins are equal width and have a height proportional to the number of data points in the bin.
 * In other respects, histograms are similar to column charts.
 * 
 * @author Stanislav Bannikov <bsadnu@gmail.com>
 */
class Histogram extends Widget
{
    /**
     * @var string unique id of histogram
     */
    public $id;

    /**
     * @var array table of data
     * Example:
     * [
     *     ['Dinosaur', 'Length'],
     *     ['Acrocanthosaurus (top-spined lizard)', 12.2],
     *     ['Albertosaurus (Alberta lizard)', 9.1],
     *     ['Allosaurus (other lizard)', 12.2],
     *     ['Apatosaurus (deceptive lizard)', 22.9],
     *     ['Archaeopteryx (ancient wing)', 0.9],
     *     ['Argentinosaurus (Argentina lizard)', 36.6],
     *     ['Baryonyx (heavy claws)', 9.1],
     *     ['Brachiosaurus (arm lizard)', 30.5],
     *     ['Ceratosaurus (horned lizard)', 6.1],
     *     ['Coelophysis (hollow form)', 2.7],
     *     ['Compsognathus (elegant jaw)', 0.9],
     *     ['Deinonychus (terrible claw)', 2.7],
     *     ['Diplodocus (double beam)', 27.1],
     *     ['Dromicelomimus (emu mimic)', 3.4],
     *     ['Gallimimus (fowl mimic)', 5.5],
     *     ['Mamenchisaurus (Mamenchi lizard)', 21.0],
     *     ['Megalosaurus (big lizard)', 7.9],
     *     ['Microvenator (small hunter)', 1.2],
     *     ['Ornithomimus (bird mimic)', 4.6],
     *     ['Oviraptor (egg robber)', 1.5],
     *     ['Plateosaurus (flat lizard)', 7.9],
     *     ['Sauronithoides (narrow-clawed lizard)', 2.0],
     *     ['Seismosaurus (tremor lizard)', 45.7],
     *     ['Spinosaurus (spiny lizard)', 12.2],
     *     ['Supersaurus (super lizard)', 30.5],
     *     ['Tyrannosaurus (tyrant lizard)', 15.2],
     *     ['Ultrasaurus (ultra lizard)', 30.5],
     *     ['Velociraptor (swift robber)', 1.8]
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
     *     'isStacked' => true,
     *     'tooltip' => [
     *         'textStyle' => [
     *             'fontName' => 'Verdana',
     *             'fontSize' => 13
     *         ]
     *     ],
     *     'vAxis' => [
     *         'title' => 'Dinosaur length',
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
     *     'hAxis' => [
     *         'gridlines' => [
     *             'color' => '#e5e5e5'
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
            google.setOnLoadCallback(drawHistogram". $uniqueInt .");
        ";
        $js .= "
            function drawHistogram". $uniqueInt ."() {

                var data". $uniqueInt ." = google.visualization.arrayToDataTable(". Json::encode($this->data) .");

                var options_histogram". $uniqueInt ." = ". Json::encode($this->options) .";

                var histogram". $uniqueInt ." = new google.visualization.Histogram($('#". $this->id ."')[0]);
                histogram". $uniqueInt .".draw(data". $uniqueInt .", options_histogram". $uniqueInt .");
            }
        ";        
        $js .= "
            $(function () {

                $(window).on('resize', resize);
                $('.sidebar-control').on('click', resize);

                function resize() {
                    drawHistogram". $uniqueInt ."();
                }
            });
        ";

        return $js;
    }   
}
