<?php
require_once JPATH_ROOT.'/libraries/gapi/gapi.class.php';
require_once JPATH_ROOT.'/analytics.config.php';

$site = JFactory::getApplication()->getSite();
$gapi = new gapi($analytics['username'], $analytics['password']);
?>
<table class="adminlist">
    <tr>
        <td class="title">
            <strong><?php echo JText::_('Most Visited Pages') ?></strong>
        </td>
        <td class="title">
            <strong><?php echo JText::_('Total') ?></strong>
        </td>
        <td class="title">
            <strong><?php echo JText::_('Unique') ?></strong>
        </td>
        <td class="title">
            <strong><?php echo JText::_('Bounce') ?></strong>
        </td>
        <td class="title">
            <strong><?php echo JText::_('Exit') ?></strong>
        </td>
    </tr>
    <?php $gapi->requestReportData($analytics['profile_id'], 'pagePath', array('pageviews', 'uniquePageviews', 'visitBounceRate', 'exitRate'), '-pageviews', 'pagePath =~ \'^\/'.$site.'\/\'', date('Y-m-d', strtotime('yesterday -30 days')), date('Y-m-d', strtotime('yesterday')), null, 10) ?>
    <?php foreach(($results = $gapi->getResults()) as $result) : ?>
        <tr>
            <td>
                <?php $link = $result->getPagePath() ?>
                <a href="http://www.lokalepolitie.be<?php echo $link ?>">
                    <?php echo htmlspecialchars(substr($link, strlen($site) + 1)) ?>
                </a>
            </td>
            <td>
                <?php echo $result->getPageviews() ?>
            </td>
            <td>
                <?php echo $result->getUniquePageviews() ?>
            </td>
            <td>
                <?php echo number_format(round($result->getVisitBounceRate(), 1), 1).'%' ?>
            </td>
            <td>
                <?php echo number_format(round($result->getExitRate(), 1), 1).'%' ?>
            </td>
        </tr>
    <?php endforeach ?>
</table>
<?php $gapi->requestReportData($analytics['profile_id'], '', array('pageviews', 'uniquePageviews'), null, 'pagePath =~ \'^\/'.$site.'\/\'', date('Y-m-d', strtotime('yesterday -30 days')), date('Y-m-d', strtotime('yesterday'))) ?>
<?php $results = $gapi->getResults() ?>

<div style="padding: 4px">
    <div style="padding: 3px; float: right; font-style: italic;"><?php echo JText::_('Based on the last 30 days.') ?></div>
    <div style="padding: 3px"><?php echo JText::_('Total pageviews: ').$results[0]->getPageviews() ?></div>
    <div style="padding: 3px"><?php echo JText::_('Total unique pageviews: ').$results[0]->getUniquePageviews() ?></div>
</div>