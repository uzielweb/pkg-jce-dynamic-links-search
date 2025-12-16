# JCE Links Dinâmicos - Plugin para Joomla

[![Joomla](https://img.shields.io/badge/Joomla-4.x%20%7C%205.x%20%7C%206.x-blue.svg)](https://www.joomla.org)
[![License](https://img.shields.io/badge/license-GPL--2.0-green.svg)](LICENSE)
[![Version](https://img.shields.io/badge/version-1.0.0-orange.svg)](https://github.com/uzielweb/plg_jce_links_dynamic/releases)

Plugin Joomla que permite criar links dinâmicos de **qualquer extensão e tabela do banco de dados** no Navegador de Links do JCE, com configuração totalmente flexível de campos e exibição.

## 🚀 Características

- ✅ **Configuração Dinâmica**: Crie links para qualquer tabela do banco de dados
- ✅ **Múltiplas Configurações**: Configure quantas categorias de links você precisar
- ✅ **Campos Personalizáveis**: Escolha livremente os campos de ID, título e exibição
- ✅ **Campos Adicionais**: Mostre informações extras (idioma, categoria, etc.) entre parênteses
- ✅ **Filtros de Estado**: Filtre por estado de publicação com campo e valor personalizados
- ✅ **Busca Inteligente**: Pesquise pelo título e campos adicionais
- ✅ **URLs Configuráveis**: Personalize componente, view e parâmetros da URL
- ✅ **Multilíngue**: Suporte para Português (pt-BR) e Inglês (en-GB)
- ✅ **Atualizações Automáticas**: Servidor de atualização integrado

## 📋 Requisitos

- Joomla 4.x, 5.x ou 6.x
- PHP 7.4 ou superior
- Editor JCE instalado e ativado

## 📦 Instalação

1. Baixe o arquivo ZIP da [última versão](https://github.com/uzielweb/plg_jce_links_dynamic/releases)
2. No painel administrativo do Joomla, vá em **Sistema → Extensões → Instalar**
3. Faça upload do arquivo ZIP
4. Após a instalação, vá em **Sistema → Plugins**
5. Localize "JCE Links Dinâmicos" e ative o plugin
6. Clique no nome do plugin para configurar

## ⚙️ Configuração

### Exemplo 1: Links para Artigos do com_content

```
Rótulo da Categoria: Artigos
Nome do Componente: com_content
Tabela do Banco: content
Campo ID: id
Campo Título: title
Campos Adicionais: language, catid
Campo de Estado: state
Valor do Estado: 1
Campo de Ordenação: title
Direção da Ordenação: ASC
Nome da View: article
Parâmetro do ID: id
```

### Exemplo 2: Links para Produtos Personalizados

```
Rótulo da Categoria: Produtos
Nome do Componente: com_produtos
Tabela do Banco: produtos
Campo ID: id
Campo Título: nome
Campos Adicionais: categoria, preco
Campo de Estado: published
Valor do Estado: 1
Campo de Ordenação: nome
Direção da Ordenação: ASC
Nome da View: produto
Parâmetro do ID: id
```

### Exemplo 3: Links para Advogados

```
Rótulo da Categoria: Advogados
Nome do Componente: com_advogados
Tabela do Banco: advogados
Campo ID: id
Campo Título: nome
Campos Adicionais: linguagem
Campo de Estado: state
Valor do Estado: 1
Campo de Ordenação: nome
Direção da Ordenação: ASC
Nome da View: advogado
Parâmetro do ID: id
```

## 📖 Como Usar

1. No editor JCE, clique no botão "Link"
2. Na janela do navegador de links, você verá suas categorias configuradas
3. Clique na categoria desejada para listar os itens
4. Use o campo de busca para filtrar itens
5. Clique no item desejado para inserir o link

## 🔧 Campos de Configuração

| Campo | Descrição | Exemplo |
|-------|-----------|---------|
| **Rótulo da Categoria** | Nome exibido no JCE | "Artigos", "Produtos" |
| **Nome do Componente** | Componente Joomla | com_content, com_produtos |
| **Tabela do Banco** | Tabela sem prefixo #__ | content, produtos |
| **Campo ID** | Coluna do identificador único | id |
| **Campo Título** | Coluna do título de exibição | title, nome, name |
| **Campos Adicionais** | Campos extras (separados por vírgula) | language, catid |
| **Campo de Estado** | Coluna de publicação | state, published |
| **Valor do Estado** | Valor para item publicado | 1 |
| **Campo de Ordenação** | Coluna para ordenar | title, ordering |
| **Direção da Ordenação** | ASC ou DESC | ASC |
| **Nome da View** | View do componente | article, produto |
| **Parâmetro do ID** | Parâmetro da URL | id, a_id |

## 🎯 Casos de Uso

Este plugin é perfeito para:

- Sites com múltiplas extensões personalizadas
- Criação de links para componentes de terceiros
- Gerenciamento de links para tabelas customizadas
- Sites multilíngues com necessidade de exibir idioma
- E-commerce com produtos categorizados
- Portais com diversos tipos de conteúdo

## 🐛 Suporte

Se você encontrar algum problema ou tiver sugestões:

1. Verifique as [issues existentes](https://github.com/uzielweb/plg_jce_links_dynamic/issues)
2. Se não encontrar, [crie uma nova issue](https://github.com/uzielweb/plg_jce_links_dynamic/issues/new)

## 📝 Changelog

Veja [CHANGELOG.md](CHANGELOG.md) para histórico de versões.

## 👨‍💻 Autor

**Ponto Mega**
- GitHub: [@uzielweb](https://github.com/uzielweb)

## 📄 Licença

Este projeto está licenciado sob a GNU/GPL v2.0 - veja o arquivo [LICENSE](LICENSE) para detalhes.

## 🙏 Agradecimentos

- Baseado no plugin JCE Links Advogados
- Comunidade Joomla
- Equipe do JCE Editor

---

⭐ Se este plugin foi útil para você, considere dar uma estrela no repositório!
