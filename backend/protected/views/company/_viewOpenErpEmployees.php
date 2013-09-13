<?php
    echo "<h2>".Yii::t('Company', 'Employees')."</h2>";
    $gridDataProvider = new CArrayDataProvider($OEHrEmployees, array(           
        'pagination'=>array(
            'pageSize' => 5,
         ),
    ));

    $gridColumns = array(
        array('name'=>'name_related'),
        array('name'=>'create_date'),
        array(
            'htmlOptions' => array('nowrap'=>'nowrap'),
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'viewButtonUrl'=>'Yii::app()->createUrl("/bankAccount/view", array("id" => $data["id"]))',
            'buttons'=>array(
                'update'=>array('visible'=>'false',),
                'delete'=>array('visible'=>'false',),
            ),
        )
    );

    $this->widget('bootstrap.widgets.TbGridView', array(
        'type'=>'striped',
        'dataProvider'=>$gridDataProvider,
        'template'=>"{items}{pager}",
        'columns'=>$gridColumns,
    ));
?>
