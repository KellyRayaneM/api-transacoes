****# Docker

## Sobre o Docker

Caso você não conheça o Docker, na Wiki desse repositório existe uma página que indica artigos para você instalar e entender como funciona o Docker.

## Containers
- apache
- mysql
- php-fpm (com xdebug)
- phpmyadmin (opcional)

## Configurações

O arquivo `.env` possui as configurações gerais que serão usadas na instalação do ambiente. É indicado que o Docker user seja o mesmo que o seu usuário local para evitar erros de permissão, para isso coloque o id do seu usuário local em `USER_ID` (execute `id -u` para encontrá-lo) e o id do seu grupo em `GROUP_ID` (execute `id -g` para encontrá-lo).

Caso queria alterar a versão do PHP (default=7.4), mudar o valor de `PHP_VERSION`.

Outra informação que você pode encontrar no `.env` é o caminho de sua aplicação. Por default basta colocar a sua aplicação na mesma pasta raiz que este ambiente, mas caso você queira utilizar de forma diferente é só mudar o valor de `PATH_APPLICATION`.

Já o apache está configurado para que a aplicação possa ser acessada em `nome.localhost`. Para alterar esse nome basta ir em `apache/demo.apache.conf` e mudar somente o `ServerName`.

## Instalação

Para instalar todos containers basta fazer `docker-compose up -d --build` nesta pasta raiz. Já se não quiser instalar o phpmyadmin faça `docker-compose up -d --build apache mysql`.


## Utilizando o Docker

Use `docker-compose up -d` (nesse ambiente) para iniciar todos os containers quando sua máquina for iniciada, caso você não tenha instalado o phpmyadmin faça `docker-compose up -d apache mysql`.

O host do DB da aplicação é o nome do container mysql, dado pela variável `MYSQL_NAME` no `.env`, e não localhost.

A pasta `mysql/data` é compartilhada com a pasta de dados do seu banco mysql, você pode usá-la para importar ou exportar dados. Além disso caso você precise recriar o seu container mysql, todos os dados existentes no antigo container persistem para o novo a partir dessa pasta.

Para instalar uma nova extensão PHP, você precisa escrever essa instalação `php/Dockerfile` e construir o container novamente. Em https://github.com/mlocati/docker-php-extension-installer, você acha alguns scripts para facilitar essa instalação. 

Caso você precise adicionar alguma coisa no `php.ini`, basta colocar em `php/conf/custom.ini` e reinicia os containers. 

Para mais informações sobre o Docker, consulte a Wiki desse repositório.