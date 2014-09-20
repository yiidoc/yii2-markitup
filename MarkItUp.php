<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\markitup;

use Yii;
use yii\widgets\InputWidget;
use yii\helpers\Html;
use yii\web\AssetBundle;

/**
 * @author Nghia Nguyen <yiidevelop@hotmail.com>
 * @since 2.0
 */
class MarkItUp extends InputWidget {

    public $options = array('class' => 'form-control', 'style' => 'overflow:auto;resize:none');
    public $setName = 'default';
    public $skinName = 'simple';
    public $addons = array();
    private $_assetBundle;

    public function init()
    {
        if ($this->hasModel()) {
            $this->options['id'] = Html::getInputId($this->model, $this->attribute);
        } else {
            $this->options['id'] = $this->getId();
        }
        $this->registerAssetBundle();
        $this->setSetting();
        $this->setSkin();
        $this->setAddOns();
        $this->registerScript();
    }

    public function run()
    {
        if ($this->hasModel()) {
            echo Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textarea($this->name, $this->value, $this->options);
        }
        $this->renderModalPreview();
    }

    public function setSetting()
    {
        $setJsAsset = "sets/{$this->setName}/set.js";
        if (file_exists(Yii::getAlias($this->getAssetBundle()->sourcePath . '/' . $setJsAsset))) {
            $this->getAssetBundle()->js[] = $setJsAsset;
        }
        $setCssAsset = "sets/{$this->setName}/style.css";
        if (file_exists(Yii::getAlias($this->getAssetBundle()->sourcePath . '/' . $setCssAsset))) {
            $this->getAssetBundle()->css[] = $setCssAsset;
        }
    }

    public function setSkin()
    {
        $skinAsset = "skins/{$this->skin}/style.css";
        if (file_exists(Yii::getAlias($this->getAssetBundle()->sourcePath . '/' . $skinAsset))) {
            $this->getAssetBundle()->css[] = $skinAsset;
        }
    }

    public function setAddOns()
    {
        if (!empty($this->addons)) {
            foreach ($this->addons as $addon) {
                $addonJsAsset = "addons/{$addon}/set.js";
                if (file_exists(Yii::getAlias($this->getAssetBundle()->sourcePath . '/' . $addonJsAsset))) {
                    $this->getAssetBundle()->js[] = $addonJsAsset;
                }
                $addonCssAsset = "addons/{$addon}/style.css";
                if (file_exists(Yii::getAlias($this->getAssetBundle()->sourcePath . '/' . $addonCssAsset))) {
                    $this->getAssetBundle()->css[] = $addonCssAsset;
                }
            }
        }
    }

    public function registerScript()
    {
        $this->view->registerJs("jQuery('#{$this->options['id']}').markItUp(mySettings);");
    }

    public function registerAssetBundle()
    {
        $this->_assetBundle = MarkItUpAsset::register($this->getView());
    }

    public function getAssetBundle()
    {
        if (!($this->_assetBundle instanceof AssetBundle)) {
            $this->registerAssetBundle();
        }
        return $this->_assetBundle;
    }

    public function renderModalPreview()
    {
        echo Html::beginTag('div', array('id' => 'miuPreview', 'class' => 'modal'));
        echo Html::beginTag('div', array('class' => 'modal-dialog'));
        echo Html::beginTag('div', array('class' => 'modal-content'));
        echo Html::beginTag('div', array('class' => 'modal-header'));
        echo Html::button('&times;', array("class" => "close", "data-dismiss" => "modal", "aria-hidden" => "true"));
        echo Html::tag('h4', 'Preview', array('class' => 'modal-title'));
        echo Html::endTag('div');
        echo Html::tag('div', '', array('class' => 'modal-body'));
        echo Html::endTag('div');
        echo Html::endTag('div');
        echo Html::endTag('div');
    }

}
