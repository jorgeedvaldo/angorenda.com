<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyResource\Pages;
use App\Filament\Resources\PropertyResource\RelationManagers\PropertyImagesRelationManager;
use App\Models\Property;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationLabel = 'Imóveis';

    protected static ?string $modelLabel = 'Imóvel';

    protected static ?string $pluralModelLabel = 'Imóveis';

    protected static ?string $recordTitleAttribute = 'title';

    /**
     * Scope queries: Admin sees all, Owner sees only their own.
     */
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $user = auth()->user();

        if ($user && $user->role === 'admin') {
            return $query;
        }

        return $query->where('user_id', auth()->id());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Proprietário')
                            ->options(User::pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->visible(fn (): bool => auth()->user()?->role === 'admin'),

                        Forms\Components\TextInput::make('title')
                            ->label('Título')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->disabled()
                            ->dehydrated(false)
                            ->helperText('Gerado automaticamente a partir do título.'),

                        Forms\Components\Textarea::make('description')
                            ->label('Descrição')
                            ->required()
                            ->rows(4),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('price')
                                    ->label('Preço')
                                    ->required()
                                    ->numeric()
                                    ->minValue(0),

                                Forms\Components\Select::make('currency')
                                    ->label('Moeda')
                                    ->options([
                                        'AOA' => 'AOA (Kwanza)',
                                        'USD' => 'USD (Dólar)',
                                        'EUR' => 'EUR (Euro)',
                                    ])
                                    ->default('AOA')
                                    ->required(),
                            ]),

                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('bedrooms')
                                    ->label('Quartos')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->required(),

                                Forms\Components\TextInput::make('bathrooms')
                                    ->label('Casas de banho')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->required(),

                                Forms\Components\TextInput::make('area')
                                    ->label('Área (m²)')
                                    ->numeric()
                                    ->minValue(0),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('purpose')
                                    ->label('Finalidade')
                                    ->options([
                                        'sale' => 'Venda',
                                        'rent' => 'Arrendamento',
                                    ])
                                    ->required(),

                                Forms\Components\Select::make('property_type')
                                    ->label('Tipo de imóvel')
                                    ->options([
                                        'apartamento' => 'Apartamento',
                                        'casa' => 'Casa',
                                        'vivenda' => 'Vivenda',
                                        'terreno' => 'Terreno',
                                        'armazem' => 'Armazém',
                                        'escritorio' => 'Escritório',
                                        'loja' => 'Loja',
                                        'edificio' => 'Edifício',
                                        'fazenda' => 'Fazenda',
                                        'outro' => 'Outro',
                                    ])
                                    ->required(),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('address')
                                    ->label('Endereço')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('city')
                                    ->label('Cidade')
                                    ->required()
                                    ->maxLength(255),
                            ]),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Activo')
                            ->default(true),

                        Forms\Components\Section::make('Imagens')
                            ->schema([
                                Forms\Components\Repeater::make('images')
                                    ->relationship()
                                    ->schema([
                                        Forms\Components\FileUpload::make('image_path')
                                            ->label('Ficheiro de Imagem')
                                            ->image()
                                            ->directory('property-images')
                                            ->disk('public')
                                            ->required()
                                            ->maxSize(5120)
                                            ->imageResizeMode('cover')
                                            ->imageCropAspectRatio('16:9'),
                                    ])
                                    ->createItemButtonLabel('Adicionar nova imagem')
                                    ->disableLabel()
                                    ->grid(2)
                            ])
                            ->collapsible(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                Tables\Columns\TextColumn::make('city')
                    ->label('Cidade')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Preço')
                    ->formatStateUsing(fn (Property $record): string => $record->formatted_price)
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('purpose')
                    ->label('Finalidade')
                    ->enum([
                        'sale' => 'Venda',
                        'rent' => 'Arrendamento',
                    ])
                    ->colors([
                        'primary' => 'sale',
                        'success' => 'rent',
                    ]),

                Tables\Columns\TextColumn::make('property_type')
                    ->label('Tipo')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Activo')
                    ->boolean(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Proprietário')
                    ->visible(fn (): bool => auth()->user()?->role === 'admin'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('purpose')
                    ->label('Finalidade')
                    ->options([
                        'sale' => 'Venda',
                        'rent' => 'Arrendamento',
                    ]),

                Tables\Filters\SelectFilter::make('property_type')
                    ->label('Tipo de Imóvel')
                    ->options([
                        'apartamento' => 'Apartamento',
                        'casa' => 'Casa',
                        'vivenda' => 'Vivenda',
                        'terreno' => 'Terreno',
                        'armazem' => 'Armazém',
                        'escritorio' => 'Escritório',
                        'loja' => 'Loja',
                        'edificio' => 'Edifício',
                        'fazenda' => 'Fazenda',
                        'outro' => 'Outro',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Activo'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            PropertyImagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }
}
