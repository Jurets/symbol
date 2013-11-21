<?php
//DebugBreak();

// Display attributes
foreach($attributes as $attrData)
{
    $limits = array();
    $arr = array();
    
    foreach($attrData['filters'] as $filter)
    {
        $url = Yii::app()->request->addUrlParam('/store/category/view', array($filter['queryKey'] => $filter['queryParam']), $attrData['selectMany']);
        $limits[$url] = $filter['title'];            
    }
    $arr[Yii::app()->request->removeUrlParam('/store/category/view', $filter['queryKey'])] = '-не выбран-';
    $limits = $arr + $limits;
    echo '<div>';
    echo '<label for="">'.mb_substr($attrData["title"], 0,8,'UTF-8').'</label>';
    echo CHtml::dropDownList($attrData['title'], Yii::app()->request->url, $limits, array('onchange'=>'applyCategorySorter(this)'));
    echo '</div>';

}

?>