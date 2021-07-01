<?php

use oxusmedia\webApp\grid;
use oxusmedia\webApp\controller;

class visualizador extends controller
{

    public function index()
    {
        $this->webApp()->requireLoginRedir();

        $this->titulo = 'Visualizador';

        if (isset($_GET['matricula'])) {

            $matricula  = $_GET['matricula'];
            $fecha      = explode(' - ', $_GET['fecha']);

            $data       = $this->getData($matricula, $fecha);

        } else {

            $matricula = null;
            $fecha = null;
            $data = $this->getData();

        }

        $matriculas = $this->getMatriculas();

        $this->render('index', [
            'matriculas'            => $matriculas,
            'matriculaSelected'     => $matricula,
            'fecha'                 => $fecha,
            'data'                  => $data
        ]);

    }

    private function getData($matricula = null, $fecha = null)
    {

        if ($matricula and $fecha) {

            //Buscar registros de matrícula
            $query = $this->db()->query("SELECT * FROM registros 
                WHERE matricula = :matricula 
                    AND DATE(fecha_hora) <= :fechaEnd 
                    AND DATE(fecha_hora) >= :fechaStart", 
                [
                    'matricula'     => $matricula,
                    'fechaStart'    => $fecha[0],
                    'fechaEnd'      => $fecha[1]
                ]
            );

            while ($row = $this->db()->getRow($query)) {
                if ($row->ubicacion != 'n/a, n/a')
                    $data[] = (array)$row;
            }

            return $data;

        } else {

            return null;

        }

    }

    private function getMatriculas()
    {

        $matriculas = [];

        $query = $this->db()->query("SELECT DISTINCT matricula FROM registros");

        while ($row = $this->db()->getRow($query)) {

            $matriculas[] = $row->matricula;

        }

        return $matriculas;

    }

}