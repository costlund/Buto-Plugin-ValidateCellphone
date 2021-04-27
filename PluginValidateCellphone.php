<?php
class PluginValidateCellphone{
  private $i18n = null;
  function __construct() {
    wfPlugin::includeonce('i18n/translate_v1');
    $this->i18n = new PluginI18nTranslate_v1();
    $this->i18n->setPath('/plugin/validate/cellphone/i18n');
  }
  public function validate_cellphone($field, $form, $data = array()){
    if(wfArray::get($form, "items/$field/is_valid") && strlen(wfArray::get($form, "items/$field/post_value"))){
      $error = false;
      /**
       * Length.
       */
      if(strlen(wfArray::get($form, "items/$field/post_value")) != 10){
        $error = true;
      }
      /**
       * Number.
       */
      if(!is_numeric(wfArray::get($form, "items/$field/post_value"))){
        $error = true;
      }
      if($error){
        $form = wfArray::set($form, "items/$field/is_valid", false);
        $form = wfArray::set($form, "items/$field/errors/", $this->i18n->translateFromTheme('?label must be numeric and have ten digits!', array('?label' => wfArray::get($form, "items/$field/label"))));
      }
    }
    return $form;
  }
  public function validate_country_code($field, $form, $data = array()){
    if(wfArray::get($form, "items/$field/is_valid") && strlen(wfArray::get($form, "items/$field/post_value"))){
      wfPlugin::includeonce('wf/array');
      $data = new PluginWfArray($data);
      $min = 10;
      $max = 999;
      if (!$this->is_integer(wfArray::get($form, "items/$field/post_value"))) {
        $form = wfArray::set($form, "items/$field/is_valid", false);
        $form = wfArray::set($form, "items/$field/errors/", $this->i18n->translateFromTheme('?label is not an integer!', array('?label' => wfArray::get($form, "items/$field/label"))));
      }elseif((int)wfArray::get($form, "items/$field/post_value") < $min){
        $form = wfArray::set($form, "items/$field/is_valid", false);
        $form = wfArray::set($form, "items/$field/errors/", $this->i18n->translateFromTheme('?label can not be less then ?min!', array('?label' => wfArray::get($form, "items/$field/label"), '?min' => $min)));
      }elseif((int)wfArray::get($form, "items/$field/post_value") > $max){
        $form = wfArray::set($form, "items/$field/is_valid", false);
        $form = wfArray::set($form, "items/$field/errors/", $this->i18n->translateFromTheme('?label can not be greater then ?max!', array('?label' => wfArray::get($form, "items/$field/label"), '?max' => $max)));
      }
    }
    return $form;   
  }
  public function is_integer($num){
    if(preg_match('/^\d+$/',str_replace('-', '', $num))){
      return true;
    }else{
      return false;
    }
  }
}