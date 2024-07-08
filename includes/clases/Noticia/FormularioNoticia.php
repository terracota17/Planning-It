<?php
namespace es\ucm\fdi\aw\Noticia;

use es\ucm\fdi\aw\Formulario as Formulario;

class FormularioNoticia extends Formulario
{
    public function __construct($id = null) {
       parent::__construct('formNoticia', ['urlRedireccion' => 'crearNoticia.php']);
       $this->id = $id;  
    }

    protected function generaCamposFormulario(&$datos)
    {
        if ($this->id != NULL) {
            $noticia =Noticia::buscaNoticiaId($this->id);
            $titulo = $datos['titulo'] ?? $noticia->getTitular();
            $cuerpo = $datos['cuerpo'] ?? $noticia->getCuerpo();
            $categoria = $datos['categoria'] ?? $noticia->getCategoria();
        }
        else {
            $titulo = $datos['titulo'] ?? '';
            $cuerpo = $datos['cuerpo'] ?? '';
            $categoria = $datos['categoria'] ?? '';
        }

        $fecha = date("Y-m-d");
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['titulo', 'cuerpo','fecha', 'categoria'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <input  type="hidden" name="idNoticia" value = "{$this->id}">
            <input  type="hidden" name="fecha" value = "{$fecha}">
        EOF;

        if ($this->id == NULL) {
            $html .= <<<EOF
            $htmlErroresGlobales
                <div>
                    <label for="titulo">Titular de la noticia: <span id = "validTitle"></span></label>
                    <input id="titulo" required type="text" name="titulo" value="$titulo" />
                    {$erroresCampos['titulo']}
                </div>
            EOF;
        }
        else {
            $html .= <<<EOF
            $htmlErroresGlobales
                <div>
                    <label for="tituloedit">Titular de la noticia: <span id = "validTitle"></span></label>
                    <input id="tituloedit" required type="text" name="tituloedit" value="$titulo" />
                    {$erroresCampos['titulo']}
                </div>
            EOF;
        }
        $html .= <<<EOF
        $htmlErroresGlobales
            <div>
                <label for="cuerpo">Cuerpo de la noticia: <span id = "validNews"></span></label>
                <input id="cuerpo" required type="text" name="cuerpo" value="$cuerpo" />
                {$erroresCampos['cuerpo']}
            </div>
            <div>
                <label for="categoria">Categoria:</label>
                    <select name="categoria" id="categoria">
                    <option value="deportes">Deportes</option>
                    <option value="politica" selected>Política</option>
                    <option value="comida">Gastronomía</option>
                    <option value="educacion">Educación</option>
                </select>
            </div>
            <div>
                <button type="submit" name="registro">Registrar</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }
    protected function procesaFormulario(&$datos)
    {
        if($_SESSION['login'] === true){
            $this->errores = [];

            if ($datos['idNoticia'] == NULL) {
                $titulo = trim($datos['titulo'] ?? '');
                $titulo = filter_var($titulo, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }
            else {
                $titulo = trim($datos['tituloedit'] ?? '');
                $titulo = filter_var($titulo, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }

            $cuerpo = trim($datos['cuerpo'] ?? '');
            $cuerpo = filter_var($cuerpo, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $fecha = trim($datos['fecha'] ?? '');
            $fecha = filter_var($fecha, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $categoria = trim($datos['categoria'] ?? '');
            
            if ($datos['idNoticia']) {
                $Noticia = Noticia::crea($titulo,$cuerpo,$fecha,$categoria,$datos['idNoticia']);
            }
            else {
                $Noticia = Noticia::crea($titulo,$cuerpo,$fecha,$categoria,null);
            }
            if($Noticia){
                $this->errores[] = "Noticia añadida correctamente";
            }
            else{
                $this->errores[] = "Error al introducir la noticia en la base de datos";
            }
            
            header('Location: listarNoticias.php');
            exit();
        }
        else{
            $this->errores[] = "Inicia sesión para poder añadir una noticia";
        }
    }
}