<?php
namespace App\html;

use DateTimeInterface;

class Form
{
    private $data;
    private $errors;
    public function __construct($data, array $errors)
    {
        $this->data = $data;
        $this->errors =$errors;
    }
      
    private function getErrorFeedBack(string $key):string
    {
        
        if(isset($this->errors[$key]))
        {
            return  '<div class="invalid-feedback">' . implode('<br>', $this->errors[$key] ) . '</div>';
        }
        return '';
    }

    private function getInputClass(string $key): string
    {
        $inputClass = 'form-control';
   
        if(isset($this->errors[$key]))
        {
            $inputClass  .= ' is-invalid';
            $invalidFeddBack = '<div class="invalid-feedback">' . implode('<br>', $this->errors[$key] ) . '</div>';
        }
        return $inputClass;
    }
     
    private function getValue(string $key)
    {
        if(is_array($this->data))
        {
            return $this->data[$key] ?? null;
        }
        $method = 'get' . str_replace(' ','',ucwords(str_replace('_', ' ', $key))); // mettre la premiere lettre en majscule
        $value =   $this->data->$method();
        if( $value instanceof \DateTimeInterface){
           return $value->format('y-m-d H:i:s');
        }
        return $value;
    }

    public function input(string $key, string $label): string
    {
        $type = $key === "password" || $key === "confirm"  ? "password" : "text";
         $value = $this->getValue($key);
         return <<<HTML
         <div class="form-group">
                <label for="field{$key}">{$label}</label>
                <input type="{$type}"  id="field{$key}" class="{$this->getInputClass($key)}" name="{$key}" value="{$value}" required>   
                {$this->getErrorFeedBack($key)}    
        </div>
HTML;
    }
    public function inputPassword(string $key, string $label): string
    {
    
         $value = '';
         return <<<HTML
         <div class="form-group">
                <label for="field{$key}">{$label}</label>
                <input type="password"  id="field{$key}" class="{$this->getInputClass($key)}" name="passwordConfirm" value="{$value}" required>   
                {$this->getErrorFeedBack($key)}    
        </div>
HTML;
    }
   

    public function date(string $key, string $label): string
    {
   
         $value = $this->getValue($key);
         return <<<HTML
         <div class="form-group">
                <label for="field{$key}">{$label}</label>
                <input type="date"  id="field{$key}" class="{$this->getInputClass($key)}" name="{$key}" value="{$value}" required>   
                {$this->getErrorFeedBack($key)}    
        </div>
HTML;
    }



    public function checkBox(string $key, string $label): string
    {
        
         return <<<HTML
         <div class="">
             
                <input type="radio"  id="field{$key}"  name="{$key}[]" value="cgu">   
                <label for="field{$key}">{$label}</label>
                {$this->getErrorFeedBack($key)}    
        </div>
HTML;
    }

    public function textArea(string $key, string $label): string
    {
        $value = $this->getValue($key);
       
        return <<<HTML
        <div class="form-group">
               <label for="field{$key}">{$label}</label>
               <textArea type="text"  id="field{$key}" class="{$this->getInputClass($key)}" name="{$key}"  required>{$value} </textArea>  
               {$this->getErrorFeedBack($key)}  
       </div>
HTML;
    }
    public function selectSimple( string $key, string $label, array $options =[])
    {
      
        $optionsHTML =[];
        $value = $this->getValue($key);
        foreach($options as $k => $v){
         
            $optionsHTML[] = "<option value=\"$k\">$v<option>";
        }
        $optionsHTML = implode('',$optionsHTML);
         return <<<HTML
         <div class="form-group">
                <label for="field{$key}">{$label}</label>
                <select   id="field{$key}" class="{$this->getInputClass($key)}" name="{$key}"  required>   
                     {$optionsHTML}
                </select>
                {$this->getErrorFeedBack($key)}    
        </div>
HTML;
    }
    public function select( string $key, string $label, array $options =[])
    {
      
        $optionsHTML =[];
        $value = $this->getValue($key);
        foreach($options as $k => $v){
            $selected = in_array($k, $value) ? " selected" :"";
            $optionsHTML[] = "<option value=\"$k\"$selected>$v<option>";
        }
        $optionsHTML = implode('',$optionsHTML);
         return <<<HTML
         <div class="form-group">
                <label for="field{$key}">{$label}</label>
                <select   id="field{$key}" class="{$this->getInputClass($key)}" name="{$key}[]" multiple required>   
                     {$optionsHTML}
                </select>
                {$this->getErrorFeedBack($key)}    
        </div>
HTML;
    }

    
    public function file(string $key, string $label){
     ;
        return <<<HTML
        <div class="form-group">
               <label for="field{$key}">{$label}</label>
               <input type="file"  id="field{$key}" class="{$this->getInputClass($key)}" name="{$key}" >   
               {$this->getErrorFeedBack($key)}    
       </div>
HTML;
    }
  
}