<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\File;
use Illuminate\Support\HtmlString;

class WebsiteAppearance extends Page
{
    protected string $view = 'filament.pages.website-appearance';
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-paint-brush';
    protected static \UnitEnum|string|null $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Website Appearance';
    protected static ?int $navigationSort = 2;
    protected static ?string $title = 'Website Background & Appearance';

    public array $data = [];

    public function mount(): void
    {
        $this->data = [
            'bg_type'            => Setting::getVal('bg_type', 'white'),
            'bg_pattern_image'   => Setting::getVal('bg_pattern_image'),
            'bg_image_select'    => Setting::getVal('bg_pattern_image'),
            'bg_opacity'         => (int) Setting::getVal('bg_opacity', 30),
            'bg_overlay_color'   => Setting::getVal('bg_overlay_color', '#ffffff'),
            'bg_overlay_opacity' => (int) Setting::getVal('bg_overlay_opacity', 0),
        ];
        $this->form->fill($this->data);
    }

    public function form(Schema $schema): Schema
    {
        $uploadedImages = [];
        $diskPath = storage_path('app/public/settings');
        if (File::isDirectory($diskPath)) {
            foreach (File::files($diskPath) as $f) {
                if (in_array(strtolower($f->getExtension()), ['jpg','jpeg','png','gif','webp'])) {
                    $rel = 'settings/' . $f->getFilename();
                    $uploadedImages[$rel] = $f->getFilename();
                }
            }
        }

        return $schema->statePath('data')->schema([

            Section::make('Background Type')
                ->description('Choose a plain white background or a custom photo/pattern.')
                ->schema([
                    Radio::make('bg_type')
                        ->label('Background Style')
                        ->options([
                            'white' => 'White / Plain',
                            'photo' => 'Custom Photo or Pattern',
                        ])
                        ->default('white')
                        ->live()
                        ->required(),
                ]),

            Section::make('Background Image')
                ->description('Upload a new image or select a previously uploaded one.')
                ->visible(fn ($get) => $get('bg_type') === 'photo')
                ->schema([
                    Tabs::make('Image Source')
                        ->tabs([
                            Tab::make('Upload New')
                                ->icon('heroicon-o-arrow-up-tray')
                                ->schema([
                                    FileUpload::make('bg_pattern_image')
                                        ->label('Upload Background Image')
                                        ->image()
                                        ->directory('settings')
                                        ->disk('public')
                                        ->imagePreviewHeight('160')
                                        ->maxSize(131072)
                                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                                        ->helperText('Small tileable PNG for a pattern, or large JPG for a full photo. Max 128MB.'),
                                ]),

                            Tab::make('Select Existing')
                                ->icon('heroicon-o-photo')
                                ->schema([
                                    Select::make('bg_image_select')
                                        ->label('Choose from previously uploaded images')
                                        ->options($uploadedImages)
                                        ->searchable()
                                        ->placeholder('-- select a previously uploaded image --')
                                        ->live()
                                        ->afterStateUpdated(function ($state, callable $set) {
                                            if ($state) {
                                                $set('bg_pattern_image', $state);
                                            }
                                        })
                                        ->helperText('Selecting here will use this image as the background.'),
                                ]),
                        ]),

                    Placeholder::make('current_preview')
                        ->label('Currently Active Background')
                        ->content(function () {
                            $img = Setting::getVal('bg_pattern_image');
                            if (!$img) {
                                return new HtmlString('<span style="color:#999">No background image saved yet.</span>');
                            }
                            $url = asset('storage/' . $img);
                            return new HtmlString(
                                "<div style=\"height:120px;border-radius:8px;border:1px solid #ddd;background-image:url({$url});background-repeat:repeat;background-size:auto;\"></div>"
                                . "<p style=\"margin-top:4px;font-size:0.75rem;color:#666;\">{$img}</p>"
                            );
                        }),
                ]),

            Section::make('Opacity & Overlay')
                ->description('Control how prominent the background appears and add a colour wash over it.')
                ->columns(2)
                ->schema([
                    TextInput::make('bg_opacity')
                        ->label('Background Opacity (%)')
                        ->numeric()
                        ->minValue(5)
                        ->maxValue(100)
                        ->step(5)
                        ->suffix('%')
                        ->default(30)
                        ->helperText('Lower = more subtle. 20–40% works well for patterns.'),

                    TextInput::make('bg_overlay_opacity')
                        ->label('Overlay Opacity (%)')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(90)
                        ->step(5)
                        ->suffix('%')
                        ->default(0)
                        ->helperText('0 = no overlay. Overlay is painted on top of the background image.'),

                    ColorPicker::make('bg_overlay_color')
                        ->label('Overlay Colour')
                        ->default('#ffffff')
                        ->columnSpanFull()
                        ->helperText('White softens a dark pattern; dark adds depth to a light photo.'),
                ]),

        ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $image = $data['bg_pattern_image'] ?? null;
        if (empty($image) && !empty($data['bg_image_select'])) {
            $image = $data['bg_image_select'];
        }

        Setting::setVal('bg_type',            $data['bg_type'] ?? 'white');
        Setting::setVal('bg_pattern_image',   $image);
        Setting::setVal('bg_opacity',         $data['bg_opacity'] ?? 30);
        Setting::setVal('bg_overlay_color',   $data['bg_overlay_color'] ?? '#ffffff');
        Setting::setVal('bg_overlay_opacity', $data['bg_overlay_opacity'] ?? 0);

        Notification::make()
            ->title('Appearance settings saved successfully')
            ->success()
            ->send();

        $this->mount();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Appearance')
                ->icon('heroicon-o-check-circle')
                ->action('save')
                ->color('success'),
        ];
    }
}