<?php defined('SYSPATH') or die('No direct script access.'); ?>

<?php echo View::factory('includes/search'); ?>

<div id="cse-search-results"></div>
<script type="text/javascript">
  var googleSearchIframeName = 'cse-search-results';
  var googleSearchFormName = 'cse-search-box';
  var googleSearchFrameWidth = 600;
  var googleSearchDomain = 'www.google.com';
  var googleSearchPath = '/cse';
</script>
<script type="text/javascript" src="http://www.google.com/afsonline/show_afs_search.js"></script>
