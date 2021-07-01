<?php

use oxusmedia\webApp\webApp;
use oxusmedia\webApp\controller;
use oxusmedia\webApp\grid;
use oxusmedia\webApp\form;
use oxusmedia\webApp\column;
use oxusmedia\webApp\input;
use oxusmedia\webApp\hidden;
use oxusmedia\webApp\password;
use oxusmedia\webApp\select;
use oxusmedia\webApp\gridActionButton;
use oxusmedia\webApp\notificacion;

class usuario extends controller
{
    public function index()
    {
        $this->webApp()->requireLoginRedir();

        $this->titulo = 'Usuarios';

        $grid = $this->configGrid();

        $this->render("index", array(
            'grid' => $grid
        ));
    }

    private function configGrid()
    {
        $grid = new grid('usuarios');

        $grid
            ->setJsonUrl($this->getMethodUrl('data'))
            ->setUniqueIdFields('id')
            ->setColModel(array(
                array(
                    'name'   => 'usuario',
                    'width'  => 150,
                    'format' => grid::FMT_STRING
                ),
                array(
                    'name'   => 'nombre',
                    'width'  => 200,
                    'format' => grid::FMT_STRING
                ),
                array(
                    'name'   => 'email',
                    'width'  => 200,
                    'format' => grid::FMT_STRING
                ),
                array(
                    'name'          => 'role',
                    'width'         => 150,
                    'format'        => grid::FMT_SELECT,
                    'formatoptions' => array('value' => $this->getRoleDescription())
                ),
                array(
                    'name'   => 'ultimoLogin',
                    'label'  => 'Última sesión',
                    'format' => grid::FMT_DATETIME
                )
            ))
            ->setDefaultSortName('usuario')
            ->setDefaultSortOrder('asc')
            ->setActions(array(
                new gridActionButton(gridActionButton::ADD, $this->webApp()->getSite() . 'usuario/add'),
                new gridActionButton(gridActionButton::EDIT, $this->webApp()->getSite() . 'usuario/edit'),
                new gridActionButton(gridActionButton::MULTI_DELETE, $this->webApp()->getSite() . 'usuario/delete')
            ));

        return $grid;
    }

    private function getRoleDescription($role = null)
    {
        $arr = array(
            webApp::ROLE_ADMIN  => 'Administrador',
            webApp::ROLE_EDITOR => 'Editor',
            webApp::ROLE_USER   => 'Usuario'
        );

        if ($role == null)
            return $arr;
        elseif (isset($arr[$role]))
            return $arr[$role];

        return false;
    }

    public function add()
    {
        $this->webApp()->requireLogin();

        $form = new form('usuarioForm', array(

            new column(array(

                new input('usuario', array(
                    'rules' => array(
                        'required' => true
                    )
                )),

                new input('email', array(
                    'rules' => array(
                        'required' => true,
                        'email'    => true
                    )
                )),

                new password('pass', array(
                    'label' => 'Contraseña',
                    'rules' => array(
                        'required' => true
                    )
                )),

                new input('nombre', array(
                    'rules' => array(
                        'required' => true
                    )
                )),

                new select('role', $this->getRoleDescription())

            ))

        ), array(
            'action' => $this->webApp()->getSite() . 'usuario/add',
            'ajax'   => true,
            'gridId' => "usuarios"
        ));

        if (isset($_POST['usuarioForm'])) {

            $form->setAtributes($_POST['usuarioForm']);

            if ($form->validate()) {

                $param = $form->getAtributes();

                $param['pass'] = md5($param['pass']);

                $this->db()->insert('usuarios', $param);

                $this->returnJson(array(
                    'error' => 0
                ));

            }

        } else {

            echo $form->render();

        }

    }

