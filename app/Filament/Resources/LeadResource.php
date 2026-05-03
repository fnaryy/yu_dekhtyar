<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Models\Lead;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';
    protected static ?string $navigationGroup = 'Заявки';
    protected static ?string $navigationLabel = 'Входящие заявки';
    protected static ?string $modelLabel = 'заявка';
    protected static ?string $pluralModelLabel = 'заявки';
    protected static ?int $navigationSort = 5;

    /**
     * Show "new" leads count as a navigation badge.
     */
    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('status', 'new')->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Заявка')
                ->description('Поля заполнены клиентом — изменять обычно не нужно.')
                ->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('name')->label('Имя')->disabled(),
                        Forms\Components\TextInput::make('company')->label('Компания')->disabled(),
                        Forms\Components\TextInput::make('contact')->label('Контакт')->disabled(),
                        Forms\Components\TextInput::make('phone')->label('Телефон')->disabled(),
                    ]),
                    Forms\Components\Textarea::make('message')->label('Сообщение')->disabled()->rows(3),
                ]),

            Forms\Components\Section::make('Обработка')
                ->schema([
                    Forms\Components\Select::make('status')
                        ->label('Статус')
                        ->options([
                            'new'       => 'Новая',
                            'contacted' => 'В работе',
                            'converted' => 'Сделка',
                            'archived'  => 'Архив',
                        ])
                        ->required()
                        ->native(false),

                    Forms\Components\Placeholder::make('telegram_status')
                        ->label('Уведомление в Telegram')
                        ->content(fn (?Lead $record): string =>
                            $record?->telegram_sent
                                ? '✓ Отправлено'
                                : ($record?->telegram_error ? '✗ Ошибка: ' . $record->telegram_error : '— не отправлялось')
                        ),

                    Forms\Components\Placeholder::make('created_at')
                        ->label('Получена')
                        ->content(fn (?Lead $record): string => $record?->created_at?->format('d.m.Y H:i') ?? '—'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Когда')
                    ->dateTime('d.m H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Имя')
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('company')
                    ->label('Компания')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact')
                    ->label('Контакт')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Скопировано'),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Телефон')
                    ->copyable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'new'       => 'Новая',
                        'contacted' => 'В работе',
                        'converted' => 'Сделка',
                        'archived'  => 'Архив',
                        default     => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'new'       => 'danger',
                        'contacted' => 'warning',
                        'converted' => 'success',
                        'archived'  => 'gray',
                        default     => 'gray',
                    }),
                Tables\Columns\IconColumn::make('telegram_sent')
                    ->label('TG')
                    ->boolean()
                    ->tooltip(fn (Lead $record): string =>
                        $record->telegram_sent
                            ? 'Уведомление отправлено в Telegram'
                            : ($record->telegram_error ?? 'Не отправлялось')
                    ),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Статус')
                    ->options([
                        'new'       => 'Новая',
                        'contacted' => 'В работе',
                        'converted' => 'Сделка',
                        'archived'  => 'Архив',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Открыть'),
                Tables\Actions\Action::make('markContacted')
                    ->label('В работу')
                    ->icon('heroicon-m-play')
                    ->color('warning')
                    ->visible(fn (Lead $record): bool => $record->status === 'new')
                    ->action(fn (Lead $record) => $record->update(['status' => 'contacted'])),
                Tables\Actions\EditAction::make()->label('Изменить'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('archive')
                        ->label('Архивировать')
                        ->icon('heroicon-m-archive-box')
                        ->action(fn ($records) => $records->each->update(['status' => 'archived'])),
                    Tables\Actions\DeleteBulkAction::make()->label('Удалить'),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeads::route('/'),
            'edit'  => Pages\EditLead::route('/{record}/edit'),
        ];
    }

    /**
     * Hide the create button — leads come from the public form.
     */
    public static function canCreate(): bool
    {
        return false;
    }
}
