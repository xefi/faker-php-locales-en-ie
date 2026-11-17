<?php

namespace Xefi\Faker\EnIe\Extensions;

use Xefi\Faker\Extensions\TextExtension as BaseTextExtension;

class TextExtension extends BaseTextExtension
{
    /**
     * The extension locale.
     *
     * @return string|null
     */
    public function getLocale(): ?string
    {
        return 'en_IE';
    }

    protected array $paragraphs = [
        [
            ['Every', 'organisation', 'needs', 'a', 'clear', 'plan', 'and', 'a', 'good', 'sense', 'of', 'humour.'],
            ['Teams', 'in', 'every', 'county', 'share', 'their', 'progress', 'at', 'the', 'end', 'of', 'the', 'month.'],
            ['Good', 'communication', 'keeps', 'regional', 'offices', 'close', 'to', 'head', 'office', 'in', 'the', 'city.'],
            ['Neighbours', 'and', 'partners', 'work', 'together', 'to', 'strengthen', 'local', 'communities.'],
        ],
        [
            ['The', 'service', 'centre', 'answers', 'queries', 'from', 'customers', 'all', 'over', 'the', 'country.'],
            ['Staff', 'analyse', 'feedback', 'carefully', 'before', 'changing', 'any', 'procedure.'],
            ['Small', 'improvements', 'to', 'daily', 'routines', 'often', 'make', 'the', 'biggest', 'difference.'],
            ['The', 'programme', 'is', 'reviewed', 'every', 'spring', 'to', 'reflect', 'new', 'needs.'],
        ],
        [
            ['Labour', 'costs', 'and', 'travel', 'expenses', 'are', 'reviewed', 'every', 'quarter.'],
            ['Suppliers', 'are', 'chosen', 'for', 'their', 'reliability', 'as', 'much', 'as', 'their', 'price.'],
            ['Managers', 'make', 'safety', 'their', 'first', 'priority', 'whatever', 'the', 'weather.'],
            ['Each', 'new', 'licence', 'is', 'recorded', 'in', 'the', 'central', 'catalogue.'],
        ],
        [
            ['Training', 'helps', 'employees', 'develop', 'skills', 'that', 'last', 'a', 'whole', 'career.'],
            ['Mentors', 'encourage', 'graduates', 'to', 'ask', 'questions', 'and', 'take', 'initiative.'],
            ['Flexible', 'arrangements', 'let', 'people', 'balance', 'work', 'with', 'family', 'and', 'sport.'],
            ['Positive', 'behaviour', 'is', 'recognised', 'and', 'celebrated', 'by', 'the', 'whole', 'team.'],
        ],
        [
            ['Reliable', 'data', 'supports', 'better', 'decisions', 'and', 'clearer', 'priorities.'],
            ['Targets', 'are', 'adjusted', 'when', 'market', 'conditions', 'change.'],
            ['Regular', 'reviews', 'make', 'it', 'easier', 'to', 'respond', 'to', 'new', 'challenges.'],
            ['Customers', 'value', 'honest', 'advice', 'and', 'a', 'friendly', 'chat.'],
            ['Sustainable', 'growth', 'depends', 'on', 'steady', 'and', 'careful', 'progress.'],
        ],
    ];
}
