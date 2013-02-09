<?php

namespace LSBase\Utils;

/**
 * HandlesDirectory
 *
 * Classe para manipular diretórios e arquivos.
 *
 * @package LSBase\Utils
 * @author Jesus Vieira <jesusvieiradelima@gmail.com>
 * @version  v1.0
 */
class HandlesDirectory
{

    protected $origin;
    protected $identity;

    public function __construct($origin, $identity)
    {
        $this->origin = $origin;
        $this->identity = $identity;
    }

    /**
     * createOrigin
     * 
     * Cria o diretório Original.
     * 
     * @author Jesus Vieira <jesusvieiradelima@gmail.com>
     * @access public
     * @return \LSBase\Utils\HandlesDirectory
     */
    public function createOrigin()
    {
        if (!file_exists($this->origin)) {
            mkdir($this->origin);
            chmod($this->origin, 0777);
        }

        return $this;
    }

    /**
     * createIdentity
     * 
     * Cria o diretório identidade tendo como referencia o ID do banco de dados.
     * 
     * @author Jesus Vieira <jesusvieiradelima@gmail.com>
     * @access public
     * @return \LSBase\Utils\HandlesDirectory
     */
    public function createIdentity()
    {
        if (!file_exists($this->origin.DIRECTORY_SEPARATOR.$this->identity)) {
            mkdir($this->origin.DIRECTORY_SEPARATOR.$this->identity);
            chmod($this->origin.DIRECTORY_SEPARATOR.$this->identity, 0777);
        }

        return $this;
    }

    /**
     * removeDirectory
     * 
     * Deleta o diretório e todos os arquivos contido nele.
     * 
     * @author Jesus Vieira <jesusvieiradelima@gmail.com>
     * @access public | static
     * @param String $dir
     */
    public static function removeDirectory($dir)
    {
        $files = array_diff(scandir($dir), array('.', '..'));

        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? self::removeDirectory("$dir/$file") : unlink("$dir/$file");
        }

        return rmdir($dir);
    }

    /**
     * removeFile
     * 
     * Deleta o arquivo indicado no $file.
     * 
     * @author Jesus Vieira <jesusvieiradelima@gmail.com>
     * @access public
     * @param String $file
     * @return \LSBase\Utils\HandlesDirectory
     */
    public function removeFile($file)
    {
        if (file_exists($file))
            unlink($file);

        return $this;
    }

    /**
     * getOrigin
     * 
     * Retorna o caminho do diretório origin
     * 
     * @author Jesus Vieira <jesusvieiradelima@gmail.com>
     * @access public
     * @return String
     */
    public function getOrigin()
    {
        return $this->origin . DIRECTORY_SEPARATOR;
    }

    /**
     * getIdentity
     * 
     * Retorna o caminho do diretório origin
     * 
     * @author Jesus Vieira <jesusvieiradelima@gmail.com>
     * @access public
     * @return String
     */
    public function getIdentity()
    {
        return $this->identity . DIRECTORY_SEPARATOR;
    }

}