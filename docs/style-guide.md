# ConnectCommerce Style Guide

This style guide provides a clear reference for design patterns, color palette, typography, and components used throughout the ConnectCommerce application. Following these guidelines will ensure visual and functional consistency across all interfaces.

## Table of Contents
- [Color Palette](#color-palette)
- [Typography](#typography)
- [Spacing System](#spacing-system)
- [Components](#components)
  - [Buttons](#buttons)
  - [Forms](#forms)
  - [Cards](#cards)
  - [Alerts and Notifications](#alerts-and-notifications)
  - [Navigation](#navigation)
- [Interactive Elements](#interactive-elements)
- [Icons](#icons)
- [Responsive Design](#responsive-design)
- [Accessibility Guidelines](#accessibility-guidelines)

## Color Palette

### Primary Colors
- **Blue Primary**: `bg-blue-600` (#2563EB) - Main brand color used for primary buttons, headers, and key actions
- **Blue Light**: `bg-blue-50` (#EFF6FF) - Used for hover states, backgrounds, and secondary elements
- **Blue Dark**: `bg-blue-800` (#1E40AF) - Used for hover states on primary buttons and gradient elements

### Neutral Colors
- **White**: `bg-white` (#FFFFFF) - Used for backgrounds, cards, and text on dark colors
- **Gray Light**: `bg-gray-50` (#F9FAFB) - Used for page backgrounds and subtle element differentiation
- **Gray Medium**: `bg-gray-200` (#E5E7EB) - Used for borders, dividers, and disabled states
- **Gray Dark**: `bg-gray-700` (#374151) - Used for secondary text
- **Black**: `text-gray-900` (#111827) - Used for primary text

### Accent Colors
- **Green**: `bg-green-500` (#10B981) - Success states, positive indicators
- **Red**: `bg-red-500` (#EF4444) - Error states, destructive actions
- **Yellow**: `bg-yellow-400` (#FBBF24) - Warning states, attention indicators
- **Indigo**: `bg-indigo-500` (#6366F1) - Alternative accent color for visual variety

### Opacity Variants
For overlays and subtle UI elements:
- 75% opacity: `bg-blue-600/75`
- 50% opacity: `bg-blue-600/50`
- 25% opacity: `bg-blue-600/25`
- 10% opacity: `bg-blue-600/10`

## Typography

### Font Family
We use **Instrument Sans** as our primary font family, with system fonts as fallbacks:
```css
font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
```

### Font Sizes
- **Display**: `text-5xl` or `text-6xl` (3rem - 3.75rem) - Used for hero sections and main headings
- **Heading 1**: `text-4xl` (2.25rem) - Primary page headings
- **Heading 2**: `text-3xl` (1.875rem) - Section headings
- **Heading 3**: `text-2xl` (1.5rem) - Subsection headings
- **Heading 4**: `text-xl` (1.25rem) - Card headings, smaller section titles
- **Body Large**: `text-lg` (1.125rem) - Featured body text, introductions
- **Body Regular**: `text-base` (1rem) - Standard body text
- **Body Small**: `text-sm` (0.875rem) - Secondary information, meta text
- **Caption**: `text-xs` (0.75rem) - Labels, help text, footnotes

### Font Weights
- **Regular**: `font-normal` (400)
- **Medium**: `font-medium` (500)
- **Semibold**: `font-semibold` (600)
- **Bold**: `font-bold` (700)
- **Extrabold**: `font-extrabold` (800) - Used for hero headlines and key CTAs

### Line Heights
- **Tight**: `leading-tight` (1.25) - Used for headings
- **Normal**: `leading-normal` (1.5) - Used for body text
- **Loose**: `leading-loose` (2) - Used for readable paragraphs

## Spacing System

We use Tailwind's built-in spacing scale throughout the application:

- **4px**: `p-1`, `m-1`, `gap-1` - Minimal spacing, icon padding
- **8px**: `p-2`, `m-2`, `gap-2` - Tight spacing, small elements
- **12px**: `p-3`, `m-3`, `gap-3` - Default button padding
- **16px**: `p-4`, `m-4`, `gap-4` - Standard content spacing
- **24px**: `p-6`, `m-6`, `gap-6` - Section spacing
- **32px**: `p-8`, `m-8`, `gap-8` - Large component spacing
- **48px**: `p-12`, `m-12`, `gap-12` - Section padding
- **64px**: `p-16`, `m-16`, `gap-16` - Page section spacing

## Components

### Buttons

#### Primary Button
```html
<button class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150">
    Primary Action
</button>
```

#### Secondary Button
```html
<button class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150">
    Secondary Action
</button>
```

#### Text Button
```html
<button class="inline-flex items-center px-4 py-2 border border-transparent font-medium text-blue-600 hover:text-blue-800 focus:outline-none transition duration-150">
    Text Action
</button>
```

#### Danger Button
```html
<button class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-150">
    Danger Action
</button>
```

#### Disabled Button
Add the `disabled` attribute and these classes: `opacity-50 cursor-not-allowed`

### Forms

#### Text Input
```html
<input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
```

#### Select Input
```html
<select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
    <option>Option 1</option>
    <option>Option 2</option>
</select>
```

#### Checkbox
```html
<div class="flex items-center">
    <input type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
    <label class="ml-2 text-sm text-gray-600">Checkbox label</label>
</div>
```

#### Form Group
```html
<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Label</label>
    <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
    <p class="mt-1 text-sm text-gray-500">Help text for the field</p>
</div>
```

### Cards

#### Standard Card
```html
<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-lg font-medium text-gray-900">Card Title</h3>
    <p class="mt-2 text-gray-600">Card content goes here.</p>
</div>
```

#### Feature Card
```html
<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <div class="p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                <!-- Icon here -->
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-medium text-gray-900">Feature Title</h3>
                <p class="mt-1 text-gray-600">Feature description goes here.</p>
            </div>
        </div>
    </div>
</div>
```

#### Interactive Card
```html
<a href="#" class="block bg-white rounded-lg shadow hover:shadow-md transition-shadow duration-300 p-6">
    <h3 class="text-lg font-medium text-gray-900">Interactive Card</h3>
    <p class="mt-2 text-gray-600">Click this card to navigate.</p>
</a>
```

### Alerts and Notifications

#### Success Alert
```html
<div class="bg-green-50 border-l-4 border-green-500 p-4">
    <div class="flex">
        <div class="flex-shrink-0">
            <!-- Success icon -->
        </div>
        <div class="ml-3">
            <p class="text-sm text-green-700">Success message goes here.</p>
        </div>
    </div>
</div>
```

#### Error Alert
```html
<div class="bg-red-50 border-l-4 border-red-500 p-4">
    <div class="flex">
        <div class="flex-shrink-0">
            <!-- Error icon -->
        </div>
        <div class="ml-3">
            <p class="text-sm text-red-700">Error message goes here.</p>
        </div>
    </div>
</div>
```

#### Toast Notification
```html
<div class="fixed bottom-4 right-4 bg-gray-800 text-white px-4 py-3 rounded-lg shadow-lg">
    <div class="flex items-center">
        <div class="mr-3">
            <!-- Notification icon -->
        </div>
        <div>
            <p class="font-medium">Notification Title</p>
            <p class="text-sm opacity-75">Notification message goes here.</p>
        </div>
    </div>
</div>
```

### Navigation

#### Navbar Link
```html
<a href="#" class="text-blue-100 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Link Text</a>
```

#### Active Navbar Link
```html
<a href="#" class="text-white bg-blue-700 px-3 py-2 rounded-md text-sm font-medium">Active Link</a>
```

#### Dropdown Menu
```html
<div x-data="{ open: false }" @click.away="open = false" class="relative">
    <button @click="open = !open" class="flex items-center text-sm font-medium focus:outline-none">
        <span>Dropdown</span>
        <svg class="ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
    </button>
    <div x-show="open" class="absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Option 1</a>
        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Option 2</a>
    </div>
</div>
```

#### Pagination
```html
<nav class="flex items-center justify-between border-t border-gray-200 px-4 sm:px-0">
    <div class="flex w-0 flex-1">
        <a href="#" class="inline-flex items-center border-t-2 border-transparent pt-4 pr-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
            Previous
        </a>
    </div>
    <div class="hidden md:flex">
        <a href="#" class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">1</a>
        <a href="#" class="inline-flex items-center border-t-2 border-blue-500 px-4 pt-4 text-sm font-medium text-blue-600">2</a>
        <a href="#" class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">3</a>
    </div>
    <div class="flex w-0 flex-1 justify-end">
        <a href="#" class="inline-flex items-center border-t-2 border-transparent pt-4 pl-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
            Next
        </a>
    </div>
</nav>
```

## Interactive Elements

### Tooltips
```html
<div x-data="{ tooltip: false }" class="relative">
    <button @mouseenter="tooltip = true" @mouseleave="tooltip = false" class="text-blue-600 hover:text-blue-800">
        Hover me
    </button>
    <div x-show="tooltip" class="absolute bottom-full mb-2 w-48 rounded bg-gray-900 text-white text-xs p-2">
        Tooltip text goes here
    </div>
</div>
```

### Modals
```html
<div x-data="{ open: false }">
    <button @click="open = true" class="bg-blue-600 text-white px-4 py-2 rounded">Open Modal</button>
    
    <div x-show="open" class="fixed inset-0 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Modal Title</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Modal content goes here.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button @click="open = false" type="button" class="bg-blue-600 text-white px-4 py-2 rounded">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
```

### Tabs
```html
<div x-data="{ activeTab: 'tab1' }">
    <div class="border-b border-gray-200">
        <nav class="flex -mb-px">
            <button @click="activeTab = 'tab1'" :class="{ 'border-blue-500 text-blue-600': activeTab === 'tab1', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'tab1' }" class="px-4 py-2 font-medium text-sm border-b-2">
                Tab 1
            </button>
            <button @click="activeTab = 'tab2'" :class="{ 'border-blue-500 text-blue-600': activeTab === 'tab2', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'tab2' }" class="ml-8 px-4 py-2 font-medium text-sm border-b-2">
                Tab 2
            </button>
        </nav>
    </div>
    <div class="mt-4">
        <div x-show="activeTab === 'tab1'">
            Content for tab 1
        </div>
        <div x-show="activeTab === 'tab2'" style="display: none;">
            Content for tab 2
        </div>
    </div>
</div>
```

### Accordion
```html
<div x-data="{ expanded: false }">
    <button @click="expanded = !expanded" class="flex justify-between w-full px-4 py-2 text-left text-gray-800 bg-gray-100 hover:bg-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        <span>Accordion Title</span>
        <svg :class="{'rotate-180': expanded}" class="w-5 h-5 transform transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
    </button>
    <div x-show="expanded" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="p-4">
        Accordion content goes here.
    </div>
</div>
```

## Icons

We use SVG icons throughout the application for consistent, scalable vector graphics. Recommended icon libraries:

- [Heroicons](https://heroicons.com/) - Used for UI elements
- [Simple Icons](https://simpleicons.org/) - Used for brand/social icons

Example icon usage:
```html
<svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
</svg>
```

## Responsive Design

Our application follows a mobile-first approach. Use these responsive prefixes for adapting layouts:

- Default: Mobile (0px+)
- `sm:` Small screens (640px+)
- `md:` Medium screens (768px+)
- `lg:` Large screens (1024px+)
- `xl:` Extra large screens (1280px+)
- `2xl:` 2X Extra large screens (1536px+)

Example responsive component:
```html
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <!-- Content -->
</div>
```

## Accessibility Guidelines

1. **Color Contrast** - Maintain a minimum contrast ratio of 4.5:1 for normal text and 3:1 for large text
2. **Keyboard Navigation** - Ensure all interactive elements are keyboard accessible
3. **ARIA Attributes** - Use appropriate ARIA roles, states, and properties for dynamic content
4. **Focus States** - Ensure visible focus indicators for keyboard navigation
5. **Alternative Text** - Provide alt text for all images and SVG icons
6. **Semantic HTML** - Use proper heading hierarchy and semantic elements

## Implementation Examples

### Dashboard Card Widget
```html
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-medium text-gray-900">Sales Overview</h3>
        <div x-data="{ menu: false }" class="relative">
            <button @click="menu = !menu" class="text-gray-400 hover:text-gray-600">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                </svg>
            </button>
            <div x-show="menu" @click.away="menu = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                <div class="py-1">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">View Details</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Export Data</a>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <div class="flex items-center">
            <span class="text-3xl font-bold text-gray-900">$24,563</span>
            <span class="ml-2 flex items-center text-sm font-medium text-green-600">
                <svg class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                </svg>
                <span>12.5%</span>
            </span>
        </div>
        <p class="mt-1 text-sm text-gray-500">Compared to previous month</p>
        <div class="mt-4 h-10 bg-gray-100 rounded-full overflow-hidden">
            <div class="h-full bg-blue-600 rounded-full" style="width: 75%"></div>
        </div>
    </div>
</div>
```

### Data Table
```html
<div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
        <h3 class="text-lg leading-6 font-medium text-gray-900">Products</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Actions</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="h-10 w-10 flex-shrink-0">
                                <img class="h-10 w-10 rounded-full" src="https://via.placeholder.com/40" alt="">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">Product Name</div>
                                <div class="text-sm text-gray-500">SKU123456</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">Electronics</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">$299.99</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Active
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="#" class="text-blue-600 hover:text-blue-900">Edit</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
```

---

This style guide should be regularly updated as new patterns and components are developed. For any new UI elements, refer to this guide first to ensure consistency across the application. 