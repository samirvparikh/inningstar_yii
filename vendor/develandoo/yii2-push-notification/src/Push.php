<?php
/**
 * @author DEVELANDOO
 * @link http://develandoo.com
 */

namespace develandoo\notification;

use Exception;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class Push extends Component
{
    /* @var $APNS_ENVIRONMENT_SANDBOX */
    const APNS_ENVIRONMENT_SANDBOX = '.sandbox';

    /* @var $APNS_ENVIRONMENT_PRODUCTION */
    const APNS_ENVIRONMENT_PRODUCTION = '';

    /* @var $FCM_URL */
    const FCM_URL = 'https://fcm.googleapis.com/fcm/send';

    /* @var $TYPE_APNS */
    const TYPE_APNS = 'apns';

    /* @var $TYPE_GCM */
    const TYPE_GCM = 'gcm';

    /* @var $TYPE_FCM */
    const TYPE_FCM = 'fcm';

    /* @var  $apnsConfig array */
    public $apnsConfig;

    /* @var  $gcmConfig array */
    public $gcmConfig;

    /* @var  $fcmConfig array */
    public $fcmConfig;

    /* @var  $options array */
    public $options;

    /* @var  $type string */
    private $type;

    /* @var  $apnsEnabled boolean default is false */
    private $apnsEnabled = false;

    /* @var  $gcmEnabled boolean default is false */
    private $gcmEnabled = false;

    /* @var  $fcmEnabled boolean default is false */
    private $fcmEnabled = false;

    /* @var  $ctx object */
    private $ctx;

    /**
     *  Develandoo yii2 push notification
     */
    public function init()
    {
        parent::init();

        if (is_array($this->apnsConfig) && !empty($this->apnsConfig)) {
            $this->validateApns();
            $this->apnsEnabled = true;
        }

        if (is_array($this->gcmConfig) && !empty($this->gcmConfig)) {
            $this->validateGcm();
            $this->gcmEnabled = true;
        }

        if (is_array($this->fcmConfig) && !empty($this->fcmConfig)) {
            $this->validateFcm();
            $this->fcmEnabled = true;
        }
    }

    /**
     * @throws InvalidConfigException
     */
    private function validateApns()
    {
        if (!ArrayHelper::keyExists('environment', $this->apnsConfig) || !ArrayHelper::isIn(ArrayHelper::getValue($this->apnsConfig, 'environment'), [
                self::APNS_ENVIRONMENT_SANDBOX, self::APNS_ENVIRONMENT_PRODUCTION])
        ) {
            throw new InvalidConfigException('Apns environment is invalid.');
        }

        if (ArrayHelper::keyExists('pem', $this->apnsConfig)) {
            if (0 === strpos(ArrayHelper::getValue($this->apnsConfig, 'pem'), '@')) {
                $path = Yii::getAlias(ArrayHelper::getValue($this->apnsConfig, 'pem'));
            } else {
                $path = ArrayHelper::getValue($this->apnsConfig, 'pem');
            }

            if (!is_file($path)) {
                throw new InvalidConfigException('Apns pem is invalid.');
            }

            $this->apnsConfig['pem'] = $path;
        } else {
            throw new InvalidConfigException('Apns pem is required.');
        }
    }

    /**
     * @throws InvalidConfigException
     */
    private function validateGcm()
    {
        if (!ArrayHelper::keyExists('apiAccessKey', $this->gcmConfig)) {
            throw new InvalidConfigException('Gcm api access key is invalid.');
        }
    }

    /**
     * @throws InvalidConfigException
     */
    private function validateFcm()
    {
        if (empty($this->fcmConfig) || !ArrayHelper::keyExists('apiAccessKey', $this->fcmConfig)) {
            throw new InvalidConfigException('Fcm api access key is not defined.');
        }
    }

    /**
     * @param array $tokens
     * @return array
     */
    private function splitDeviceTokens($tokens)
    {
        $apnsTokens = [];
        $firebaseTokens = [];
        $invalidTokens = [];

        foreach ($tokens as $token) {
            if (strlen($token) == 64) {
                $apnsTokens[] = $token;
            } elseif (strlen($token) == 152) {
                $firebaseTokens[] = $token;
            } else {
                $invalidTokens[] = $token;
            }
        }

        return [
            'apns' => $apnsTokens,
            'firebase' => $firebaseTokens,
            'invalid' => $invalidTokens
        ];
    }

    /**
     * @return Push
     */
    public function firebase()
    {
        $this->type = self::TYPE_FCM;
        return $this;
    }

    /**
     * @return Push
     */
    public function android()
    {
        $this->type = self::TYPE_GCM;
        return $this;
    }

    /**
     * @return Push
     */
    public function ios()
    {
        $this->type = self::TYPE_APNS;
        return $this;
    }

    /**
     * @param array $tokens
     * @param array $payload
     * @return mixed
     * @throws Exception
     */
    public function send($tokens, $payload = [])
    {
        if ($this->type) {
            switch ($this->type) {
                case self::TYPE_GCM:
                    self::sendGcm($tokens, $payload);
                    break;
                case self::TYPE_FCM:
                    self::sendFcm($tokens, $payload);
                    break;
                case self::TYPE_APNS:
                    self::sendApns($tokens, $payload);
                    break;
            }
        } else {
            $tokens = self::splitDeviceTokens($tokens);

            if ($this->apnsEnabled && !empty(ArrayHelper::getValue($tokens, 'apns'))) {
                self::sendApns(ArrayHelper::getValue($tokens, 'apns'), $payload);
            }

            if (!empty(ArrayHelper::getValue($tokens, 'firebase'))) {
                if ($this->gcmEnabled) {
                    self::sendGcm(ArrayHelper::getValue($tokens, 'firebase'), $payload);
                } elseif ($this->fcmEnabled) {
                    self::sendFcm(ArrayHelper::getValue($tokens, 'firebase'), $payload);
                }

            }

            if (is_array($this->options) && ArrayHelper::getValue($this->options, 'returnInvalidTokens', false)) {
                return ArrayHelper::getValue($tokens, 'invalid');
            }
        }
    }

    /**
     * @deprecated
     *
     * @param array $tokens
     * @param array $data
     * @throws Exception
     */
    private function sendGcm($tokens, $data = [])
    {
        if (!$this->gcmEnabled) {
            throw new InvalidConfigException('Gcm in not enabled.');
        }

        if (!empty($tokens)) {
            $fields = [
                'registration_ids' => $tokens,
                'data' => $data
            ];

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, self::FCM_URL);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                sprintf('Authorization: key=%s', ArrayHelper::getValue($this->gcmConfig, 'apiAccessKey')),
                'Content-Type: application/json'
            ]);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_POSTFIELDS, Json::encode($fields));

            $result = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                throw new Exception($err);
            }

            Yii::info($result);
        }
    }

    /**
     * @param array $tokens Set of device tokens generated by FCM.
     * @param array $payload Payload of notification. Should contain 'notification'
     * property for background message and 'data' property for foreground
     * message.
     * @throws Exception
     */
    private function sendFcm($tokens, $payload = [])
    {
        if (!$this->fcmEnabled) {
            throw new InvalidConfigException('FCM in not enabled.');
        }

        if (!empty($tokens)) {
            $fields = ArrayHelper::merge([
                'registration_ids' => $tokens
            ], $payload);

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, self::FCM_URL);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                sprintf('Authorization: key=%s', ArrayHelper::getValue($this->fcmConfig, 'apiAccessKey')),
                'Content-Type: application/json'
            ]);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_POSTFIELDS, Json::encode($fields));

            $result = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                throw new Exception($err);
            }

            Yii::info($result);
        }
    }

    /**
     * @param array $token
     * @param array $body
     * @throws Exception
     */
    private function sendApns($token, $body)
    {
        if (!$this->apnsEnabled) {
            throw new InvalidConfigException('Apns in not enabled.');
        }

        $path = sprintf('ssl://gateway%s.push.apple.com:2195', ArrayHelper::getValue($this->apnsConfig, 'environment'));
        $this->ctx = stream_context_create();
        stream_context_set_option($this->ctx, 'ssl', 'local_cert', ArrayHelper::getValue($this->apnsConfig, 'pem'));

        if (ArrayHelper::keyExists('passphrase', $this->apnsConfig)) {
            stream_context_set_option($this->ctx, 'ssl', 'passphrase', ArrayHelper::getValue($this->apnsConfig, 'passphrase'));
        }

        $fp = stream_socket_client($path, $err, $message, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $this->ctx);

        if (!$fp) {
            throw new Exception("Failed to connect: $err $message");
        }

        if (is_array($body)) {
            $body = Json::encode($body);
        }

        $tokens = [];

        if (is_string($token)) {
            $tokens[] = $token;
        } else {
            $tokens = $token;
        }

        foreach ($tokens as $token) {
            try {
                $msg = chr(0) . pack('n', 32) . pack('H*', $token) . pack('n', strlen($body)) . $body;

                $result = fwrite($fp, $msg, strlen($msg));

                if (!$result) {
                    Yii::error(sprintf('Message does not delivered to ' . $token));
                } else {
                    Yii::info('Message successfully delivered to ' . $token);
                }
            } catch (Exception $e) {
                Yii::error($e);
            }
        }

        fclose($fp);
    }
}
