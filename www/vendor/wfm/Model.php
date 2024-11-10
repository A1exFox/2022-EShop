<?php

namespace wfm;

use Valitron\Validator;
use RedBeanPHP\R;

abstract class Model
{
    public array $attributes = [];
    public array $errors = [];
    public array $rules = [];
    public array $labels = [];

    public function __construct()
    {
        Db::getInstance();
    }

    public function load($data)
    {
        foreach($this->attributes as $name => $value)
            if (isset($data[$name]))
                $this->attributes[$name] = $data[$name];
    }

    public function validate($data):bool
    {
        $lang_code = App::$app->getProperty('language')['code'];
        Validator::langDir(APP . '/languages/validator/lang');
        Validator::lang($lang_code);

        $validator = new Validator($data);
        $validator->rules($this->rules);
        $validator->labels($this->getLabels());
        if ($validator->validate()) {
            return true;
        } else {
            $this->errors = $validator->errors();
            return false;
        }
    }

    public function getLabels(): array
    {
        $labels = [];
        foreach ($this->labels as $k => $v) {
            $labels[$k] = ___($v);
        }
        return $labels;
    }

    public function save($table): int|string
    {
        $tbl = R::dispense($table);
        foreach($this->attributes as $name => $value) {
            if ($value != '')
                $tbl->$name = $value;
        }
        return R::store($tbl);
    }

    public function checkUnique($text_error = ''): bool
    {
        $user = R::findOne('user', 'email = ?', [$this->attributes['email']]);
        if ($user) {
            $this->errors['unique'][] = $text_error ?: ___('user_signup_error_email_unique');
            return false;
        }
        return true;
    }
}