<?php
namespace common\components\rbac;

use Yii;
use yii\rbac\Rule;
use common\models\User;

/**
 * User group rule class.
 */
class GroupRule extends Rule
{
    /**
     * @inheritdoc
     */
    public $name = 'group';
 
    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {
        if (!Yii::$app->user->isGuest) {
            $role = Yii::$app->user->identity->role;
 
            if ($item->name == User::ROLE_GOD_MODE) {
                return $role == User::ROLE_GOD_MODE_ID;
            } elseif ($item->name === User::ROLE_ADMIN) {
                return	$role === User::ROLE_ADMIN_ID ||
						$role === User::ROLE_GOD_MODE_ID;
            } elseif ($item->name === User::ROLE_ANALYST) {
                return	$role === User::ROLE_ANALYST_ID ||
						$role === User::ROLE_GOD_MODE_ID ||
						$role === User::ROLE_ADMIN_ID;
            } elseif ($item->name === User::ROLE_EDITOR) {
                return	$role === User::ROLE_EDITOR_ID ||
						$role === User::ROLE_GOD_MODE_ID ||
						$role === User::ROLE_ADMIN_ID ||
						$role === User::ROLE_ANALYST_ID;
            } elseif ($item->name === User::ROLE_SENIOR_SELLER) {
                return	$role === ser::ROLE_SENIOR_SELLER_ID ||
						$role === User::ROLE_GOD_MODE_ID ||
						$role === User::ROLE_ADMIN_ID ||
						$role === User::ROLE_ANALYST_ID ||
						$role === User::ROLE_EDITOR_ID;
            } elseif ($item->name === User::ROLE_SELLER) {
                return	$role === User::ROLE_SELLER_ID ||
						$role === User::ROLE_GOD_MODE_ID ||
						$role === User::ROLE_ADMIN_ID ||
						$role === User::ROLE_ANALYST_ID ||
						$role === User::ROLE_EDITOR_ID ||
						$role === User::ROLE_SENIOR_SELLER_ID;
            } elseif ($item->name === User::ROLE_STUDY) {
                return	$role === User::ROLE_STUDY_ID ||
						$role === User::ROLE_GOD_MODE_ID ||
						$role === User::ROLE_ADMIN_ID ||
						$role === User::ROLE_ANALYST_ID ||
						$role === User::ROLE_EDITOR_ID ||
						$role === User::ROLE_SENIOR_SELLER_ID ||
						$role === User::ROLE_SELLER_ID;
            } elseif ($item->name === User::ROLE_SDO) {
                return	$role === User::ROLE_SDO_ID ||
						$role === User::ROLE_GOD_MODE_ID ||
						$role === User::ROLE_ADMIN_ID ||
						$role === User::ROLE_ANALYST_ID ||
						$role === User::ROLE_EDITOR_ID ||
						$role === User::ROLE_SENIOR_SELLER_ID ||
						$role === User::ROLE_SELLER_ID ||
						$role === User::ROLE_STUDY_ID;
            } elseif ($item->name === User::ROLE_PROOF) {
                return	$role === User::ROLE_PROOF_ID ||
						$role === User::ROLE_GOD_MODE_ID ||
						$role === User::ROLE_ADMIN_ID ||
						$role === User::ROLE_ANALYST_ID ||
						$role === User::ROLE_EDITOR_ID ||
						$role === User::ROLE_SENIOR_SELLER_ID ||
						$role === User::ROLE_SELLER_ID ||
						$role === User::ROLE_STUDY_ID ||
						$role === User::ROLE_SDO_ID;
            } elseif ($item->name === User::ROLE_VERIFICATION) {
                return	$role === User::ROLE_VERIFICATION_ID ||
						$role === User::ROLE_GOD_MODE_ID ||
						$role === User::ROLE_ADMIN_ID ||
						$role === User::ROLE_ANALYST_ID ||
						$role === User::ROLE_EDITOR_ID ||
						$role === User::ROLE_SENIOR_SELLER_ID ||
						$role === User::ROLE_SELLER_ID ||
						$role === User::ROLE_STUDY_ID ||
						$role === User::ROLE_SDO_ID ||
						$role === User::ROLE_PROOF_ID;
            }
        }
        return false;
    }
}
?>