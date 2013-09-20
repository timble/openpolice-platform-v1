<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<?php
    $account = str_replace('@', '', $params->get('account', ''));
?>

<a class="twitter-timeline" width="200" href="https://twitter.com/<?php echo $account ?>" data-screen-name="<?php echo $account ?>" data-widget-id="344729335502086144" data-tweet-limit="1" data-chrome="noheader nofooter transparent">Tweets by @<?php echo $account ?></a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>


<p><?php echo JText::_( 'Follow us on' ); ?> <a href="http://twitter.com/<?php echo $account ?>">twitter.com/<?php echo $account ?></a></p>