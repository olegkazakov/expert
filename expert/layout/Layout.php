<?php
namespace expert\layout;

class Layout {

  private $layoutName='default';
  private $viewName;
  private $view;
  public function getView() {
    return $this->view;
  }

  public function setView($view) {
    $this->view = $view;
  }

  public function getLayoutName() {
    return $this->layoutName;
  }

  public function setLayoutName($layoutName) {
    $this->layoutName = $layoutName;
  }

  public function render($viewName){
    $fileName = "layout/{$this->layoutName}.php";
    if (!file_exists($fileName)){
        throw new \RuntimeException('Нэту такого файла!');
    }
    $this->viewName = $viewName;
    require $fileName;
  }
  public function view() {
    $fileName = "expert/views/{$this->viewName}.php";
    require $fileName;
  }
}
