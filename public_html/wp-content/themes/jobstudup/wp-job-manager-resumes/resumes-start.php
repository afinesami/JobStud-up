<!-- Listings Loader -->
<div class="listings-loader">
                <div class="spinner">
                  <div class="double-bounce1"></div>
                  <div class="double-bounce2"></div>
                </div>
            </div>
<?php $layout = Kirki::get_option( 'workscout', 'pp_resume_old_layout', false );  ?>

<ul class="resumes <?php if(!$layout) { ?>alternative<?php } ?>">