# Desafio BackEnd Frete Rápido  
Consiste no desenvolvimento de uma API com dois endpoins sendo uma para a relização de cotações de frete a partir de um objeto JSON e um para a coleta de métricas através de um parametro indicando a quantidade de registros a serem cotados. 

## Tecnologias  

 - PHP 8  
 - Laravel 10  
 - Docker - Laradock  
 - Banco de dados MYSQL  
 - NGINX  

 **Observações: ** Link da documentação do Laradock : [Acessar](https://laradock.io/getting-started/)

## Instruções
Ao clonar este repositório acessar a pasta laradock e executar o seguinte comando:

>  docker-compose up -d nginx php-fpm mysql

Após a conclusão da criação dos containers utilizar o seguinte comando:

> docker-compose exec workspace bash  

Já estando dentro do container seguir os passos abaixo:

> cp .env.example .env  
> composer install  
> php artisan key:generate  
> php artisan migrate:install  
> php artisan migrate  
  
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
Resultado esperado:  
```json  
{
   "carrier":[
      {
         "name":"EXPRESSO FR",
         "service":"Rodoviário",
         "deadline":"3",
         "price":17
      },
      {
         "name":"Correios",
         "service":"SEDEX",
         "deadline":1,
         "price":20.99
      }
   ]
}
``` 

**Rota 2: GET - .../metrics?last_quotes={?}**  
Esta rota consulta os registros cadastrados no banco de dados onde o parametro "last_quotes" define o número de cotações em ordem decrescente. 
Neste endpoint será mostrado uma listagem com as seguintes informações:

- Quantidade de resultados por transportadora;
- Total de “preco_frete” por transportadora; (final_price na API)
- Média de “preco_frete” por transportadora; (final_price na API)
- O frete mais barato geral;
- O frete mais caro geral;

Retorno esperado:  
```json  
[
	{
		"carrier_name": "CORREIOS",
		"quantity_results": 6,
		"total_price_shipping": "666.32",
		"average_shipping_price": "111.053333",
		"general_cheapest_shipping": "78.03",
		"most_expensive_shipping_overall": "162.68"
	},
    {....}, 
    {....}
]
```


