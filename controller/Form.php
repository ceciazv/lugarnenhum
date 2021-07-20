<?php
class Form
{
  public function __construct()
  {
    Transaction::open();
  }
  public function controller()
  {
    $form = new Template("view/form.html");
    $form->set("id", "");
    $form->set("prato", "");
    $form->set("ingredientes", "");
    $form->set("preco", "");
    $retorno["msg"] = $form->saida();
    return $retorno;
  }

  public function salvar()
  {
    if (isset($_POST["prato"]) && isset($_POST["ingredientes"]) && isset($_POST["preco"])) {
      try {
        $conexao = Transaction::get();
        $prato = $conexao->quote($_POST["prato"]);
        $ingredientes = $conexao->quote($_POST["ingredientes"]);
        $preco = $conexao->quote($_POST["preco"]);
        $crud = new Crud();
        if (empty($_POST["id"])) {
          $retorno = $crud->insert(
            "cardapio",
            "prato,ingredientes,preco",
            "{$prato},{$ingredientes},{$preco}"
          );
        } else {
          $id = $conexao->quote($_POST["id"]);
          $retorno = $crud->update(
            "cardapio",
            "prato={$prato}, ingredientes={$ingredientes}, preco={$preco}",
            "id={$id}"
          );
        }
      } catch (Exception $e) {
        $retorno["msg"] = "Ocorreu um erro! " . $e->getMessage();
        $retorno["erro"] = TRUE;
      }
    } else {
      $retorno["msg"] = "Preencha todos os campos! ";
      $retorno["erro"] = TRUE;
    }
    return $retorno;
  }

  public function __destruct()
  {
    Transaction::close();
  }
}
