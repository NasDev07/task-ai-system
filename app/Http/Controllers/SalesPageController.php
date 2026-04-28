<?php

namespace App\Http\Controllers;

use App\Models\SalesPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use RuntimeException;

class SalesPageController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    public function index()
    {
        return view('sales-page.form');
    }

    public function edit(SalesPage $salesPage)
    {
        $this->authorize('update', $salesPage);

        return view('sales-page.form', [
            'salesPage' => $salesPage,
        ]);
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'features' => 'required|string|max:500',
            'target_audience' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'unique_selling_point' => 'required|string|max:500',
        ]);

        $validated['user_id'] = Auth::id();

        try {
            $generated = $this->generateSalesCopy($validated);

            $validated['headline'] = $generated['headline'] ?? '';
            $validated['subheadline'] = $generated['subheadline'] ?? '';
            $validated['benefits'] = $generated['benefits'] ?? '';
            $validated['features_breakdown'] = $generated['features_breakdown'] ?? '';
            $validated['social_proof'] = $generated['social_proof'] ?? '';
            $validated['pricing_display'] = $generated['pricing_display'] ?? '';
            $validated['call_to_action'] = $generated['call_to_action'] ?? '';

            $salesPage = SalesPage::create($validated);

            return redirect()->route('sales-page.show', $salesPage->id)
                ->with('success', 'Sales page generated successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['api' => $e->getMessage()]);
        }
    }

    public function history(Request $request)
    {
        $query = SalesPage::query()->where('user_id', Auth::id());

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($builder) use ($search) {
                $builder->where('product_name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $pages = $query->latest()->paginate(10);

        return view('sales-page.history', compact('pages'));
    }

    public function update(Request $request, SalesPage $salesPage)
    {
        $this->authorize('update', $salesPage);

        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'features' => 'required|string|max:500',
            'target_audience' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'unique_selling_point' => 'required|string|max:500',
        ]);

        try {
            $generated = $this->generateSalesCopy($validated);

            $salesPage->update([
                ...$validated,
                'headline' => $generated['headline'] ?? '',
                'subheadline' => $generated['subheadline'] ?? '',
                'benefits' => $generated['benefits'] ?? '',
                'features_breakdown' => $generated['features_breakdown'] ?? '',
                'social_proof' => $generated['social_proof'] ?? '',
                'pricing_display' => $generated['pricing_display'] ?? '',
                'call_to_action' => $generated['call_to_action'] ?? '',
            ]);

            return redirect()->route('sales-page.show', $salesPage)
                ->with('success', 'Sales page regenerated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['api' => $e->getMessage()]);
        }
    }

    public function show(SalesPage $salesPage)
    {
        $this->authorize('view', $salesPage);

        return view('sales-page.show', compact('salesPage'));
    }

    public function destroy(SalesPage $salesPage)
    {
        $this->authorize('delete', $salesPage);

        $salesPage->delete();

        return redirect()->route('sales-page.history')
            ->with('success', 'Sales page deleted successfully!');
    }

    public function export(SalesPage $salesPage)
    {
        $this->authorize('view', $salesPage);

        $html = view('sales-page.export', [
            'salesPage' => $salesPage,
        ])->render();

        return response()->streamDownload(function () use ($html) {
            echo $html;
        }, str($salesPage->product_name)->slug() . '-sales-page.html', [
            'Content-Type' => 'text/html; charset=UTF-8',
        ]);
    }

    public function regenerateSection(SalesPage $salesPage, Request $request)
    {
        $this->authorize('update', $salesPage);

        $section = $request->validate([
            'section' => 'required|in:headline,subheadline,benefits,features_breakdown,social_proof,pricing_display,call_to_action',
        ])['section'];

        try {
            $sectionPrompt = $this->buildSectionPrompt($salesPage, $section);

            $apiKey = env('GEMINI_API_KEY');
            $model = env('GEMINI_MODEL', 'gemini-2.0-flash');
            $url = sprintf(
                'https://generativelanguage.googleapis.com/v1beta/models/%s:generateContent?key=%s',
                $model,
                $apiKey
            );

            $response = Http::timeout(60)->acceptJson()->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $sectionPrompt],
                        ],
                    ],
                ],
                'generationConfig' => [
                    'temperature' => 0.8,
                    'topP' => 0.95,
                    'topK' => 64,
                    'maxOutputTokens' => 500,
                    'responseMimeType' => 'application/json',
                ],
            ]);

            if ($response->failed()) {
                throw new RuntimeException('Failed to regenerate section.');
            }

            $content = $response->json('candidates.0.content.parts.0.text');
            $generated = json_decode($content, true);

            if (!isset($generated[$section])) {
                throw new RuntimeException('Invalid response format.');
            }

            $salesPage->update([
                $section => $generated[$section],
            ]);

            return back()->with('success', ucfirst(str_replace('_', ' ', $section)) . ' regenerated successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['regenerate' => $e->getMessage()]);
        }
    }

    private function generateSalesCopy(array $data): array
    {
        $apiKey = env('GEMINI_API_KEY');

        if (!$apiKey) {
            throw new RuntimeException('Gemini API key not configured.');
        }

        $model = env('GEMINI_MODEL', 'gemini-2.0-flash');
        $url = sprintf(
            'https://generativelanguage.googleapis.com/v1beta/models/%s:generateContent?key=%s',
            $model,
            $apiKey
        );

        $response = Http::timeout(60)->acceptJson()->post($url, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $this->buildPrompt($data)],
                    ],
                ],
            ],
            'generationConfig' => [
                'temperature' => 0.8,
                'topP' => 0.95,
                'topK' => 64,
                'maxOutputTokens' => 2000,
                'responseMimeType' => 'application/json',
            ],
        ]);

        if ($response->failed()) {
            if ($response->status() === 429) {
                throw new RuntimeException('Gemini quota exceeded. Aktifkan billing atau gunakan API key/project lain yang masih punya quota.');
            }

            $error = $response->json('error.message') ?? $response->body();
            throw new RuntimeException('Gemini API Error: ' . $error);
        }

        $content = $response->json('candidates.0.content.parts.0.text');

        if (!is_string($content) || trim($content) === '') {
            throw new RuntimeException('Gemini API returned empty content.');
        }

        $generated = json_decode($content, true);

        if (!is_array($generated)) {
            throw new RuntimeException('Gemini API returned invalid JSON.');
        }

        return $generated;
    }

    private function buildPrompt(array $data): string
    {
        return <<<EOT
You are a professional sales copywriter. Generate a compelling sales page for the following product.

IMPORTANT: You MUST respond with ONLY a valid JSON object, no additional text, no markdown formatting, no code blocks.

Product Name: {$data['product_name']}
Description: {$data['description']}
Features: {$data['features']}
Target Audience: {$data['target_audience']}
Price: \${$data['price']}
Unique Selling Point: {$data['unique_selling_point']}

Return ONLY this JSON structure:
{
  "headline": "A compelling main headline (max 100 chars)",
  "subheadline": "An engaging subheadline (max 150 chars)",
  "benefits": "3-4 key benefits formatted as a list (max 500 chars)",
  "features_breakdown": "Detailed feature breakdown (max 1000 chars)",
  "social_proof": "Social proof and testimonial suggestions (max 300 chars)",
  "pricing_display": "Persuasive pricing copy (max 200 chars)",
  "call_to_action": "Compelling CTA text (max 100 chars)"
}
EOT;
    }

    private function buildSectionPrompt(SalesPage $salesPage, string $section): string
    {
        $sectionPrompts = [
            'headline' => "Create a compelling, conversion-focused headline for '{$salesPage->product_name}'. 
Product: {$salesPage->description}
Target Audience: {$salesPage->target_audience}
USP: {$salesPage->unique_selling_point}
Respond with JSON: {\"headline\": \"your headline here\"}",

            'subheadline' => "Create an engaging subheadline that complements this headline: '{$salesPage->headline}'
Product: {$salesPage->description}
Features: {$salesPage->features}
Respond with JSON: {\"subheadline\": \"your subheadline here\"}",

            'benefits' => "Generate 4 compelling benefits for '{$salesPage->product_name}'
Features: {$salesPage->features}
Target Audience: {$salesPage->target_audience}
USP: {$salesPage->unique_selling_point}
Respond with JSON: {\"benefits\": \"benefit1, benefit2, benefit3, benefit4\"}",

            'features_breakdown' => "Write a detailed feature breakdown for '{$salesPage->product_name}'
Features: {$salesPage->features}
Description: {$salesPage->description}
Respond with JSON: {\"features_breakdown\": \"detailed paragraph here\"}",

            'social_proof' => "Create social proof and testimonial for '{$salesPage->product_name}'
Target Audience: {$salesPage->target_audience}
USP: {$salesPage->unique_selling_point}
Respond with JSON: {\"social_proof\": \"testimonial here\"}",

            'pricing_display' => "Create persuasive pricing copy for \${$salesPage->price} for '{$salesPage->product_name}'
USP: {$salesPage->unique_selling_point}
Target Audience: {$salesPage->target_audience}
Respond with JSON: {\"pricing_display\": \"pricing copy here\"}",

            'call_to_action' => "Create a compelling call-to-action for '{$salesPage->product_name}'
USP: {$salesPage->unique_selling_point}
Price: \${$salesPage->price}
Respond with JSON: {\"call_to_action\": \"CTA text here\"}"
        ];

        return $sectionPrompts[$section] ?? "Regenerate this section for {$salesPage->product_name}";
    }
}
