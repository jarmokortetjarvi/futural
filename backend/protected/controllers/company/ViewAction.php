<?php
class ViewAction extends CAction
{
    public function run($id)
    {
        $controller=$this->getController();
        $controller->allowUser(MANAGER);
        
        $action = isset($_GET['action']) ? $_GET['action'] : null;
        $company = $controller->loadModel($id);
        $bankUser = BankUser::model()->findByAttributes(array('username'=>$company->tag));
        
        // Format variables so we don't need multiple renderers
        $costBenefitCalculationsArray = null;
        $realizedItemsArray = null;
        $bankAccounts = null;
        $OEHrEmployees = null;
        $OESaleOrders = null;
        $OEPurchaseOrders = null;
        $remarks = null;
        
        // Change OpenERP-database
        Yii::app()->dbopenerp->setActive(false);
        Yii::app()->dbopenerp->connectionString = "pgsql:host=erp.futurality.fi;dbname={$company->tag}";
        Yii::app()->dbopenerp->setActive(true);
        
        if($action=='bankAccounts' OR $action=='costBenefitCalculation'){
            $bankAccounts = BankAccount::model()->findAll(
                array(
                    'condition'=>'bank_user_id=:bank_user_id', 
                    'params'=>array('bank_user_id'=>$bankUser->id),
                )
            );
        }
        
        if($action=='costBenefitCalculation'){

            $costBenefitCalculations = CostbenefitCalculation::model()->findAllByAttributes(array('company_id'=>$company->id));
            $costBenefitCalculationsArray = array();
            foreach($costBenefitCalculations as $costBenefitCalculation){
                $costBenefitCalculationsArray[ $costBenefitCalculation->id ][ 'create_date' ] = date('d.m.Y', strtotime($costBenefitCalculation->create_date));
                
                foreach($costBenefitCalculation->costbenefitItems as $CBCItem){
                    $key = $CBCItem->costbenefitItemType->name;
                    $costBenefitCalculationsArray[ $costBenefitCalculation->id ][ $key ] = $CBCItem;
                };
                // Add side expenses to the salaries
                $costBenefitCalculationsArray[ $costBenefitCalculation->id ][ 'salaries' ]->value += $costBenefitCalculationsArray[ $costBenefitCalculation->id ][ 'sideExpenses' ]->value;
            }

            // Get the realized sales
            $criteria=new CDbCriteria;
            $criteria->select='date_trunc(\'week\', create_date) AS week, account_id, SUM(credit) AS credit, SUM(debit) AS debit';
            $criteria->group='week, account_id';
            $criteria->order='week, account_id';

            $realizedItemsArray = array();
            $accountMoveLines = AccountMoveLine::model()->findAll($criteria);
            foreach($accountMoveLines as $accountMoveLine){
                $realizedItemsArray[ date('W', strtotime($accountMoveLine->week)) ][ $accountMoveLine->account->code ] = $accountMoveLine['credit'] - $accountMoveLine['debit'];
            }
        }
        elseif($action=='employees'){
            $OEHrEmployees = HrEmployee::model()->findAll(array('order'=>'name_related'));
        }
        
        elseif($action=='saleOrders'){
            $OESaleOrders = SaleOrder::model()->findAll(array('order'=>'create_date DESC'));
        }
        
        elseif($action=='purchaseOrders'){
            $OEPurchaseOrders = PurchaseOrder::model()->findAll(array('order'=>'create_date DESC'));
        }
        elseif($action=='remarks'){
            $remarks = Remark::model()->findAll(array('condition'=>"company_id={$company->id}"));
        }

        $controller->render('view',array(
            'action'=>$action,
            'company'=>$company,
            'costBenefitCalculations'=>$costBenefitCalculationsArray,
            'realizedItemsArray'=>$realizedItemsArray,
            'bankAccounts'=>$bankAccounts,
            'OEHrEmployees'=>$OEHrEmployees,
            'OESaleOrders'=>$OESaleOrders,
            'OEPurchaseOrders'=>$OEPurchaseOrders,
            'remarks'=>$remarks,
        ));
    }
}
?>