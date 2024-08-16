<?php
/**
 * defAI
 *
 * Provide dedicated Content for AI bots.
 *
 * Whether that is random content, a Redirect to another website
 * or just some specific site that you provide is up to you.
 *
 * @package           defai
 * @author            Andreas Heigl
 * @copyright         2024 stella-maris.solutions
 * @license           GPL-3.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       defAI
 * Plugin URI:        https://defai.volkswAIgen.org
 * Description:       Provide dedicated content just for AI bots.
 * Version:           %tag%
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Andreas Heigl
 * Author URI:        https://andreas.heigl.org
 * Text Domain:       defai
 * License:           GPL v3 or later
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 */
if ( ! defined( 'ABSPATH' ) ) exit;

require __DIR__ . '/vendor/autoload.php';


$defai = new \VolkswAIgen\DefAI\DefAI();
$defai->init();
