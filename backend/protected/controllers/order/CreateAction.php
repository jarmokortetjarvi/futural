<?php
class CreateAction extends CAction
{
    private $runLog;
    
    /**
     * Lists all models.
     */
    public function run()
    {
        $controller=$this->getController();
        $controller->allowUser(ADMIN);
        
        $this->log("Creating orders started on ".date('Y-m-d H:i:s'));
    
        // 1. Check if orders are already made for this week
        $this->log("TODO: check if orders have already been made");
        
        // 2. Get supplier firms
        $supplierCompanies = Yii::app()->db->createCommand()
                ->select('tag, name')
                ->from('company')
                ->queryAll();
        $this->log("Got ".count($supplierCompanies)." suppliers.");
        
        // Get supplier names in array
        $supplierNames = null;
        foreach($supplierCompanies as $company){
            $supplierNames.="$company[tag],";
        }
        $supplierNames = substr($supplierNames, 0, -1);
        
        // Get all suppliers that exist in OpenERP
        $supplierOpenerp = Yii::app()->dbopenerp->createCommand()
            ->select('datname')
            ->from('pg_database')
            ->where('datistemplate = false AND datname = ANY(\'{'.$supplierNames.'}\')')
            ->queryAll();
        // Existing suppliers to array
        $existingSuppliers = array();
        foreach($supplierOpenerp as $supplier){
            $existingSuppliers[$supplier['datname']] = $supplier['datname'];
        }
        
        $supplierData=new CActiveDataProvider('Company');

        // 3. Get customer firms
        $customerCompanies = Yii::app()->dbopenerp->createCommand()
            ->select('name')
            ->from('res_company')
            ->queryAll();
        
        $this->log("Got ".count($customerCompanies)." customers");
        
        // 4. Run through each supplier
        foreach($supplierCompanies as $supplier){
            if(!array_key_exists($supplier['tag'], $existingSuppliers)) continue;
            
            $this->log("Using $supplier[name] ($supplier[tag]) .");
        }
        
        $customerData=new CActiveDataProvider('ResCompany');
        
        $model=new Order;
        
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Order']))
        {
                $model->attributes=$_POST['Order'];
                if($model->save())
                    $this->redirect(array('view','id'=>$model->id));
        }

        $controller->render('create',array(
                'model'=>$model,
                'runLog'=>$this->runLog,
                'customerData'=>$customerData,
                'supplierData'=>$supplierData,
        ));
    }
    
    private function log($entry){
        $timestamp = date('H:i:s');
        $this->runLog[]= "$timestamp - $entry";
    }
}
?>