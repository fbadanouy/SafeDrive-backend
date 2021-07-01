<?php

use oxusmedia\webApp\controller;
use oxusmedia\webApp\form;
use oxusmedia\webApp\column;
use oxusmedia\webApp\input;
use oxusmedia\webApp\password;
use oxusmedia\webApp\button;

class site extends controller
{
    public function index()
    {
        $this->webApp()->requireLoginRedir();

        $this->titulo = '';

        $this->render('index');
    }

    public function login()
    {
        if ($this->webApp()->isLoggedIn())

            $this->redirect($this->webApp()->getSite());

        else{

            if (isset($_POST["login"])) {

                $form = $this->constructLoginForm();

                $form->setAtributes($_POST['login']);

                if ($form->validate()) {

                    $param = $form->getAtributes();

                    if ($this->webApp()->login($param["usuario"], $param["contrasena"])) {

                        $this->redirect($this->webApp()->getSite());

                        return;

                    }

                }

            }

            $this->titulo = 'Iniciar sesión';

            $this->addCss($this->webApp()->getSite() . 'assets/css/login.css');

            $this->render('login', array(
                'loginForm' => $this->constructLoginForm()
            ));

        }

    }

    private function constructLoginForm()
    {
        return new form('login',
            array(
                new column(array(
                    new input('usuario'),
                    new password('contrasena', array(
                        'label' => 'Contraseña',
                    ))
                ))
            ),
            array(
                'buttons' => array(
                    new button('login', button::SUBMIT, button::PRIMARY, array(
                        'label' => 'Iniciar sesión'
                    ))
                )
            )
        );
    }

    public function logout()
    {
        $this->webApp()->logout();

        $this->redirect($this->webApp()->getSite() . 'site/login');
    }

}