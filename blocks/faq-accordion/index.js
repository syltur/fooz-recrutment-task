/**
 * Task 5: FAQ Accordion Block - Editor Script
 * 
 * Uses InnerBlocks for adding multiple Q&A items
 * Editable title above the accordion
 */
(function (wp) {
    var registerBlockType = wp.blocks.registerBlockType;
    var createElement = wp.element.createElement;
    var useBlockProps = wp.blockEditor.useBlockProps;
    var InnerBlocks = wp.blockEditor.InnerBlocks;
    var RichText = wp.blockEditor.RichText;
    var __ = wp.i18n.__;

    // Template: Heading (question) + Paragraph (answer)
    var FAQ_TEMPLATE = [
        ['core/heading', { level: 4, placeholder: 'Question...' }],
        ['core/paragraph', { placeholder: 'Answer...' }],
    ];

    registerBlockType('fooz/faq-accordion', {
        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            var blockProps = useBlockProps({
                className: 'fooz-faq-editor-wrapper'
            });

            return createElement('div', blockProps,
                // Editable title above accordion
                createElement(RichText, {
                    tagName: 'h2',
                    className: 'faq-main-title',
                    value: attributes.title,
                    onChange: function (title) {
                        setAttributes({ title: title });
                    },
                    placeholder: __('Enter FAQ title...', 'fooz')
                }),
                // InnerBlocks area for Q&A items
                createElement('div', {
                    className: 'faq-inner-blocks-area',
                    style: { border: '1px dashed #ccc', padding: '20px' }
                },
                    createElement(InnerBlocks, {
                        template: FAQ_TEMPLATE,
                        templateLock: false
                    })
                )
            );
        },
        save: function () {
            return createElement(InnerBlocks.Content);
        }
    });
})(window.wp);
