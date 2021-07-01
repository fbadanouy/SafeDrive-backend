<?php $this->renderInclude("header");?>

<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-6">    
            <select id="matriculaSelector" class="form-control">
                <option value="0" disabled selected>Seleccione una matrícula... </option>
                <?php 
                    foreach ($matriculas as $matricula) {
                        $selected = ($matricula == $matriculaSelected) ? ' selected' : '';
                        echo '<option value="' . $matricula . '"' . $selected . '>' . $matricula . '</option>'; 
                    }
                ?>
            </select>
        </div>
        <div class="col-lg-6"> 
            <input type="text" class="form-control" name="daterange" value="<?php if ($fecha) echo $fecha[0] . ' - ' . $fecha[1]; else echo '2020-11-14 - 2020-11-14'; ?>"/>
        </div>
    </div>
</div>

<script>
    $("#matriculaSelector").change(function () {
        if ($(this).val() != 0)
            window.location = 'visualizador?matricula=' + $('#matriculaSelector').val() + '&fecha=' + $('input[name="daterange"]').val();
    });
    $(function() {
        $('input[name="daterange"]').daterangepicker({
            "locale": {
                "format": "YYYY-MM-DD",
                "separator": " - ",
                "applyLabel": "Aplicar",
                "cancelLabel": "Cancelar",
                "fromLabel": "Desde",
                "toLabel": "Hasta",
                "customRangeLabel": "Custom",
                "weekLabel": "S",
                "daysOfWeek": [
                    "Do",
                    "Lu",
                    "Ma",
                    "Mi",
                    "Ju",
                    "Vi",
                    "Sá"
                ],
                "monthNames": [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],
                "firstDay": 1
            },
            opens: 'left'
        }, function(start, end, label) {
            window.location = 'visualizador?matricula=' + $('#matriculaSelector').val() + '&fecha=' + start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD');
        });
    });
</script>

<?php
    if ($data) { 
        $velocidades = getVelocidades($data);
?>
        </br>
        </br>
        </br>

        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list-ul fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo sizeof($data) ?></div>
                                    <div>Registros</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-dashboard fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $velocidades[0] ?> km/h</div>
                                    <div>Velocidad Promedio</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-dashboard fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $velocidades[1] ?> km/h</div>
                                    <div>Velocidad Máxima</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div id="mapid" style="height: 550px;">
                </div>
            </div>
        </div>

        <script>
            var mymap = L.map('mapid').setView([<?php echo $data[0]['ubicacion']; ?>], 13);

            L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom: 18,
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1,
                accessToken: 'pk.eyJ1IjoiZmJhZGFubyIsImEiOiJja2dmb2twanQxOXo2MnhwNDF1OHlya2d2In0.hNzHPjxde3ayge_DHGVlrg'
            }).addTo(mymap);

            <?php foreach ($data as $registro) { 
                    if ($registro['ubicacion'] != 'n/a, n/a') { ?>
                        var marker = L.marker([<?php echo $registro['ubicacion'];?>]).addTo(mymap);
                        marker.bindPopup(
                            '<div><h4><?php echo $registro['fecha_hora']; ?></h4></div><div><h4><?php echo $registro['evento']; ?></h4></div><div><img width="308" height="180" src="data:image/jpg;base64,<?php echo substr($registro['foto'], 2, -1) ?>" alt="Foto" /></div>', {
                            minWidth: 308,
                            minHeight: 220
                        });
            <?php   }
                } ?>

        </script>
<?php
    } else {
        ?>

        </br>
        </br>
        </br>

        <div class="row">
            <?php if ($matriculaSelected) {?>
                <h3 style="text-align: center;">No existen registros para el rango de fechas seleccionado</h3>
            <?php } ?>
        </div>
        <?php
    }
?>

<?php $this->renderInclude("footer");?>

<?php

function getVelocidades($data) {
    $sumaVelocidades = $velocidadMaxima = 0;

    foreach ($data as $d) {
        $sumaVelocidades += $d['velocidad'];
        $velocidadMaxima = ($velocidadMaxima < $d['velocidad']) ? $d['velocidad'] : $velocidadMaxima;
    }

    return [round($sumaVelocidades/sizeof($data), 2), $velocidadMaxima];
}

?>
