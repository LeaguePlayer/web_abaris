<?php

class QuestionForm extends CFormModel
{
    public $questArticle;
    public $phone;
    public $email;
    public $comment;

    public function rules() {
        $rules = array(
            array('phone', 'required'),
            array('email', 'email'),
            array('comment', 'safe'),
        );
        return $rules;
    }

    public function attributeLabels()
    {
        return array(
            'phone'=>"Телефон",
            'email'=>"E-mail",
            'comment'=>"Комментарий",
        );
    }
}