<?php

namespace Laravist\GeeCaptcha;

/**
 * Class GeeCaptcha.
 */
class GeeCaptcha extends GeetestLib
{
    public function __construct($captcha_id, $private_key)
	{
        if (! session_id()) {
            session_start();
        }

        parent::__construct($captcha_id, $private_key);
    }

    /**
     * @return bool
     *
     * 判断是否是正确来自GT的服务器，万一down机或者什么的。
     */
    public function isFromGTServer()
    {
        return $_SESSION['gtserver'] == 1;
    }

    /**
     * @return bool|mixed|string
     *
     * 判断验证是否成功
     */
    public function success()
    {
        $result = $this->success_validate($_POST['geetest_challenge'], $_POST['geetest_validate'], $_POST['geetest_seccode']);

        return $result;
    }

    /**
     * @return int
     *
     * GT 服务器是否有回应
     */
    public function hasAnswer()
    {
        return $this->fail_validate($_POST['geetest_challenge'], $_POST['geetest_validate']);
    }

    /**
     * @return mixed
     *
     * 判断GT 服务器是否正常
     */
    public function GTServerIsNormal()
    {
        $status = $this->pre_process();
        $_SESSION['gtserver'] = $status;

        return $this->get_response_str();
    }
}
