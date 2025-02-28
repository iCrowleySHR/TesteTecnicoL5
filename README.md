# Projeto de API RESTful (Teste Técnico L5 Network)

Este projeto é uma API RESTful que gerencia clientes, produtos e pedidos. Ela foi desenvolvida usando Code Igniter 4 e utiliza o **Insomnia** para simular requisições HTTP (onde o arquivo pode ser encontrado na raiz do projeto). Abaixo estão as instruções para configurar e utilizar a API.


## 🌐 Visão Geral

A API permite a criação, leitura, atualização e exclusão (CRUD) de clientes, produtos e pedidos. Todas as rotas exigem autenticação via token JWT, exceto a rota de autenticação (`/client/auth`) e (`/client/create`). 
O sistema conta também com validação de CPF e Email e em todos os campos, com uso de Validation em arquivos separados e nas Models. Havendo tratamento de erros em todas as rotas, sendo informado no JSON e no status da requisição.

---
## 📦 Instalação

Siga os passos abaixo para configurar o projeto CodeIgniter 4.

### ⚙️ Requisitos

- **PHP >= 8.0**
- **Composer** instalado

### 🚀 Passo a Passo

1. **Instale as dependências**
   ```sh
   composer install
   ```

3. **Copie o arquivo de ambiente**
   ```sh
  	cp env.example .env
   ```

4. **Configure o ambiente**
   - Abra o arquivo `.env` e configure as variáveis conforme necessário, incluindo o banco de dados.


5. **Crie o banco de dados e aplique as migrações**
   - Criar um banco com nome `testetecnicol5`.
     
   ```sh
   php spark migrate
   ```

7. **Inicie o servidor local**
   ```sh
   php spark serve
   ```
---

## 🚀 Rotas da API

### Clientes

### **Criar Cliente**: `POST /client/create`
  - Cria um novo cliente com nome, CPF, e-mail e senha.
 
Exemplo de envio :
```
{
	"nome": "Gustavo Gualda",
	"cpf": 22474347038,
	"email": "gustavogualda@gmail.com",
	"senha": "1234526"
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
		"nome": "Gustavo Gualda",
		"email": "gustavogualda@gmail.com",
		"criado_em": "2025-02-27 18:52:22",
		"atualizado_em": "2025-02-27 18:52:22"
	}
}
```

### **Autenticar Cliente**: `POST /client/auth`
  - Autentica o cliente e retorna um token JWT para uso nas demais rotas.
  
Exemplo de envio:
```
{
	"email": "gustavogualda@gmail.com",
	"senha": "1234526"
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
  
### **Mostrar Dados do Cliente**: `GET /client/show`
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
		"cpf": "22474347038",
		"nome": "Gustavo Gualda",
		"email": "gustavogualda10@gmail.com",
		"criado_em": "2025-02-27 16:43:08",
		"atualizado_em": "2025-02-27 18:22:28"
	}
}
```
  
### **Atualizar Dados do Cliente**: `PUT /client/update`
  - Atualiza os dados do cliente (ex.: e-mail). Sendo necessário o dado que vai atualizar no JSON, não precisando ser todos, sendo o: e-mail, senha e/ou nome
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
		"cpf": "22474347038",
		"nome": "Gustavo Gualda",
		"email": "gustavogualda10@gmail.com",
		"criado_em": "2025-02-27 16:43:08",
		"atualizado_em": "2025-02-27 18:22:28"
	}
}
```
  
### **Excluir Conta do Cliente**: `DELETE /client/delete`
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
    "nome": "Produto XYZ",
    "preco": 19.99,
    "descricao": "ABCDEFGHIJ"
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
		"cliente_id_criador": "2",
		"preco": "19.99",
		"nome": "Produto XYZ",
		"descricao": "ABCDEFGHIJ",
		"criado_em": "2025-02-27 17:29:02",
		"atualizado_em": "2025-02-27 17:29:02"
	}
}
```
  
### **Mostrar Produtos**: `GET /product/show`
Retorna uma lista de todos os produtos cadastrados. Você pode filtrar os resultados passando parâmetros pela URL.

#### Parâmetros opcionais:
- `cliente_id_criador` (string) - ID do cliente criador do produto.
- `preco` (float) - Preço do produto.
- `nome` (string) - Nome do produto.
- `descricao` (string) - Descrição do produto.
- `criado_em` (string, formato: YYYY-MM-DD) - Data de criação do produto.
- `atualzado_em` (string, formato: YYYY-MM-DD) - Data de última atualização do produto.
- `pagina` (int) - Página que deseja acessar.
- `por_pagina` (int) - Quantos objetos deseja por página.

#### Exemplo da URL:
`GET /product/show?client_id_creator=123&price=49.99&name=ProdutoExemplo&created_at=2025-02-01`

