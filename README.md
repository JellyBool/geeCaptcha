# 极验证 Composer Package

## 视频教程: [Laravist](https://laravist.com/series/tools-that-are-dame-good-for-developer/episodes/1)

>说明：由于geetest本身的composer package有很多不必要的文件，这里是最精简的版本，只用于验证码验证。

## 演示

![geetesst](https://cloud.githubusercontent.com/assets/6011686/12508320/385a56a6-c136-11e5-9353-b686c85bd37a.gif)

## Usage

安装 （目前的版本是 1.0）：

```
composer require laravist/geecaptcha
```

1. 实例化
```php
 $captcha = new \Laravist\GeeCaptcha\GeeCaptcha($captcha_id, $private_key);
```

2. 使用的使用可以这样判断验证码是否验证成功（通常是post路由里）：

```php
 if ($captcha->isFromGTServer() && $captcha->success()) 
 {
     // 登录的代码逻辑在这里   
 }

```
> 注意: 上面第一个判断是检测GT(geetest.com)的服务器是否正常，第二个才是检测验证码是否正确。

3. 对于需要重新生成验证码的时候（通常放在get方式的路由里）：

```php
$captcha = new \Laravist\GeeCaptcha\GeeCaptcha($captcha_id, $private_key);
echo $captcha->GTServerIsNormal();
```

## Laravel 使用用例

routes

```php
Route::group(['middleware' => ['web']], function () {
    Route::get('/login', function () {
        return view('login');
    });

    Route::post('/verify', function () {
        $captcha = new \Laravist\GeeCaptcha\GeeCaptcha(env('CAPTCHA_ID'), env('PRIVATE_KEY'));
        if ($captcha->isFromGTServer()) {
            if($captcha->success()){
                return 'success';
            }
            return 'no';
        }
        if ($captcha->hasAnswer()) {
                return "answer";
        }
        return "no answer";
    });

    Route::get('/captcha', function () {
        $captcha = new \Laravist\GeeCaptcha\GeeCaptcha(env('CAPTCHA_ID'), env('PRIVATE_KEY'));

        echo $captcha->GTServerIsNormal();
    });

});
```
login视图:

```html
<!DOCTYPE html>
<html>
    <head>
        <title>Laravel Geetest</title>
        <script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>
        <script src="http://api.geetest.com/get.php"></script>
    </head>
    <body>
        <div class="container">
            <div class="content" id="container">
                <div class="title">Laravel 5</div>
                <form method="post" action="/verify">
                    {{ csrf_field() }}
                    <div class="box">
                        <label>邮箱：</label>
                        <input type="text" name="email" value=""/>
                    </div>
                    <div class="box">
                        <label>密码：</label>
                        <input type="password" name="password" />
                    </div>
                    <div class="box" id="div_geetest_lib">
                        <div id="captcha"></div>
                        <script src="http://static.geetest.com/static/tools/gt.js"></script>
                        <script>
                            var handler = function (captchaObj) {
                                // 将验证码加到id为captcha的元素里
                                captchaObj.appendTo("#captcha");
                            };
                            $.ajax({
                                // 获取id，challenge，success（是否启用failback）
                                url: "captcha?rand="+Math.round(Math.random()*100),
                                type: "get",
                                dataType: "json", // 使用jsonp格式
                                success: function (data) {
                                    // 使用initGeetest接口
                                    // 参数1：配置参数，与创建Geetest实例时接受的参数一致
                                    // 参数2：回调，回调的第一个参数验证码对象，之后可以使用它做appendTo之类的事件
                                    initGeetest({
                                        gt: data.gt,
                                        challenge: data.challenge,
                                        product: "float", // 产品形式
                                        offline: !data.success
                                    }, handler);
                                }
                            });
                        </script>
                    </div>
                    <div class="box">
                        <button id="submit_button">提交</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>

```


