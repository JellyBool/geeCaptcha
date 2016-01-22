# geeCaptcha
极验证 Composer Package

>说明：由于geetest本身的composer package有很多不必要的文件，这里是最精简的版本，只用于验证码验证。

## Usage

安装 （目前的版本是 1.0）：

```
composer require laravist/geecaptcha
```

1. 实例化
```
 $captcha = new \App\GeeCaptcha\GeeCaptcha($captcha_id, $private_key);
```

2. 使用的使用可以这样判断验证码是否验证成功（通常是post路由里）：

```
 if ($captcha->isFromGTServer() && $captcha->success()) 
 {
     // 登录的代码逻辑在这里   
 }

```
> 注意: 上面第一个判断是检测GT(geetest.com)的服务器是否正常，第二个才是检测验证码是否正确。

3. 对于需要重新生成验证码的时候（通常放在get方式的路由里）：

```
$captcha = new \App\GeeCaptcha\GeeCaptcha($captcha_id, $private_key);
echo $captcha->GTServerIsNormal();
```
