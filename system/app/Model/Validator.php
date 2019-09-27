<?php
namespace Core\Model;
use Illuminate\Database\Capsule\Manager as DB;
/**
 * 
 */
class Validator
{
	protected   $field_name,
                $data,
                $errors = [];

/*
* Main Validator
*/

    public function __construct($values, $fields = []){

        $this->data = $values;
        foreach ($fields as $field => $constraints) {
            $this->field_name = $field;
            if (isset($values[$field])) {
                $field_value = $values[$field];
                foreach (explode("|", $constraints) as  $constraint) {
                    $obj = explode(":", $constraint);
                    $function_name = $obj[0];
                    if (isset($obj[1])) {
                        if(method_exists($this, $function_name))
                        {
                            $this->$function_name($obj[1],$field_value);
                        }
                    }
                }
            }else{
                if (strpos($constraints, 'required') !== false) {
                    $this->report($this->field_name.' field is requried');
                }   
            }
        }
        return $this;
    }

    /*
* Object Interface Methods
*/
    private function report($message){
        $this->errors[$this->field_name][]= $message;
    }

    public function errors(){

        return $this->errors;
    }

    public function passed(){
        if (!count($this->errors)) {
            return true;
        }
    }

/*
* Validation Rules
*/

    public function max($length,$value){
        if (strlen($value)>$length) {
            $this->report("{$this->field_name} must consist of less than {$length} characters");
        }
    }

    public function min($length,$value){
        if (strlen($value)<$length) {
            $this->report("{$this->field_name} must consist of atleast {$length} characters");
        }
    }

    public function empty($length,$value){
        if (empty($value)) {
            $this->report("{$this->field_name} must not be empty");
        }
    }

    public function distinct($tableName,$value){
        if (DB::table($tableName)->where($this->field_name, $value)->whereNull('deleted_at')->exists()) {
            $this->report("{$this->field_name} already exists");
        }
    }

    public function is_registered($tableName,$value){
        if (!DB::table($tableName)->where($this->field_name, $value)->whereNull('deleted_at')->exists()) {
            $this->report("{$this->field_name} is not a registered email");
        }
    }

    public function date($format,$date){     
    
        if (!preg_match("/\d{4}-\d{2}-\d{2}\b/",$date)) {
            $this->report("incorrect {$this->field_name} values");
        }else{
            $d = DateTime::createFromFormat($format, $date); 
            if ($d && $d->format($format) !== $date) {
                $this->report("{$this->field_name} format should be {$format}");
            }
        }        
    }

    public function match($matchField,$value){
        if (isset($this->data[$matchField])) {
            $valueTwo = $this->data[$matchField];
            if ($value !== $valueTwo) {
                $this->report("{$this->field_name} does not match {$matchField}");
            }
        }else{
            $this->report("{$matchField} is required");
        }

        
    }

    public function format($type,$value){
        switch ($type) {
            case 'noWhiteSpace':
                if (preg_match("/\s/",$value)) {
                    $this->report("{$this->field_name} may not contain any spaces");
            }break;

            case 'alpha':
                if (preg_match("/[^a-zA-Z]/",$value)) {
                    $this->report("{$this->field_name} may only contain letters");
            }break;

            case 'alphaNum':
                if (preg_match("/[^a-zA-Z0-9]/",$value)) {
                    $this->report("{$this->field_name} may only contain letters");
            }break;

            case 'alphaNum':
                if (preg_match("/[^a-zA-Z0-9]/",$value)) {
                    $this->report("{$this->field_name} may only contain lettersa and numbers");
            }break;

            case 'num':
                if (preg_match("/[^0-9]/",$value)) {
                    $this->report("{$this->field_name} may only contain numbers");
            }break;

            case 'bool':
                if (!preg_match("/(1|0)\b/",$value)) {
                    $this->report("{$this->field_name} may only contain 1 or 0");
            }break;

            case '!empty':
                if (strlen($value) == 0) {
                    $this->report("{$this->field_name} must not be empty");
            }break;


            case 'email':
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->report("in correct {$this->field_name} format");
            }break;
            
            default:
                # code...
                break;
        }
    }
}