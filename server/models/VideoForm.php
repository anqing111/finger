<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 2020/7/6
 * Time: 19:03
 */

namespace app\models;
use app\modules\wap\controllers\BaseController;
use Vod\Request\V20170321\CreateUploadVideoRequest;
use Vod\Request\V20170321\GetPlayInfoRequest;
use Vod\Request\V20170321\GetVideoPlayAuthRequest;
use Yii;
use yii\base\Model;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use yii\helpers\Json;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'lib/voduploadsdk' . DIRECTORY_SEPARATOR . 'Autoloader.php';
class VideoForm extends Model{

    const AccessKeyId = 'LTAI4G5bTWKmihQHeNRfixxs';
    const AccessKeySecret = 'vZv0Sq1qyPD1bQ8QSZ3GjI0QfNtMfP';
    /**
     * 获取视频上传地址和凭证
     * @param client 发送请求客户端
     * @return CreateUploadVideoResponse 获取视频上传地址和凭证响应数据
     */
//    public static function createUploadVideo($title,$filename) {
//        $resCode = 0;
//        AlibabaCloud::accessKeyClient(self::AccessKeyId, self::AccessKeySecret)
//            ->regionId('cn-hangzhou')
//            ->asDefaultClient();
////ad652f1e-d427-4f88-be26-0a1cd3a2da94
//        try {
//            $result = AlibabaCloud::rpc()
//                ->product('vod')
//                // ->scheme('https') // https | http
//                ->version('2017-03-21')
//                ->action('CreateUploadVideo')
//                ->method('POST')
//                ->host('video.bazeskill.com')
//                ->options([
//                    'query' => [
//                        'RegionId' => "cn-shanghai",
//                        'Title' => $title,
//                        'FileName' => $filename,
//                    ],
//                ])
//                ->request();
//            $res = $result->toArray();
//            print_r($res);
//        } catch (ClientException $e) {
//            print_r($e->getMessage());
//        } catch (ServerException $e) {
//            print_r($e->getMessage());
//        }
//
//
//        die;
//        if(empty($res['Code']))
//        {
//            $resCode = 1;
//            self::getPlayInfo();
//        }
//        return $resCode;
//    }
    //获取播放凭证
//    public static function getPlayInfo($videoId) {
//        $resCode = 0;
//        AlibabaCloud::accessKeyClient(self::AccessKeyId, self::AccessKeySecret)
//            ->regionId('cn-hangzhou')
//            ->asDefaultClient();
//
//        try {
//            $result = AlibabaCloud::rpc()
//                ->product('vod')
//                // ->scheme('https') // https | http
//                ->version('2017-03-21')
//                ->action('getPlayInfo')
//                ->method('POST')
//                ->host('vod.cn-shanghai.aliyuncs.com')
//                ->options([
//                    'query' => [
//                        'RegionId' => "cn-hangzhou",
//                        'Videoid' => $videoId,
//                    ],
//                ])
//                ->request();
//        } catch (ClientException $e) {
//            return $resCode;
//        } catch (ServerException $e) {
//            return $resCode;
//        }
//
//        $res = $result->toArray();
//    }

    // 上传本地视频
    public static function uploadLocalVideo($title,$filename)
    {
        try {

            $uploader = new \AliyunVodUploader(self::AccessKeyId, self::AccessKeySecret);
            $uploadVideoRequest = new \UploadVideoRequest($filename, $title);
            //$uploadVideoRequest->setCateId(1);
            //$uploadVideoRequest->setCoverURL("http://xxxx.jpg");
            //$uploadVideoRequest->setTags('test1,test2');
            //$uploadVideoRequest->setStorageLocation('outin-xx.oss-cn-beijing.aliyuncs.com');
            //$uploadVideoRequest->setTemplateGroupId('6ae347b0140181ad371d197ebe289326');
            $userData = array(
                "MessageCallback"=>array("CallbackURL"=>Yii::$app->params['imagePath'].'/ProcessMessageCallback/index.php'),
                "Extend"=>array("localId"=>"xxx", "test"=>"www")
            );
            $uploadVideoRequest->setUserData(Json::encode($userData));
            $VideoId = $uploader->uploadLocalVideo($uploadVideoRequest);
            //存日志
            BaseController::log(Json::encode($VideoId),'video');

            return $VideoId;
        } catch (Exception $e) {
            $error = sprintf("testUploadLocalVideo Failed, ErrorMessage: %s\n Location: %s %s\n Trace: %s\n",
                $e->getMessage(), $e->getFile(), $e->getLine(), $e->getTraceAsString());
            BaseController::log('Exception:'.$error,'video');
        }
        return false;
    }
    //上传本地视频
    public static function createUploadVideo($client,$title,$filename)
    {
        $request = new CreateUploadVideoRequest();
        $request->setTitle($title);
        $request->setFileName($filename);
        $request->setDescription("Video Description");
        $request->setCoverURL("http://img.alicdn.com/tps/TB1qnJ1PVXXXXXCXXXXXXXXXXXX-700-700.png");
        $request->setTags("tag1,tag2");
        $request->setAcceptFormat('JSON');
        return $client->getAcsResponse($request);
    }
    //获取视频上传地址
    public static function getPlayInfo($client, $videoId) {
        $request = new GetPlayInfoRequest();
//        $request = new GetVideoPlayAuthRequest(); //获取上传凭证
        $request->setVideoId($videoId);
        $request->setAuthTimeout(3600*24);
//        $request->setAuthInfoTimeout(3600*24);
        $request->setAcceptFormat('JSON');
        return $client->getAcsResponse($request);
    }

    public static function initVodClient() {
        $regionId = 'cn-shanghai';  // 点播服务接入区域
        $profile = \DefaultProfile::getProfile($regionId, self::AccessKeyId, self::AccessKeySecret);
        return new \DefaultAcsClient($profile);
    }

}