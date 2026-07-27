<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuthorResource\Pages;
use App\Filament\Resources\AuthorResource\RelationManagers;
use App\Models\Author;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\FormsComponent;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AuthorResource extends Resource
{
    protected static ?string $model = Author::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function form(Form $form): Form
    {
        return $form    
          // untuk membuat form pada halaman create authors
            ->schema([
                Forms\Components\TextInput::make(
                    'name')->required(),
                Forms\Components\TextInput::make(
                    'username')->required(),

                    // syntax yang berfungsi untuk menambahkan file atau foto avatar profile penulis(author)
                Forms\Components\FileUpload::make(
                    'avatar')
                    ->image()
                    ->required(),

                Forms\Components\Textarea::make(
                    'bio')->required(),
                    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

        //untuk menampilkan listcoulumns author yang sudah terdaftar 
            ->columns([
                Tables\Columns\ImageColumn::make('avatar'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('username'),
                Tables\Columns\TextColumn::make('bio')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuthors::route('/'),
            'create' => Pages\CreateAuthor::route('/create'),
            'edit' => Pages\EditAuthor::route('/{record}/edit'),
        ];
    }
}
