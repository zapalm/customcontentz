{**
 * Custom contents: module for PrestaShop 1.2-1.6
 *
 * @author    zapalm <zapalm@ya.ru>
 * @copyright 2011-2016 zapalm
 * @link      http://prestashop.modulez.ru/en/ The module's homepage
 * @license   http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 **}

<!-- MODULE: customcontentz -->
{literal}
	<STYLE TYPE="text/css">
		<!--
		.customcontentz-top {

		}
		.customcontentz-home {

		}
		.customcontentz-category-footer {

		}
		-->
	</STYLE>
{/literal}

{if $place == 'home'}
	<div class="customcontentz-home">
		{$CUSTOMCONTENTZ_HOME_TEXT}
	</div>
{elseif $place == 'top'}
	<div class="customcontentz-top">
		{$CUSTOMCONTENTZ_TOP_TEXT}
	</div>
{elseif $place == 'footer'}
	<div class="customcontentz-category-footer">
		{$CUSTOMCONTENTZ_CAT_FOOTER_TEXT}
	</div>
{/if}
<!-- /MODULE: customcontentz -->
