<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsCategoryResource\Pages;
use App\Filament\Resources\NewsCategoryResource\RelationManagers;
use App\Models\NewsCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\FormsComponent;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NewsCategoryResource extends Resource
{
    protected static ?string $model = NewsCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make(
                    'title'
                )

                //generate slug, syntax di bawah memberikan function agar column slug bisa mengikuti title kerna column slug di inisialisasi menjadi readonly
                
                ->live(onBlur: true)
                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                
                ->required(),

                Forms\Components\Textarea::make(
                    'slug'
                )->readOnly(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                // untuk menampilkan title serta slug ke dalam component table news category(Crud)
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('slug')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListNewsCategories::route('/'),
            'create' => Pages\CreateNewsCategory::route('/create'),
            'edit' => Pages\EditNewsCategory::route('/{record}/edit'),
        ];
    }
}
