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

### Se tiver o Make instalado

Use os commandos: 

    `make start`

Para fazer a limpeza da aplicação, use o comando:

    `make clean`


### Se não tiver o Make instalado

1. Clone o repositório  
   `git clone https://github.com/LucasGarbuyo/fiap-tech-challenge.git`

2. Acesse a pasta do projeto com o terminal 

3. Copie o arquivo `.env.example` para `.env`    
   `cp .env.example .env`

4. Iniciando os containers do Docker.  
   Esse processo pode demorar um pouco na primeira vez que for executado, pois o docker irá baixar as imagens necessárias para a execução dos containers.  
   Execute o comando:    
   `docker-compose up -d`

5. Acesse o container da aplicação com o comando:  
   `docker exec -it fiap-tech-challenge-php-1 bash`

6. Para instalar as dependências do projeto, execute o comando dentro do container:  
   `composer install`

7. Crie uma chave para a aplicação com o comando:  
   `php artisan key:generate`

8. Para criar as tabelas no banco de dados, execute o comando:  
   `php artisan migrate:fresh`

9. Para popular o banco de dados, execute o comando:  
   `php artisan db:seed`

10. Acesse a aplicação com o endereço  
    [http://localhost:8000](http://localhost:8000)

11. Acesse o Swagger com o endereço  
    [http://localhost:8000/api/documentation](http://localhost:8000/api/documentation)

## Para remover a aplicação

### Se tiver o Make instalado, use o comando:

    `make clean`

### Se não tiver o Make instalado, siga os passos abaixo:

1. Execute o comando  
   `docker-compose down`
2. **(Recomendado)** excluir a pasta do mysql dentro de ./docker/database/volumes/mysql. Vai poupar espaço.  
   `rm -Rf ./docker/database/volumes/mysql`


## Kubernetes

### Requisitos
1. Docker 
2. Minikube

### Passo a passo para inicialização da aplicação

1. Inicie o Minikube 
   `minikube start`
2. Habilite o addon de Ingress no Minikube 
   `minikube addons enable ingress`
3. Habilite o addon de Metrics no Minikube 
   `minikube addons enable metrics-server`
4. Aplique os arquivos de deploy do Kubernetes
   `make kubectl-deploy-apply`
5. Para ver o endereço da aplicação, obtenha o IP do Minikube 
   `minikube ip`      
6. Para ver o endereço da aplicação, obtenha o IP do Minikube 
   `minikube dashboard`      

### Passo a passo para remover da aplicação

1. Remover os arquivos de deploy do Kubernetes
   `make kubectl-deploy-delete`
2. Pare o minikube
   `minikube stop`
3. Delete o minikube
   `minikube delete`