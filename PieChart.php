<?php

namespace bsadnu\googlecharts;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use bsadnu\googlecharts\GoogleJsApiAsset;

/**
 * Pie chart widget.
 * A pie chart is a divided into sectors, illustrating numerical proportion.
 * In a pie chart, the arc length of each sector (and consequently its central angle and area), is proportional to the quantity it represents.
 * While it is named for its resemblance to a pie which has been sliced, there are variations on the way it can be presented.
 * 
 * @author Stanislav Bannikov <bsadnu@gmail.com>
 */
class PieChart extends Widget
{
    /**
     * @var string unique id of chart
     */
    public $id;

    /**
     * @var array table of data
     * Example:
     * [
     *     ['Major', 'Degrees'],
     *     ['Business', 256070],
     *     ['Education', 108034],
     *     ['Social Sciences & History', 127101],
     *     ['Health', 81863],
     *     ['Psychology', 74194]
     * ]
     */
    public $data = [];

    /**
     * @var array table of extra data necessary for inner circle chart types
     * Example:
     * [
     *     ['Major', 'Degrees'],
     *     ['Business', 358293],
     *     ['Education', 101265],
     *     ['Social Sciences & History', 172780],
     *     ['Health', 129634],
     *     ['Psychology', 97216]
     * ]
     */
    public $extraData = [];    

    /**
     * @var array options
     * Example:
     * [
     *     'fontName' => 'Verdana',
     *     'height' => 300,
     *     'width' => 500,
     *     'chartArea' => [
     *         'left' => 50,
     *         'width' => '90%',
     *         'height' => '90%'
     *     ],
     *     'diff' => [
     *         'oldData' => [
     *             'inCenter' => false
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
            google.setOnLoadCallback(drawChart". $uniqueInt .");
        ";
        if (!empty($this->extraData)) {
            $js .= "
                function drawChart". $uniqueInt ."() {

                    var oldData". $uniqueInt ." = google.visualization.arrayToDataTable(". Json::encode($this->data) .");

                    var newData". $uniqueInt ." = google.visualization.arrayToDataTable(". Json::encode($this->extraData) .");

                    var options". $uniqueInt ." = ". Json::encode($this->options) .";

                    var pie". $uniqueInt ." = new google.visualization.PieChart($('#". $this->id ."')[0]);

                    var diffData". $uniqueInt ." = pie". $uniqueInt .".computeDiff(oldData". $uniqueInt .", newData". $uniqueInt .");

                    pie". $uniqueInt .".draw(diffData". $uniqueInt .", options". $uniqueInt .");
                }
            ";
        } else {
            $js .= "
                function drawChart". $uniqueInt ."() {

                    var data". $uniqueInt ." = google.visualization.arrayToDataTable(". Json::encode($this->data) .");

                    var options". $uniqueInt ." = ". Json::encode($this->options) .";

                    var pie". $uniqueInt ." = new google.visualization.PieChart($('#". $this->id ."')[0]);

                    pie". $uniqueInt .".draw(data". $uniqueInt .", options". $uniqueInt .");
                }
            ";            
        }

        return $js;
    }   
}
