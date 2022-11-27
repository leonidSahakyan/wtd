<?php

namespace App\Helpers;

use Session;

class Translate
{
    /**
     * @var int
     */
    public $langs;

    public function __construct($for = 'backendActiveLang')
    {
        $this->langs = Session::get('bLangs');
    }

    public function make($model, $data)
    {
        $fields = $model->multilangualFiled;
        foreach ($fields as $filed) {
            foreach ($this->langs as $lang) {
                $f = $filed . '_' . $lang['lang'];
                if (isset($data[$f])) {
                    $model->$f = $data[$f];
                }
                if(@$data[$f] == null){
                    $model->$f = '';
                }
            }
        }

        return $model;
    }

    public function makeArray($fields, $data)
    {
        $dataArray = [];
        foreach ($fields as $filed) {
            foreach ($this->langs as $lang) {
                $f = $filed . '_' . $lang['lang'];
                if (isset($data[$f])) {
                    $dataArray[$f] = $data[$f];
                }
            }
        }

        return $dataArray;
    }
}