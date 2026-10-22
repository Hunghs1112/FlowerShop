<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Mystery Box — editable content (admin can override the English version)
    |--------------------------------------------------------------------------
    | Used by MysteryBoxContentService and the mystery-box/* views.
    */

    'content' => [
        'hero_title' => 'Mystery Flower Box',
        'breadcrumb_home' => 'Home',
        'breadcrumb_mystery' => 'Mystery Flower Box',
        'hero_description' => 'Let LNT pick the flowers, you keep the surprise',
        'intro_title' => 'Discover The Unexpected',
        'intro_description' => 'Tell us a few of your preferences and LNT will prepare a truly special flower box just for you.',
        'step_labels' => ['Style', 'Color', 'Preferences', 'Budget', 'Surprise', 'Note', 'Confirm'],
        'style_title' => 'Choose A Style',
        'styles' => ['Elegant', 'Romantic', 'Natural', 'Minimal', 'Luxurious'],
        'color_title' => 'Choose Colors (you may pick several)',
        'colors' => ['White', 'Cream', 'Pink', 'Green', 'Red', 'Pastel', 'No limit'],
        'preference_title' => 'Flower Preferences',
        'preferences' => ['Lots of flowers', 'Few flowers', 'Lots of greenery', 'Gentle', 'Bold', 'Natural'],
        'budget_title' => 'Budget',
        'budgets' => [
            ['value' => '500k-1M', 'label' => '500,000đ - 1,000,000đ'],
            ['value' => '1M-2M', 'label' => '1,000,000đ - 2,000,000đ'],
            ['value' => '2M-5M', 'label' => '2,000,000đ - 5,000,000đ'],
            ['value' => '5M+', 'label' => 'Over 5,000,000đ'],
        ],
        'surprise_title' => 'Level of Surprise',
        'surprise_levels' => ['Completely surprising', 'Partly surprising', 'Keep some of my requests'],
        'note_title' => 'Note',
        'name_label' => 'Full name',
        'phone_label' => 'Phone number',
        'email_label' => 'Email (optional)',
        'request_label' => 'Special request',
        'request_placeholder' => 'For example: no lilies, deliver in the morning...',
        'confirm_title' => 'Confirm Mystery Box',
        'selected_info_title' => 'Your Selection',
        'style_summary_label' => 'Style:',
        'color_summary_label' => 'Palette:',
        'preference_summary_label' => 'Preferences:',
        'budget_summary_label' => 'Budget:',
        'surprise_summary_label' => 'Level of surprise:',
        'disclaimer' => 'Every Mystery Box is a unique design. The actual flowers may change with the season but always stay true to the spirit and budget you chose.',
        'success_page_title' => 'Request Submitted',
        'success_page_description' => 'Thank you for trusting LNT',
        'success_title' => 'We Have Your Request',
        'success_request_id_label' => 'Request ID:',
        'success_message' => 'LNT will check the flowers and confirm with you before preparing the order.',
        'success_contact_message' => 'We will contact you via your phone number',
        'success_summary_title' => 'Request Details',
        'success_style_label' => 'Style',
        'success_color_label' => 'Palette',
        'success_preference_label' => 'Preferences',
        'success_budget_label' => 'Budget',
        'success_surprise_label' => 'Level of surprise',
        'success_note_label' => 'Note',
        'success_home_label' => 'Back to home',
        'previous_label' => 'Previous',
        'next_label' => 'Next',
        'submit_label' => 'Confirm request',
    ],

    /*
    |--------------------------------------------------------------------------
    | Mystery Box — interface strings & JavaScript
    |--------------------------------------------------------------------------
    */

    'ui' => [
        'page_title' => 'Mystery flower box · Lam Nhiên Thảo',
        'hero_title' => 'Mystery flower box',
        'hero_lead' => 'Eight items are hiding in the secret room. Each one holds something you want to send with the flower box: color tone, flower type, style, preferences… Find them all, then use the final key to lock the room back up.',
        'hint_button' => '💡 Hint',
        'reveal_button' => 'Reveal all items',
        'seal_button' => 'Seal & send flower box',
        'aria_secret_room' => 'The secret room. Find the 6 hidden items.',
        'aria_hidden_item' => 'Hidden item',
        'aria_items_list' => 'Items to find',
        'privacy_note' => 'Delivery details are used only to process your order',
        'flowers' => ['Sample bouquet', 'Tulip', 'Baby\'s breath', 'Ecuadorian rose', 'Protea', 'Phalaenopsis', 'Carnation', 'Malaysian chrysanthemum', 'Lily', 'No preference'],

        'fields' => [
            'color' => [
                'obj' => 'Color palette',
                'label' => 'Flower color tone',
                'help' => 'Pick up to 3 color tones you like.',
            ],
            'flower' => [
                'obj' => 'Botany book',
                'label' => 'Special flower type',
                'help' => 'A flower type you would love to find in the box, if available.',
            ],
            'style' => [
                'obj' => 'Picture frame',
                'label' => 'Style',
                'help' => 'What feeling should the flower box carry?',
            ],
            'interest' => [
                'obj' => 'Music record',
                'label' => 'Preferences',
                'help' => 'What does the recipient (or you) love? LNT will use that to choose the flowers and matching details.',
                'extra' => 'Tell us a bit more (optional)',
            ],
            'budget' => [
                'obj' => 'Piggy bank',
                'label' => 'Budget',
                'help' => 'Choose a budget range for the flower box.',
            ],
            'surprise' => [
                'obj' => 'Small gift box',
                'label' => 'Level of surprise',
                'help' => 'How surprising would you like it to be?',
            ],
            'note' => [
                'obj' => 'Notebook',
                'label' => 'Note',
                'help' => 'Pollen allergies, colors or flower types to avoid, the occasion, a note to include with the card…',
            ],
            'confirm' => [
                'obj' => 'The key',
                'label' => 'Confirm',
                'help' => 'Delivery details. The final key to lock the room.',
            ],
        ],

        'miss_messages' => ['Not here…', 'Try somewhere else', 'Hmm…'],
        'sealed_text' => 'Sealed ✓',
        'noted_text' => 'Noted ✓',
        'no_selection' => 'You have not chosen any preferences yet. LNT will create freely.',
        'tap_to_choose' => 'Tap to choose',
        'not_found' => 'Not found yet',
        'found_label' => 'Found, not selected yet.',
        'stored_label' => 'Saved.',
        'required_label' => 'required',
        'hint_label' => 'Not found yet, tap for a hint.',
        'hidden_item_aria' => 'Hidden item',

        'contact_name' => 'Full name *',
        'contact_phone' => 'Phone / Zalo *',
        'contact_address' => 'Delivery address *',
        'contact_date' => 'Preferred delivery date *',
        'contact_note' => 'Extra note (optional)',
        'contact_note_placeholder' => 'Pollen allergies, colors or flower types to avoid, the occasion, a note to include with the card…',
        'consent_text' => 'I have read the',
        'consent_link' => 'return and exchange policy',
        'consent_tail' => 'and agree that LNT may contact me to confirm the order.',

        'panel_kicker' => 'YOU FOUND IT',
        'later_button' => 'Later',
        'keep_button' => 'Save',
        'lock_button' => 'Lock the room',

        'err_max_items' => 'Select at most :max items.',
        'err_min_choice' => 'Please select at least one option.',
        'err_required_fields' => 'Please fill in all fields marked with *.',
        'err_invalid_phone' => 'That phone number does not look right.',
        'err_consent' => 'Please confirm you have read the policy.',
        'err_missing' => 'Still missing: :list. Find the matching item in the room.',

        'status_found' => 'Found :found/:total items · :filled saved',
        'status_ready' => ' · ready to seal',
        'err_send_failed' => 'Could not send the request.',
        'err_network' => 'Could not connect. Please try again.',
        'extra_note_prefix' => 'Extra preferences: ',
    ],

    /*
    |--------------------------------------------------------------------------
    | Mystery Box — success page
    |--------------------------------------------------------------------------
    */

    'success' => [
        'heading' => 'Request Submitted',
        'subheading' => 'Thank you for trusting LNT',
        'title' => 'We Have Your Request',
        'request_id_label' => 'Request ID:',
        'message' => 'LNT will check the flowers and confirm with you before preparing the order.',
        'contact_message' => 'We will contact you via your phone number',
        'summary_title' => 'Request Details',
        'style_label' => 'Style',
        'color_label' => 'Palette',
        'preference_label' => 'Preferences',
        'budget_label' => 'Budget',
        'surprise_label' => 'Level of surprise',
        'note_label' => 'Note',
        'home_label' => 'Back to home',
        'no_note' => 'None',
    ],
];
