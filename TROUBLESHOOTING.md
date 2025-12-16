# Troubleshooting - Busca não funciona

## Problema: A busca não retorna resultados

### Verificações necessárias:

#### 1. Plugin JCE Links Dynamic está habilitado?
- Vá para **Extensões → Plugins**
- Procure por **JCE - Links Dynamic**
- Certifique-se de que está **Habilitado** (status verde)

#### 2. Plugin JCE Links Dynamic está configurado?
- Abra o plugin **JCE - Links Dynamic**
- Verifique se há **pelo menos uma configuração** na seção "Link Configurations"
- Cada configuração deve ter:
  - **Label**: Nome da área de busca (ex: "Advogados", "Artigos")
  - **Component**: Nome do componente (ex: "com_advogados", "com_content")
  - **Table**: Nome da tabela no banco (ex: "advogados", "content")
  - **ID Field**: Campo de ID (geralmente "id")
  - **Title Field**: Campo de título (ex: "title", "nome")

#### 3. Plugin Search Dynamic está habilitado?
- Vá para **Extensões → Plugins**
- Procure por **Search - Dynamic**
- Certifique-se de que está **Habilitado** (status verde)

#### 4. Módulo de Busca está publicado?
- Vá para **Conteúdo → Módulos do Site**
- Procure pelo módulo **Smart Search** ou **Search**
- Certifique-se de que está **Publicado**

#### 5. Teste a busca:

1. **Verifique as áreas de busca disponíveis:**
   - Acesse o formulário de busca do site
   - Clique em "Busca Avançada" ou similar
   - Verifique se aparecem as áreas configuradas (ex: "Advogados")

2. **Faça uma busca de teste:**
   - Digite um termo que você sabe que existe na tabela
   - Selecione a área específica
   - Clique em "Buscar"

### Comandos SQL para debug:

```sql
-- Verificar se o plugin JCE está habilitado
SELECT * FROM #__extensions 
WHERE element = 'links_dynamic' AND folder = 'jce' AND enabled = 1;

-- Verificar se o plugin Search está habilitado
SELECT * FROM #__extensions 
WHERE element = 'dynamic' AND folder = 'search' AND enabled = 1;

-- Verificar configurações do plugin JCE
SELECT params FROM #__extensions 
WHERE element = 'links_dynamic' AND folder = 'jce';
```

### Logs de erro:

Verifique os logs do Joomla em:
- **Sistema → Manutenção → Logs de Depuração**
- Procure por erros relacionados a "PlgSearchDynamic" ou "WFLinkBrowser_dynamic"

### Problemas comuns:

#### A área de busca não aparece:
- O plugin JCE Links Dynamic não está habilitado
- O plugin JCE Links Dynamic não tem configurações
- O plugin Search Dynamic não está habilitado

#### A busca não retorna resultados:
- A tabela especificada não existe
- O campo de título não existe na tabela
- O estado (state_field) está filtrado incorretamente
- Não há registros que correspondam ao termo buscado

#### Erro SQL:
- Verifique se todos os campos configurados existem na tabela
- Verifique se o nome da tabela está correto
- Verifique se há prefixo na tabela (#__ será substituído automaticamente)

### Exemplo de configuração funcional:

```
Label: Advogados
Component: com_advogados
Table: advogados (ou #__advogados)
ID Field: id
Title Field: nome
Display Fields: oab, cidade (opcional - separados por vírgula)
State Field: published (opcional)
State Value: 1 (opcional)
Order Field: nome (opcional)
Order Direction: ASC (opcional)
View Name: advogado
ID Parameter: id
```

### Ainda não funciona?

1. **Desabilite e habilite novamente ambos os plugins**
2. **Limpe o cache do Joomla** (Sistema → Limpar Cache)
3. **Verifique os logs de erro** do PHP e do Joomla
4. **Teste com o Joomla em modo debug** (Sistema → Configuração Global → Sistema → Debug)
