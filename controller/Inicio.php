<?php
class Inicio
{
  public function controller()
  {
    $inicio = new Template("view/inicio.html");
    $inicio->set("nome", "brunna, cecilia e nayara");
    $retorno["msg"] = $inicio->saida();
    return $retorno;
  }
}
