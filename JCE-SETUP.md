# Como Verificar se o Plugin Aparece no JCE Editor

## Passo 1: Verificar se o Plugin JCE está Habilitado

1. Vá em **Extensões → Plugins**
2. Procure por **JCE - Links Dynamic**
3. Verifique se está **Habilitado** (verde)
4. Abra o plugin e adicione uma configuração de teste:
   - **Label**: Teste
   - **Component**: com_content
   - **Table**: content
   - **ID Field**: id
   - **Title Field**: title
   - **View Name**: article
   - **ID Parameter**: id
5. Salve

## Passo 2: Configurar o JCE para Mostrar Links Dynamic

1. Vá em **Componentes → JCE Editor → Profiles**
2. Edite o perfil que você usa (geralmente "Default")
3. Clique na aba **Plugin Parameters**
4. Procure por **Links** ou **Link Browser**
5. Nas opções de **Link Browser Sources**, certifique-se de que **Dynamic** está selecionado/habilitado

## Passo 3: Verificar no Editor

1. Vá para **Conteúdo → Artigos** e crie/edite um artigo
2. No editor JCE, selecione algum texto
3. Clique no botão **Link** (ícone de corrente/link)
4. No navegador de links que abrir, procure por **"Teste"** (ou o label que você configurou)
5. Se aparecer, clique nele para ver os itens da tabela

## Passo 4: Limpar Cache

Se ainda não aparecer:

1. Vá em **Sistema → Limpar Cache**
2. Selecione todos os caches
3. Clique em **Excluir**
4. Atualize a página do editor (F5)
5. Tente novamente

## Passo 5: Verificar Configuração do JCE

O JCE precisa estar configurado para carregar extensões de links. Verifique:

1. **Componentes → JCE Editor → Configuração**
2. Na aba **Editor**, procure por configurações de **Links** ou **Link Browser**
3. Certifique-se de que extensões de terceiros estão permitidas

## Debug SQL

Execute no phpMyAdmin ou similar para verificar se o plugin está registrado:

```sql
-- Verificar se o plugin está habilitado
SELECT * FROM #__extensions 
WHERE element = 'links_dynamic' 
AND folder = 'jce' 
AND enabled = 1;

-- Ver as configurações do plugin
SELECT params FROM #__extensions 
WHERE element = 'links_dynamic' 
AND folder = 'jce';
```

## Localização Esperada no JCE

Quando funcionar corretamente, ao clicar no botão **Link** do JCE Editor, você verá:

```
Link Browser
├── Articles (padrão do JCE)
├── Categories (padrão do JCE)
├── Contacts (padrão do JCE)
└── [SEU LABEL AQUI] ← Sua configuração deve aparecer aqui
    ├── Item 1
    ├── Item 2
    └── ...
```

## Possíveis Problemas

### Não aparece nenhuma opção de link dinâmico:
- O plugin não está habilitado
- O plugin não tem configurações
- O JCE não está reconhecendo a extensão
- Cache precisa ser limpo

### Aparece a categoria mas sem itens dentro:
- A tabela não existe
- O campo ID ou Title está errado
- O filtro de estado está bloqueando os resultados
- Não há registros na tabela

### Erro ao clicar:
- Configuração incorreta dos campos
- Tabela não existe
- Permissões de banco de dados

## Teste Manual via Console

Abra o console do navegador (F12) e execute:

```javascript
// Verificar se o JCE está carregado
console.log(window.tinymce || window.WFEditor);

// Verificar plugins carregados
if (window.WFEditor) {
    console.log(WFEditor.plugins);
}
```

Se nada disso funcionar, envie:
1. Screenshot do plugin habilitado e configurado
2. Screenshot do JCE Profile com as configurações
3. Versão do Joomla
4. Versão do JCE Editor
