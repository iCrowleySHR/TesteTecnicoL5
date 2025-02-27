# Projeto de API RESTful (Teste Técnico L5 Network)

Este projeto é uma API RESTful que gerencia clientes, produtos e pedidos. Ela foi desenvolvida usando Code Igniter 4 e utiliza o **Insomnia** para simular requisições HTTP (onde o arquivo pode ser encontrado na raiz do projeto). Abaixo estão as instruções para configurar e utilizar a API.


## 🌐 Visão Geral

A API permite a criação, leitura, atualização e exclusão (CRUD) de clientes, produtos e pedidos. Todas as rotas exigem autenticação via token JWT, exceto a rota de autenticação (`/client/auth`) e (`/client/create`). 
O sistema conta também com validação de CPF e Email e em todos os campos, com uso de Validation em arquivos separados e nas Models. Havendo tratamento de erros em todas as rotas, sendo informado no JSON e no status da requisição

---

## 🚀 Rotas da API

### Clientes

- **Criar Cliente**: `POST /client/create`
  - Cria um novo cliente com nome, CPF, e-mail e senha.
 
Exemplo de envio :
```
{
	"name": "Gustavo Gualda",
	"cpf": 22474347038,
	"email": "gustavogualda@gmail.com",
	"password": "1234526"
}
```

Exemplo de resposta:
```
{
	"cabecalho": {
		"status": 201,
		"mensagem": "Cliente cadastrado com sucesso."
	},
	"retorno": {
		"id": "5",
		"cpf": "22474347038",
		"name": "Gustavo Gualda",
		"email": "gustavogualda@gmail.com",
		"created_at": "2025-02-27 18:52:22",
		"updated_at": "2025-02-27 18:52:22"
	}
}
```

- **Autenticar Cliente**: `POST /client/auth`
  - Autentica o cliente e retorna um token JWT para uso nas demais rotas.
  
Exemplo de envio:
```
{
	"email": "gustavogualda@gmail.com",
	"password": "1234526"
}
```

Exemplo de resposta:
```
{
	"cabecalho": {
		"status": 201,
		"mensagem": "Cliente autenticado com sucesso."
	},
	"retorno": {
		"token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjUiLCJjcGYiOiIyMjQ3NDM0NzAzOCIsIm5hbWUiOiJHdXN0YXZvIEd1YWxkYSIsImVtYWlsIjoiZ3VzdGF2b2d1YWxkYUBnbWFpbC5jb20iLCJjcmVhdGVkX2F0IjoiMjAyNS0wMi0yNyAxODo1MjoyMiIsInVwZGF0ZWRfYXQiOiIyMDI1LTAyLTI3IDE4OjUyOjIyIiwiZXhwIjoxNzcyMjE4MzYyfQ.kTZ04yMfgeu4Chv9pUyNEIXmRkJScFYxY7iwr9xnhfw"
	}
}
```
  
- **Mostrar Dados do Cliente**: `GET /client/show`
  - Retorna os dados do cliente autenticado.
Exemplo de resposta:
```
{
	"cabecalho": {
		"status": 200,
		"mensagem": "Dados do cliente retornados com sucesso."
	},
	"retorno": {
		"id": "2",
		"cpf": "16815031829",
		"name": "Gustavo Gualda",
		"email": "gustavogualda10@gmail.com",
		"created_at": "2025-02-27 16:43:08",
		"updated_at": "2025-02-27 18:22:28"
	}
}
```
  
- **Atualizar Dados do Cliente**: `PUT /client/update`
  - Atualiza os dados do cliente (ex.: e-mail). Sendo necessário o dado que vai atualizar no JSON, sendo o: e-mail, senha e name
Exemplo de envio:
```
{
	"email": "gustavogualda10@gmail.com"
}
```
Exemplo de resposta:
```
{
	"cabecalho": {
		"status": 200,
		"mensagem": "Cliente atualizado com sucesso."
	},
	"retorno": {
		"id": "2",
		"cpf": "16815031829",
		"name": "Gustavo Gualda",
		"email": "gustavogualda10@gmail.com",
		"created_at": "2025-02-27 16:43:08",
		"updated_at": "2025-02-27 18:22:28"
	}
}
```
  
- **Excluir Conta do Cliente**: `DELETE /client/delete`
  - Exclui a conta do cliente autenticado.
 ```
{
	"cabecalho": {
		"status": 200,
		"mensagem": "Cliente deletado com sucesso."
	},
	"retorno": []
}
```

