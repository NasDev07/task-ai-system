<?php

/**
 * Sales Page Design Templates
 * 
 * Defines different styling templates for generating sales pages
 * Users can choose between modern, minimalist, and bold designs
 */

return [
  'default' => 'modern',

  'templates' => [
    'modern' => [
      'name' => 'Modern',
      'description' => 'Clean, professional design with bold typography',
      'colors' => [
        'primary' => '#0066cc',
        'secondary' => '#0052a3',
        'accent' => '#004d99',
        'background' => '#ffffff',
        'text' => '#1a202c',
      ],
      'fonts' => [
        'heading' => "'Public Sans', sans-serif",
        'body' => "'Public Sans', sans-serif",
      ],
      'spacing' => 'large',
      'border_radius' => '12px',
      'shadow_style' => 'medium',
    ],

    'minimalist' => [
      'name' => 'Minimalist',
      'description' => 'Simple, elegant design with plenty of whitespace',
      'colors' => [
        'primary' => '#0066cc',
        'secondary' => '#0052a3',
        'accent' => '#cce5ff',
        'background' => '#ffffff',
        'text' => '#333333',
      ],
      'fonts' => [
        'heading' => "'Inter', sans-serif",
        'body' => "'Inter', sans-serif",
      ],
      'spacing' => 'extra_large',
      'border_radius' => '0px',
      'shadow_style' => 'minimal',
    ],

    'bold' => [
      'name' => 'Bold',
      'description' => 'Vibrant, eye-catching design with strong contrasts',
      'colors' => [
        'primary' => '#003d99',
        'secondary' => '#0052a3',
        'accent' => '#0066cc',
        'background' => '#f8f9fa',
        'text' => '#212529',
      ],
      'fonts' => [
        'heading' => "'Poppins', sans-serif",
        'body' => "'Open Sans', sans-serif",
      ],
      'spacing' => 'medium',
      'border_radius' => '20px',
      'shadow_style' => 'large',
    ],

    'corporate' => [
      'name' => 'Corporate',
      'description' => 'Professional B2B design with traditional styling',
      'colors' => [
        'primary' => '#003d99',
        'secondary' => '#0052a3',
        'accent' => '#cce5ff',
        'background' => '#ffffff',
        'text' => '#1a1a1a',
      ],
      'fonts' => [
        'heading' => "'Georgia', serif",
        'body' => "'Trebuchet MS', sans-serif",
      ],
      'spacing' => 'medium',
      'border_radius' => '4px',
      'shadow_style' => 'subtle',
    ],

    'startup' => [
      'name' => 'Startup',
      'description' => 'Modern, energetic design for SaaS and tech products',
      'colors' => [
        'primary' => '#0066cc',
        'secondary' => '#0052a3',
        'accent' => '#4d94ff',
        'background' => '#f9fafb',
        'text' => '#111827',
      ],
      'fonts' => [
        'heading' => "'Outfit', sans-serif",
        'body' => "'Work Sans', sans-serif",
      ],
      'spacing' => 'large',
      'border_radius' => '16px',
      'shadow_style' => 'medium',
    ],
  ],
];
