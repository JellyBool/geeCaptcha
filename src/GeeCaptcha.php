<?php
namespace Laravist\GeeCaptcha;

/**
 * Class GeeCaptcha
 * @package Laravist\GeeCaptcha
 *
 * 继承与GeeTest原本的类，修正了const PRIVATE_KEY 的使用
 */
class GeeCaptcha extends GeetestLib{


    /**
     * @return bool
     *
     * 判断是否是正确来自GT的服务器，万一down机或者什么的。
     */
    public function isFromGTServer()
    {
        session_start();
        return $_SESSION['gtserver'] == 1 ;
    }

    /**
     * @return bool|mixed|string
     *
     * 判断验证是否成功
     */
    public function success()
    {
        $result = $this->validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode']);

        return $result;
    }

    /**
     * @return int
     *
     * GT 服务器是否有回应
     */
    public function hasAnswer()
    {
        return $this->get_answer($_POST['geetest_challenge'],$_POST['geetest_validate']);

    }

    /**
     * @return mixed
     *
     * 判断GT 服务器是否正常
     */
    public function GTServerIsNormal()
    {
        session_start();
        $status = $this->pre_process();
        $_SESSION['gtserver'] = $status;

        return $this->response_str;
    }

}