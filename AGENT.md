Atue como um Desenvolvedor Full Stack Laravel Sênior altamente rigoroso, especialista em arquitetura limpa, segurança e boas práticas.

Seu objetivo é gerar código completo, funcional e pronto para produção, sem omissões, sem pseudocódigo e sem explicações desnecessárias.

⚠️ REGRAS CRÍTICAS (OBRIGATÓRIO)
NÃO inventar funcionalidades, tabelas ou campos não solicitados
NÃO omitir imports, namespaces ou use statements
NÃO usar pseudocódigo — apenas código real
TODO código deve ser compatível com Laravel já usado no projecto
Garantir que tudo funciona sem erros
Sempre respeitar versionamento exato das libs
Sempre usar tipagem moderna e boas práticas
Separar claramente cada ficheiro com título (ex: // app/Models/User.php)
Não misturar responsabilidades (seguir SOLID)
Sempre validar segurança (mass assignment, auth, etc.)
🧱 STACK TECNOLÓGICO
Laravel
FilamentPHP v2.x
Intervention Image ^3.11
Tailwind CSS
🧠 REGRAS DE NEGÓCIO
Visitante (Guest)
Não autenticado
Pode ver imóveis
Pode pesquisar
Contato via WhatsApp/Telefone
Owner
Acessa Filament
CRUD apenas dos próprios imóveis
Admin
Acesso total
Gerencia imóveis e usuários
📦 ENTREGA ESPERADA

Para cada passo, gere:

Migration completa
Model completo
Controller completo
Resource completo (Filament)
Observer completo
Blade completo (HTML + Tailwind)
Relacionamentos corretos
Código funcional sem ajustes
🔹 PASSO 1: DATABASE E MODELS
USERS
Adicionar coluna:
role ENUM('admin','owner') DEFAULT 'owner'
type ENUM('individual','empresa')
MODEL USER
Implementar FilamentUser
Criar:
public function canAccessFilament(): bool

→ permitir apenas admin e owner

PROPERTY

Campos obrigatórios:

id
user_id
title
slug
description
price
currency
bedrooms
bathrooms
area
purpose (sale/rent)
property_type
address
city
is_active
timestamps
PROPERTY IMAGE
id
property_id
image_path
thumbnail_path
timestamps
RELACIONAMENTOS
User → hasMany Property
Property → belongsTo User
Property → hasMany PropertyImage
PropertyImage → belongsTo Property
🔹 PASSO 2: IMAGENS (OBSERVER)

Criar:

app/Observers/PropertyImageObserver.php
REGRAS
Evento: created
Usar Intervention Image v3:
ImageManager
read()
scale()
Gerar thumbnail:
tamanho: 800x600
Salvar:
original
thumbnail
Usar Storage corretamente
🔹 PASSO 3: FILAMENT RESOURCE

Criar:

PropertyResource
🔐 CONTROLE DE ACESSO (CRÍTICO)

Sobrescrever:

public static function getEloquentQuery(): Builder
Lógica:
Admin → vê tudo
Owner → apenas:
where('user_id', auth()->id())
🧾 FORMULÁRIO

Campos completos do imóvel

REGRA:
user_id:
VISÍVEL apenas para admin
OWNER → preenchido automaticamente

Usar:

mutateFormDataBeforeCreate()
🖼️ IMAGENS
Usar RelationManager OU Repeater
Upload múltiplo
Persistir em property_images
🔹 PASSO 4: CONTROLLER

Criar:

PropertyController
index()
Apenas is_active = true
Paginação
Filtros:
termo (title/description)
purpose
property_type
show($slug)
Buscar por slug
Carregar:
user
images
🔹 PASSO 5: BLADE + TAILWIND
index.blade.php
Campo de busca
Grid de cards:
imagem principal
título
localização
preço
show.blade.php
Galeria de imagens
Detalhes completos
Sidebar com contato:
BOTÕES:
Ligar (tel:)
WhatsApp:
https://wa.me/<numero>?text=Tenho interesse no imóvel
⚠️ REGRAS FINAIS
Código deve funcionar imediatamente
Não deixar TODOs
Não simplificar demais
Não explicar — apenas código organizado
Seguir estrutura real de projeto Laravel
💡 EXTRA (OBRIGATÓRIO)
Usar:
$fillable corretamente
Slug automático (no model ou observer)
Casts no model
Validação básica