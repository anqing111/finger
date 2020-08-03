<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 2020/7/6
 * Time: 19:03
 */

namespace app\models;
use app\models\db\BMsg;
use Yii;
use yii\base\Model;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use yii\helpers\Json;

class SMSForm extends Model{

    const AccessKeyId = 'LTAI4GKTD7QTvadk6cwDtdLK';
    const AccessKeySecret = 'HM8ZnW3s5rdgBIBIF8o3cCIYyXjAjB';
    const SMS_SIGN = '八泽国际';
    public static function sendDayuTextMsg($sPhone,$arPara,$sTemplate)
    {
        $retCode = 0;
        $message = Json::encode($arPara);
        if(empty($arPara))
        {
            return $retCode;
        }

        $query = [
            'RegionId' => 'cn-hangzhou',
            'PhoneNumbers' => $sPhone,
            'SignName' => self::SMS_SIGN,
            'TemplateCode' => $sTemplate,
            'TemplateParam' => $message
        ];

        AlibabaCloud::accessKeyClient(self::AccessKeyId, self::AccessKeySecret)
            ->regionId('cn-hangzhou')
            ->asDefaultClient();

        try {
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                // ->scheme('https') // https | http
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host('dysmsapi.aliyuncs.com')
                ->options([
                    'query' => $query,
                ])
                ->request();
        } catch (ClientException $e) {
            return $retCode;
        } catch (ServerException $e) {
            return $retCode;
        }

        $ret = $result->toArray();
        if($ret['Code']=='OK'){
            $retCode = 1;
            //下发日志记录
            $msgDBObj = new BMsg();

            $msgDBObj->sPhone = $sPhone;
            $msgDBObj->sMsg = $sTemplate.$message;
            $msgDBObj->iUserID = 0;
            $msgDBObj->sendresult = $retCode;
            $msgDBObj->save();
        }
        return $retCode;
    }

}