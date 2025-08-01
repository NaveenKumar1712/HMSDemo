<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-2">
                <?php
$this->load->view('admin/referral/referralSidebar');
?>
            </div>
            <div class="col-md-10"> 
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line("referral_category_list"); ?></h3>
                        <div class="box-tools pull-right">
                            <?php if ($this->rbac->hasPrivilege('referral_category', 'can_add')) { ?>
                                <a data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-sm addcategory"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add_referral_category'); ?></a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped table-bordered example">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('name'); ?></th>
                                        <?php if ($this->rbac->hasPrivilege('referral_category', 'can_edit') || $this->rbac->hasPrivilege('referral_category', 'can_delete')) { ?>
                                            <th class="text-right noExport"><?php echo $this->lang->line('action'); ?></th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if (empty($category)) {
                                    ?>
                                    <?php
                                        } else {
                                        foreach ($category as $key => $value) {
                                    ?>
                                            <tr>
                                                <td class="mailbox-name">
                                                    <a href="#" data-toggle="popover" class="detail_popover"><?php echo $value['name'] ?></a>

                                                </td>
                                                <td class="mailbox-date pull-right">
                                                    <?php if ($this->rbac->hasPrivilege('referral_category', 'can_edit')) { ?>
                                                        <a href="#" onclick="getRecord('<?php echo $value['id'] ?>')" class="btn btn-default btn-xs" data-target="#myModalEdit" data-toggle="tooltip" title="" data-original-title="<?php echo $this->lang->line('edit'); ?>">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    <?php } if ($this->rbac->hasPrivilege('referral_category', 'can_delete')) { ?>
                                                        <a  class="btn btn-default btn-xs" data-toggle="tooltip" title="" onclick="delete_referral('<?php echo $value['id']; ?>')" data-original-title="<?php echo $this->lang->line('delete') ?>">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php
}
}
?>
                                </tbody>
                            </table><!-- /.table -->
                        </div><!-- /.mail-box-messages -->
                    </div><!-- /.box-body -->
                </div>
            </div><!--/.col (left) -->
            <!-- right column -->
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm400" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line("add_category"); ?></h4>
            </div>
            <form id="addcategory" class="ptt10" method="post" accept-charset="utf-8" enctype="multipart/form-data">   
                <div class="modal-body pt0 pb0">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('name'); ?></label>
                        <span class="req"> *</span>
                        <input  name="name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('name'); ?>" />
                    </div>
                </div>    
                <div class="modal-footer">
                    <div class="pull-right">
                        <button type="submit" id="addcategorybtn" data-loading-text="<?php echo $this->lang->line('processing'); ?>" class="btn btn-info"><?php echo $this->lang->line('save'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
$data = $this->session->userdata('hospitaladmin');
$api_base_url = $this->config->item('api_base_url');
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#addcategory').on('submit', function(e) {
        e.preventDefault();
        var formData = {
            "name": $('input[name=name]').val(),
            "is_active":"1",
            "Hospital_id":<?=$data['hospital_id']?>
            
        };
        $.ajax({
            url: '<?=$api_base_url?>setup-referral-referral-category',
            type: 'POST',
            data: formData,
            beforeSend: function() {
                $('#formaddbtn').button('loading');
            },
            success: function(response) {
                successMsg('Category add successfully'); 
                location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('An error occurred. Please try again.');
                $('#formaddbtn').button('reset');
            }
        });
    });
});
</script>
<div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm400" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line("edit_category"); ?></h4>
            </div>

            <form id="editcategory" class="" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                <div class="modal-body pt0 pb0">
                    <div class="ptt10 row" id="">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('name'); ?></label>
                                <span class="req"> *</span>
                                <input id="edit_name" name="name" placeholder="" type="text" class="form-control"  value="<?php echo set_value('name'); ?>" />
                                <input id="categoryid" name="categoryid" placeholder="" type="hidden" class="form-control"  />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="pull-right">
                        <button type="submit" data-loading-text="<?php echo $this->lang->line('processing'); ?>" id="editcategorybtn" class="btn btn-info"><?php echo $this->lang->line('save'); ?></button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<script>
    //editformadd
    $(document).ready(function() {
        $('#editcategory').on('submit', function(e) {
            e.preventDefault();
            var formData = {
                "name": $('#edit_name').val(),
                "is_active": "1",
                "Hospital_id":<?=$data['hospital_id']?>
            };
            $.ajax({
                url: '<?=$api_base_url?>setup-referral-referral-category/' + $('#categoryid').val(),
                type: 'PATCH',
                data: formData,
                beforeSend: function() {
                    $('#editformaddbtn').button('loading');
                },
                success: function(response) {
                    let message = response[0]?.['data ']?.messege || 'Default success message';
                    successMsg(message);
                    location.reload();
                    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('An error occurred. Please try again.');
                    $('#editformaddbtn').button('reset');
                }
            });
        });
    });
</script>
<script>   
    function getRecord(id) {
        $('#myModalEdit').modal('show');
        $.ajax({
            url: '<?php echo base_url(); ?>admin/referralcategory/get/' + id,
            type: "POST",
            dataType: "json",
            success: function (data) {
                $("#edit_name").val(data.name);
                $("#categoryid").val(id);
            },
            error: function () {
                alert("Fail")
            }

        });
    }

   
    
    $(document).ready(function (e) {
        $('#myModal,#myModalEdit').modal({
        backdrop: 'static',
        keyboard: false,
        show:false
        });
    });
</script>
<script>
    function delete_referral(id) {
        var result = confirm("Are you sure you want to delete this category?");
        if (result) {
            $.ajax({
                url: '<?=$api_base_url?>setup-referral-referral-category/' + id + '?Hospital_id=<?=$data['hospital_id']?>',
                type: "Delete",
                success: function (response) {
                    successMsg(response[0].message);
                    location.reload();
                },
                error: function () {
                    alert("Fail")
                }
            });
        }
    }
</script>