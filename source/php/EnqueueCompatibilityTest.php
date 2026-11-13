<?php

namespace {
    if (!function_exists('__')) {
        function __($text, $domain = 'default')
        {
            return $text;
        }
    }
}

namespace CustomerFeedback\Tests {
    use CustomerFeedback\App;
    use PHPUnit\Framework\TestCase;
    use WpService\Implementations\FakeWpService;
    use WpUtilService\WpUtilService;

    class EnqueueCompatibilityTest extends TestCase
    {
        public function testFeedbackAssetsAreEnqueuedWithWpService(): void
        {
            $wp = new FakeWpService([
                'pluginsUrl' => 'https://example.test/wp-content/plugins/customer-feedback',
                'wpRegisterScript' => true,
                'wpRegisterStyle' => true,
                'wpLocalizeScript' => true,
                'addFilter' => true,
            ]);
            $manager = (new WpUtilService($wp))->enqueue('/var/www/wp-content/plugins/customer-feedback', cacheBust: false);
            $reflection = new \ReflectionClass(App::class);
            $app = $reflection->newInstanceWithoutConstructor();
            $reflection->getProperty('wpEnqueue')->setValue($app, $manager);

            $app->enqueueScripts();
            $app->adminEnqueue();

            self::assertSame('js-customer-feedbackjs', $wp->methodCalls['wpRegisterScript'][0][0]);
            self::assertSame('js-customer-feedbackjs', $wp->methodCalls['wpEnqueueScript'][0][0]);
            self::assertSame('feedback', $wp->methodCalls['wpLocalizeScript'][0][1]);
            self::assertCount(3, $wp->methodCalls['wpLocalizeScript'][0][2]);
            self::assertCount(2, $wp->methodCalls['wpRegisterStyle']);
            self::assertCount(2, $wp->methodCalls['wpEnqueueStyle']);
        }
    }
}
