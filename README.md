# endroid-qrcode

#### 介绍
Endroid\QrCode中文字库版，可以自定义字库文件路径！！基于Endroid\QrCode-v5.1.0 ，由于官方的不内置中文字体且不能直接自定义字体，我稍改了一下，内置中文字体且支持自定义字库路径，支持如ttf、off等所有字体格式

#### 软件架构

随便改了一下，以后再拉取不用手动改了


#### 安装教程

```
composer require  chenm/endroid-qrcode
```

#### 使用说明

使用非常简单，参考下面代码即可


```php

namespace app\common\util;

use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\Font\CnSans;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Margin\Margin;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\SvgWriter;
use Endroid\QrCode\Writer\PdfWriter;

/**
 * 快捷二维码类 基于 Endroid\QrCode-v5.1.0  new Qrcode('png')->create('测试二维码内容',100, 12)
 */
class Qrcode 
{

    /**
     * 错误信息
     * @var string
     */
    public static $error = '';

    public $options = [
        // 文字大小
        'labelSize' => 20,
        // 文字编码格式
        'charset'   => 'UTF-8',
    ];

    /**
     * 二维码实例
     *
     * @var \Endroid\QrCode\Builder\BuilderInterface
     */
    private $qrcodeBuilder = '';

    /**
     * 初始化
     *
     * @param string $ext 填充格式 支持pdf、svg、png三种
     * @return Qrcode
     */
    public function __construct($ext = 'png')
    {

        switch ($ext) {
            case 'pdf':
                $this->qrcodeBuilder = Builder::create()
                    ->writer(new PdfWriter());
                break;
            case 'svg':
                $this->qrcodeBuilder = Builder::create()
                    ->writer(new SvgWriter());
                break;
            default:
                $this->qrcodeBuilder = Builder::create()
                    ->writer(new PngWriter());
                break;
        }
    }

    /**
     * 生成二维码
     *
     * @param string $text  文本内容
     * @param integer $size 二维码大小 单位PX
     * @param integer $qrcode_margin 边距大小 单位PX
     * @param array $options
     * @return \Endroid\QrCode\Writer\Result\ResultInterface
     */
    public function create($text = '', $size = 100, $qrcode_margin = 12, $options = ['labelSize' => 16, 'labelText' => ''])
    {
        $this->options = array_merge($this->options, $options);

        // 创建 QrCode 实例
        $qrCode = $this->qrcodeBuilder->data($text);
        // 禁用结果验证
        $qrCode = $qrCode->validateResult(false);
        $qrCode = $qrCode->encoding(new Encoding(strtoupper($this->options['charset'] ?? 'UTF-8')));
        $qrCode = $qrCode->errorCorrectionLevel(ErrorCorrectionLevel::High);
        $qrCode = $qrCode->size($size);
        $qrCode =    $qrCode->margin($qrcode_margin);
        $qrCode =    $qrCode->roundBlockSizeMode(RoundBlockSizeMode::Margin);

        // 添加标签（如果有）
        if ($this->options['labelText'] ?? '') {
            $labelSize = intval($this->options['labelSize'] ?? 16);
            $labelSize = $labelSize > 10 ? $labelSize : 14;
            $qrCode = $qrCode->labelText($this->options['labelText']);
            $qrCode = $qrCode->labelFont(new CnSans($labelSize));
            $qrCode = $qrCode->labelAlignment(LabelAlignment::Center);
            $qrCode = $qrCode->labelMargin(new Margin(2, 0, 8, 0));
        }
        // 使用 Builder 生成二维码
        $result = $qrCode->build();
        return $result;
    }
}

```

#### 参与贡献

基于Endroid\QrCode，v5.1.0版本，专用请自行注明
