<?php

namespace bsadnu\googlecharts;

use Yii;
use bsadnu\googlecharts\GoogleJsApiAsset;
use yii\helpers\Html;
use yii\web\View;

/**
 * Column chart widget.ttt
 * @author Stanislav Bannikov <bsadnu@gmail.com>
 */
class ColumnChart extends Widget
{

    /**
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
     */
    public function init()
    {
        parent::init();
        $view = Yii::$app->getView();
        $this->registerAssets();
        $view->registerJs($this->getJs());
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $content = Html::tag('div', null, ['id'=>'google-column']);

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
        $js = [];
        $js [] = "function drawColumn(){var o=google.visualization.arrayToDataTable([['Year','Sales','Expenses'],['2004',1e3,400],['2005',1170,460],['2006',660,1120],['2007',1030,540]]),e={fontName:'Roboto',height:400,fontSize:12,chartArea:{left:'5%',width:'90%',height:350},tooltip:{textStyle:{fontName:'Roboto',fontSize:13}},vAxis:{title:'Sales and Expenses',titleTextStyle:{fontSize:13,italic:!1},gridlines:{color:'#e5e5e5',count:10},minValue:0},legend:{position:'top',alignment:'center',textStyle:{fontSize:12}}},t=new google.visualization.ColumnChart($('#google-column')[0]);t.draw(o,e)}google.load('visualization','1',{packages:['corechart']}),google.setOnLoadCallback(drawColumn),$(function(){function o(){drawColumn()}$(window).on('resize',o),$('.sidebar-control').on('click',o)});";
        return implode("\n", $js);
    }   
}
