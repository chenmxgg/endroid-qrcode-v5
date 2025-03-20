<?php

declare(strict_types=1);

namespace Endroid\QrCode\Label\Font;

/**
 * 自定义简体中文版字库 By 沉梦
 */
final class CnSans implements FontInterface
{

    public $path = __DIR__ . '/../../../assets/cn_sans.ttf';

    public function __construct(
        private int $size = 16
    ) {}

    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * 设置自定义字体路径
     *
     * @param string $path
     * @return void
     */
    public function setPath(string $path)
    {
        $this->path = $path;
        return $this;
    }

    public function getSize(): int
    {
        return $this->size;
    }
}
