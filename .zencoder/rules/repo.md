---
description: Repository Information Overview
alwaysApply: true
---

# Astronomy Theme Information

## Summary
Astronomy is a theme plugin for the Leconfe platform. It provides a customizable theme with modern design elements, responsive layouts, and configurable components for conference websites.

## Structure
- **src/**: Contains the main theme class and template files
- **resources/views/**: Frontend views organized by context (website, scheduledConference)
- **public/**: CSS and other public assets
- **vendor/**: Composer dependencies

## Language & Runtime
**Language**: PHP
**Build System**: Composer
**Package Manager**: Composer
**Namespace**: `Astronomy\`

## Dependencies
**Main Dependencies**:
- Requires Leconfe core framework
- Uses Filament Forms components for theme configuration
- Uses CSS Generator for dynamic styling
- Uses Couleur library for color manipulation

## Build & Installation
```bash
composer install
```

## Main Files
**Entry Point**: `index.php` - Returns a new instance of the AstronomyTheme class
**Main Class**: `src/AstronomyTheme.php` - Extends the core Theme class
**Configuration**: `index.yaml` - Defines theme metadata (name, version, type)
**CSS**: `public/astronomy.css` - Main stylesheet with custom theme styling

## Theme Features
**Customization Options**:
- Color picker for appearance customization
- Header image uploads
- Layout builder with configurable blocks
- Banner button customization
- Toggle for top navigation

**Components**:
- Speakers section
- Sponsors section
- Partners section
- Latest news section
- Custom content sections

## Views Structure
**Frontend Views**:
- Website components and pages
- Scheduled conference components and pages
- Blade anonymous components for reusable UI elements

## Styling
**CSS Framework**: Uses Tailwind CSS (loaded via CDN)
**UI Library**: Uses DaisyUI components
**Custom Styling**: Implements custom animations, responsive design, and theme color variables
**Font**: Uses "Inter Tight" font family