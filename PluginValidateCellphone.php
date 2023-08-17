<?php
class PluginValidateCellphone{
  private $i18n = null;
  private $country_digits = array('45' => 8, '46' => 10);
  function __construct() {
    wfPlugin::includeonce('i18n/translate_v1');
    $this->i18n = new PluginI18nTranslate_v1();
    $this->i18n->setPath('/plugin/validate/cellphone/i18n');
    $this->country_digits = new PluginWfArray($this->country_digits);
  }
  public function validate_cellphone($field, $form, $data = array()){
    $form = new PluginWfArray($form);
    $data = new PluginWfArray($data);
    if($form->get("items/$field/is_valid") && wfPhpfunc::strlen($form->get("items/$field/post_value"))){
      $error = false;
      /**
       * Length.
       */
      $digits = null;
      if($data->get('country_code_param')){
        if(wfRequest::get($data->get('country_code_param'))){
          $digits = $this->country_digits->get(wfRequest::get($data->get('country_code_param')));
        }
        if($digits && wfPhpfunc::strlen($form->get("items/$field/post_value")) != $digits){
          $error = true;
        }
      }
      /**
       * Number.
       */
      if(!is_numeric($form->get("items/$field/post_value"))){
        $error = true;
      }
      if($error){
        $form->set("items/$field/is_valid", false);
        if(!$digits){
          $form->set("items/$field/errors/", $this->i18n->translateFromTheme('?label must be numeric!', array('?label' => $form->get("items/$field/label"))));
        }else{
          $form->set("items/$field/errors/", $this->i18n->translateFromTheme('?label must be numeric and have ?digits digits!', array('?label' => $form->get("items/$field/label"), '?digits' => $digits)));
        }
      }
    }
    return $form->get();
  }
  public function validate_country_code($field, $form, $data = array()){
    if(wfArray::get($form, "items/$field/is_valid") && wfPhpfunc::strlen(wfArray::get($form, "items/$field/post_value"))){
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
    if(preg_match('/^\d+$/',wfPhpfunc::str_replace('-', '', $num))){
      return true;
    }else{
      return false;
    }
  }
}