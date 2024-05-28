# FIAP - TECH CHALLENGE - SOFTWARE ARCHITECTURE

## INTEGRANTES - GRUPO 47

- RM354121 - Lucas 
- RM354259 - Thiago
- RM353824 - Raphael
- RM355935 - Lucas
- RM354852 - Mauro

## Documentação DDD - Domain Driven Design

Link para a documentação do DDD no site do Miro:

[https://miro.com/app/board/uXjVKQcty_w=/](https://miro.com/app/board/uXjVKQcty_w=/)

Documentação do sistema (DDD) com Event Storming, incluindo todos os passos/tipos de diagrama mostrados na aula 6 do
módulo de DDD, e utilizando a linguagem ubíqua, dos seguintes fluxos:

 - Realização do pedido e pagamento; 
 - Preparação e entrega do pedido.


## Passo a passo para inicialização da aplicação

1. Clone o repositório
2. Acesse a pasta do projeto
3. Para subir os containers:  
   `docker-compose up -d`
4. Acesse o container da aplicação com o comando  
   `docker exec -it fiap-tech-challenge-app bash`
5. Para instalar as dependências do projeto, execute o comando  
   `composer install`
6. Copie o arquivo `.env.example` para `.env` e configure o banco de dados
7. Crie uma chave para a aplicação com o comando  
   `php artisan key:generate`
8. Para criar as tabelas no banco de dados, execute o comando  
   `php artisan migrate`
7. Para popular o banco de dados, execute o comando  
   `php artisan db:seed`
8. Acesse a aplicação com o endereço  
   [http://localhost:8000](http://localhost:8000)
9. Acesse o Swagger com o endereço  
   [http://localhost:8000/api/documentation](http://localhost:8000/api/documentation)

## Para remover a aplicação

1. Execute o comando  
   `docker-compose down`
2. Exclua a pasta do mysql dentro de ./docker/database/volumes/mysql (recomendado).  
   `rm -Rf ./docker/database/volumes/mysql`
3. 
