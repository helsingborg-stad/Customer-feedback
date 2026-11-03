<?php

declare(strict_types=1);

namespace {
    // Minimal WordPress stubs so Form::getFormData() can run without WordPress.
    if (!function_exists('__')) {
        function __($text, $domain = 'default')
        {
            return $text;
        }
    }

    if (!function_exists('is_user_logged_in')) {
        function is_user_logged_in()
        {
            return false;
        }
    }

    if (!function_exists('get_terms')) {
        function get_terms($args = [])
        {
            return $GLOBALS['customerFeedbackTestTerms'] ?? [];
        }
    }
}

namespace CustomerFeedback {
    use PHPUnit\Framework\TestCase;

    /**
     * Ensures the data passed to the Blade views matches the types
     * expected by component-library (field and option components).
     */
    class FormTest extends TestCase
    {
        protected function setUp(): void
        {
            $GLOBALS['customerFeedbackTestTerms'] = [
                (object) ['term_id' => 12, 'name' => 'Topic A', 'description' => ''],
                (object) ['term_id' => 34, 'name' => 'Topic B', 'description' => 'Desc'],
            ];
        }

        protected function tearDown(): void
        {
            unset($GLOBALS['customerFeedbackTestTerms']);
        }

        public function testCommentHelperTextAndPlaceholderAreStrings(): void
        {
            $data = (new Form())->getFormData();

            $this->assertIsString($data['labels']->comment->explain);
            $this->assertIsString($data['labels']->comment->placeholder);
        }

        public function testEmailHelperTextAndPlaceholderAreStrings(): void
        {
            $data = (new Form())->getFormData();

            $this->assertIsString($data['labels']->email->explain);
            $this->assertIsString($data['labels']->email->placeholder);
        }

        public function testTopicValueIsStringVersionOfTermId(): void
        {
            $data = (new Form())->getFormData();

            $this->assertCount(2, $data['topics']);
            $this->assertSame('12', $data['topics'][0]->value);
            $this->assertSame('34', $data['topics'][1]->value);
        }

        public function testTopicIdIsKeptAsIntegerInJsonData(): void
        {
            $data = (new Form())->getFormData();
            $json = json_decode($data['jsonData'], true);

            $this->assertSame(12, $data['topics'][0]->id);
            $this->assertSame(12, $json['topics'][0]['id']);
        }

        public function testNoTopicsGivesEmptyList(): void
        {
            $GLOBALS['customerFeedbackTestTerms'] = [];

            $data = (new Form())->getFormData();

            $this->assertSame([], $data['topics']);
        }
    }
}
