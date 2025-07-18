<?php $currency_symbol = $this->customlib->getHospitalCurrencyFormat();
$data = $this->session->userdata('hospitaladmin');
$api_base_url = $this->config->item('api_base_url');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header ptbnull">
                        <h3 class="box-title titlefix"> <?php echo $this->lang->line('item_stock_list'); ?></h3>
                        <div class="box-tools pull-right">
                            <?php if ($this->rbac->hasPrivilege('item_stock', 'can_add')) { ?>
                                <a data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-sm additemstock"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add_item_stock'); ?></a>
                            <?php } ?>
                            <?php if ($this->rbac->hasPrivilege('issue_item', 'can_view')) { ?>
                                <a href="<?php echo base_url(); ?>admin/issueitem" class="btn btn-primary btn-sm"><i class="fa fa-reorder"></i> <?php echo $this->lang->line('issue_item'); ?> </a>
                            <?php
                            }
                            if ($this->rbac->hasPrivilege('item', 'can_view')) {
                            ?>
                                <a href="<?php echo base_url(); ?>admin/item" class="btn btn-primary btn-sm"><i class="fa fa-reorder"></i> <?php echo $this->lang->line('item'); ?> </a>
                            <?php } ?>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive mailbox-messages">
                            <div class="download_label"><?php echo $this->lang->line('item_stock_list'); ?></div>
                            <table class="table table-hover table-striped table-bordered ajaxlist" data-export-title="<?php echo $this->lang->line('item_stock_list'); ?>">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('name'); ?></th>
                                        <th><?php echo $this->lang->line('category'); ?></th>
                                        <th><?php echo $this->lang->line('supplier'); ?></th>
                                        <th><?php echo $this->lang->line('store'); ?></th>
                                        <th><?php echo $this->lang->line('date'); ?></th>
                                        <th><?php echo $this->lang->line('description'); ?></th>
                                        <th class=" "><?php echo $this->lang->line('total_quantity'); ?></th>
                                        <th class="text-right"><?php echo $this->lang->line('purchase_price') . " (" . $currency_symbol . ")"; ?></th>
                                        <!-- <th class=""><?php echo $this->lang->line('action'); ?></th> -->
                                    </tr>
                                </thead>
                                <tbody>
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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="follow_up">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('add_item_stock') ?></h4>
            </div>
            <form id="iteamadd" id="itemstockform" name="itemstockform" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                <div class="scroll-area">
                    <div class="modal-body pt0 pb0">
                        <div class="row ptt10">
                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('item_category'); ?></label><small class="req"> *</small>

                                    <select autofocus="" id="item_category_id" name="item_category_id" class="form-control">
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        <?php
                                        foreach ($itemcatlist as $item_category) {
                                        ?>
                                            <option value="<?php echo $item_category['id'] ?>" <?php
                                                                                                if (set_value('item_category_id') == $item_category['id']) {
                                                                                                    echo "selected = selected";
                                                                                                }
                                                                                                ?>><?php echo $item_category['item_category'] ?></option>

                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('item_category_id'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('item'); ?></label><small class="req"> *</small>

                                    <select id="item_id" name="item_id" class="form-control">
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>

                                    </select>
                                    <span class="text-danger"><?php echo form_error('item_id'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('supplier'); ?></label><small class="req"> *</small>

                                    <select id="supplier_id" name="supplier_id" class="form-control">
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        <?php
                                        foreach ($itemsupplier as $itemsup) {
                                        ?>
                                            <option value="<?php echo $itemsup['id'] ?>" <?php
                                                                                            if (set_value('supplier_id') == $itemsup['id']) {
                                                                                                echo "selected = selected";
                                                                                            }
                                                                                            ?>><?php echo $itemsup['item_supplier'] ?></option>

                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('supplier_id'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('store'); ?></label>

                                    <select id="store_id" name="store_id" class="form-control">
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        <?php
                                        foreach ($itemstore as $itemstorel) {
                                        ?>
                                            <option value="<?php echo $itemstorel['id'] ?>" <?php
                                                                                            if (set_value('store_id') == $itemstorel['id']) {
                                                                                                echo "selected = selected";
                                                                                            }
                                                                                            ?>><?php echo $itemstorel['item_store'] ?></option>

                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('store_id'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('quantity'); ?></label><small class="req"> *</small> <span id="item_unit"></span>
                                    <div class="">
                                        <span class="miplus">
                                            <select class="form-control" name="symbol">
                                                <option value="+">+</option>
                                                <option value="-">-</option>
                                            </select>
                                        </span>
                                        <input id="quantity" name="quantity" placeholder="" type="text" class="form-control miplusinput" value="<?php echo set_value('quantity'); ?>" />
                                    </div>

                                    <span class="text-danger"><?php echo form_error('quantity'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('purchase_price'); ?></label><small class="req"> *</small>
                                    <input id="purchase_price" name="purchase_price" placeholder="" type="text" class="form-control" value="<?php echo set_value('purchase_price'); ?>" />
                                    <span class="text-danger"><?php echo form_error('purchase_price'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('date'); ?></label>
                                    <input id="date" name="date" placeholder="" type="text" class="form-control" value="<?php echo date($this->customlib->getHospitalDateFormat()); ?>" readonly="readonly" />
                                    <span class="text-danger"><?php echo form_error('date'); ?></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('description'); ?></label>
                                    <textarea class="form-control" id="description" name="description" placeholder="" rows="3"><?php echo set_value('description'); ?></textarea>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo $this->lang->line('attach_document'); ?></label>
                                    <input id="item_photo" name="item_photo" placeholder="" type="file" class="filestyle form-control" data-height="40" value="<?php echo set_value('item_photo'); ?>" />
                                    <span class="text-danger"><?php echo form_error('item_photo'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div><!--./modal-->
                </div>
                <div class="modal-footer">
                    <div class="pull-right">
                        <button type="submit" data-loading-text="<?php echo $this->lang->line('processing'); ?>" id="form1btn" class="btn btn-info pull-right"><i class="fa fa-check-circle"></i> <?php echo $this->lang->line('save'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editmyModal" tabindex="-1" role="dialog" aria-labelledby="follow_up">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('edit_item_stock'); ?></h4>
            </div>

            <form id="editform" name="itemstockform" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                <div class="modal-body pt0 pb0">
                    <div class="row ptt10">
                        <?php echo $this->customlib->getCSRF(); ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('item_category'); ?></label><small class="req"> *</small>

                                <select autofocus="" id="edititem_category_id" name="item_category_id" class="form-control">
                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                    <?php
                                    foreach ($itemcatlist as $item_category) {
                                    ?>
                                        <option value="<?php echo $item_category['id'] ?>"><?php echo $item_category['item_category'] ?></option>

                                    <?php
                                    }
                                    ?>
                                </select>
                                <span class="text-danger"><?php echo form_error('item_category_id'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('item'); ?></label><small class="req"> *</small>

                                <select id="edititem_id" name="item_id" class="form-control">
                                    <option value=""><?php echo $this->lang->line('select'); ?></option>

                                </select>
                                <span class="text-danger"><?php echo form_error('item_id'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('supplier'); ?></label><small class="req"> *</small>

                                <select id="editsupplier_id" name="supplier_id" class="form-control">
                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                    <?php
                                    foreach ($itemsupplier as $itemsup) {
                                    ?>
                                        <option value="<?php echo $itemsup['id'] ?>"><?php echo $itemsup['item_supplier'] ?></option>

                                    <?php
                                    }
                                    ?>
                                </select>
                                <span class="text-danger"><?php echo form_error('supplier_id'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('store'); ?></label>

                                <select id="editstore_id" name="store_id" class="form-control">
                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                    <?php
                                    foreach ($itemstore as $itemstore) {
                                    ?>
                                        <option value="<?php echo $itemstore['id'] ?>"><?php echo $itemstore['item_store'] ?></option>

                                    <?php
                                    }
                                    ?>
                                </select>
                                <span class="text-danger"><?php echo form_error('store_id'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('quantity'); ?></label><small class="req"> *</small>
                                <div class="">
                                    <span class="miplus">
                                        <select class="form-control" name="symbol">
                                            <option value="+">+</option>
                                            <option value="-">-</option>
                                        </select>
                                    </span>
                                    <input id="editquantity" name="quantity" placeholder="" type="text" class="form-control miplusinput" value="<?php echo set_value('quantity'); ?>" />
                                    <input type="hidden" name="itemstockid" id="itemstockid">
                                    <input type="hidden" name="oldfile" id="oldfile">
                                </div>

                                <span class="text-danger"><?php echo form_error('quantity'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('purchase_price'); ?></label>
                                <input id="epurchase_price" name="purchase_price" placeholder="" type="text" class="form-control purchase_price" value="<?php echo set_value('purchase_price'); ?>" />
                                <span class="text-danger"><?php echo form_error('purchase_price'); ?></span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('date'); ?></label>
                                <input id="editdate" name="date" placeholder="" type="text" class="form-control date" value="<?php echo set_value('date'); ?>" readonly="readonly" />
                                <span class="text-danger"><?php echo form_error('date'); ?></span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('description'); ?></label>
                                <textarea class="form-control" id="editdescription" name="description" placeholder="" rows="3"><?php echo set_value('description'); ?></textarea>
                                <span class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('attach_document'); ?></label>
                                <input id="edititem_photo" name="item_photo" placeholder="" type="file" class="filestyle form-control" data-height="40" value="<?php echo set_value('item_photo'); ?>" />
                                <span class="text-danger"><?php echo form_error('item_photo'); ?></span>
                            </div>
                        </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="modal-footer">
                    <div class="pull-right">
                        <button type="submit" id="editformbtn" data-loading-text="<?php echo $this->lang->line('processing'); ?>" class="btn btn-info pull-right"><?php echo $this->lang->line('save'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<script>
    $(document).ready(function() {
        const itemstockid = $("#itemstockid").val();
        console.log(itemstockid);
        handleFormSubmission('#iteamadd', '<?= $api_base_url ?>php-inventory/item-stock', '#form1btn', 'item_photo', 'POST');
        handleFormSubmission('#editform', '<?= $api_base_url ?>php-inventory/item-stock/', '#editformbtn', 'edititem_photo', 'PATCH');
    });

    function handleFormSubmission(formId, apiUrl, buttonId, fileInputId, method) {
        $(formId).on('submit', function(e) {
            e.preventDefault();
            if (!validateForm(this)) return;

            $(buttonId).button('loading');
            let formData = prepareFormData(this, fileInputId);

            if (formData.itemstockid) {
                apiUrl = apiUrl + formData.itemstockid;
            }

            let finalobject = {
                "itemstockid": formData.itemstockid ? parseInt(formData.itemstockid) : undefined,
                "item_id": parseInt(formData.item_id),
                "item_supplier_id": parseInt(formData.supplier_id),
                "item_store_id": parseInt(formData.store_id),
                "symbol": formData.symbol,
                "item_stock_quantity": calculateStockQuantity(formData),
                "item_stock_purchase_price": parseFloat(formData.purchase_price),
                "item_stock_date": formatDate(formData.date),
                "item_stock_description": formData.description,
                "item_stock_attachment": '',
                "hospital_id": <?= $data['hospital_id'] ?>
            };

            handleFileUploadAndSubmit(formData, apiUrl, finalobject, fileInputId, buttonId, method);
        });
    }

    function validateForm(form) {
        let isValid = true;
        const requiredFields = ['item_id', 'supplier_id', 'store_id', 'quantity', 'purchase_price', 'date'];

        requiredFields.forEach(field => {
            const fieldValue = $(form).find(`[name="${field}"]`).val();
            if (!fieldValue || fieldValue.trim() === '') {
                errorMsg(`${field.replace('_', ' ')} is required.`);
                isValid = false;
            }
        });

        return isValid;
    }

    function prepareFormData(form, fileInputId) {
        let formData = new FormData(form);
        let formObject = {};
        formData.forEach((value, key) => {
            formObject[key] = value;
        });
        formObject.file = document.getElementById(fileInputId).files[0];
        formObject.oldfile = $('#oldfile').val();
        return formObject;
    }

    function calculateStockQuantity(formData) {
        return formData.symbol === '+' ? parseInt(formData.quantity) : -Math.abs(parseInt(formData.quantity));
    }

    function formatDate(originalDate) {
        let dateParts = originalDate.split('/');
        return `${dateParts[2]}-${dateParts[0]}-${dateParts[1]}`;
    }

    function handleFileUploadAndSubmit(formData, apiUrl, finalobject, fileInputId, buttonId, method) {
        if (formData.file) {
            uploadFile(formData.file, formData.oldfile, (uploadedUrl) => {
                finalobject.item_stock_attachment = uploadedUrl || formData.oldfile;
                submitForm(apiUrl, finalobject, buttonId, method);
            });
        } else {
            finalobject.item_stock_attachment = formData.oldfile;
            submitForm(apiUrl, finalobject, buttonId, method);
        }
    }

    function uploadFile(fileInput, oldfile, callback) {
        let fileUploadData = new FormData();
        fileUploadData.append('file', fileInput);

        $.ajax({
            url: 'https://phr-api.plenome.com/file_upload',
            type: 'POST',
            data: fileUploadData,
            contentType: false,
            processData: false,
            success: function(response) {
                callback(response.data);
            },
            error: function() {
                callback(oldfile);
            }
        });
    }

    function submitForm(apiUrl, finalobject, buttonId, method) {
        $.ajax({
            url: apiUrl,
            type: method,
            data: JSON.stringify(finalobject),
            contentType: 'application/json',
            success: function(data) {
                $(buttonId).button('reset');
                if (data.status === "fail") {
                    errorMsg(data.error.join(" "));
                } else {
                    successMsg(data.message);
                    location.reload();
                }
            },
            error: function() {
                $(buttonId).button('reset');
                $('#error_message').html('Error in saving data.').show();
            }
        });
    }
</script>


<script>
    $(document).ready(function() {

        $('.detail_popover').popover({
            placement: 'right',
            trigger: 'hover',
            container: 'body',
            html: true,
            content: function() {
                return $(this).closest('td').find('.fee_detail_popover').html();
            }
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {

        var item_id_post = '<?php echo set_value('item_id') ?>';
        item_id_post = (item_id_post != "") ? item_id_post : 0;
        var item_category_id_post = '<?php echo set_value('item_category_id'); ?>';
        item_category_id_post = (item_category_id_post != "") ? item_category_id_post : 0;
        populateItem(item_id_post, item_category_id_post);

        var date_format = '<?php echo $result = strtr($this->customlib->getHospitalDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';

        $('#date').datepicker({

            format: date_format,
            autoclose: true
        });

        $('.detail_popover').popover({
            placement: 'right',
            trigger: 'hover',
            container: 'body',
            html: true,
            content: function() {
                return $(this).closest('td').find('.fee_detail_popover').html();
            }
        });

        $(document).on('change', '#item_category_id', function(e) {
            $('#item_id').html("");
            var item_category_id = $(this).val();
            populateItem(0, item_category_id);
        });

        $(document).on('change', '#item_id', function(e) {
            var item_category_id = $(this).val();

            $.ajax({
                type: "GET",
                url: base_url + "admin/itemstock/getItemunit",
                data: {
                    'id': item_category_id
                },
                dataType: "json",
                success: function(data) {
                    $('#item_unit').html("<?php echo $this->lang->line('in'); ?>" + " " + data.unit);
                }
            });
        });

        $(document).on('change', '#edititem_category_id', function(e) {
            $('#edititem_id').html("");
            var item_category_id = $(this).val();
            populateItem(0, item_category_id, 'edititem_id');
        });
    });

    function populateItem(item_id_post, item_category_id_post, htmlid = 'item_id') {
        if (item_category_id_post != "") {
            $('#' + htmlid).html("");

            var base_url = '<?php echo base_url() ?>';
            var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
            $.ajax({
                type: "GET",
                url: base_url + "admin/itemstock/getItemByCategory",
                data: {
                    'item_category_id': item_category_id_post
                },
                dataType: "json",
                success: function(data) {
                    $.each(data, function(i, obj) {
                        var select = "";
                        if (item_id_post == obj.id) {
                            var select = "selected=selected";
                        }
                        div_data += "<option value=" + obj.id + " " + select + ">" + obj.name + "</option>";
                    });
                    $('#' + htmlid).append(div_data);
                }

            });
        }
    }




    function get_data(id) {

        $.ajax({

            url: "<?php echo base_url() ?>admin/itemstock/edit/" + id,
            type: "POST",
            dataType: "json",
            success: function(res) {


                $("#edititem_category_id").val(res.item_category_id);
                $("#edititem_id").val(res.item_id);
                $("#editsupplier_id").val(res.supplier_id);
                $("#editstore_id").val(res.store_id);
                $("#editquantity").val(res.quantity);
                $("#editdate").val(res.date);

                $("#epurchase_price").val(res.purchase_price);
                $("#editdescription").text(res.description);
                $("#itemstockid").val(res.id);
                $("#oldfile").val(res.attachment);
                populateItem(res.item_id, res.item_category_id, 'edititem_id');

                $('#editmyModal').modal('show');

            }
        });
    }


    function delete_record(id) {
        if (confirm('<?php echo $this->lang->line('delete_confirm'); ?>')) {
            $.ajax({
                url: '<?= $api_base_url ?>php-inventory/item-stock/' + id + '?hospital_id=<?= $data['hospital_id'] ?>',
                type: 'DELETE',
                dataType: 'json',
                success: function(res) {
                    successMsg('<?php echo $this->lang->line('delete_message'); ?>');
                    window.location.reload(true);
                },
                error: function() {
                    alert("Fail")
                }
            });
        }
    }

    $(".additemstock").click(function() {
        $('#form1').trigger("reset");
        $(".dropify-clear").trigger("click");
    });

    $(document).ready(function(e) {
        $('#myModal,#editmyModal').modal({
            backdrop: 'static',
            keyboard: false,
            show: false
        });
    });
</script>

<!-- //========datatable start===== -->
<script type="text/javascript">
    (function($) {
        'use strict';
        $(document).ready(function() {
            initDatatable('ajaxlist', 'admin/itemstock/getitemstockDatatable', [], [], 100);
        });
    }(jQuery))
</script>
<!-- //========datatable end===== -->