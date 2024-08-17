<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

error_reporting(error_reporting() & ~E_USER_DEPRECATED);
class FeatureContext implements Context
{
	private ?Response $res = null;

	private string $userAgent = 'BehatTester';

	/**
	 * This needs to be something that is NOT restricted to private use!
	 */
	private string $ipAddress = '1.2.3.4';

	/**
	 * @var string[]
	 */
	private array $output = [];

	private static string $themePath = '';
	/**
	 * Initializes context.
	 *
	 * Every scenario gets its own context instance.
	 * You can also pass arbitrary arguments to the
	 * context constructor through behat.yml.
	 *
	 * @BeforeSuite
	 */
	public static function beforeSuite()
	{
		passthru('wp --allow-root core version');
		exec('wp --allow-root config create --dbname=wordpress --dbuser=root --dbpass=wppasswd --dbhost=db');
		exec('wp --allow-root core install --url=localhost --title=Example --admin_user=localadmin --admin_password=P@ssw0rd --admin_email=info@example.com');
		exec('wp --allow-root plugin is-active defai', $response, $code);
		if ($code !== 0) {
			exec('wp --allow-root plugin activate defai');
		}
		exec('wp --allow-root theme list | grep -E "\Wactive" | awk \'{ print $1; }\'', $result);
		var_dump($result);
		exec ('wp --allow-root theme path ' . $result[0] . ' --dir', $output, $code);
		self::$themePath = $output[0];
	}

	public function __construct()
	{
		file_put_contents(self::$themePath . '/functions.php', <<<'EOF'
			<?php add_filter( 'admin_email_check_interval', '__return_false' );
			EOF);
	}

	/**
	 * @Given a useragent of :arg1
	 */
	public function aUseragentOf(string $arg1)
	{
		$this->userAgent = $arg1;
	}

	/**
	 * @When the main website is called
	 */
	public function theMainWebsiteIsCalled()
	{
		exec(sprintf(
			'curl -I -H "User-Agent: %1$s", -H "X-Forwarded-For: %2$s" http://nginx/',
			$this->userAgent,
			$this->ipAddress
		), $output, $code);
		var_dump($output);
		$this->output = $output;
	}

	/**
	 * @Then the respose is a redirect to :arg1
	 */
	public function theResposeIsARedirectTo($arg1)
	{
		foreach ($this->output as $line) {
			if (! preg_match('/location: (.*)/i', $line, $matches)) {
				continue;
			}

			Assert::eq($matches[1], $arg1);
			return;
		}

		Assert::true(false, 'Expected a redirect response.');
	}
}