### Produtos

- **Criar Produto**: `POST /product/create`
  - Cria um novo produto com nome, preço e descrição.
  
Exemplo de envio:
```
{
    "name": "Produto XYZ",
    "price": 19.99,
    "description": "ABCDEFGHIJ"
}
```
Exemplo de resposta:
```
{
	"cabecalho": {
		"status": 201,
		"mensagem": "Produto cadastrado com sucesso."
	},
	"retorno": {
		"id": "11",
		"client_id_creator": "2",
		"price": "19.99",
		"name": "Produto XYZ",
		"description": "ABCDEFGHIJ",
		"created_at": "2025-02-27 17:29:02",
		"updated_at": "2025-02-27 17:29:02"
	}
}
```
  
- **Mostrar Produtos**: `GET /product/show`
  - Retorna uma lista de todos os produtos. (Podendo ver todos os produtos cadastrados)
    
Exemplo de resposta
```
{
	"cabecalho": {
		"status": 200,
		"mensagem": "Produtos retornados com sucesso."
	},
	"retorno": [
		{
			"id": "1",
			"client_id_creator": "2",
			"price": "19.99",
			"name": "Produto XYZ",
			"description": "ABCDEFGHIJ",
			"created_at": "2025-02-27 17:04:59",
			"updated_at": "2025-02-27 17:04:59"
		},
		{
			"id": "2",
			"client_id_creator": "2",
			"price": "19.99",
			"name": "Produto XYZ",
			"description": "ABCDEFGHIJ",
			"created_at": "2025-02-27 17:05:00",
			"updated_at": "2025-02-27 17:05:00"
		},
		{
			"id": "10",
			"client_id_creator": "2",
			"price": "19.99",
			"name": "Produto XYZ",
			"description": "ABCDEFGHIJ",
			"created_at": "2025-02-27 17:28:08",
			"updated_at": "2025-02-27 17:28:08"
		}
	]
}
```
  
- **Mostrar Produto por ID**: `GET /product/show/{id}`
  - Retorna os detalhes de um produto específico. 
    
Exemplo de resposta:
```
{
	"cabecalho": {
		"status": 200,
		"mensagem": "Produto retornado com sucesso."
	},
	"retorno": {
		"id": "10",
		"client_id_creator": "2",
		"price": "19.99",
		"name": "Produto XYZ",
		"description": "ABCDEFGHIJ",
		"created_at": "2025-02-27 17:28:08",
		"updated_at": "2025-02-27 17:28:08"
	}
}
```
  
- **Atualizar Produto**: `PUT /product/update/{id}`
  - Atualiza os dados de um produto existente. Sendo necessário apenas o campo que ira atualizar, sendo: name, price e description. (Podendo atualizar apenas o produto que você mesmo criou).
  - 
Exemplo de envio:
```
{
    "name": "Produto XYZ",
    "price": 195.99,
    "description": "ABCDEFGHIJ"
}
```
Exemplo de resposta:
```
{
	"cabecalho": {
		"status": 200,
		"mensagem": "Produto atualizado com sucesso."
	},
	"retorno": {
		"id": "12",
		"client_id_creator": "5",
		"price": "195.99",
		"name": "Produto XYZ",
		"description": "ABCDEFGHIJ",
		"created_at": "2025-02-27 19:34:13",
		"updated_at": "2025-02-27 19:34:18"
	}
}
```
  
- **Excluir Produto**: `DELETE /product/delete/{id}`
  - Exclui um produto específico. (Podendo excluir apenas produtos que você mesmo criou).
    
Exemplo de resposta:
```
{
	"cabecalho": {
		"status": 200,
		"mensagem": "Produto deletado com sucesso."
	},
	"retorno": []
}
```

### Pedidos

- **Criar Pedido**: `POST /order/create`
  - Cria um novo pedido com ID do produto, quantidade e status.
  
- **Mostrar Pedidos**: `GET /order/show`
  - Retorna uma lista de todos os pedidos.
  
- **Mostrar Pedido por ID**: `GET /order/show/{id}`
  - Retorna os detalhes de um pedido específico.
  
- **Atualizar Pedido**: `PUT /order/update/{id}`
  - Atualiza o status de um pedido existente.
  
- **Excluir Pedido**: `DELETE /order/delete/{id}`
  - Exclui um pedido específico. (Podendo excluir apenas pedidos que você mesmo criou).

---
