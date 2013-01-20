ListService - Sistema de Help Desk
==================================
----------------------------------

Introdução
----------
A criação de um sistema, hoje, pode ser considerada fácil, se for avaliado a questão das ferramentas de desenvolvimento disponíveis no mercado. Todavia ocorre uma grande diferença nos aspectos de se fazer um sistema realizado de qualquer maneira e um feito através de regras e normas apresentadas pela engenharia de software, por mais que a empresa seja de pequeno porte, quando um sistema é realizado de forma consistente e com documentação seguindo à risca os padrões, conceitos e normas, os resultados alcançados são positivos e gratificantes. 

Motivação
---------
A motivação do grupo em realizar o estágio e desenvolver um projeto, foi aceito como um desafio, devido à complexidade de tal sistema, e um desafio maior ainda, que é por em prática o que foi aprendido, e principalmente os benefícios que um sistema desenvolvido corretamente, sob a orientação do professor de estágio supervisionado, pode proporcionar.

O sistema não é de grandes proporções, por se tratar de uma empresa de pequeno porte, torna-se ainda mais gratificante poder verificar os resultados alcançados e acompanhar passo a passo o crescimento da empresa após a implantação do sistema.

Instalação do Sistema
---------------------
Para instalar é bastante simples, no Terminal digite o seguinte comando:

    git clone https://github.com/janainapaixao/sortear.git

Após ter feito uma copia do projeto, navegue até a pasta do mesmo, onde na 
qual terá um arquivo composer.phar, este arquivo é responsável por baixar 
todas as dependências necessários para o seu funcionamento.

Novamente no terminal digite:
    
    php composer.phar self-update
    php composer.phar install

O comando “php composer.phar self-update” é para atualizar o próprio arquivo
composer.phar, já o comando “php composer.phar install” é para instalar as dependências.

OBS.
----

Caso ocorra um erro de TimeOut execute este comando:

    COMPOSER_PROCESS_TIMEOUT=9000 php composer.phar install

O comando “COMPOSER_PROCESS_TIMEOUT=9000” como o próprio nome já diz é para definir o
tempo limite de execução do arquivo  composer.phar
