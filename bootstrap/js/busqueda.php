<?php
   require('conexion.php');
   $busqueda=$_POST['busqueda'];
   if ($busqueda<>''){
   	//numero de palabras
   	$trozos=explode(" ",$busqueda);
   	$numero=count($trozos);
   	if ($numero==1) {
   		$cadbusca="SELECT * FROM post WHERE CONTENIDO LIKE '%$busqueda%' OR TITULO LIKE '%$busqueda%' LIMIT 10;";
   	} elseif ($numero>1) {
   		$cadbusca="SELECT * , MATCH ( TITULO, CONTENIDO ) AGAINST ( '$busqueda' ) AS Score FROM post WHERE MATCH ( TITULO, CONTENIDO ) AGAINST ( '$busqueda' ) ORDER BY Score DESC LIMIT 50;";
   	}
   
   	function limitarPalabras($cadena, $longitud, $elipsis = "..."){
   	$palabras = explode(' ', $cadena);
   	if (count($palabras) > $longitud)
   		return implode(' ', array_slice($palabras, 0, $longitud)) . $elipsis;
   	else
   	return $cadena;
   	}
?>
<table border="1px">
<tbody>
	<tr>
	<td class="titulo">Titulo</td>
	<td class="contenido">Contenido</td>
	<td class="autor">Autor</td>
	</tr>
<?php
   	$result=mysql_query($cadbusca, $con);
   	$i=1;
   	while ($row = mysql_fetch_array($result)){
	   echo "
	   <tr>
	   <td class=\"titulo\">".$row['titulo']."</td>
	   <td class=\"contenido\">".limitarPalabras($row['contenido'],20)."</td>
	   <td class=\"autor\">".$row['autor']."</td>
	   </tr>";
	   $i++;
   	}
?>
</tbody>
</table>
<?php
	//cierra el if inicial
	}
	echo "entro";
?> 