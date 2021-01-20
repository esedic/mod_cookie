<?php
/**
 * @package    mod_cookies
 *
 * @author     Elvis Sedić info@spletodrom.si
 * @copyright  Spletodrom
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://www.spletodrom.si
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\HTML\HTMLHelper;

HTMLHelper::_('jquery.framework');

$doc = Factory::getDocument();
$doc->addStyleSheet(Uri::root() . "modules/mod_cookies/assets/gdpr-cookie.css");
$doc->addScript("modules/mod_cookies/assets/gdpr-cookie.min.js");
$doc->addScriptDeclaration("

    jQuery.gdprcookie.init({
        cookieTypes: [{
            type: 'Obvezni piškotki',
            value: 'essential',
            description: 'Brez obveznih piškotkov stran ne more delovati. Onemogoči se jih lahko samo v nastavitvah vašega brskalnika.',
            checked: true,
        }, {
            type: 'Analitika',
            value: 'analytics',
            description: 'S pomočjo analitičnih piškotkov zbiramo podatke o uporabi spletne strani za namene statistike in izboljšave uporabniške izkušnje.',
            checked: true,
        }],
        title: 'Ta spletna stran uporablja piškotke',
        message: 'Nekateri piškotki so obvezni za delovanje strani, nekateri piškoti pa nam pomagajo zagotavljati  boljšo uporabniško izkušnjo prek vpogleda, kako uporabniki uporabljajo spletno stran. <a href=\"https://www.lassana.si/slo/piskotki\">Več o uporabi piškotkov na lassana.si</a>',
        delay: 600,
        expires: 1,
        acceptBtnLabel: 'Sprejmi',
        advancedBtnLabel: 'Prilagodi',
        subtitle: 'Izberi dovoljene piškotke',
    });

    jQuery(document.body)
        .on('gdpr:show', function() {
            console.log('Cookie dialog is shown');
        })
        .on('gdpr:accept', function() {
            var preferences = jQuery.gdprcookie.preference();
            console.log('Preferences saved:', preferences);
            console.log();
        })
        .on('gdpr:advanced', function() {
            console.log('Advanced button was pressed');
        });

        if (jQuery.gdprcookie.preference('analytics') === true) {
            console.log('This should run because analytics is accepted.');

            var gaScript = document.createElement('script');
            gaScript.src = 'https://www.googletagmanager.com/gtag/js?id=UA-XXXXXXXXX-X';
            document.getElementsByTagName('head')[0].appendChild(gaScript);

            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-XXXXXXXXX-X');
        }

        if (jQuery.gdprcookie.preference('essential') === true) {
            console.log('This should run because essential is accepted.');
        }
");