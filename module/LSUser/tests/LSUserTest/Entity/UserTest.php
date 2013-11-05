<?php
namespace LSUserTest\Entity;

use LSUserTest\Framework\TestCase;
use LSTypeuser\Entity\TypeUser;

class UserTest extends TestCase
{
    protected $class = '\\LSUser\\Entity\\User';

    public function test_verifica_se_classe_existe()
    {
        $this->assertTrue(class_exists($this->class));
    }

    public function data_provider_atributos()
    {
        return array(
            array('id', 1),
            array('name', 'teste'),
            array('email', 'teste@teste.com.br'),
            array('login', 'teste'),
            array('password', '12345'),
            array('registry', new \DateTime('now')),
            array('avatar', 'imagem.jpg'),
            array('active', true),
            array('salt', '123232454567659803495'),
            array('active_key', 'khksd98e882k2kknsnk04-580s'),
            array('type_user', new TypeUser())
        );
    }

    /**
     * @dataProvider data_provider_atributos
     */
    public function test_verifica_se_a_classe_tem_atributos_esperados($atributo)
    {
        $this->assertClassHasAttribute($atributo, $this->class);
    }

    /**
     * @dataProvider data_provider_atributos
     */
    public function test_verifica_se_classe_possui_get_e_sets_dos_atributos($atributo, $valor)
    {
        $atributo = str_replace(' ', '', ucwords(str_replace('_', ' ', $atributo)));

        $get = 'get' . $atributo;
        $set = 'set' . $atributo;

        $this->assertTrue(method_exists($this->class, $get));
        $this->assertTrue(method_exists($this->class, $set));
    }

    /**
     * @dataProvider data_provider_atributos
     */
    public function test_verifica_interface_fluente_nos_metodos_sets($atributo, $valor)
    {
        $atributo = str_replace(' ', '', ucwords(str_replace('_', ' ', $atributo)));

        $set = 'set' . $atributo;

        $user = new $this->class;
        $result = $user->$set($valor);

        $this->assertInstanceOf($this->class, $result);
    }

    public function test_verifica_se_existe_metodo_ENCRIPTPASSWORD()
    {
        $user = new $this->class;

        $this->assertTrue(method_exists($this->class, 'encryptPassword'));
        $this->assertNotEmpty($user->encryptPassword('12345'));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage ID aceita apenas números inteiros
     */
    public function test_verifica_se_recebe_erro_se_id_nao_for_inteiro()
    {
        $user = new $this->class;
        $user->setId('oi');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage ID aceita apenas números maiores que zero
     */
    public function test_verifica_se_recebe_erro_se_id_for_negativo_ou_zero()
    {
        $user = new $this->class;
        $user->setId(-1);
        $user->setId(0);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage NAME aceita apenas 80 caracteres
     */
    public function test_verifica_se_recebe_erro_se_NAME_tiver_mais_de_80_caracteres()
    {
        $user = new $this->class;
        $user->setName('Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage EMAIL aceita apenas 255 caracteres
     */
    public function test_verifica_se_recebe_erro_se_EMAIL_tiver_mais_de_255_caracteres()
    {
        $user = new $this->class;
        $user->setEmail('Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage LOGIN aceita apenas 255 caracteres
     */
    public function test_verifica_se_recebe_erro_se_LOGIN_tiver_mais_de_255_caracteres()
    {
        $user = new $this->class;
        $user->setLogin('Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage PASSWORD aceita apenas 255 caracteres
     */
    public function test_verifica_se_recebe_erro_se_PASSWORD_tiver_mais_de_255_caracteres()
    {
        $user = new $this->class;
        $user->setPassword('Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage REGISTRY aceita apenas DATETIME
     */
    public function test_verifica_se_recebe_erro_se_REGISTRY_nao_for_datetime()
    {
        $user = new $this->class;
        $user->setRegistry('oi');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage AVATAR aceita apenas 255 caracteres
     */
    public function test_verifica_se_recebe_erro_se_AVATAR_tiver_mais_de_255_caracteres()
    {
        $user = new $this->class;
        $user->setAvatar('Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage ACTIVE aceita apenas booleanos
     */
    public function test_verifica_se_recebe_erro_se_ACTIVE_nao_for_boolean()
    {
        $user = new $this->class;
        $user->setActive('oi');
        $user->setActive(1);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage SALT aceita apenas 255 caracteres
     */
    public function test_verifica_se_recebe_erro_se_SALT_tiver_mais_de_255_caracteres()
    {
        $user = new $this->class;
        $user->setSalt('Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage ACTIVEKEY aceita apenas 255 caracteres
     */
    public function test_verifica_se_recebe_erro_se_ACTIVEKEY_tiver_mais_de_255_caracteres()
    {
        $user = new $this->class;
        $user->setActiveKey('Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.');
    }

    public function test_verifica_se_SALT_e_ACTIVEKEY_estao_sendo_inicializados()
    {
        $user = new $this->class;

        $this->assertNotEmpty($user->getSalt());
        $this->assertNotEmpty($user->getActiveKey());
    }

    public function test_verifica_hydrator_no_construtor()
    {
        $array = array(
            'id' => 1,
            'name' => 'teste',
            'email' => 'teste@teste.com',
            'login' => 'teste',
            'password' => '12345',
            'registry' => new \DateTime("now"),
            'avatar' => 'avatar.jpg',
            'active' => false,
            'salt' => 'kmjuiyy4uy32i4g5',
            'active_key' => 'poqoweur98745asdf',
            'type_user' => new TypeUser()
        );

        $user = new $this->class($array);

        foreach ($user->toArray() as $value) {
            $this->assertNotNull($value);
        }
    }

    public function test_verifica_metodo_toArray()
    {
        $user = new $this->class;
        $user->setId(1)
            ->setName('teste')
            ->setEmail('teste@teste.com')
            ->setLogin('teste')
            ->setPassword('12345')
            ->setRegistry(new \DateTime('now'))
            ->setAvatar('avatar.jpg')
            ->setSalt('kmjuiyy4uy32i4g5')
            ->setActive(false)
            ->setActiveKey('poqoweur98745asdf')
            ->setTypeUser(new TypeUser());

        $result = $user->toArray();

        $array = array(
            'id' => 1,
            'name' => 'teste',
            'email' => 'teste@teste.com',
            'login' => 'teste',
            'password' => $user->getPassword(),
            'registry' => new \DateTime("now"),
            'avatar' => 'avatar.jpg',
            'active' => false,
            'salt' => 'kmjuiyy4uy32i4g5',
            'active_key' => 'poqoweur98745asdf',
            'type_user' => new TypeUser()
        );

        $this->assertEquals($result, $array);
    }
} 