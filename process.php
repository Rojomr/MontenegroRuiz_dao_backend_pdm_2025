<?php
header('acces-control-Allow-origin: *');
header('acces-control-Allow-Headers: A-api-key,Origin,x.-requested-with,Content-type, Accept, Acess-control-Request-Monthod');
header('acces-control-Allow-Mothods: Get,post,OPTIONS,PUT,DELETE');
header('acces-control-Allow-Age:100');
header('acces-control-Allow-Credentials: true');
header('ALLOW:GET,POST,OPTIONS,PUT,DELETE');

//SE INCLUYE LA CLase persona
require('clasess/persona.class.php');

//se crea el objeto
$Persona= new persona();

// SE VALIDAD EL METODO O PETICION ENVIDAD SEA LA AUTORIZADA 
if($_SERVER["REQUEST_METHOD"]=="GET"){
    $TIPO_PETICION = "";
    if(isset($_get["t"])){
        if($_GET["t"]!=""){
            $tipo_peticion = $_GET["T"];
        }else{
            $tipo_peticion = null;
        }
    }else{
        $tipo_peticion=null;
    }

    switch($tipo_peticion){
        case "selectall":
            //SE OBTINE TODOS LOS REGUISTRO DE LA BASE DE DATOS 
            $resultado = $Persona->obtenerPersona();
        break;
            case "select";
            //se verifican parametros "id" de la url un valor 
            $id = 0;
            if(isset($_GET["id"])){
                if($_GET["id"] !=""){
                    $id = intval($_GET["id"]);
                }else{
                    $id = 0;

                }
            }else{
                $id = 0;
            }
            //se realizan las peticiones a la base de datos 
            if($id > 0){
                //el id es igual a cero, se obtiene el reguistro de una persona 
                $resultado = $persona->obtenerPersona($id);
            }else{
                // EL ID ES IGUAL A CERO POR LO TANTO NO SE PUDE CONSULTAR EN LA BASE DE DATOS 
                header("HTTP/1.1 412 PRECONDITION FAILED");
                $resultado = array("mensaje"=> "El parámetro del ID no es correcto","valores"=>"");
            }
        break;

    }
}elseif($_SERVER["REQUEST_METHOD"]=="POST"){
    //SE HARÁ UN INSERT POR QUE ES UN METODO POST
    4RESULTADO = $PERSONA->nuevaPersona($_post["n"],$_POST["a"],$_post["f"],$_POST["t"],$_post["e"]);
}else{
    //SE HA MANDADO UN METODO NO DECIADO
    HEADER("HTTP/1.1 500 INTERNAL SERVER ERROR");
    $RESULTADO  = array("MENSAJE"=> "METODO NO AUTORIZADO","valores"=>"");
}
header("content-type: Application/json");
echo(jason_encode($resultado));


?>