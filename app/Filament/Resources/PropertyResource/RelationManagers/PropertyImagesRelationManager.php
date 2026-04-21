<?php

namespace App\Filament\Resources\PropertyResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class PropertyImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    protected static ?string $recordTitleAttribute = 'image_path';

    protected static ?string $title = 'Imagens';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image_path')
                    ->label('Imagem')
                    ->image()
                    ->directory('property-images')
                    ->disk('public')
                    ->required()
                    ->maxSize(5120)
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('16:9'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail_path')
                    ->label('Thumbnail')
                    ->disk('public')
                    ->width(120)
                    ->height(80),

                Tables\Columns\TextColumn::make('image_path')
                    ->label('Ficheiro')
                    ->limit(40),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Adicionada em')
                    ->dateTime('d/m/Y H:i'),
            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Adicionar Imagem'),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
