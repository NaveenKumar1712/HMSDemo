<div class="content-wrapper">  

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-2">
                <div class="box border0">
                    <ul class="tablists">
                    <?php if ($this->rbac->hasPrivilege('leave_types', 'can_view')) { ?>
                            <li><a href="<?php echo base_url(); ?>admin/leavetypes" ><?php echo $this->lang->line('leave_type'); ?></a></li>
                        <?php } ?>
                        <?php if ($this->rbac->hasPrivilege('department', 'can_view')) { ?>
                            <li><a href="<?php echo base_url(); ?>admin/department" class="active"><?php echo $this->lang->line('department'); ?></a></li>
                        <?php } ?>
                        <?php if ($this->rbac->hasPrivilege('designation', 'can_view')) { ?>
                            <li><a href="<?php echo base_url(); ?>admin/designation/designation"><?php echo $this->lang->line('designation'); ?></a></li>
                        <?php } ?>
                         <?php if ($this->rbac->hasPrivilege('specialist', 'can_view')) { ?>
                            <li><a href="<?php echo base_url(); ?>admin/specialist" ><?php echo $this->lang->line('specialist'); ?></a></li>
                        <?php } ?>
                        <?php if ($this->rbac->hasPrivilege('payroll', 'can_view')) { ?>
                            <li><a href="<?php echo base_url(); ?>admin/admin/payroll_setup"><?php echo $this->lang->line('payroll'); ?></a></li>
                        <?php } ?>   
                        <?php if ($this->rbac->hasPrivilege('payroll', 'can_view')) { ?>
                            <li><a href="<?php echo base_url(); ?>admin/admin/payroll_setup_type"><?php echo $this->lang->line('payroll'); ?> Type</a></li>
                        <?php } ?>   
                    </ul>
                </div>
            </div>
            <div class="col-md-10">              
                <div class="box box-primary" id="tachelist">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('department_list'); ?></h3>
                        <div class="box-tools pull-right">
                            <?php if ($this->rbac->hasPrivilege('department', 'can_add')) { ?>
                                <a data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-sm department"><i class="fa fa-plus"></i>  <?php echo $this->lang->line('add_department'); ?></a>    
                            <?php } ?> 
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="mailbox-controls">
                        </div>
                        <div class="table-responsive mailbox-messages">
                            <div class="download_label"><?php echo $this->lang->line('department_list'); ?></div>
                            <table class="table table-striped table-bordered table-hover ajaxlist" id="ajaxlist">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th><?php echo $this->lang->line('department'); ?></th>
                                        <th class="text-right noExport"><?php echo $this->lang->line('action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>                                  
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="">
                        <div class="mailbox-controls">
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </section>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('add_department'); ?></h4> 
            </div>

            <form id="departmentadd"  name="employeeform" method="post" accept-charset="utf-8"  enctype="multipart/form-data">
                <div class="modal-body pt0 pb0">
                    <div class="ptt10">
                        <div class="form-group">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('name'); ?></label><small class="req"> *</small>
                            <input autofocus="" id="type"  name="type" placeholder="" type="text" class="form-control"  />
                            <span class="text-danger"><?php echo form_error('type'); ?></span>
                        </div>             

                    </div>
                </div><!--./modal-->         
                <div class="modal-footer">
                    <button type="submit" data-loading-text="<?php echo $this->lang->line('processing'); ?>" id="formaddbtn" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                </div>
            </form>


        </div><!--./row--> 
    </div>
</div>
<?php
$data = $this->session->userdata('hospitaladmin');
$api_base_url = $this->config->item('api_base_url');
?>
<script>
$(document).ready(function() {
    $('#departmentadd').on('submit', function(e) {
        e.preventDefault();
        let department_name = $('input[name=type]').val();
        let type = department_name;
        if (!type || type.trim() === '' || !/^[A-Za-z0-9\s]+$/.test(type)) {
            errorMsg('Please enter a valid Department name. It should not contain only spaces or special characters.');
            return false;
        }
        var formData = {
            "department_name": $('input[name=type]').val(),
            "is_active":"yes",
            "Hospital_id":<?=$data['hospital_id']?>            
        };
        sendAjaxRequest('<?=$api_base_url?>setup-human-resource-department', 'POST', formData,function(response) {
            handleResponse(response);
        });
    });
});
</script>

<div class="modal fade" id="editmyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('edit_department'); ?></h4> 
            </div>
            <form id="editformadd" name="employeeform"  accept-charset="utf-8"  enctype="multipart/form-data">
                <div class="modal-body pt0 pb0">
                    <div class="ptt10">

                        <div class="form-group">
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('name'); ?></label><small class="req"> *</small>
                            <input autofocus="" id="type1"  name="type" placeholder="" type="text" class="form-control"   />
                            <span class="text-danger"><?php echo form_error('type'); ?></span>

                            <input autofocus="" id="dept_id"  name="departmenttypeid" placeholder="" type="hidden" class="form-control"   />
                        </div>


                    </div>
                </div><!--./modal-->    
                <div class="modal-footer">
                    <button type="submit" data-loading-text="<?php echo $this->lang->line('processing'); ?>" id="editformaddbtn" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                </div>
            </form>


        </div><!--./row--> 
    </div>
</div>
<script>
    //editformadd
    $(document).ready(function () {
        $('#editformadd').on('submit', function (e) {
            e.preventDefault();
            var formData = {
                "department_name": $('#type1').val(),  
                "is_active":"yes",
                "Hospital_id":<?=$data['hospital_id']?>             
            };
            let  departmenttypeid = $('#dept_id').val();
            let type = $('#type1').val();
            if (!type || type.trim() === '' || !/^[A-Za-z0-9\s]+$/.test(type)) {
                errorMsg('Please enter a valid Department name. It should not contain only spaces or special characters.');
                return false;
            }
            const accessToken = '<?= $data['accessToken'] ?? '' ?>';
            if (!accessToken) {
                errorMsg("Access token missing. Please login again.");
                return;
            }
            sendAjaxRequest('<?=$api_base_url?>setup-human-resource-department/' + departmenttypeid, 'PATCH', formData, function(response) {
                handleResponse(response);
            });
        });
    });
</script>
<!-- //========datatable start===== -->
<script>
const initialData = <?= json_encode($initialData) ?>;
const initialDataTotal = initialData.recordsTotal || initialData.length || 0;
$(document).ready(function() {
   
    let actionTemplate = `
        <a href="#" onclick="get(key:id)" class="btn btn-default btn-xs" data-toggle='#editmyModal' data-record-id="key:id" title="Edit">
            <i class="fa fa-pencil"></i>
        </a>
        <a href="#" onclick="deleterecord(key:id)" class="btn btn-default btn-xs" data-loading-text="Please Wait.." data-toggle="tooltip" data-record-id="key:id" title="Delete">
            <i class="fa fa-trash"></i>
        </a>
    `;
    initializeTable(initialData, initialDataTotal, `${base_url}admin/department/getdepartmentlist`, '#ajaxlist', [
            'sno','department_name', 'action'
        ],
        actionTemplate,
        'id'
    );
});
</script>
<!-- //========datatable end===== --> 
<script>
    $(document).ready(function () {
        // Setup datatables
        $.fn.dataTableExt.oApi.fnPagingInfo = function (oSettings)
        {
            return {
                "iStart": oSettings._iDisplayStart,
                "iEnd": oSettings.fnDisplayEnd(),
                "iLength": oSettings._iDisplayLength,
                "iTotal": oSettings.fnRecordsTotal(),
                "iFilteredTotal": oSettings.fnRecordsDisplay(),
                "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
            };
        };

    });

    function get(id) {
        $('#editmyModal').modal('show');
        $.ajax({
            dataType: 'json',
            url: '<?php echo base_url(); ?>admin/department/get_data/' + id,
            success: function (result) {
                $('#dept_id').val(result.id);
                $('#type1').val(result.department_name);
            }
        });
    }

    function deleterecord(id)
    {
        if(confirm('Are you sure you want to delete this')){
            sendAjaxRequest('<?=$api_base_url?>setup-human-resource-department/' + id + '?Hospital_id=<?=$data['hospital_id']?>', 'DELETE', {}, function(response) {
                handleResponse(response);
            });
        }
    }
	
	
$(".department").click(function(){
	$('#formadd').trigger("reset");
});

        $(document).ready(function (e) {
                $('#myModal,#editmyModal').modal({
                backdrop: 'static',
                keyboard: false,
                show:false
                });
        });
</script>