Exemplo de resposta
```
{
	"cabecalho": {
		"status": 200,
		"mensagem": "Produtos retornados com sucesso."
	},
	"retorno": {
		"dados": [
			{
				"id": "1",
				"cliente_id_criador": "1",
				"preco": "19.99",
				"nome": "Produto XYZ",
				"descricao": "ABCDEFGHIJ",
				"criado_em": "2025-02-28 00:33:17",
				"atualizado_em": "2025-02-28 00:33:17"
			},
			{
				"id": "2",
				"cliente_id_criador": "1",
				"preco": "19.99",
				"nome": "Produto karla",
				"descricao": "ABCDEFGHIJ",
				"criado_em": "2025-02-28 00:40:48",
				"atualizado_em": "2025-02-28 00:40:48"
			}
		],
		"paginacao": {
			"pagina_atual": 1,
			"por_pagina": 2,
			"total": 21,
			"ultima_pagina": 11
		}
	}
}
```
  
### **Mostrar Produto por ID**: `GET /product/show/{id}`
  - Retorna os detalhes de um produto específico. 
    
Exemplo de resposta:
```
{
	"cabecalho": {
		"status": 200,
		"mensagem": "Produto retornado com sucesso."
	},
	"retorno":{
		"id": "10",
		"cliente_id_criador": "2",
		"preco": "19.99",
		"nome": "Produto XYZ",
		"descricao": "ABCDEFGHIJ",
		"criado_em": "2025-02-27 17:04:59",
		"atualizado_em": "2025-02-27 17:04:59"
		},
}
```
  
### **Atualizar Produto**: `PUT /product/update/{id}`
  - Atualiza os dados de um produto existente. Sendo necessário apenas o campo que irá atualizar, sendo: nome, preco e/ou descricao. (Podendo atualizar apenas o produto que você mesmo criou).

Exemplo de envio:
```
{
    "nome": "Produto XYZ",
    "preco": 195.99,
    "descricao": "ABCDEFGHIJ"
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
		"cliente_id_criador": "5",
		"preco": "195.99",
		"nome": "Produto XYZ",
		"descricao": "ABCDEFGHIJ",
		"criado_em": "2025-02-27 19:34:13",
		"atualizado_em": "2025-02-27 19:34:18"
	}
}
```
  
### **Excluir Produto**: `DELETE /product/delete/{id}`
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

### **Criar Pedido**: `POST /order/create`
  - Cria um novo pedido com ID do produto, quantidade e status.
Exemplo de envio:
```
{
	"product_id": "1",
	"quantity": "1",
	"status": "Em Aberto"
}
```
Exemplo de resposta:
```
{
	"cabecalho": {
		"status": 201,
		"mensagem": "Ordem cadastrada com sucesso."
	},
	"retorno": {
		"id": "19",
		"cliente_id": "1",
		"produto_id": "1",
		"quantidade": 1,
		"status": "Em Aberto",
		"criado_em": "2025-02-28 01:05:00",
		"atualizado_em": "2025-02-28 01:05:00"
	}
}
```
  
### **Mostrar Pedidos**: `GET /order/show`
Retorna uma lista de todos os pedidos cadastrados. A requisição pode ser filtrada pela URL e possui paginação.

#### Parâmetros opcionais:
- `client_id` (int) - ID do cliente que fez o pedido.
- `status` (string) - Status do pedido (ex: `pago`, `pendente`, `cancelado`).
- `created_at` (string, formato: YYYY-MM-DD) - Data de criação do pedido.
- `updated_at` (string, formato: YYYY-MM-DD) - Data de última atualização do pedido.
- `pagina` (int) - Página que deseja acessar.
- `por_pagina` (int) - Quantos objetos deseja por página.

#### Exemplo de solicitação:
`GET /order/show?status=pago&client_id=123&created_at=2025-02-01&page=2`
  
### **Mostrar Pedido por ID**: `GET /order/show/{id}`
  - Retorna os detalhes de um pedido específico.
Exemplo de resposta:
```
{
	"cabecalho": {
		"status": 200,
		"mensagem": "Ordem retornada com sucesso."
	},
	"retorno": {
		"id": "2",
		"cliente_id": "1",
		"produto_id": "1",
		"quantidade": 1,
		"status": "Em Aberto",
		"criado_em": "2025-02-28 01:04:57",
		"atualizado_em": "2025-02-28 01:04:57"
	}
}
```
### **Atualizar Pedido**: `PUT /order/update/{id}`
  - Atualiza o status de um pedido existente. (Apenas o cliente criador do pedido pode atualizar)
Exemplo de envio:
```
{
	"status": "Pago"
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
		"id": "19",
		"cliente_id": "1",
		"produto_id": "1",
		"quantidade": 1,
		"status": "Pago",
		"criado_em": "2025-02-28 01:05:00",
		"atualizado_em": "2025-02-28 01:05:10"
	}
}
```
  
### **Excluir Pedido**: `DELETE /order/delete/{id}`
  - Exclui um pedido específico. (Podendo excluir apenas pedidos que você mesmo criou).
  - Sendo necessário o dado que vai atualizar no JSON, não precisando ser todos, sendo o: quantidade e/ou status
```
{
	"cabecalho": {
		"status": 200,
		"mensagem": "Ordem deletado com sucesso."
	},
	"retorno": []
}
```
---
Criado por Gustavo Gualda para teste técnico da L5 Networks.
