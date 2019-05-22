<?php
class PluginValidateCellphone{
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
      /**
       * Starts with 07.
       */
      if(substr(wfArray::get($form, "items/$field/post_value"), 0, 2) != '07'){
        $error = true;
      }
      if($error){
        $form = wfArray::set($form, "items/$field/is_valid", false);
        $form = wfArray::set($form, "items/$field/errors/", __('?label must be in format 07xxxxxxxx (ten digits)!', array('?label' => wfArray::get($form, "items/$field/label"))));
      }
    }
    return $form;
  }
}