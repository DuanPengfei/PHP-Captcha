<?php

session_start();
ob_clean();

class Captcha {
  // 公开接口，绘制验证码图像
  public static function draw($length, $width) {
    // 随机数字
    $num1 = rand(0, 9);
    $num2 = rand(0, 9);

    // 随机运算符
    $operator = self::randOperator($num1, $num2);

    // 计算记过并将结果存入 SESSION
    self::setResult($num1, $num2, $operator);

    // 创建图像
    $img = imagecreate($length, $width);

    // 背景颜色 
    imagecolorallocate($img, rand(230, 250), rand(230, 250), rand(230, 250));

    // 内容颜色
    $textColor = imagecolorallocate($img, 0, 0, 0);

    // 绘制图像
    imagestring($img, rand(3, 5), rand($length / 20.0, $length / 20.0 * 3.0), rand($width / 4.0, $width / 2.0), $num1, $textColor);
    imagestring($img, rand(3, 5), rand(($length / 5.0) + $length / 20.0, ($length / 5.0) + $length / 20.0 * 3.0), rand($width / 4.0, $width / 2.0), $operator, $textColor);
    imagestring($img, rand(3, 5), rand(2 * ($length / 5.0) + $length / 20.0, 2 * ($length / 5.0) + $length / 20.0 * 3.0), rand($width / 4.0, $width / 2.0), $num2, $textColor);
    imagestring($img, rand(3, 5), rand(3 * ($length / 5.0) + $length / 20.0, 3 * ($length / 5.0) + $length / 20.0 * 3.0), rand($width / 4.0, $width / 2.0), '=', $textColor);
    imagestring($img, rand(3, 5), rand(4 * ($length / 5.0) + $length / 20.0, 4 * ($length / 5.0) + $length / 20.0 * 3.0), rand($width / 4.0, $width / 2.0), '?', $textColor);

    // 设置显示格式为图像
    header('Content-type: image/jpeg');
    imagejpeg($img);
  }

  // 公开接口，判断用户输入的验证码是否正确
  public static function check ($captchaResult) {
    if (isset($_SESSION['captchaResult'])) {
      if ($captchaResult == $_SESSION['captchaResult']) {
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  // 随机运算符
  private function randOperator($num1, $num2) {
    $operator[] = '-';
    $operator[] = '+';
    $operator[] = '*';

    if ($num1 < $num2) {
      return $operator[rand(1, 2)];
    } else {
      return $operator[rand(0, 2)];
    }
  }

  // 计算记过并将结果存入 SESSION
  private function setResult($num1, $num2, $operator) {
    switch ($operator) {
      case '+':
        $_SESSION['captchaResult'] = $num1 + $num2;
        break;

      case '-':
        $_SESSION['captchaResult'] = $num1 - $num2;
        break;

      case '*':
        $_SESSION['captchaResult'] = $num1 * $num2;
        break;
      
      default:
        break;
    }
  }
}

?>