<?php
  require_once ('LIGA3/LIGA.php');

  BD('localhost', 'root', '', 'base');

  $tabla = 'usuarios';
  $liga  = LIGA($tabla);

  $resp  = '';
  if (isset($_GET['accion'])) {
  if ($_GET['accion'] == 'insertar') {
   $resp = $liga->insertar($_POST);
   
  } elseif ($_GET['accion'] == 'modificar') {
   $datos = array($_POST['cual']=>$_POST);
    $resp = $liga->modificar($datos);
   }
 }
    if (isset($_GET['borrar'])) {
  $resp = $liga->eliminar($_GET['borrar']);
 }
  if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
  echo $resp;
  exit(0);
 }

 if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
  echo $resp;
  exit(0);
 }

   HTML::cabeceras(array('title'      =>'Examen',
      'description'=>'Página de Examen',
      'css'        =>'util/LIGA.css',
      'style'      =>'label { width:300px; }',
    'js' => array('js/jquery-3.1.1.min.js', 'js/jquery.liga-1.3.13.js', 'js/codigo.js')
      )
      );

   ob_start();

   $cols = array('*', '-contraseña', 'acción'=>'<a href="?borrar=@[0]">Borrar</a>');
  $join = array('depende'=>$liga);
  $pie  = '<th colspan="@[numCols]">Total de instancias: @[numReg]</th>';
  HTML::tabla($liga, 'Instancias de '.$tabla, $cols, true, $join, $pie);

  $props  = array('form'=>'method="POST" action="?accion=insertar"',
      'input[puesto]'=>array('required'=>'required'));
  $campos = array('*', '-fecha');
  HTML::forma($liga, 'Registro de '.$tabla, $campos, $props, true, $_POST);


  $props  = array('form'=>array('method'=>'POST', 'action'=>'?accion=modificar'), 'prefid'=>'algo',
      'input[puesto]'=>array('required'=>'required'));
  $cual   = !empty($_POST['cual']) ? $_POST['cual'] : '';
  $select = HTML::selector($liga, 1, array('select'=>array('name'=>'cual', 'id'=>'algocual'),
               'option'=>array('value'=>'@[0]'),
               "option@si('$cual'=='@[0]')"=>array('selected'=>'selected')), array('depende'=>$liga)
         );
  $campos = array('cual'=>$select, '*', '-fecha');
  HTML::forma($liga, 'Modificar '.$tabla, $campos, $props, true);
 $cont = ob_get_clean();
 
 HTML::cuerpo(array('cont'=>$cont));
  

    HTML::pie();

?>