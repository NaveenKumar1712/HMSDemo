     <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php
            if ($this->rbac->hasPrivilege('staff_id_card', 'can_add') || $this->rbac->hasPrivilege('staff_id_card', 'can_edit')) {
                ?>
                <div class="col-md-4">
                    <!-- Horizontal Form -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo $this->lang->line('edit_staff_id_card'); ?></h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form    id="certificateform" name="certificateform" method="post" accept-charset="utf-8">
                            <div class="box-body">
                                <?php if ($this->session->flashdata('msg')) { ?>
                                    <?php echo $this->session->flashdata('msg');
                                    $this->session->unset_userdata('msg');
                                     ?>
                                <?php } ?>
                                <?php
                                if (isset($error_message)) {
                                    echo "<div class='alert alert-danger'>" . $error_message . "</div>";
                                }
                                ?>
                                <?php echo $this->customlib->getCSRF(); ?>
                                <input type="hidden" name="id" value="<?php echo set_value('id', $editstaffidcard[0]->id); ?>" >
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('background_image'); ?></label>
                                    <input id="documents" value="<?php echo $editstaffidcard[0]->background; ?>" placeholder="" type="file" class="filestyle form-control" data-height="40"  name="background_image">
                                   
                                    <span class="text-danger"><?php echo form_error('background_image'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('logo'); ?></label>
                                    <input id="logo_img" placeholder="" value="<?php echo $editstaffidcard[0]->logo; ?>" type="file" class="filestyle form-control" data-height="40"  name="logo_img">
                                   
                                    <span class="text-danger"><?php echo form_error('logo_img'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('signature'); ?></label>
                                    <input id="sign_image" placeholder="" value="<?php echo $editstaffidcard[0]->sign_image; ?>" type="file" class="filestyle form-control" data-height="40"  name="sign_image">
                                    
                                    <span class="text-danger"><?php echo form_error('sign_image'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('hospital_name'); ?></label><small class="req"> *</small>
                                    <input autofocus="" id="hospital_name" name="hospital_name" placeholder="" type="text" class="form-control" value="<?php echo set_value('hospital_name', $editstaffidcard[0]->hospital_name); ?>" />
                                    <span class="text-danger"><?php echo form_error('hospital_name'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('address_phone_email'); ?></label>
                                    <textarea class="form-control" id="address" name="address" placeholder="" rows="3" placeholder=""><?php echo set_value('address', $editstaffidcard[0]->hospital_address); ?></textarea>
                                    <span class="text-danger"><?php echo form_error('address'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('id_card_title'); ?></label><small class="req"> *</small>
                                    <input id="title" name="title" placeholder="" type="text" class="form-control" value="<?php echo set_value('title', $editstaffidcard[0]->title); ?>" />
                                    <span class="text-danger"><?php echo form_error('title'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('header_color'); ?></label>
                                    <input id="header_color" name="header_color" placeholder="" type="text" class="form-control my-colorpicker1" value="<?php echo set_value('header_color', $editstaffidcard[0]->header_color); ?>" />
                                </div>
                                <div class="form-group switch-inline">
                                    <label><?php echo $this->lang->line('staff_name'); ?></label>
                                    <div class="material-switch switchcheck">
                                        <input id="enable_name" name="is_active_staff_name" type="checkbox" class="chk" value="1" <?php echo set_checkbox('is_active_staff_name', '1', (set_value('is_active_staff_name', $editstaffidcard[0]->enable_name) == 1) ? TRUE : FALSE); ?>>
                                        <label for="enable_name" class="label-success"></label>
                                    </div>
                                </div>
                                <div class="form-group switch-inline">
                                    <label><?php echo $this->lang->line('staff_id'); ?></label>
                                    <div class="material-switch switchcheck">
                                        <input id="enable_staff_id" name="is_active_staff_id" type="checkbox" class="chk" <?php echo set_checkbox('is_active_staff_id', '1', (set_value('is_active_staff_id', $editstaffidcard[0]->enable_staff_id) == 1) ? TRUE : FALSE); ?> value="1">
                                        <label for="enable_staff_id" class="label-success"></label>
                                    </div>
                                </div>
                                   <div class="form-group switch-inline">
                                    <label><?php echo $this->lang->line('designation'); ?></label>
                                    <div class="material-switch switchcheck">
                                        <input id="enable_designation" name="is_active_designation" type="checkbox" class="chk" value="1" <?php echo set_checkbox('is_active_staff_id', '1', (set_value('is_active_designation', $editstaffidcard[0]->enable_designation) == 1) ? TRUE : FALSE); ?>>
                                        <label for="enable_designation" class="label-success"></label>
                                    </div>
                                </div>
                                <div class="form-group switch-inline">
                                    <label><?php echo $this->lang->line('department'); ?></label>
                                    <div class="material-switch switchcheck">
                                        <input id="enable_department" name="is_active_department" type="checkbox" class="chk" value="1" <?php echo set_checkbox('is_active_department', '1', (set_value('is_active_department', $editstaffidcard[0]->enable_staff_department) == 1) ? TRUE : FALSE); ?>>
                                        <label for="enable_department" class="label-success"></label>
                                    </div>
                                </div>
                                <div class="form-group switch-inline">
                                    <label><?php echo $this->lang->line('father_name'); ?></label>
                                    <div class="material-switch switchcheck">
                                        <input id="enable_fathers_name" name="is_active_staff_father_name" type="checkbox" class="chk" value="1" <?php echo set_checkbox('is_active_staff_father_name', '1', (set_value('is_active_staff_father_name', $editstaffidcard[0]->enable_fathers_name) == 1) ? TRUE : FALSE); ?>>
                                        <label for="enable_fathers_name" class="label-success"></label>
                                    </div>
                                </div>
                                <div class="form-group switch-inline">
                                    <label><?php echo $this->lang->line('mother_name'); ?></label>
                                    <div class="material-switch switchcheck">
                                        <input id="enable_mother_name" name="is_active_staff_mother_name" type="checkbox" class="chk" value="1" <?php echo set_checkbox('is_active_staff_mother_name', '1', (set_value('is_active_staff_mother_name', $editstaffidcard[0]->enable_mothers_name) == 1) ? TRUE : FALSE); ?>>
                                        <label for="enable_mother_name" class="label-success"></label>
                                    </div>
                                </div>
                                <div class="form-group switch-inline">
                                    <label><?php echo $this->lang->line('date_of_joining'); ?></label>
                                    <div class="material-switch switchcheck">
                                        <input id="enable_date_of_joining" name="is_active_date_of_joining" type="checkbox" class="chk" value="1" <?php echo set_checkbox('is_active_date_of_joining', '1', (set_value('is_active_date_of_joining', $editstaffidcard[0]->enable_date_of_joining) == 1) ? TRUE : FALSE); ?>>
                                        <label for="enable_date_of_joining" class="label-success"></label>
                                    </div>
                                </div>
                                <div class="form-group switch-inline">
                                    <label><?php echo $this->lang->line('current_address'); ?></label>
                                    <div class="material-switch switchcheck">
                                        <input id="enable_staff_permanent_address" name="is_active_staff_permanent_address" type="checkbox" class="chk" value="1" <?php echo set_checkbox('is_active_staff_permanent_address', '1', (set_value('is_active_staff_permanent_address', $editstaffidcard[0]->enable_permanent_address) == 1) ? TRUE : FALSE); ?>>
                                        <label for="enable_staff_permanent_address" class="label-success"></label>
                                    </div>
                                </div>
                                 <div class="form-group switch-inline">
                                    <label><?php echo $this->lang->line('phone'); ?></label>
                                    <div class="material-switch switchcheck">
                                        <input id="enable_staff_phone" name="is_active_staff_phone" type="checkbox" class="chk" value="1" <?php echo set_checkbox('is_active_staff_phone', '1', (set_value('is_active_staff_phone', $editstaffidcard[0]->enable_staff_phone) == 1) ? TRUE : FALSE); ?>>
                                        <label for="enable_staff_phone" class="label-success"></label>
                                    </div>
                                </div>
                                <div class="form-group switch-inline">
                                    <label><?php echo $this->lang->line('date_of_birth'); ?></label>
                                    <div class="material-switch switchcheck">
                                        <input id="enable_staff_dob" name="is_active_staff_dob" type="checkbox" class="chk" value="1" <?php echo set_checkbox('is_active_staff_dob', '1', (set_value('is_active_staff_dob', $editstaffidcard[0]->enable_staff_dob) == 1) ? TRUE : FALSE); ?>>
                                        <label for="enable_staff_dob" class="label-success"></label>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                            </div>
                        </form>
                    </div>

                </div><!--/.col (right) -->
                <!-- left column -->
            <?php } ?>
            <div class="col-md-<?php
            if ($this->rbac->hasPrivilege('staff_id_card', 'can_add') || $this->rbac->hasPrivilege('staff_id_card', 'can_edit')) {
                echo "8";
            } else {
                echo "12";
            }
            ?>">
                <!-- general form elements -->
                <div class="box box-primary" id="hroom">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('staff_id_card_list'); ?></h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="mailbox-messages">
                            <div class="download_label"><?php echo $this->lang->line('staff_id_card_list'); ?></div>
                            <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover example">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('id_card_title'); ?></th>
                                        <!-- <th>Certificate Text</th> -->
                                        <th><?php echo $this->lang->line('background_image'); ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($staffidcardlist)) {
                                        ?>

                                        <?php
                                    } else {
                                        $count = 1;
                                        foreach ($staffidcardlist as $staffidcards_value) {
                                            ?>
                                            <tr>
                                                <td class="mailbox-name">
                                                    <a href="#" data-toggle="popover" class="detail_popover" ><?php echo $staffidcards_value->title; ?></a>
                                                </td>
                                                <td class="mailbox-name">
                                                <?php if ($staffidcards_value->background != '' && !is_null($staffidcards_value->background)) { 
                                                        $userdata = $this->session->userdata('hospitaladmin');
                                                        $accessToken = $userdata['accessToken'] ?? '';
                                                        $url = "https://phr-api.plenome.com/file_upload/getDocs";
                                                        $client = curl_init($url);
                                                        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
                                                        curl_setopt($client, CURLOPT_POST, true);
                                                        curl_setopt($client, CURLOPT_POSTFIELDS, json_encode(['value' => $staffidcards_value->background]));
                                                        curl_setopt($client, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Authorization: ' . $accessToken]);
                                                        $response = curl_exec($client);
                                                        if (curl_errno($client)) {
                                                            error_log('Curl error: ' . curl_error($client));
                                                        }
                                                        curl_close($client);
                                                        if ($response !== false) {
                                                            $base64Image = "data:image/png;base64," . trim($response);
                                                        } else {
                                                            $base64Image = "base_url('uploads/patient_images/no_image.png'.img_time())";
                                                        }
                                                    ?>
                                                        <img src="<?php echo $base64Image; ?>" width="40">
                                                    <?php } else { ?>
                                                        <i class="fa fa-picture-o fa-3x" aria-hidden="true"></i>
                                                    <?php } ?>

                                                </td>
                                                <td class="mailbox-date pull-right no-print">
                                                    <a id="<?php echo $staffidcards_value->id ?>" class="btn btn-default btn-xs view_data" data-toggle="tooltip" title="<?php echo $this->lang->line('view'); ?>">
                                                        <i class="fa fa-reorder"></i>
                                                    </a>
                                                    <?php if ($this->rbac->hasPrivilege('staff_id_card', 'can_edit')) { ?>
                                                        <a href="<?php echo base_url(); ?>admin/staffidcard/edit/<?php echo $staffidcards_value->id ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('edit'); ?>">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                        <?php
                                                    }
                                                    if ($this->rbac->hasPrivilege('staff_id_card', 'can_delete')) {
                                                        ?>
                                                        <a href="<?php echo base_url(); ?>admin/staffidcard/delete/<?php echo $staffidcards_value->id ?>" class="btn btn-default btn-xs"  data-toggle="tooltip" title="<?php echo $this->lang->line('delete'); ?>" onclick="return confirm('<?php echo $this->lang->line('delete_confirm') ?>');">
                                                            <i class="fa fa-remove"></i>
                                                        </a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        $count++;
                                    }
                                    ?>
                                </tbody>
                            </table><!-- /.table -->
                          </div>  
                        </div><!-- /.mail-box-messages -->
                    </div><!-- /.box-body -->
                </div>
            </div><!--/.col (left) -->
            <!-- right column -->
        </div>
        <div class="row">
            <div class="col-md-12">
            </div><!--/.col (right) -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('view_id_card'); ?></h4>
            </div>
            <div class="modal-body" id="certificate_detail">
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var base_url = '<?php echo base_url() ?>';
    function printDiv(elem) {
        Popup(jQuery(elem).html());
    }
    function Popup(data)
    {
        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({"position": "absolute", "top": "-1000000px"});
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
        frameDoc.document.write('<html>');
        frameDoc.document.write('<head>');
        frameDoc.document.write('<title></title>');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/bootstrap/css/bootstrap.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/font-awesome.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/ionicons.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/AdminLTE.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/skins/_all-skins.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/iCheck/flat/blue.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/morris/morris.css">');


        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/jvectormap/jquery-jvectormap-1.2.2.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/datepicker/datepicker3.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/daterangepicker/daterangepicker-bs3.css">');
        frameDoc.document.write('</head>');
        frameDoc.document.write('<body>');
        frameDoc.document.write(data);
        frameDoc.document.write('</body>');
        frameDoc.document.write('</html>');
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 500);
        return true;
    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.view_data').click(function () {
            var certificateid = $(this).attr("id");
            $.ajax({
                url: "<?php echo base_url('admin/staffidcard/view') ?>",
                method: "post",
                data: {certificateid: certificateid},
                success: function (data) {
                    $('#certificate_detail').html(data);
                    $('#myModal').modal("show");
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('.detail_popover').popover({
            placement: 'right',
            trigger: 'hover',
            container: 'body',
            html: true,
            content: function () {
                return $(this).closest('td').find('.fee_detail_popover').html();
            }
        });
        $("#header_color").colorpicker();
    });
    
    $(document).ready(function (e) {
        $('#myModal').modal({
        backdrop: 'static',
        keyboard: false,
        show:false
        });
    }); 
</script>
<?php
$data = $this->session->userdata('hospitaladmin');
$api_base_url = $this->config->item('api_base_url');
?>
<script>
     $("#certificateform").on('submit', async function (e) {
    e.preventDefault();
    let hospitalId = <?=$data['hospital_id']?>;
    let newFile = $("#documents")[0].files[0];
    let logoFile = $("#logo_img")[0].files[0];
    let signFile = $("#sign_image")[0].files[0];

    let formData = {
        title: $("#title").val(),
        hospital_name: $("#hospital_name").val(),
        hospital_address: $("#address").val(),
        background: newFile ? await uploadImage(newFile) :"<?php echo $editstaffidcard[0]->sign_image; ?>",
        logo: logoFile ? await uploadImage(logoFile) : "<?php echo $editstaffidcard[0]->logo; ?>",
        sign_image: signFile ? await uploadImage(signFile) : "<?php echo $editstaffidcard[0]->sign_image; ?>",
        header_color: $("#header_color").val(),
        enable_staff_role: $("#enable_staff_role").is(':checked') ? 1 : 0,
        enable_staff_id: $("#enable_staff_id").is(':checked') ? 1 : 0,
        enable_staff_department: $("#enable_staff_department").is(':checked') ? 1 : 0,
        enable_designation: $("#enable_designation").is(':checked') ? 1 : 0,
        enable_name: $("#enable_name").is(':checked') ? 1 : 0,
        enable_fathers_name: $("#enable_fathers_name").is(':checked') ? 1 : 0,
        enable_mothers_name: $("#enable_mothers_name").is(':checked') ? 1 : 0,
        enable_date_of_joining: $("#enable_date_of_joining").is(':checked') ? 1 : 0,
        enable_permanent_address: $("#enable_permanent_address").is(':checked') ? 1 : 0,
        enable_staff_dob: $("#enable_staff_dob").is(':checked') ? 1 : 0,
        enable_staff_phone: $("#enable_staff_phone").is(':checked') ? 1 : 0,
        status: 1,
        hospital_id: <?=$data['hospital_id']?>
    };
    console.log(JSON.stringify(formData,null,2));

    $.ajax({
        url: '<?=$api_base_url?>staff-id-card/' + <?=$editstaffidcard[0]->id?>,
        type: 'PATCH',
        contentType: 'application/json',
        data: JSON.stringify(formData),
        success: function (response) {
           successMsg(response[0]['data '].messege);
            window.location.reload();
        },
        error: function (xhr) {
            alert(xhr.responseJSON?.message || 'Something went wrong.');
        }
    });
});

async function uploadImage(file) {
    let fileUploadData = new FormData();
    fileUploadData.append('file', file);
    try {
        let response = await $.ajax({
            url: 'https://phr-api.plenome.com/file_upload',
            type: 'POST',
            data: fileUploadData,
            contentType: false,
            processData: false
        });
        return response.data;
    } catch (error) {
        return $("#old_file").val();
    }
}
</script>
<script>
    function delete_record(id) {
        if (confirm("Are you sure you want to delete this certificate?")) {
            $.ajax({
                url: "<?=$api_base_url?>patient-id-card/" + id + "?hospital_id=<?=$data['hospital_id']?>",
                type: "DELETE",           
                success: function (data) {
                    successMsg("Deleted certificate Successfully!");
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                }
            });
        }
    }
</script>