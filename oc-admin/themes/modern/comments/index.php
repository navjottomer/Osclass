<?php if ( ! defined('OC_ADMIN')) {
    exit('Direct access is not allowed.');
}
/*
 * Copyright 2014 Osclass
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

function addHelp()
{
    echo '<p>' . __('Manage the comments that users publish on the listings on your site. You can also edit, delete, activate or block comments.') . '</p>';
}
    osc_add_hook('help_box', 'addHelp');

function customPageHeader()
{
    ?>
        <h1><?php _e('Listing'); ?>
            <a href="<?php echo osc_admin_base_url(true) . '?page=settings&action=comments'; ?>" class="btn ico ico-32 ico-engine float-right"><?php _e('Settings'); ?></a>
            <a href="#" class="btn ico ico-32 ico-help float-right"></a>
        </h1>
    <?php
}
    osc_add_hook('admin_page_header', 'customPageHeader');

function customPageTitle($string)
{
    return sprintf(__('Comments &raquo; %s'), $string);
}
    osc_add_filter('admin_title', 'customPageTitle');

    //customize Head
function customHead()
{
    ?>
        <script type="text/javascript">
            // autocomplete users
            $(document).ready(function(){
                // check_all bulkactions
                $("#check_all").change(function(){
                    var isChecked = $(this).prop("checked");
                    $('.col-bulkactions input').each( function() {
                        if( isChecked == 1 ) {
                            this.checked = true;
                        } else {
                            this.checked = false;
                        }
                    });
                });

                // dialog delete
                $("#dialog-comment-delete").dialog({
                    autoOpen: false,
                    modal: true
                });

                // dialog bulk actions
                $("#dialog-bulk-actions").dialog({
                    autoOpen: false,
                    modal: true
                });
                $("#bulk-actions-submit").click(function() {
                    $("#datatablesForm").submit();
                });
                $("#bulk-actions-cancel").click(function() {
                    $("#datatablesForm").attr('data-dialog-open', 'false');
                    $('#dialog-bulk-actions').dialog('close');
                });
                // dialog bulk actions function
                $("#datatablesForm").submit(function() {
                    if( $("#bulk_actions option:selected").val() == "" ) {
                        return false;
                    }

                    if( $("#datatablesForm").attr('data-dialog-open') == "true" ) {
                        return true;
                    }

                    $("#dialog-bulk-actions .form-row").html($("#bulk_actions option:selected").attr('data-dialog-content'));
                    $("#bulk-actions-submit").html($("#bulk_actions option:selected").text());
                    $("#datatablesForm").attr('data-dialog-open', 'true');
                    $("#dialog-bulk-actions").dialog('open');
                    return false;
                });
                // /dialog bulk actions
            });

            // dialog delete function
            function delete_dialog(item_id) {
                $("#dialog-comment-delete input[name='id']").attr('value', item_id);
                $("#dialog-comment-delete").dialog('open');
                return false;
            }
        </script>
        <?php
}
    osc_add_hook('admin_header', 'customHead', 10);

    $aData      = __get('aData');
    $aRawRows   = __get('aRawRows');
    $sort       = Params::getParam('sort');
    $direction  = Params::getParam('direction');

    $columns    = $aData['aColumns'];
    $rows       = $aData['aRows'];

    osc_current_admin_theme_path( 'parts/header.php' ); ?>
<h2 class="render-title"><?php _e('Comments'); ?></h2>
<div class="relative">
    <div id="listing-toolbar">
        <div class="float-right">
            <?php if (Params::getParam('showAll') != 'off') { ?>
            <a href="<?php echo osc_admin_base_url(true) . '?page=comments&showAll=off'; ?>" class="btn btn-red"><?php _e('Hidden comments');?></a>
            <?php } else { ?>
            <a href="<?php echo osc_admin_base_url(true) . '?page=comments'; ?>" class="btn btn-blue"><?php _e('All comments');?></a>
            <?php } ?>
        </div>
    </div>
    <form class="" id="datatablesForm" action="<?php echo osc_admin_base_url(true); ?>" method="post" data-dialog-open="false">
        <input type="hidden" name="page" value="comments" />
        <input type="hidden" name="action" value="bulk_actions" />
        <div id="bulk-actions">
            <label>
                <?php osc_print_bulk_actions('bulk_actions', 'bulk_actions', __get('bulk_options'), 'select-box-extra'); ?>
                <input type="submit" id="bulk_apply" class="btn" value="<?php echo osc_esc_html( __('Apply') ); ?>" />
            </label>
        </div>
        <div class="table-contains-actions">
            <table class="table" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <?php foreach ($columns as $k => $v) {
                            echo '<th class="col-'.$k.' '.($sort==$k?($direction=='desc'?'sorting_desc':'sorting_asc'):'').'">'.$v.'</th>';
                        }; ?>
                    </tr>
                </thead>
                <tbody>
                <?php if ( count($rows) > 0 ) { ?>
                    <?php foreach ($rows as $key => $row) { ?>
                        <tr class="<?php echo implode(' ', osc_apply_filter('datatable_comment_class', array(), $aRawRows[$key], $row)); ?>">
                            <?php foreach ($row as $k => $v) { ?>
                                <td class="col-<?php echo $k; ?>"><?php echo $v; ?></td>
                            <?php }; ?>
                        </tr>
                    <?php }; ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="6" class="text-center">
                        <p><?php _e('No data available in table'); ?></p>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <div id="table-row-actions"></div><!-- used for table actions -->
        </div>
    </form>
</div>
<?php
function showingResults()
{
    $aData = __get('aData');
    echo '<ul class="showing-results"><li><span>'.osc_pagination_showing((Params::getParam('iPage')-1)*$aData['iDisplayLength']+1, ((Params::getParam('iPage')-1)*$aData['iDisplayLength'])+count($aData['aRows']), $aData['iTotalDisplayRecords'], $aData['iTotalRecords']).'</span></li></ul>';
}
    osc_add_hook('before_show_pagination_admin', 'showingResults');
    osc_show_pagination_admin($aData);
?>
<form id="dialog-comment-delete" method="get" action="<?php echo osc_admin_base_url(true); ?>" class="has-form-actions hide" title="<?php echo osc_esc_html(__('Delete comment')); ?>">
    <input type="hidden" name="page" value="comments" />
    <input type="hidden" name="action" value="delete" />
    <input type="hidden" name="id" value="" />
    <div class="form-horizontal">
        <div class="form-row">
            <?php _e('Are you sure you want to delete this comment?'); ?>
        </div>
        <div class="form-actions">
            <div class="wrapper">
            <a class="btn" href="javascript:void(0);" onclick="$('#dialog-comment-delete').dialog('close');"><?php _e('Cancel'); ?></a>
            <input id="comment-delete-submit" type="submit" value="<?php echo osc_esc_html( __('Delete') ); ?>" class="btn btn-red" />
            </div>
        </div>
    </div>
</form>
<div id="dialog-bulk-actions" title="<?php _e('Bulk actions'); ?>" class="has-form-actions hide">
    <div class="form-horizontal">
        <div class="form-row"></div>
        <div class="form-actions">
            <div class="wrapper">
                <a id="bulk-actions-cancel" class="btn" href="javascript:void(0);"><?php _e('Cancel'); ?></a>
                <a id="bulk-actions-submit" href="javascript:void(0);" class="btn btn-red" ><?php echo osc_esc_html( __('Delete') ); ?></a>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
<?php osc_current_admin_theme_path( 'parts/footer.php' ); ?>
