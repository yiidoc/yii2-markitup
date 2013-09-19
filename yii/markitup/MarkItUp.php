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

/**
 * @author Nghia Nguyen <yiidevelop@hotmail.com>
 * @since 2.0
 */
class MarkItUp extends InputWidget
{
    const PACKAGE = 'yii\markitup\MarkItUpAsset';
    public $options = array('class' => 'form-control', 'style' => 'overflow:auto;resize:none');
    public $setting = 'default';
    public $skin = 'simple';
    public $addons = array();
    private $_package = array(
        'depends' => array('\yii\web\JqueryAsset'),
        'js' => array(
            'jquery.markitup.js',
        )
    );

    public function init()
    {
        if ($this->hasModel()) {
            $this->options['id'] = Html::getInputId($this->model, $this->attribute);
        } else {
            $this->options['id'] = $this->getId();
        }
        $this->setSetting();
        $this->setSkin();
        $this->setAddOns();
    }

    public function run()
    {
        if ($this->hasModel()) {
            echo Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textarea($this->name, $this->value, $this->options);
        }
        $this->renderModalPreview();
        $this->registerBundle();
        $this->registerScript();
    }

    public function registerBundle()
    {
        $this->_package['sourcePath'] = Yii::getAlias('@yii/markitup/assets');
        Yii::$app->assetManager->bundles[self::PACKAGE] = $this->_package;
        $this->view->registerAssetBundle(self::PACKAGE);
    }

    public function setSetting()
    {
        if (!empty($this->setting)) {
            $this->_package['js'][] = "sets/{$this->setting}/set.js";
            $this->_package['css'][] = "sets/{$this->setting}/style.css";
        }
    }

    public function setSkin()
    {
        if (!empty($this->skin)) {
            $this->_package['css'][] = "skins/{$this->skin}/style.css";
        }
    }

    public function setAddOns()
    {
        if (!empty($this->addons)) {
            foreach ($this->addons as $addon) {
                $this->_package['js'][] = "addons/{$addon}/set.js";
                $this->_package['css'][] = "addons/{$addon}/style.css";
            }
        }
    }

    public function registerScript()
    {
        $this->view->registerJs("jQuery('#{$this->options['id']}').markItUp(mySettings);");
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