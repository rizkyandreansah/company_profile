<?php

if (!function_exists('formatNewsContent')) {
    /**
     * Format news content with proper HTML formatting
     * 
     * @param string $content
     * @return string
     */
    function formatNewsContent($content)
    {
        // Escape HTML first for security
        $content = e($content);
        
        // Handle headers (## Header becomes <h4>)
        $content = preg_replace('/^## (.+)$/m', '<h4>$1</h4>', $content);
        $content = preg_replace('/^# (.+)$/m', '<h3>$1</h3>', $content);
        
        // Convert **text** to <strong>text</strong> for bold
        $content = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $content);
        
        // Convert __text__ to <em>text</em> for italic
        $content = preg_replace('/__(.*?)__/', '<em>$1</em>', $content);
        
        // Split content by double line breaks for paragraphs
        $paragraphs = preg_split('/(\r?\n){2,}/', $content);
        
        $formattedContent = '';
        foreach ($paragraphs as $paragraph) {
            $paragraph = trim($paragraph);
            if (!empty($paragraph)) {
                // Check if it's already a header
                if (preg_match('/^<h[3-6]>/', $paragraph)) {
                    $formattedContent .= $paragraph . "\n";
                } else {
                    // Convert single line breaks to <br> within paragraphs
                    $paragraph = str_replace(["\r\n", "\r", "\n"], '<br>', $paragraph);
                    $formattedContent .= '<p>' . $paragraph . '</p>' . "\n";
                }
            }
        }
        
        return $formattedContent;
    }
}

if (!function_exists('truncateText')) {
    /**
     * Truncate text to specified length
     * 
     * @param string $text
     * @param int $length
     * @param string $suffix
     * @return string
     */
    function truncateText($text, $length = 150, $suffix = '...')
    {
        if (strlen($text) <= $length) {
            return $text;
        }
        
        return substr($text, 0, $length) . $suffix;
    }
}