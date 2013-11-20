<?php
//DebugBreak();

// Display attributes
foreach($attributes as $attrData)
{
    $limits = array();
    foreach($attrData['filters'] as $filter)
    {
        $url = Yii::app()->request->addUrlParam('/store/category/view', array($filter['queryKey'] => $filter['queryParam']), $attrData['selectMany']);
        $limits[$url] = $filter['title'];            
    }
    echo '<div>';
    echo '<label for="">'.mb_substr($attrData["title"], 0,5,'UTF-8').'</label>';
    echo CHtml::dropDownList($attrData['title'], Yii::app()->request->url, $limits, array('onchange'=>'applyCategorySorter(this)'));
    echo '</div>';

}

?>