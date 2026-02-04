<?php
/**
 * Task 5: FAQ Accordion Block - Server-side Render
 * 
 * Outputs the block wrapper with title and content container
 * JavaScript (view.js) transforms headings/paragraphs into accordion structure
 */
$wrapper_attributes = get_block_wrapper_attributes([
    'class' => 'fooz-faq-wrapper'
]);

$title = isset($attributes['title']) ? esc_html($attributes['title']) : __('FAQ', 'fooz');
?>

<div <?php echo $wrapper_attributes; ?>>
    <h2 class="faq-main-title">
        <?php echo $title; ?>
    </h2>
    <div class="faq-items-container">
        <?php echo wp_kses_post($content); ?>
    </div>
</div>