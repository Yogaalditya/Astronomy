<?php

namespace Astronomy;

use App\Classes\Theme;

use App\Facades\Hook;
use App\Forms\Components\TinyEditor;
use Filament\Forms\Components\ColorPicker;
use luizbills\CSS_Generator\Generator as CSSGenerator;
use matthieumastadenis\couleur\ColorFactory;
use matthieumastadenis\couleur\ColorSpace;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Blade;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;

class AstronomyTheme extends Theme
{
	public function boot()
	{
		if (app()->getCurrentScheduledConference()?->getMeta('theme') == 'Astronomy') {
			Blade::anonymousComponentPath($this->getPluginPath('resources/views/frontend/website/components'), prefix: 'website');
			Blade::anonymousComponentPath($this->getPluginPath('resources/views/frontend/scheduledConference/components'), prefix: 'scheduledConference');
		}
		Blade::anonymousComponentPath($this->getPluginPath('resources/views/frontend/website/components'), 'astronomy');
	}

	public function getFormSchema(): array
	{
		return [
			Toggle::make('top_navigation')
				->label('Enable Top Navigation')
				->default(false),
			Toggle::make('enable_countdown')
				->label('Enable Countdown on Banner')
				->default(false),
			TextArea::make('description')
				->label('Description')
				->rows(5),
			ColorPicker::make('description_color')
				->regex('/^#?(([a-f0-9]{3}){1,2})$/i')
				->label('Description Label Color'),
			SpatieMediaLibraryFileUpload::make('images')
				->collection('astronomy-header')
				->label('Upload Header Images')
				->multiple()
				->maxFiles(4)
				->image(),
			ColorPicker::make('appearance_color')
				->regex('/^#?(([a-f0-9]{3}){1,2})$/i')
				->label(__('general.appearance_color')),

			// Layouts
			Builder::make('layouts')
				->collapsible()
				->collapsed()
				->cloneable()
				->blockNumbers(false)
				->reorderableWithButtons()
				->reorderableWithDragAndDrop(false)
				->blocks([
					Builder\Block::make('speakers')
						->label('Speakers')
						->icon('heroicon-o-users')
						->maxItems(1),
					Builder\Block::make('sponsors')
						->label('Sponsors')
						->icon('heroicon-o-building-office-2')
						->maxItems(1),
					Builder\Block::make('partners')
						->label('Partners')
						->icon('heroicon-o-building-office')
						->maxItems(1),
					Builder\Block::make('latest-news')
						->label('Latest News')
						->icon('heroicon-o-newspaper')
						->maxItems(1),
					Builder\Block::make('layout-template-1')
						->label('Layout Template 1')
						->icon('heroicon-o-rectangle-stack')
						->schema([
							TextInput::make('section_title')
								->label('Section Title')
								->placeholder('Advantages & Benefits for Participants'),
							Repeater::make('cards')
								->label('Cards')
								->addActionLabel('Add Card')
								->schema([
									TextInput::make('title')
										->label('Title')
										->required(),
									Textarea::make('description')
										->label('Description')
										->rows(3)
										->required(),
								])
								->minItems(1)
								->columns(1),
						]),
					Builder\Block::make('layout-template-2')
						->label('Layout Template 2')
						->icon('heroicon-o-rectangle-group')
						->schema([
							TextInput::make('title')
								->label('Title')
								->required(),
							Textarea::make('description')
								->label('Description')
								->rows(3),
							SpatieMediaLibraryFileUpload::make('background_image')
								->collection('astronomy-hero')
								->label('Background Image')
								->image()
								->maxFiles(1),
							Repeater::make('buttons')
								->label('Buttons')
								->schema([
									TextInput::make('text')->label('Text')->required(),
									TextInput::make('url')->label('URL')->required()->url(),
									Select::make('style')->label('Style')->options([
										'primary' => 'Primary',
										'outline' => 'Outline',
									])->default('primary'),
								])
								->columns(2)
								->minItems(0),
						]),
					Builder\Block::make('layout-template-3')
						->label('Layout Template 3')
						->icon('heroicon-o-rectangle-group')
						->schema([
							Grid::make(2)
								->schema([
									Grid::make()
										->schema([
											Select::make('left.type')
												->label('Left Column Type')
												->options([
													'image' => 'Image',
													'description' => 'Description',
												])
												->reactive()
												->required(),
											SpatieMediaLibraryFileUpload::make('left.image')
												->collection('astronomy-about-left')
												->label('Left Image')
												->image()
												->maxFiles(1)
												->visible(fn ($get) => $get('left.type') === 'image'),
											TextInput::make('left.title')
												->label('Left Title')
												->visible(fn ($get) => $get('left.type') === 'description'),
											Textarea::make('left.description')
												->label('Left Description')
												->rows(3)
												->visible(fn ($get) => $get('left.type') === 'description'),
											Repeater::make('left.points')
												->label('Left Points')
												->schema([
													TextInput::make('text')->label('Text')->required(),
												])
												->minItems(0)
												->columns(1)
												->visible(fn ($get) => $get('left.type') === 'description'),
										]),
									Grid::make()
										->schema([
											Select::make('right.type')
												->label('Right Column Type')
												->options([
													'image' => 'Image',
													'description' => 'Description',
												])
												->reactive()
												->required(),
											SpatieMediaLibraryFileUpload::make('right.image')
												->collection('astronomy-about-right')
												->label('Right Image')
												->image()
												->maxFiles(1)
												->visible(fn ($get) => $get('right.type') === 'image'),
											TextInput::make('right.title')
												->label('Right Title')
												->visible(fn ($get) => $get('right.type') === 'description'),
											Textarea::make('right.description')
												->label('Right Description')
												->rows(3)
												->visible(fn ($get) => $get('right.type') === 'description'),
											Repeater::make('right.points')
												->label('Right Points')
												->schema([
													TextInput::make('text')->label('Text')->required(),
												])
												->minItems(0)
												->columns(1)
												->visible(fn ($get) => $get('right.type') === 'description'),
										]),
								])
						]),
					Builder\Block::make('layouts')
						->label('Custom Content')
						->icon('heroicon-m-bars-3-bottom-left')
						->schema([
							TextInput::make('name_content')
								->label('Title')
								->required(),
							TinyEditor::make('about')
								->label('Content')
								->profile('advanced')
								->required(),
						]),

				]),

			Repeater::make('banner_buttons')
				->schema([
					TextInput::make('text')->required(),
					TextInput::make('url')
						->required()
						->url(),
					ColorPicker::make('text_color'),
					ColorPicker::make('background_color'),
				])
				->columns(2),
		];
	}

