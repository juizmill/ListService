<?php
namespace LSUserTest\BaseTest;

use LSUserTest\Framework\TestCase;

class UsuarioControllerTest extends TestCase
{
    protected $class = '\\LSUser\\Controller\\UserController';
    /**
     * Verifica se a classe existe
     */
    public function test_classe_existe()
    {
        $this->assertTrue(class_exists($this->class));
    }
} 