<?php

namespace console\controllers;

use Yii;
//use console\components\ExcelExport;
//use console\components\ExcelImport;
use common\models\UserMails;
use common\models\User;
//use console\models\Exchange;
use yii\console\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ExchangeController implements the CRUD actions for Profile model.
 */
class ExchangeController extends Controller
{

    /**
     * Lists all Profile models.
     * @return mixed
     */
    /*public function actionExport()
    {
        $searchModel = new Exchange();
        $dataProvider = $searchModel->search('', true);
		$dataProvider->pagination->pageSize=1000;
		$dataProvider->totalCount=1000;
		if( $dataProvider->totalCount == 0 ) {
			$path = '/var/www/html/frontend/web/uploads/exchange/profile.xlsx';
			if(is_file($path)) {
				unlink($path);
			}
			echo "Erased";
			return true;
		}
		echo "Exported";
		ExcelExport::run($searchModel, $dataProvider);

    }*/

    /**
     * Get SDO file.
     * @return mixed
     */
    public function actionUpload()
    {
		file_put_contents('/var/www/html/frontend/web/uploads/exchange/new_staff.xml',file_get_contents('http://213.169.78.29/new_staff.xml'));
		file_put_contents('/var/www/html/frontend/web/uploads/exchange/passed_staff.xml',file_get_contents('http://213.169.78.29/passed_staff.xml'));
	}

    /**
     * Get SDO file.
     * @return mixed
     */
    public function actionImport()
    {
		$mail = new UserMails;


		$xml_string = file_get_contents('/var/www/html/frontend/web/uploads/exchange/new_staff.xml');
		$xml = simplexml_load_string($xml_string);
		if( isset($xml->Staff->Collaborator) ) {
			foreach($xml->Staff->Collaborator as $user) {
				$id = explode('-',$user->code);
				$id = (int)$id[1];
				if( ($model = User::findOne($id)) == null) {
					throw new NotFoundHttpException('The requested page does not exist.');
				}
				if( $model->role == 5 ) {
					$model->changeRoleSilence(6);
					$mail->proofEmail($model);
				}
				//var_dump($model);
			}
		}

		$xml_string = file_get_contents('/var/www/html/frontend/web/uploads/exchange/passed_staff.xml');
		$xml = simplexml_load_string($xml_string);
		if( isset($xml->Staff->Collaborator) ) {
			foreach($xml->Staff->Collaborator as $user) {
				$id = explode('-',$user->code);
				$id = (int)$id[1];
				if( ($model = User::findOne($id)) == null) {
					throw new NotFoundHttpException('The requested page does not exist.');
				}
				if( $model->role == 6 ) {
					$model->changeRoleSilence(10);
					$mail->sendAdminEmail('admin-sdo', $model);
					return $mail->sdoSuccessEmail($model);
				}
				//var_dump($model);
			}
		}
	}
}