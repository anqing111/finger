<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 2020/7/6
 * Time: 19:03
 */

namespace app\models;
use Yii;
use yii\base\Model;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

class VideoForm extends Model{

    const AccessKeyId = 'LTAI4GKTD7QTvadk6cwDtdLK';
    const AccessKeySecret = 'HM8ZnW3s5rdgBIBIF8o3cCIYyXjAjB';
    /**
     * 获取视频上传地址和凭证
     * @param client 发送请求客户端
     * @return CreateUploadVideoResponse 获取视频上传地址和凭证响应数据
     */
    public static function createUploadVideo($title,$filename) {

        $resCode = 0;
        AlibabaCloud::accessKeyClient(self::AccessKeyId, self::AccessKeySecret)
            ->regionId('cn-hangzhou')
            ->asDefaultClient();

        try {
            $result = AlibabaCloud::rpc()
                ->product('vod')
                // ->scheme('https') // https | http
                ->version('2017-03-21')
                ->action('CreateUploadVideo')
                ->method('POST')
                ->host('vod.cn-shanghai.aliyuncs.com')
                ->options([
                    'query' => [
                        'RegionId' => "cn-hangzhou",
                        'Title' => $title,
                        'FileName' => $filename,
                    ],
                ])
                ->request();
        } catch (ClientException $e) {
            return $resCode;
        } catch (ServerException $e) {
            return $resCode;
        }

        $res = $result->toArray();
        if(empty($res['Code']))
        {
            $resCode = 1;
            self::getPlayInfo();
        }
        return $resCode;
    }
    //获取播放凭证
    public static function getPlayInfo($videoId) {
        $resCode = 0;
        AlibabaCloud::accessKeyClient(self::AccessKeyId, self::AccessKeySecret)
            ->regionId('cn-hangzhou')
            ->asDefaultClient();

        try {
            $result = AlibabaCloud::rpc()
                ->product('vod')
                // ->scheme('https') // https | http
                ->version('2017-03-21')
                ->action('getPlayInfo')
                ->method('POST')
                ->host('vod.cn-shanghai.aliyuncs.com')
                ->options([
                    'query' => [
                        'RegionId' => "cn-hangzhou",
                        'Videoid' => $videoId,
                    ],
                ])
                ->request();
        } catch (ClientException $e) {
            return $resCode;
        } catch (ServerException $e) {
            return $resCode;
        }

        $res = $result->toArray();
    }
    /*public static function getPlayInfo($client, $videoId) {
        $request = new GetPlayInfoRequest();
        $request->setVideoId($videoId);
        $request->setAuthTimeout(3600*24);
        $request->setAcceptFormat('JSON');
        return $client->getAcsResponse($request);
    }

    public static function initVodClient($accessKeyId, $accessKeySecret) {
        $regionId = 'cn-shanghai';  // 点播服务接入区域
        $profile = DefaultProfile::getProfile($regionId, $accessKeyId, $accessKeySecret);
        return new DefaultAcsClient($profile);
    }*/


}