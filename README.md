# Projeto de API RESTful (Teste Técnico L5 Network)

Este projeto é uma API RESTful que gerencia clientes, produtos e pedidos. Ele foi desenvolvido para ser testado localmente e utiliza o **Insomnia** para simular requisições HTTP. Abaixo estão as instruções para configurar e utilizar a API.

## 📋 Tabela de Conteúdos

- [Visão Geral](#-visão-geral)
- [Rotas da API](#-rotas-da-api)
  - [Clientes](#clientes)
  - [Produtos](#produtos)
  - [Pedidos](#pedidos)
- [Configuração do Ambiente](#-configuração-do-ambiente)
- [Autenticação](#-autenticação)
- [Como Testar com o Insomnia](#-como-testar-com-o-insomnia)
- [Exemplos de Requisições](#-exemplos-de-requisições)

---

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
  
- **Mostrar Produtos**: `GET /product/show`
  - Retorna uma lista de todos os produtos.
  
- **Mostrar Produto por ID**: `GET /product/show/{id}`
  - Retorna os detalhes de um produto específico.
  
- **Atualizar Produto**: `PUT /product/update/{id}`
  - Atualiza os dados de um produto existente.
  
- **Excluir Produto**: `DELETE /product/delete/{id}`
  - Exclui um produto específico.

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
  - Exclui um pedido específico.

---
