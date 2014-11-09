<?php

class Message extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'message';
    protected $guarded = array('id');

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    // protected $hidden = array('password', 'remember_token');


    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    // public function getAuthIdentifier()
    // {
    //  return $this->getKey();
    // }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    // public function getAuthPassword()
    // {
    //  return $this->password;
    // }



    public function sender()
    {
        return $this->belongsTo('User', 'sender_id', 'id');
    }

    public function receiver()
    {
        return $this->belongsTo('User', 'receiver_id', 'id');
    }

    public function classmate()
    {
        return $this->belongsTo('Classmate', 'classmate_id', 'id');
    }

    /* 发送手机短信
        $mobile 手机号
        $msg 短信信息
    */
    public function mobileMsg($mobile, $msg)
    {
        // 信息格式必须备案才能发移动手机号
        //$msg = "验证码：{$query['code']}（为了保证账户安全，请勿向他人泄漏）【音教360】";

        $cpmid = Config::get('app.mobile_cpid');
        $port = Config::get('app.mobile_port');
        $md5 = Config::get('app.mobile_md5');
        $post = Config::get('app.mobile_post');
        $timestamp = time();
        $signature = md5($md5 . $timestamp);

        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
            <MtPacket>
            <cpid>{$cpmid}</cpid>
            <mid>0</mid>
            <cpmid>{$cpmid}</cpmid>
            <mobile>{$mobile}</mobile>
            <port>{$port}</port>
            <msg>{$msg}</msg>
            <msgtype>1</msgtype>
            <signature>{$signature}</signature>
            <timestamp>{$timestamp}</timestamp>
            <validtime>1800</validtime>
            </MtPacket>
        ";

        $header[] = "Content-type: text/xml"; //定义content-type为xml
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        $response = curl_exec($ch);

        /*
        if(curl_errno($ch))
        {
             curl_error($ch);
        }
        */
        curl_close($ch);

        $xml = simplexml_load_string($response);
        // 发送成功
        if($xml->result == 0)
        {
            return 1;
        }
        else
        {
            return $xml;
        }
    }
}
