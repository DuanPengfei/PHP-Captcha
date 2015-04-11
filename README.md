# PHPCaptcha
##Usage
Show the captcha

```
<img src="Captcha 文件夹地址/CaptchaInterface.php" />
```

Checkout the user's input captcha

```
if (Captcha::check(用户提交的数据)) {
	code...
} else {
	code...
}
```

##使用方式
显示验证码

```
<img src="Captcha 文件夹地址/CaptchaInterface.php" />
```

判断验证码是否正确

```
if (Captcha::check(用户提交的数据)) {
	code...
} else {
	code...
}
```