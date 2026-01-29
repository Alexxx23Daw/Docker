<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>T8_Calculadora6A</title>
</head>
<body>
    
<?php
  if (!isset($_REQUEST["Enviar"])){
?>
 
  <h1>Realiza tus operaciones aquí</h1>
<form action="t8Calculadora6A.php" method="get">
  
  <fieldset>
    <legend>Calculadora:</legend>
    <label for="Operacion">Seleccione un número:
    <input type="number" id="dato" name="dato" placeholder="dato" required/> 
    <input type="submit" name="Enviar" value="Enviar"/>  
  </fieldset>
</form>

<?php    
} else{

  $dato = $_REQUEST["dato"];
  $sumaDivisores = 0;

  //Tabla de multiplicar
  echo "Tabla de multiplicar: <br><br>";
  for ($i = 1; $i <= 10; $i++){
   echo "$dato x $i = " . ($dato * $i) . "<br>"; 
  }
    echo "<br>";

  //Divisores
  echo "Divisores de $dato: ";
  for ($i = 1; $i <= $dato; $i++) 
    if($dato % $i == 0){
      echo "$i";
      $sumaDivisores = $sumaDivisores + $i;
    }
  echo "<br>";

  //Numero hasta el dato
  echo "Números hasta tú dato: ";
  for ($i = 1; $i <= $dato; $i++){
    echo "$i";
  }  

  //Suma de los divisores
  echo "<p>Suma total de los divisores: $sumaDivisores</p>";
  
  //Par o Impar
  echo "<p>Tú número es un numero:</p>";
  if($dato % 2 == 0){
    echo "<p>$dato es par</p>";
  }else{
    echo "<p>$dato es impar</p>";
  }

  echo '<p><a href="t8Calculadora6A.php">Volver al formulario</a></p>';
}
?>
</body>
</html>