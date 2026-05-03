<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FlipCardResource\Pages;
use App\Models\FlipCard;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FlipCardResource extends Resource
{
    protected static ?string $model = FlipCard::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationGroup = 'Контент сайта';
    protected static ?string $navigationLabel = 'Услуги (карточки)';
    protected static ?string $modelLabel = 'карточка услуги';
    protected static ?string $pluralModelLabel = 'карточки услуг';
    protected static ?int $navigationSort = 20;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()
                ->schema([
                    Forms\Components\Grid::make(3)->schema([
                        Forms\Components\TextInput::make('num')
                            ->label('Номер (на лицевой стороне)')
                            ->placeholder('01')
                            ->required()
                            ->maxLength(4),

                        Forms\Components\TextInput::make('title')
                            ->label('Заголовок')
                            ->placeholder('ОХВАТЫ')
                            ->required()
                            ->maxLength(60)
                            ->columnSpan(2),
                    ]),

                    Forms\Components\Textarea::make('description')
                        ->label('Текст на обратной стороне')
                        ->required()
                        ->rows(4)
                        ->maxLength(500)
                        ->helperText('Появляется при клике на карточку — переворачивается на 180°.'),

                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Порядок (меньше = выше)')
                            ->numeric()
                            ->default(0),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Показывать на сайте')
                            ->default(true)
                            ->inline(false),
                    ]),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('num')
                    ->label('№')
                    ->width(60),
                Tables\Columns\TextColumn::make('title')
                    ->label('Заголовок')
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Описание')
                    ->limit(80)
                    ->color('gray')
                    ->wrap(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Активна')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Активна'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListFlipCards::route('/'),
            'create' => Pages\CreateFlipCard::route('/create'),
            'edit'   => Pages\EditFlipCard::route('/{record}/edit'),
        ];
    }
}
