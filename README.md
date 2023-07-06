# Desafio BackEnd Frete Rápido  
Consiste no desenvolvimento de uma API com dois endpoins sendo uma para a relização de cotações de frete a partir de um objeto JSON e um para a coleta de métricas através de um parametro indicando a quantidade de registros a serem cotados. 

## Tecnologias  

 - PHP 8
 - Laravel 10
 - Docker
 - Banco de dados MYSQL
 - NGINX

## Instruções
Ao clonar este repositório acessar a pasta laradock e executar o seguinte comando:

>  docker-compose up -d nginx php-fpm mysql

Após subir a conclusão da criação dos containers utilizar o seguinte comando:

> docker-compose exec workspace bash  

Já estando dentro do container seguir com a instalação das dependências através do composer a partir do comando:

> composer install
  
  ## Endpoints
Concluída a instalação a aplicação ficará disponível na seguinte url : http://localhost

**Rota 1: POST - {url}/quote**

Objeto a ser enviado:

```json
{
   "recipient":{
      "address":{
         "zipcode":"01311000"
      }
   },
   "volumes":[
      {
	         "category":7,
	         "amount":1,
	         "unitary_weight":5,
	         "price":349,
	         "sku":"abc-teste-123",
	         "height":0.2,
	         "width":0.2,
	         "length":0.2
      },
      {
	         "category":7,
	         "amount":2,
	         "unitary_weight":4,
	         "price":556,
	         "sku":"abc-teste-527",
	         "height":0.4,
	         "width":0.6,
	         "length":0.15
      }
   ]
}
```
