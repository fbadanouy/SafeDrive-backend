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

class registros extends controller
{
    public function index()
    {
        $this->webApp()->requireLoginRedir();

        $this->titulo = 'Registros';

        $grid = $this->configGrid();

        $this->render("index", array(
            'grid' => $grid
        ));
    }

    public function showPicture()
    {
        $registroId = $_GET['registro_id'];

        $registro = $this->db()->queryRow("SELECT * FROM registros WHERE id = :id",[
            "id"    => $registroId
        ]);

        $this->render("registro", array(
            'registro' => $registro
        ));        

    }

    private function configGrid()
    {
        $grid = new grid('registros');

        $grid
            ->setJsonUrl($this->getMethodUrl('data'))
            ->setColModel(array(
                array(
                    'name'   => 'matricula',
                    'width'  => 50,
                    'format' => grid::FMT_STRING
                ),
                array(
                    'name'   => 'fecha_hora',
                    'label'  => 'Fecha',
                    'format' => grid::FMT_DATETIME
                ),
                array(
                    'name'   => 'evento',
                    'width'  => 100,
                    'format' => grid::FMT_STRING
                ),
                array(
                    'name'   => 'ubicacion',
                    'width'  => 200,
                    'format' => grid::FMT_STRING
                ),
                array(
                    'name'      => 'velocidad',
                    'width'     => 50,
                    'format'    => grid::FMT_STRING,
                )
            ))
            ->setDefaultSortName('matricula')
            ->setDefaultSortOrder('asc');

        return $grid;
    }


    public function data()
    {
        $this->webApp()->requireLogin();

        $grid = $this->configGrid();

        $grid->renderData($this->db(), "SELECT * FROM registros");
    }

}