<?php

/**
 * Created by PhpStorm.
 * User: Leen
 * Date: 11/02/2017
 * Time: 16:47
 */
require_once ('ErrorHandler.php');
class Validator
{
    protected $errorHandler;
    protected $rules=['verplicht','tekst','email','bestaat'];
    public $messages=[
        'verplicht'=>'Het :veld veld is verplicht',
        'tekst'=>'Het :veld veld mag enkel tekst bevatten',
        'gemeente'=>'Het :veld veld mag enkel tekst bevatten of '-' bevatten',
        'email'=>'Dit is geen geldig e-mailadres',
        'bestaat'=>'Dit e-mailadres is reeds in gebruik.'
    ];

    public function __construct(Errorhandler $errorHandler)
    {
        $this->errorHandler=$errorHandler;
    }
    public function check($items,$rules)
    {
        foreach ($items as $item=>$value)
        {
            if (in_array($item,array_keys($rules)))
            {
                $this->validate([
                    'field'=>$item,
                    'value'=>$value,
                    'rules'=>$rules[$item]
                ]);
            }
        }
        return $this;
    }
    public function fails()
    {
        return $this->errorHandler->hasErrors(); //returns a BOOLEAN
    }
    public function errors()
    {
        return $this->errorHandler;
    }
    protected function validate($item)
    {
        $field=$item['field'];
        foreach ($item['rules']as $rule=>$satisifer)
        {
            if(in_array($rule,$this->rules))
            {
                if(!call_user_func_array([$this,$rule],[$field,$item['value'],$satisifer]))
                {
                    $this->errorHandler->addErrors(
                        str_replace([':veld'],[$field],$this->messages[$rule]),
                        $field);
                }
            }
        }
    }
    protected function verplicht($field,$value,$satisifer)
    {
        return !empty(trim($value));
    }
    protected function tekst($field,$value,$satisfier)
    {
        return preg_match("/^[a-zA-Z_-]*$/",$value);

    }
    protected function gemeente($field,$value,$satisifer){
        return preg_match("/^[a-zA-Z_-]*$/",$value);
    }
    protected function email($field,$value,$satisifer)
    {
        return filter_var($value,FILTER_VALIDATE_EMAIL);
    }
    protected function bestaat($field,$value){
        $model=new KlantModel();
        return !($model->checkEmail($value)); //returnt een boolean

    }

    /**
     * @return Errorhandler
     */
    public function getErrorHandler()
    {
        return $this->errorHandler;
    }

    /**
     * @return array
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }

}