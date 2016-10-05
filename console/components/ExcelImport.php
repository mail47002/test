<?php
namespace console\components;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\Profile;
use common\models\UserMails;

use \PHPExcel;
use \PHPExcel_IOFactory;
use \PHPExcel_Settings;
use \PHPExcel_Style_Fill;
use \PHPExcel_Writer_IWriter;
use \PHPExcel_Worksheet;

/**
 * Login form
 */
class ExcelImport extends Model
{
	private $users;
	private $points;

	public function run(){
		$this->loadArrays();
		if(!empty($this->users)) {
			$this->insertData();
		}
	}

	private function loadArrays(){

		$objReader = PHPExcel_IOFactory::createReader("Excel5");
		$objPHPExcel = $objReader->load("/var/www/html/frontend/web/uploads/exchange/import.xls"); 
		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
			$arrayData = $worksheet->toArray();
		}

		foreach($arrayData as $key => $value) {
			if($key == 0) {
				continue;
			}
			if( substr_count($value[0], 'smp-') == 0 ) {
				continue;
			}
			$id = (int)str_replace('smp-', '', $value[0]);
			if( $value[2] == 'Пройден' ) {
				$this->users[$id] = true;
			} else {
				$this->users[$id] = false;
			}

			$this->points[$id] = (int)$value[1];
		}
	}

	private function insertData(){
		foreach($this->users as $id => $passed) {
			$user = User::findUserById($id);
			if(!$user) {
				continue;
			}
			if($passed === true && $user->role < 10) {
				$user->changeRoleSilence(10);
				$this->sendEmail($user);
			}
			if(isset($this->points[$id]) && $this->points[$id] !== null) {
				$profile = Profile::findById($id);
				if( $profile->sdo_points != $this->points[$id] ) {
					$profile->changeSdoPoints($this->points[$id]);
				}
			}
		}
	}


    /**
     * Sends an email to admin and user.
     *
     * @return boolean whether the email was send
     */
    private function sendEmail($user)
    {
		$mail = new UserMails;
		$mail->sendAdminEmail('admin-sdo', $user);
		return $mail->sdoSuccessEmail($user);
    }
}