    public function edit()
    {
        $this->webApp()->requireLogin();

        $usuario = $this->db()->queryRow('SELECT id, usuario, email, nombre, role FROM usuarios WHERE id = :id', array(
            'id' => isset($_POST['usuario']['id']) ? $_POST['usuario']['id'] : $_POST['id']
        ));

        if ($usuario) {

            $form = new form('usuario', array(

                new column(array(

                    new hidden('id'),

                    new input('email', array(
                        'rules' => array(
                            'required' => true,
                            'email'    => true
                        )
                    )),

                    new password('pass', array(
                        'label'       => 'Contraseña',
                        'htmlOptions' => array(
                            'placeholder' => 'dejar vacío para no cambiar la contraseña'
                        )
                    )),

                    new input('nombre', array(
                        'rules' => array(
                            'required' => true
                        )
                    )),

                    new select('role', $this->getRoleDescription(), $usuario->usuario == 'admin' ? array('htmlOptions' => array('disabled' => 'disabled')) : null)

                ))

            ), array(
                'action' => $this->webApp()->getSite() . 'usuario/edit',
                'ajax'   => true,
                'gridId' => "usuarios"
            ));

            if (isset($_POST['usuario'])) {

                $form->setAtributes($_POST['usuario']);

                if ($form->validate()) {

                    $param = $form->getAtributes();

                    if (!empty($param['pass']))
                        $param['pass'] = md5($param['pass']);
                    else
                        unset($param['pass']);

                    $this->db()->update('usuarios', $param,
                        array(
                            'id' => $param['id']
                        )
                    );

                    $this->returnJson(array(
                        'error' => 0
                    ));

                }

            }else{

                $form->setAtributes($usuario);

                echo $form->render();

            }

        }

    }

    public function delete()
    {
        $this->webApp()->requireLogin();

        if (isset($_POST['id'])) {

            $db = $this->db();

            $usuario = $db->queryRow('SELECT * FROM usuarios WHERE id IN(:ids) AND usuario = "admin"', array(
                'ids' => implode(',', $_POST['id'])
            ));

            if (!$usuario) {

                $db->query('DELETE FROM usuarios WHERE id IN(:ids)', array(
                    'ids' => implode(',', $_POST['id'])
                ));

                $this->returnJson(array(
                    'error' => 0
                ));

            }else{

                $this->returnJson(array(
                    'error'   => 1,
                    'mensaje' => 'No se permite eliminar el usuario admin.'
                ));

            }

        }

    }

    public function data()
    {
        $this->webApp()->requireLogin();

        $grid = $this->configGrid();

        $grid->renderData($this->db(), "SELECT * FROM usuarios");
    }

    public function miperfil()
    {
        $this->webApp()->requireLoginRedir();

        $this->titulo = 'Mi perfil';

        $form = new form('usuario', array(

            new column(array(

                new input('email', array(
                    'rules' => array(
                        'required' => true,
                        'email'    => true
                    )
                )),

                new password('pass', array(
                    'label'       => 'Contraseña',
                    'htmlOptions' => array(
                        'placeholder' => 'dejar vacío para no cambiar la contraseña'
                    )
                )),

                new input('nombre', array(
                    'rules' => array(
                        'required' => true
                    )
                )),

                new select('theme', array(
                    webApp::THEME_LIGHT  => 'Claro',
                    webApp::THEME_DARKLY => 'Oscuro'
                ), array(
                    'label' => 'Tema'
                ))

            ))

        ));

        if (isset($_POST['usuario'])) {

            $form->setAtributes($_POST['usuario']);

            if ($form->validate()) {

                $param = $form->getAtributes();

                if (!empty($param['pass']))
                    $param['pass'] = md5($param['pass']);
                else
                    unset($param['pass']);

                $this->db()->update('usuarios', $param,
                    array(
                        'id' => $this->webApp()->getUsuarioId()
                    )
                );

                $this->webApp()->setTheme($param['theme']);

                $this->notify('Sus datos se actualizaron correctamente', notificacion::SUCCESS);

            }

        } else {

            $usuario = $this->db()->queryRow('SELECT email, nombre, theme FROM usuarios WHERE id = :id', array(
                'id' => $this->webApp()->getUsuarioId()
            ));

            $form->setAtributes($usuario);

        }

        $this->render("miperfil", array(
            'form' => $form
        ));
    }

    public function theme()
    {
        $this->webApp()->requireLoginRedir();

        if (isset($_GET['id'])) {

            if ($this->webApp()->setTheme($_GET['id'])) {

                $this->db()->update('usuarios',
                    array(
                        'theme' => $_GET['id']
                    ),
                    array(
                        'id' => $this->webApp()->getUsuarioId()
                    )
                );

            }

            $this->redirect($_SERVER['HTTP_REFERER']);

        }

    }

}