<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Filament\Resources\NewsResource\RelationManagers;
use App\Models\News;
use App\Models\NewsCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\FormsComponent;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use illuminate\Support\Str;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';

    public static function form(Form $form): Form
    {
        return $form

        //Seperti biasa untuk menampilkan Forms di dalam crud untuk meng input data news
            ->schema([
                Forms\Components\Select::make('author_id')
                // untuk sebagai relasi dengan schema 'author' dengan coulumn 'name'
                ->relationship('author','name')
                ->required(),
                 
                Forms\Components\Select::make('news_category_id')
                // function nya sama seperti di atas dengan database 'NewsCategory' yang menginisalisasi atau mengambil data dari column 'title'
                ->relationship('newsCategory','title')
                ->required(),

                Forms\Components\TextInput::make('title')
                ->live(onBlur:true)
                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                ->required(),

                Forms\Components\Textarea::make('slug')
                ->readOnly(),

                //untuk menginpot foto untuk di tampilkan di ui (user interface) beranda berita
                Forms\Components\FileUpload::make('thumbnail')
                ->image()
                ->required(),

                Forms\Components\RichEditor::make('content')
                ->required()
                ->columnSpanFull(),

                Forms\Components\Toggle::make('is_featured')
                

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('author.name'),
                Tables\Columns\TextColumn::make('NewsCategory.title'),
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\ImageColumn::make('thumbnail'),
                Tables\Columns\ToggleColumn::make('is_featured')
            ])
            ->filters([

                //syntax yang memiliki function untuk memfilter berita berdasarkan author(penulis)
                Tables\Filters\SelectFilter::make('author_id')
                ->relationship('author','name')
                ->label('Select Author'),

                //sama function syntaxnya memiliki kegunaan untuk memfilter atau menyaring berita akan tetapi yang ini berdasarkan judul category
                Tables\Filters\SelectFilter::make('news_category_id')
                ->relationship('newsCategory','title')
                ->label('Select Category')

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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
