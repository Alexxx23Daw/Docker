<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarifa Luz Hora</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@latest/dist/Chart.min.js"></script>
</head>
<?php
    require_once 'datos.php';

    // Fecha que quieres mostrar
    $fecha = $_GET['fecha'] ?? '2025-11-01';
    $preciosPorHora = obtenerPreciosPorFecha($conexion, $fecha); //Llenamos el array
?>

<body>
    <nav class="menu">
        <img class="logo" src="logo.png">
        <ul>
            <li>Mercado Luz y Gas</li>
            <li>Compañías</li>
            <li>Trámites</li>
            <li>Distribuidoras</li>
            <li>Ahorro</li>
            <li>Herrmientas</li>
        </ul>
    </nav>

    <main>
    <div class="titular">
        <h1>Consulta el precio de la luz hoy: Detalles y Evolución de la <br>tarifa PVPC</h1>
    </div>

    <div class="cambiar-dia">
        <div class="titular-precio">
        <h2>Precio de la luz por horas hoy</h2>
        <h2><?= date("d/m/Y", strtotime($fecha)) ?></h2>
        </div>

        <div class="boton-fecha">
            <form method="GET" action="index.php">
                <label for="fecha">Selecciona un día:</label>
                <select id="fecha" name="fecha">
                    <?php
                    $fechasDisponibles = ['2025-11-01', '2025-11-10', '2025-11-15', '2025-11-20'];
                    foreach ($fechasDisponibles as $dia) {
                        $selected = ($dia === $fecha) ? 'selected' : '';
                        echo "<option value=\"$dia\" $selected>" . date("d/m/Y", strtotime($dia)) . "</option>";
                    }
                    ?>
                </select>
                <input type="submit" value="Ver precios">
            </form>
        </div>
    </div>

    <div class="grafico1">
        <div class="grafico1-hora">
            <p><strong>Precio a las 19:00</strong></p>
        </div>
        <div class="grafico1-fecha">
            <p><?= date("d/m/Y", strtotime($fecha)) ?></p>
        </div>
        <div class="grafico-barras">
            <canvas id="grafica"></canvas>
        </div>
    </div>

    <div class="sabiasQue">
        <p><b>¿Sabías qué?</b></p>
        <p>Si no quieres modificar tu rutina, hoy podrías utilizar este tramo para poner lavadoras o cocinar ya que está ligeramente más bajo.</p>
        <div class="sabias-horas">
            <h1>14-17h</h1>
            <h3>🡣 0.13 €/kWh</h3>
        </div>
        <p>Este es el tramo de 2 o 3 horas más económicas durante el día (de 7 a 21 horas), que puede o no contener la hora más económica del dia.</p>
    </div>

    <div class="precios">
        <div class="precio-medio">
            <p><b>Precio medio del día</b></p>
            <p><?= date("d/m/Y", strtotime($fecha)) ?></p>
            <div>
                <?php
                    $precios = array_column($preciosPorHora, 'precio');
                    
                    if (count($precios) > 0){
                        $media = array_sum($precios) / count($precios);
                        echo "<h2>$media</h2>"; 
                    }
                ?>
            </div>
            <p>€/kWh</p>
        </div>
        <div class="precio-bajo">
            <p><b>Precio más bajo del día</b></p>
            <p><?= date("d/m/Y", strtotime($fecha)) ?></p>
                <?php
                    $precioMinimo = min($precios); //Buscamos el precio minimo

                    //Buscamos la hora que le corresponde 
                    foreach ($preciosPorHora as $registro){
                        if ($registro['precio'] == $precioMinimo){
                            $horaMinima = $registro['hora'];
                            break;
                        }
                    }
                    echo "<h1>" . $horaMinima . "-" . ($horaMinima + 1) . "h</h1>";
                    echo "<p class='verde'>" . "🡣" .number_format($precioMinimo, 3) . "€/kWh</p>";
                ?>
        </div>
        <div class="precio-alto">
            <p><b>Precio más alto del día</b></p>
            <p><?= date("d/m/Y", strtotime($fecha)) ?></p>
                <?php
                    $precioMaximo = max($precios);

                    foreach ($preciosPorHora as $registro) {
                        if ($registro['precio'] == $precioMaximo) {
                            $horaMaxima = $registro['hora'];
                            break;
                        }
                    }
                    echo "<h1>" . $horaMaxima. "-" . ($horaMaxima + 1) . "h</h1>";
                    echo "<p class='rojo'>" . "🡡" . number_format($precioMaximo, 3) . "€/kWh</p>";
                ?>
        </div>
    </div> 

    <div class="listaPrecios">
        <?php if ($preciosPorHora && count($preciosPorHora) > 0): ?>
            <div class="lista-precios">
                <h3>Precios por hora del <?= htmlspecialchars(date("d/m/Y", strtotime($fecha))) ?></h3>
                <ul>
                    <?php
                    $precios = array_column($preciosPorHora, 'precio');
                    
                    foreach ($preciosPorHora as $fila):
                        $precio = $fila['precio'];

                        if ($precio < 0.1) {
                            $color = "🟢";
                        } elseif ($precio < 0.2) {
                            $color = "🟡";
                        } else {
                            $color = "🔴";
                        }
                    ?>

                        <li>
                            <?= str_pad($fila['hora'], 2, '0', STR_PAD_LEFT) ?>:00 →
                            <?= number_format($precio, 2) ?> €/kWh <?= $color ?>
                        </li>

                    <?php endforeach; ?>
                </ul>
            </div>
        <?php else: ?>
            <p>No hay datos disponibles para la fecha seleccionada.</p>
        <?php endif; ?>
    </div>

    <div class="precioMedio-mensual">
        <h2>Precio medio mensual del PVCP</h2>
        <p>Fuente: REE - ESIOS</p>
        <hr>  
        <div class="grafico-barras2">
            <canvas id="grafica2"></canvas>
        </div>
    </div>
    </main>

    <script>
    const preciosPorHora = <?php echo json_encode($preciosPorHora);?>;
    </script>
    <script src="script.js"></script>
</body>
</html>