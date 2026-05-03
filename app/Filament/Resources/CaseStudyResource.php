<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CaseStudyResource\Pages;
use App\Models\CaseStudy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CaseStudyResource extends Resource
{
    protected static ?string $model = CaseStudy::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static ?string $navigationGroup = 'Контент сайта';
    protected static ?string $navigationLabel = 'Кейсы';
    protected static ?string $modelLabel = 'кейс';
    protected static ?string $pluralModelLabel = 'кейсы';
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Кейс')->tabs([

                // ==================== ОСНОВНОЕ ====================
                Forms\Components\Tabs\Tab::make('Основное')
                    ->icon('heroicon-m-identification')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('brand')
                                ->label('Название бренда')
                                ->required()
                                ->maxLength(120)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn ($state, Forms\Set $set, ?string $old, $context) =>
                                    $context === 'create' ? $set('slug', Str::slug($state)) : null
                                ),

                            Forms\Components\TextInput::make('slug')
                                ->label('URL-slug')
                                ->required()
                                ->maxLength(120)
                                ->unique(ignoreRecord: true)
                                ->helperText('Латинский идентификатор для URL. Заполнится автоматически.'),
                        ]),

                        Forms\Components\TextInput::make('category')
                            ->label('Категория и год')
                            ->placeholder('Спортивная обувь · 2025')
                            ->required()
                            ->maxLength(120),

                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('sort_order')
                                ->label('Порядок (меньше = выше)')
                                ->numeric()
                                ->default(0),
                            Forms\Components\Toggle::make('is_active')
                                ->label('Опубликован на сайте')
                                ->default(true)
                                ->inline(false),
                        ]),
                    ]),

                // ==================== ТЕКСТЫ ====================
                Forms\Components\Tabs\Tab::make('Тексты')
                    ->icon('heroicon-m-document-text')
                    ->schema([
                        Forms\Components\Textarea::make('problem')
                            ->label('С каким вопросом пришли')
                            ->required()
                            ->rows(3)
                            ->maxLength(1000),

                        Forms\Components\Textarea::make('solution')
                            ->label('Что мы сделали (краткое резюме)')
                            ->required()
                            ->rows(2)
                            ->maxLength(500)
                            ->helperText('1–2 предложения. Видны до раскрытия аккордеона.'),

                        Forms\Components\Repeater::make('solution_paragraphs')
                            ->label('Развёрнутое описание (абзацы)')
                            ->helperText('Раскрываются при нажатии «+» в аккордеоне на сайте.')
                            ->simple(
                                Forms\Components\Textarea::make('text')
                                    ->required()
                                    ->rows(3)
                                    ->maxLength(2000)
                            )
                            ->reorderable()
                            ->collapsed()
                            ->itemLabel(fn (array $state): ?string => Str::limit($state['text'] ?? '', 60))
                            ->minItems(1),
                    ]),

                // ==================== АУДИТОРИЯ И АВТОРЫ ====================
                Forms\Components\Tabs\Tab::make('Площадки и авторы')
                    ->icon('heroicon-m-rectangle-group')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\Repeater::make('platforms')
                                ->label('Площадки')
                                ->simple(
                                    Forms\Components\TextInput::make('name')
                                        ->placeholder('YouTube')
                                        ->required()
                                        ->maxLength(40)
                                )
                                ->reorderable()
                                ->minItems(1),

                            Forms\Components\Repeater::make('audience')
                                ->label('Целевая аудитория (строки)')
                                ->simple(
                                    Forms\Components\TextInput::make('line')
                                        ->placeholder('M / F · 18–34')
                                        ->required()
                                        ->maxLength(80)
                                )
                                ->reorderable()
                                ->minItems(1),
                        ]),

                        Forms\Components\Section::make('Авторы')
                            ->description('Сколько авторов задействовано в кампании')
                            ->schema([
                                Forms\Components\Grid::make(4)->schema([
                                    Forms\Components\TextInput::make('authors_total')
                                        ->label('Всего')
                                        ->numeric()->minValue(0)->default(0)->required(),
                                    Forms\Components\TextInput::make('authors_micro')
                                        ->label('Микро')
                                        ->numeric()->minValue(0)->default(0),
                                    Forms\Components\TextInput::make('authors_mid')
                                        ->label('Миддл')
                                        ->numeric()->minValue(0)->default(0),
                                    Forms\Components\TextInput::make('authors_top')
                                        ->label('Топ')
                                        ->numeric()->minValue(0)->default(0),
                                ]),
                            ]),
                    ]),

                // ==================== КЛИЕНТ ====================
                Forms\Components\Tabs\Tab::make('Клиент и отзыв')
                    ->icon('heroicon-m-user-circle')
                    ->schema([
                        Forms\Components\Grid::make(3)->schema([
                            Forms\Components\TextInput::make('client_name')
                                ->label('Имя клиента')
                                ->required()
                                ->maxLength(120),
                            Forms\Components\TextInput::make('client_role')
                                ->label('Должность · компания')
                                ->placeholder('CMO · NORDFIT')
                                ->required()
                                ->maxLength(120),
                            Forms\Components\TextInput::make('client_initials')
                                ->label('Инициалы (2 буквы)')
                                ->maxLength(4)
                                ->required()
                                ->helperText('Показываются, если фото не загружено'),
                        ]),

                        Forms\Components\FileUpload::make('client_photo')
                            ->label('Фото клиента (опционально)')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('client-photos')
                            ->maxSize(2048),

                        Forms\Components\Textarea::make('testimonial')
                            ->label('Отзыв клиента')
                            ->required()
                            ->rows(4)
                            ->maxLength(1500),
                    ]),

                // ==================== ВИДЕО ====================
                Forms\Components\Tabs\Tab::make('Видео')
                    ->icon('heroicon-m-play-circle')
                    ->schema([
                        Forms\Components\TextInput::make('video_url')
                            ->label('Ссылка на видео')
                            ->required()
                            ->url()
                            ->placeholder('https://www.youtube.com/watch?v=…')
                            ->helperText('YouTube, VK или прямая ссылка. Для YouTube обложка подтянется автоматически.'),

                        Forms\Components\FileUpload::make('video_thumbnail')
                            ->label('Своя обложка (опционально)')
                            ->image()
                            ->disk('public')
                            ->directory('video-thumbnails')
                            ->helperText('Если не загружать — для YouTube возьмём официальную обложку.')
                            ->maxSize(4096),

                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('video_brand')
                                ->label('Бренд (надпись на превью)')
                                ->maxLength(60),
                            Forms\Components\TextInput::make('video_author')
                                ->label('Автор (@username)')
                                ->placeholder('@runner_pro')
                                ->maxLength(60),
                        ]),

                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('video_views')
                                ->label('Просмотры')
                                ->placeholder('1.2M просмотров')
                                ->maxLength(40),
                            Forms\Components\TextInput::make('video_date')
                                ->label('Дата публикации')
                                ->placeholder('12.04.2026')
                                ->maxLength(40),
                        ]),
                    ]),
            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('#')
                    ->sortable()
                    ->width(50),
                Tables\Columns\TextColumn::make('brand')
                    ->label('Бренд')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('category')
                    ->label('Категория')
                    ->limit(40)
                    ->color('gray'),
                Tables\Columns\TextColumn::make('authors_total')
                    ->label('Авторов')
                    ->numeric()
                    ->alignCenter(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Активен')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Изменён')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Активен'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ReplicateAction::make()
                    ->label('Дублировать')
                    ->beforeReplicaSaved(function (CaseStudy $replica): void {
                        $replica->slug  = $replica->slug . '-' . Str::random(4);
                        $replica->brand = $replica->brand . ' (копия)';
                        $replica->is_active = false;
                    }),
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
            'index'  => Pages\ListCaseStudies::route('/'),
            'create' => Pages\CreateCaseStudy::route('/create'),
            'edit'   => Pages\EditCaseStudy::route('/{record}/edit'),
        ];
    }
}
