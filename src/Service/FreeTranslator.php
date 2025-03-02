<?php

namespace App\Service;

use Stichoza\GoogleTranslate\GoogleTranslate;

class FreeTranslator
{
    private GoogleTranslate $translator;
    
    public function __construct()
    {
        $this->translator = new GoogleTranslate();
        $this->translator->setSource('fr'); // Default source: French
        $this->translator->setUrl('http://translate.google.com/translate_a/single');
    }

    public function translateToArabic(string $text): string
    {
        try {
            return $this->translator->setTarget('ar')->translate($text);
        } catch (\Throwable $e) {
            return $text; // Return original text on failure
        }
    }
}