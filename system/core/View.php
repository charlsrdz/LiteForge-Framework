<?php
namespace LiteForge\Core;

class View
{
    protected $layout;
    protected $sections = [];
    protected $currentSection;

    /**
     * Establece el layout principal.
     *
     * @param string $layout Nombre del archivo de layout.
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    /**
     * Inicia una sección.
     *
     * @param string $name Nombre de la sección.
     */
    public function startSection($name)
    {
        $this->currentSection = $name;
        ob_start();
    }

    /**
     * Finaliza la sección y almacena su contenido.
     */
    public function endSection()
    {
        $this->sections[$this->currentSection] = ob_get_clean();
    }

    /**
     * Renderiza una vista con el layout y las secciones.
     *
     * @param string $view Nombre del archivo de vista.
     * @param array $data Datos a pasar a la vista.
     */
    public function render($view, $data = [])
    {
        extract($data);

        ob_start();
        include __DIR__ . "/../views/{$view}.php";
        $content = ob_get_clean();

        if ($this->layout) {
            include __DIR__ . "/../views/layouts/{$this->layout}.php";
        } else {
            echo $content;
        }
    }

    /**
     * Obtiene el contenido de una sección.
     *
     * @param string $name Nombre de la sección.
     * @return string Contenido de la sección.
     */
    public function section($name)
    {
        return $this->sections[$name] ?? '';
    }
}
