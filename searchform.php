<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Yuriy
 * Date: 12/2/12
 * Time: 9:31 PM
 */
?>
<form role="search" method="get" id="searchform" action="<?php esc_url( home_url( '/' ) ) ?>">
    <div>
        <input type="text"  value="<?php get_search_query() ?>" value placeholder="Search" name="s" id="s" />
        <input type="submit" id="searchsubmit" value="" title="Search"/>
    </div>
</form>

