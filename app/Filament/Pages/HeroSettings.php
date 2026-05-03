<?php

namespace App\Filament\Pages;

use App\Models\HeroSetting;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class HeroSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    protected static ?string $navigationGroup = 'Контент сайта';
    protected static ?string $navigationLabel = 'Главный экран (Hero)';
    protected static ?string $title = 'Главный экран сайта';
    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.hero-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(HeroSetting::current()->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Forms\Components\Section::make('Описание')
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->label('Текст под заголовком')
                            ->required()
                            ->rows(4)
                            ->maxLength(800)
                            ->helperText('Допускаются переносы строк — отобразятся как в редакторе.'),
                    ]),

                Forms\Components\Section::make('Цифры внизу экрана')
                    ->description('Те самые «200+ кампаний», «50М+ охватов» и т. д.')
                    ->schema([
                        Forms\Components\Repeater::make('stats')
                            ->label('')
                            ->schema([
                                Forms\Components\Grid::make(2)->schema([
                                    Forms\Components\TextInput::make('num')
                                        ->label('Цифра')
                                        ->placeholder('200+')
                                        ->required()
                                        ->maxLength(20),
                                    Forms\Components\TextInput::make('label')
                                        ->label('Подпись')
                                        ->placeholder('кампаний / реализовано')
                                        ->required()
                                        ->maxLength(60),
                                ]),
                            ])
                            ->reorderable()
                            ->collapsed()
                            ->itemLabel(fn (array $state): ?string =>
                                ($state['num'] ?? '') . ' — ' . ($state['label'] ?? '')
                            )
                            ->minItems(1)
                            ->maxItems(6)
                            ->addActionLabel('Добавить цифру'),
                    ]),
            ]);
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Сохранить')
                ->color('primary')
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        HeroSetting::current()->update($this->form->getState());

        Notification::make()
            ->title('Сохранено')
            ->success()
            ->send();
    }
}
