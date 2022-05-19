# Informações gerais sobre o projeto

A requisição inicial a ser realizada seria um cadastro de usuário ao criar um usuário
é criada uma carteira com saldo 0.0. 

Após a criação do usuario é possível adicionar saldo na carteira por meio de deposito para fazer tranferências.

As requisições são feitas via postman.

#### Ferramentas utilizadas no projeto

- [X] PHP 8
- [X] Laravel 8
- [X] Mysql
- [X] Arquitetura MVC
- [X] Docker


## Pré-requisitos
- Ter o docker-composer instalado
- Ter uma ferramenta que faça requisições a API Ex: Postman 

**Rotas para Usuario**
|Métodos| Parâmetros | Descrição |
|---|---|---|
|`GET`| `/api/users` | Retorna um JSON com todos os usuário. |
|`GET`| `/api/user/{id}` | Retorna o usurário usando id do usuario. |
|`GET`| `/api/user/{email}` | Retorna o usurário usando email do usuario. |
|`GET`| `/api/user/{document}` | Retorna o usurário usando cpf ou cnpj do usuario. |
|`POST`| `/api/user` | Efetua o cadastro de um usuário. |
|`PUT`| `/api/user/update/{id}` | Atualiza o usurário usando id do usuario. |
|`DELETE`| `/api/user/delete/{id}` | Deleta o usurário usando id do usuario. |

### Criar [POST][/api/user]

+ Atributos
 
  -campos obrigatórios

    + name: nome do usuário
    + email: e-mail do usuário 
    + type_document: informa se o documento é cpf ou npj 
    + document: cpf ou cnpj do usuário 
    + password: password do usuário 
    + type_user: define se é usuario comum ou lojista

+ Request (application/json)

    + Headers

          Content-Type: application/json

    + Body

          {
                "name": "nome",
                "email": "email@email.com",
                "type_document": "cpf or cnpj",
                "document": "000000000",
                "password": "XXXXXXX",
                "type_user" : "sales ou common"
          }


### Atualizar [PUT][/api/user/{id}]

+ Atributos

    + id: ID do usuário deve ser informado no link
    + nome: nome do usuário 
    + email: e-mail do usuário 
    + document: cpf ou cnpj do usuário 
    + password: senha atual 
    + type_document: informa se o documento é cpf ou npj
    + type_user: define se é usuario comum ou lojista


+ Request (application/json)

    + Headers

          Content-Type: application/json

    + Body

          {
              "name": "nome",
              "email": "email@email.com",
              "type_document": "cpf or cnpj",
              "document": "000000000",
              "password": XXXXXXX,
              "type_user" : "sales ou common"
             
          }


**Rotas para Conta**
|Métodos| Parâmetros | Descrição |
|---|---|---|
|`GET`| `/api/wallets` | Retorna um JSON com todas as carteiras. |
|`GET`| `/api/wallet/{id}` | Retorna a carteira baseado no id do usuario. |
|`POST`| `/api/transfer` | Efetua uma transferencia entre usuarios. |
|`POST`| `/api/deposit` | Efetua o deposito . |
|`POST`| `/api/withdraw` | Efetua o saque . |


### Transferir [POST][/api/transfer]

+ Atributos (Campos Obrigatórios)

    + id_user_out: id do usuario que irá enviar dinheiro
    + user_id_in: id do usuário que recebe o dinheiro
    + value: valor a ser enviado
    + password: senha pra validar a tranferência

+ Request (application/json)

    + Headers

          Content-Type: application/json

    + Body

          {
              "id_user_out" : 7,
              
               "id_user_in" : 5,

              "value": 10.00,

              "password": "123456"
          }


### Depositar[POST][/api/deposit]

+ Atributos (Campos Obrigatórios)

    + user_id_in: id do usuário que recebe o dinheiro
    + value: Valor a depositar 
    + password: senha pra validar a deposito

+ Request (application/json)

    + Headers

          Content-Type: application/json

    + Body

          {
              "user_id_in": 1,
             
              "password": "123456"

              "value": 10.00,
          }

### Sacar[POST][/api/withdraw]

+ Atributos (Campos Obrigatórios)

    + id_user: id do usuário que retira o dinheiro
    + value: Valor a sacar 
    + password: senha pra validar a deposito

+ Request (application/json)

    + Headers

          Content-Type: application/json

    + Body

          {
              "id_user": 1,
             
              "password": "123456"

              "value": 10.00,
          }

**Rotas para Trasações**
|Métodos| Parâmetros | Descrição |
|---|---|---|
|`GET`| `/api/transactions` | Retorna um JSON com todas as transações. |
|`GET`| `/api/transactions/{id}` | Retorna um JSON com as transações do id do usuário. |


> 
