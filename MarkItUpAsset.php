<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\markitup;

use yii\web\AssetBundle;

/**
 * @author Nghia Nguyen <yiidevelop@hotmail.com>
 * @since 2.0
 */
class MarkItUpAsset extends AssetBundle {

    public $sourcePath = '@vendor/yiidoc/yii2-markitup/assets';
    public $js = ['jquery.markitup.js'];

}
