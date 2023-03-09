<?php

declare(strict_types=1);

namespace Kernel\Helper;

/**
 * Html - 助手类.
 */
class HtmlHelper
{
    /**
     * 获取 - img 标签中 src 属性的值.
     *
     * @example
     * ```
     * $html = '<p><img alt="有下划线结束符" src="1.png" /></p> <div><img alt="无下划线结束符" src="2.png"></div>';
     * $srcArr = HtmlHelper::getAllImgSrc($html); // 结果 ['1.png', '2.png']
     * ```
     */
    public static function getAllImgSrc(string $html): array
    {
        $srcArr = [];

        // 首先将富文本字符串中的 img 标签进行匹配
        $patternImg = '/<img\b.*?(?:>|\/>)/i';
        preg_match_all($patternImg, $html, $matches);

        if (isset($matches[0])) {
            foreach ($matches[0] as $imgTag) {
                // 进一步提取 img 标签中的 src属性信息
                $patternSrc = '/\bsrc\b\s*=\s*[\'\"]?([^\'\"]*)[\'\"]?/i';
                preg_match_all($patternSrc, $imgTag, $matchSrc);

                if (isset($matchSrc[1])) {
                    foreach ($matchSrc[1] as $src) {
                        // 将匹配到的 src 信息压入数组
                        $srcArr[] = $src;
                    }
                }
            }
        }

        return $srcArr;
    }
}
