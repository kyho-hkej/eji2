<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

class UserIdentity extends User implements IdentityInterface
{

	protected $_id;

	/**
	 * Authenticates a user by a UUID.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticateUUID($uuid)
	{
		if(!$uuid)
			return false;
	
		$currentUser=CurrentUser::model()->findbyAttributes(array('uuid'=>$uuid));
		if($currentUser){
			if(!$currentUser->isExpired()){
				$sql="SELECT user_id, login, password, firstname, lastname, forumname, enable, deleted, contact_email, createdate, member_type, agentname,
                     case when hkej_member.subscribe_enddate < cast(now() as date) then 'Y' else 'N' end as expired from hkej_member
                                        WHERE login = '".$currentUser->login. "'  ";
				$hkej_member = app()->dbMainsiteRemoteWeb->createCommand($sql)->queryRow();				
				if($hkej_member){					
					$hkej_member['subscriptions']=$this->getSubscriptions($hkej_member['user_id']);
					$this->_id=$hkej_member['user_id'];
					$this->username=$hkej_member['login'];
					$this->errorCode=self::ERROR_NONE;
					// add session
					app()->session->add('profile', $hkej_member);
					// add domain cookie for targeting AD banner
					//$currentUser->addCrmUserType();								
					app()->request->cookies['uuid2'] = new CHttpCookie('uuid2', md5($hkej_member['user_id']), $options=array('domain'=>'.hkej.com'));
				
					//edit 20160926
					$profile=app()->session->get('profile');
					if ($profile['member_type'] == 'HKEJ_STAFF' || $profile['member_type'] == 'VIP') {	//HKEJ staff or VIP					
						app()->request->cookies['HKEJ004'] = new CHttpCookie('HKEJ004', 'M13', $options=array('domain'=>'.hkej.com'));
					//} else if ($profile['member_type'] == 'ORDINARY') {
						//app()->request->cookies['HKEJ004'] = new CHttpCookie('HKEJ004', 'M02', $options=array('domain'=>'.hkej.com'));					
					} else if ($profile['agentname']){ 
						app()->request->cookies['HKEJ004'] = new CHttpCookie('HKEJ004', 'M03', $options=array('domain'=>'.hkej.com'));
					} else {
					//edit 20160926 end
					
					// adding domain cookies hkej001, hkej002, hkej003 for subscription promotion
					// if S1 is expired $hkej_member['subscriptions'] will be exmpty, use another getExpiredSubscriptions() to retrieve the expiry date of latest subscription					
					//edit 20160926
					If (!$hkej_member['subscriptions']){
						$hkej_member['subscriptions']=$this->getExpiredSubscriptions($hkej_member['user_id']);
						//pr($hkej_member['subscriptions']);
						foreach ($hkej_member['subscriptions'] as $subscription){
							if ($subscription['service_code'] == 'S1'){
								$S1_end_date = $subscription['expiry_date'];																	
								$today_date=date_create(date('Y-m-d', time()));
								$diff = $today_date->diff(date_create($S1_end_date));
								$days_left=$diff->format("%R%a");
								//echo $days_left;
								if ( $days_left <= -31) { //expiry date > 1 month as of today
									//echo 'Message 2';
									app()->request->cookies['HKEJ004'] = new CHttpCookie('HKEJ004', 'M02', $options=array('domain'=>'.hkej.com'));
								} else { //expiry date within 1 month as of today
									//echo 'Message 4 '.$S1_end_date;
									app()->request->cookies['HKEJ004'] = new CHttpCookie('HKEJ004', 'M04', $options=array('domain'=>'.hkej.com'));
								}
							}
						} //edit 20160926 end
					} else {
					//add domain cookie for S1 service expiry date
					foreach ($hkej_member['subscriptions'] as $subscription){
						if ($subscription['service_code'] == 'S1'){
							//mask the expiry date, convert it to UNIX timestamp+7 
							$e=strtotime($subscription['expiry_date'])+7;						
							app()->request->cookies['HKEJ001'] = new CHttpCookie('HKEJ001', $e, $options=array('domain'=>'.hkej.com'));
							
							//check user's credit card expiry date (MM/YY)
							$sql3="CALL sp_get_creditcard_expiry_date(:id, @isGet, @cardM, @cardY)";
							$cmd = app()->dbMainsiteRemoteWeb->createCommand($sql3);
							$cmd->bindParam(":id", $this->_id, PDO::PARAM_INT);
							$cmd->execute();
							$result = app()->dbMainsiteRemoteWeb->createCommand('SELECT @isGet, @cardM, @cardY')->queryRow();
							
							if (!empty($result)) {
								$isGet = $result['@isGet'];
								$cardMM = sprintf("%02d", $result['@cardM']); //append leading 0
								$cardYY = $result['@cardY'];
							
								//echo sprintf("%02d", $cardMM).'-'.$cardYY;
								if ($isGet != 0) { //with valid credit card info $isGet==1																		

									$isGet = $result['@isGet'];
									$cardMM = sprintf("%02d", $result['@cardM']); //append leading 0
									$cardYY = $result['@cardY'];
									
									//echo sprintf("%02d", $cardMM).'-'.$cardYY;
									if ($isGet != 0) { //with valid credit card info $isGet==1
										$dateyear = $cardMM.'/1/'.$cardYY;
										$lastday = $cardYY.'-'.$cardMM.'-'.date('t',strtotime($dateyear)); //find last day of the month	in yy-mm-dd
										$end_date = date_create_from_format('y-m-j', $lastday); // convert yy-mm-dd -> yyyy-mm-dd
										//$S1_end_date = $this->unmaskExpiryDate();
										
										//echo 'credit card end date '.$end_date->format('Y-m-d');
										//add credit card end date to domain cookie HKEJ004
										//mask the date, convert it to UNIX timestamp+7
										$e=(string)$end_date->format('Y-m-d');
										$cardend=strtotime($e)+7;
										//$cardend=$end_date->format('Y-m-d');
										
										//app()->request->cookies['HKEJ004'] = new CHttpCookie('HKEJ004', $cardend, $options=array('domain'=>'.hkej.com'));
										
										$S1_end_date=$subscription['expiry_date'];
									
										if ($end_date->format('Y-m-d') > $S1_end_date){
											$diff = $end_date->diff(date_create($S1_end_date));
											$months_left=(($diff->format('%y') * 12) + $diff->format('%m'));
											//card expires same month as S1 returns 0
											if ($months_left === 0) {
												app()->request->cookies['HKEJ003'] = new CHttpCookie('HKEJ003', '0', $options=array('domain'=>'.hkej.com'));
												//card expiry date > S1 more than 1 month returns 1
											} else if ($months_left >=1){
												app()->request->cookies['HKEJ003'] = new CHttpCookie('HKEJ003', '1', $options=array('domain'=>'.hkej.com'));
											}
										} else {
											//card expires earlier than S1, always returns -1
											app()->request->cookies['HKEJ003'] = new CHttpCookie('HKEJ003', '-1', $options=array('domain'=>'.hkej.com'));
										}
									}
									
									
								} else { //no valid card info
									app()->request->cookies['HKEJ003'] = new CHttpCookie('HKEJ003', '-9999', $options=array('domain'=>'.hkej.com'));
								}
							}
							
							
							
							//edit 20160926
							//check if users got auto renew successfully setup
							$sql2="SELECT user_id, service_code, status from hkej_auto_renew_approval WHERE user_id ='".$this->_id."' AND service_code='S1' AND status='Y' ";
							$auto_renew = app()->dbMainsiteRemoteWeb->createCommand($sql2)->queryRow();
							if (!$auto_renew) {
								app()->request->cookies['HKEJ002'] = new CHttpCookie('HKEJ002', '0', $options=array('domain'=>'.hkej.com'));
							} else {
								app()->request->cookies['HKEJ002'] = new CHttpCookie('HKEJ002', '1', $options=array('domain'=>'.hkej.com'));
							}
							// adding domain cookies hkej001, hkej002, hkej003 END
							
							//edit 20180321
							//check if the user is on hkej_member_stripe, 0=NO, 1=YES
							$sql4="SELECT * FROM hkej_member_stripe WHERE stripe_profile = 'EJM' AND user_id ='".$this->_id."'";
							$is_stripe = app()->dbEntitlement->createCommand($sql4)->queryRow();
							if (!$is_stripe) {
								app()->request->cookies['HKEJ005'] = new CHttpCookie('HKEJ005', '0', $options=array('domain'=>'.hkej.com'));
							} else {
								app()->request->cookies['HKEJ005'] = new CHttpCookie('HKEJ005', '1', $options=array('domain'=>'.hkej.com'));
							}
							//adding domain cookie hkej005 END
														
							$S1_end_date = $subscription['expiry_date'];
							$today_date=date_create(date('Y-m-d', time()));
							$diff = $today_date->diff(date_create($S1_end_date));
							$days_left=$diff->format("%R%a");
								
							$autoRenew=app()->request->cookies['HKEJ002'];
							if ($autoRenew=='0') {
								if ($days_left <= 10) { //S1 expires within 10 days
									app()->request->cookies['HKEJ004'] = new CHttpCookie('HKEJ004', 'M07', $options=array('domain'=>'.hkej.com'));
								} else if (($days_left > 10) &&  ($days_left <= 60 )) {
									app()->request->cookies['HKEJ004'] = new CHttpCookie('HKEJ004', 'M06', $options=array('domain'=>'.hkej.com'));
								} else if (($days_left > 60) &&  ($days_left <= 90 )) {
									app()->request->cookies['HKEJ004'] = new CHttpCookie('HKEJ004', 'M05', $options=array('domain'=>'.hkej.com'));
								} else if ($days_left > 90 ){ //S1 expires > 3 months
									app()->request->cookies['HKEJ004'] = new CHttpCookie('HKEJ004', 'M08', $options=array('domain'=>'.hkej.com'));
								}
							} else if ($autoRenew=='1') {
								$expiry=app()->request->cookies['HKEJ003'];
									
								if ($expiry!='-1') {
									app()->request->cookies['HKEJ004'] = new CHttpCookie('HKEJ004', 'M12', $options=array('domain'=>'.hkej.com'));
								} else { //card expired before S1
									if ($days_left <= 10) { //S1 expires within 10 days
										app()->request->cookies['HKEJ004'] = new CHttpCookie('HKEJ004', 'M11', $options=array('domain'=>'.hkej.com'));
									} else if (($days_left > 10) &&  ($days_left <= 60 )) {
										app()->request->cookies['HKEJ004'] = new CHttpCookie('HKEJ004', 'M10', $options=array('domain'=>'.hkej.com'));
									} else if (($days_left > 60) &&  ($days_left <= 90 )) {
										app()->request->cookies['HKEJ004'] = new CHttpCookie('HKEJ004', 'M09', $options=array('domain'=>'.hkej.com'));
									} else if ($days_left > 90 ){ //S1 expires > 3 months
										app()->request->cookies['HKEJ004'] = new CHttpCookie('HKEJ004', 'M12', $options=array('domain'=>'.hkej.com'));
									}
								}
							}
							//edit 20160926 end							
							}
						}
					}										
					er('UserIdentity/authenticateUUID: '.$uuid .' success');
					}
				}else{
					er('UserIdentity/authenticateUUID: '.$uuid .' failed');
				}
				
			}else{						
				app()->request->cookies['HKEJ004'] = new CHttpCookie('HKEJ004', 'M01', $options=array('domain'=>'.hkej.com'));
				er('UserIdentity/authenticateUUID: '.$uuid .' already expired');
			}
		} 
		
		return $this->errorCode==self::ERROR_NONE;
		
	}

	/**
	 * @return integer the ID of the user record
	 */
	public function getId()
	{
		return $this->_id;
	}	

}


?>