	public function onActivate(): void
	{
		Hook::add('Frontend::Views::Head', function ($hookName, &$output) {
			$output .= '<script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>';
			$output .= '<link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" />';
			$css = $this->url('astronomy.css');
			$output .= "<link rel='stylesheet' type='text/css' href='$css'/> ";

			if ($appearanceColor = $this->getSetting('appearance_color')) {
				$oklch = ColorFactory::new($appearanceColor)->to(ColorSpace::OkLch);
				$css = new CSSGenerator();
				$css->root_variable('p', "{$oklch->lightness}% {$oklch->chroma} {$oklch->hue}");

				$oklch = ColorFactory::new('#1F2937')->to(ColorSpace::OkLch);
				$css->root_variable('bc', "{$oklch->lightness}% {$oklch->chroma} {$oklch->hue}");

				$output .= <<<HTML
					<style>
						{$css->get_output()}
					</style>
				HTML;
			}
		});
	}

	public function getFormData(): array
	{
		return [
			'images' => $this->getSetting('images'),
			'appearance_color' => $this->getSetting('appearance_color'),
			'description_color' => $this->getSetting('description_color'),
			'layouts' => $this->getSetting('layouts') ?? [] ,
			'name_content' => $this->getSetting('name_content'),
			'about' => $this->getSetting('about'),
			'top_navigation' => $this->getSetting('top_navigation'),
			'enable_countdown' => $this->getSetting('enable_countdown'),
			'banner_buttons' => $this->getSetting('banner_buttons'),
			'description' => $this->getSetting('description'),
		];
	}
}