<?php

/**
 * MIT License
 * ===========
 *
 * Copyright (c) 2013 Jesus Vieira <jesusvieiradelima@gmail.com>
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
 */

namespace LSBase\Utils;

use \Exception;
use Zend\File\Transfer\Adapter\Http;

/**
 * UploadFile
 *
 * Classe Controller UploadFile
 *
 * @package    Utils
 * @author     Jesus Vieira <jesusvieiradelima@gmail.com>
 * @copyright  2012 Jesus Vieira.
 * @license    http://www.opensource.org/licenses/mit-license.php  MIT License
 * @link       http://www.webpatterns.com.br
 * @version  v1.0
 */
class UploadFile
{
    protected $destination;
    protected $ticket;
    protected $path;
    protected $http;
    protected $fileName;

    public function __construct(Http $http, $destination = null, $ticket = null, $path = null )
    {
        $this->http        = $http;
        $this->destination = $destination;
        $this->ticket      = $ticket;
        $this->path        = $path;

        //Cria a pasta do ticket
        if (!\file_exists($this->destination)) {
            if (\mkdir($this->destination)) {
                \chmod($this->destination, 0777);
            } else {
                throw new Exception('Não foi possível criar a pasta de destino.');
            }
        }

        //Cria a pasta de destino
        if (!\file_exists($this->destination.DIRECTORY_SEPARATOR.$this->ticket)) {
            if (\mkdir($this->destination.DIRECTORY_SEPARATOR.$this->ticket)) {
                \chmod($this->destination.DIRECTORY_SEPARATOR.$this->ticket, 0777);
            } else {
                throw new Exception('Não foi possível criar a pasta do Ticket.');
            }
        }

        //Cria a pasta de destino
        if (!\file_exists($this->destination.DIRECTORY_SEPARATOR.$this->ticket.DIRECTORY_SEPARATOR.$this->path)) {
            if (\mkdir($this->destination.DIRECTORY_SEPARATOR.$this->ticket.DIRECTORY_SEPARATOR.$this->path)) {
                \chmod($this->destination.DIRECTORY_SEPARATOR.$this->ticket.DIRECTORY_SEPARATOR.$this->path, 0777);
            } else {
                throw new Exception('Não foi possível criar a pasta de interação.');
            }
        }

        //Indica a pasta de destino do arquivo
        $http->setDestination($this->destination.DIRECTORY_SEPARATOR.$this->ticket.DIRECTORY_SEPARATOR.$this->path);

        $newName = $this->removerCaracter($_FILES['archive']['name']);

        //Renomeia o arquivo
        $http->addFilter('Rename', array('target' =>
            $this->destination.DIRECTORY_SEPARATOR.$this->ticket.DIRECTORY_SEPARATOR.$this->path.DIRECTORY_SEPARATOR.$newName, 'overwrite' => true));


        $files = $http->getFileInfo();

        foreach ($files as $file) {

            // validators are ok ?
            if (!$http->isValid($file)) {
                print_r($http->getMessages());

            }
        }

        $http->receive();// Salva o arquivo

        $this->fileName = $newName;

    }

    /**
     * getFileName
     *
     * Retorna o nome do arquivo
     *
     * @return String
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * removerCaracter
     *
     * Remove caracteres especiais
     *
     * @param  String $string
     * @return String
     */
    public function removerCaracter($str){

        $aaa = array('/(à|á|â|ã|ä|å|æ|Á|Ã|Â|À|Ä)/','/(è|é|ê|ë|É|Ê|È|Ë)/','/(ì|í|î|ï|Í|Î|Ì|Ï)/','/(ð|ò|ó|ô|õ|ö|ø|Õ|Ó|Ò|Ö)/','/(ù|ú|û|ü|Ú|Ù|Ü)/','/ç/','/þ/','/ñ/','/ß/','/(ý|ÿ)/','/(=|\+|\/|\'|\_|\\n| |\(|\))/');

        $bbb = array('a','e','i','o','u','c','d','n','s','y','-','');

        return trim(trim(trim(preg_replace('/-{2,}/s', '-', preg_replace($aaa, $bbb, strtolower($str)))),'_'),'-');

    }

}