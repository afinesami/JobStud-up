<?php

/**
* Dropcap shortcode type = full
* Usage: [dropcap color="gray"] [/dropcap]// margin-down margin-both
*/

function workscout_dropcap($atts, $content = null) {
    extract(shortcode_atts(array(
        'type'=>''), $atts));
    return '<span class="dropcap '.$type.'">'.$content.'</span>';
}

?>