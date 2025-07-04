<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Actions;

class PostResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Articles Management';

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
            'publish'
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->required()->maxLength(255),
                Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),
                Forms\Components\Textarea::make('excerpt'),
                SpatieMediaLibraryFileUpload::make('feature_image')
                    ->collection('featured_image')
                    ->columnStart(1)
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('content')->columnStart(1)->columnSpanFull(),
                Forms\Components\Grid::make(2)->schema([
                Forms\Components\Select::make('categories')
                    ->relationship('categories', 'name')
                    ->multiple()
                    ->preload(),

                Forms\Components\Select::make('tags')
                    ->relationship('tags', 'name')
                    ->multiple()
                    ->preload(),
                    ]),
                Forms\Components\Toggle::make('published'),
                Forms\Components\DateTimePicker::make('published_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\TextColumn::make('categories.name')
                    ->label('Categories')
                    ->badge()
                    ->separator(', ')
                    ->limit(3), // tampilkan maksimal 3 nama kategori
                Tables\Columns\TextColumn::make('tags.name')
                    ->label('Tags')
                    ->badge()
                    ->separator(', ')
                    ->limit(3), // tampilkan maksimal 3 nama tag
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Author')
                    ->searchable(),
                Tables\Columns\TextColumn::make('published')
                    ->badge()
                    ->formatStateUsing(fn($state) : string => $state == 1 ? 'Published' : 'Unpublished')
                    ->color(fn($state) : string => $state == 1 ? 'success' : 'danger'),
                Tables\Columns\TextColumn::make('created_at'),
                Tables\Columns\TextColumn::make('updated_at'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('publish')
                ->label(function(\App\Models\Post $post):string {
                    if($post->published == 1) {
                        return 'Unpublish';
                    }else {
                        return 'Publish';
                    }
                })
                ->color(function(\App\Models\Post $post):string {
                    if($post->published == 1) {
                        return 'danger';
                    }else {
                        return 'success';
                    }
                })
                ->authorize('publish_post')
                ->icon(function(\App\Models\Post $post):string {
                    if($post->published == 1) {
                        return 'heroicon-o-x-circle';
                    }else {
                        return 'heroicon-o-check-circle';
                    }
                })
                ->action(function(\App\Models\Post $post) {
                    $post->published = !$post->published;
                    $post->save();
                }),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'view' => Pages\ViewPost::route('/{record}'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}