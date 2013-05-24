<?php

/**
 * MIT License
 * ===========
 *
 * Copyright (c) 2013 Jesus Vieira de Lima. <jesusvieiradelima@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
 * CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @package    Utils
 * @subpackage LSBase
 * @author     Jesus Vieira de Lima. <jesusvieiradelima@gmail.com>
 * @copyright  2012 Jesus Vieira de Lima..
 * @license    http://www.opensource.org/licenses/mit-license.php  MIT License
 * @version    v1.0
 * @link       http://webpatterns.com.br
 */

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

    /**
     * __construct
     *
     * @param String $origin
     * @param String $identity
     */
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
     * @access public
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
     * @param  String                         $file
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
