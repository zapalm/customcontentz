{**
 * Custom contents: module for PrestaShop 1.5-1.6
 *
 * @author    zapalm <zapalm@ya.ru>
 * @copyright 2011-2016 zapalm
 * @link      http://prestashop.modulez.ru/en/ The module's homepage
 * @license   http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 **}

<!-- MODULE: customcontentz -->
{if $place == 'home'}
	<div class="customcontentz-home">
		{$CUSTOMCONTENTZ_HOME_TEXT}
	</div>
{elseif $place == 'top'}
	<div class="customcontentz-top col-lg-12">
		{$CUSTOMCONTENTZ_TOP_TEXT}
	</div>
{elseif $place == 'footer'}
	<div class="customcontentz-category-footer col-lg-12">
		{$CUSTOMCONTENTZ_CAT_FOOTER_TEXT}
	</div>
{/if}
<!-- /MODULE: customcontentz -->
