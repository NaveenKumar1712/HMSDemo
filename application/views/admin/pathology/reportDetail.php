<?php
$currency_symbol = $this->customlib->getHospitalCurrencyFormat();
$genderList = $this->customlib->getGender();
$data = $this->session->userdata('hospitaladmin');
$api_base_url = $this->config->item('api_base_url');
?>
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title titlefix"><?php echo $this->lang->line('pathology_bill'); ?></h3>
                        <div class="box-tools pull-right">
                            <?php if ($this->rbac->hasPrivilege('pathology_bill', 'can_add')) { ?>
                            <button type="button" class="btn btn-primary btn-sm assigntest" id="load1"
                                data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> <?php echo $this->lang->line('please_wait'); ?>"><i
                                    class="fa fa-plus"></i> <?php echo $this->lang->line('generate_bill'); ?></button>
                            <?php } ?>
                            <?php if ($this->rbac->hasPrivilege('pathology_test', 'can_view')) { ?>
                            <a data-toggle="" href="<?php echo base_url(); ?>admin/pathology/search"
                                class="btn btn-primary btn-sm pathology"><i class="fa fa-reorder"></i>
                                <?php echo $this->lang->line('pathology_test'); ?></a>
                            <?php } ?>

                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="">
                            <table class="table table-striped table-bordered table-hover ajaxlist" id="testreport"
                                cellspacing="0" width="100%"
                                data-export-title="<?php echo $this->lang->line('pathology_test_reports'); ?>">
                                <thead>
                                    <tr>
                                        <th class="white-space-nowrap"><?php echo $this->lang->line('bill_no'); ?></th>
                                        <th class="white-space-nowrap"><?php echo $this->lang->line('case_id'); ?></th>
                                        <th class="white-space-nowrap">
                                            <?php echo $this->lang->line('reporting_date'); ?></th>
                                        <th class="white-space-nowrap"><?php echo $this->lang->line('patient_name'); ?>
                                        </th>

                                        <th class="white-space-nowrap">
                                            <?php echo $this->lang->line('reference_doctor'); ?></th>

                                        <?php
                                        if (!empty($fields)) {
                                            foreach ($fields as $fields_key => $fields_value) {
                                        ?>
                                        <th class="white-space-nowrap"><?php echo $fields_value->name; ?></th>
                                        <?php
                                            }
                                        }
                                        ?>
                                        <th class="white-space-nowrap">
                                            <?php echo $this->lang->line('amount') . ' (' . $currency_symbol . ')'; ?>
                                        </th>
                                        <th class="white-space-nowrap">
                                            <?php echo $this->lang->line('paid_amount') . ' (' . $currency_symbol . ')'; ?>
                                        </th>
                                        <th class="text-right white-space-nowrap">
                                            <?php echo $this->lang->line('balance_amount') . ' (' . $currency_symbol . ')'; ?>
                                        </th>
                                    </tr>

                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" id="assigntestModal" aria-hidden="true" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog pup100" role="document">
        <div class="modal-content modal-media-content">
            <form id="bill" accept-charset="utf-8" method="post">
                <input type="hidden" name="doctor_id" id="doctorid">
                <div class="modal-header modal-media-header border-0">
                    <button type="button" class="close pupclose" data-dismiss="modal">&times;</button>
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-9">
                            <div class="p-2 select2-full-width">
                                <select class="form-control patient_list_ajax" id="addpatient_id" name="patientid">
                                    <option value="" disabled selected>Select Patient</option>
                                </select>

                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-1">
                            <div class="p-2">
                                <?php if ($this->rbac->hasPrivilege('patient', 'can_add')) { ?>
                                <a data-toggle="modal" id="add" onclick="holdModal('myModalpa')"
                                    class="modalbtnpatient"><i class="fa fa-plus"></i>
                                    <span><?php echo $this->lang->line('new_patient'); ?></span></a>
                                <?php } ?>
                            </div>
                        </div>


                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <div class="p-2">
                                <div class="input-group">
                                    <input type="text" class="form-control border-0" id="prescription_no"
                                        placeholder="<?php echo $this->lang->line('prescription_no'); ?>"
                                        name="prescription_no">
                                    <div class="input-group-btn">
                                        <button class="btn btn-default btn-group-custom" type="button"
                                            id="search_prescription">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- ./row -->

                </div>
                <!--./modal-header-->

                <div class="pup-scroll-area">
                    <div class="tabinsetbottom pt5">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-2 col-md-3 col-sm-4">
                                    <label><?php echo $this->lang->line('bill_no'); ?> <input readonly name="bill_no"
                                            class="transparentbg-border" id="billno" type="text" /></label>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-4">
                                    <label><?php echo $this->lang->line('case_id'); ?> <input readonly
                                            name="case_reference_id" id="case_reference_id" type="text"
                                            class="transparentbg-border" /></label>
                                </div>
                                <div class="col-lg-7 col-md-5 col-sm-4 text-right text-md-left">
                                    <label><?php echo $this->lang->line('date'); ?>

                                        <input name="date" id="txtDate10" type="text"
                                            class="transparentbg-border" /></label>
                                </div>
                            </div>
                            <!--./row-->
                        </div>
                        <!--./container-fluid-->
                    </div>
                    <!--./tabinsetbottom-->
                    <div class="modal-body pb0">

                    </div>
                    <!--./row-->
                </div>
                <div class="modal-footer sticky-footer">
                    <div class="pull-right">
                        <p id="demo"></p>
                        <button type="button" onclick="addTotal()" class="btn btn-info"><i class="fa fa-calculator"></i>
                            <?php echo $this->lang->line('calculate'); ?></button>
                        <button type="submit" name="save_print" style="display: none;"
                            data-loading-text="<?php echo $this->lang->line('processing'); ?>"
                            class="btn btn-info printsavebtn"><i class="fa fa-print"></i>
                            <?php echo $this->lang->line('save_print'); ?>
                        </button>
                        <button type="submit" name="save"
                            data-loading-text="<?php echo $this->lang->line('processing'); ?>" style="display: none"
                            id="billsave" class="btn btn-info"><i class="fa fa-check-circle"></i>
                            <?php echo $this->lang->line('save'); ?></button>
                    </div>
                </div>
            </form>
        </div>
        <!--./modal-body-->
    </div>
</div>
<div class="modal fade" id="viewModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-toggle="tooltip"
                    title="<?php echo $this->lang->line('clase'); ?>" data-dismiss="modal">&times;</button>
                <div class="modalicon">
                    <div id='edit_delete'>
                        <a href="#" data-target="#edit_prescription" data-toggle="modal" title=""
                            data-original-title="<?php echo $this->lang->line('edit'); ?>"><i
                                class="fa fa-pencil"></i></a>

                        <a href="#" data-toggle="tooltip" title=""
                            data-original-title="<?php echo $this->lang->line('delete'); ?>"><i
                                class="fa fa-trash"></i></a>
                    </div>
                </div>
                <h4 class="modal-title"><?php echo $this->lang->line('report_details'); ?></h4>
            </div>
            <div class="modal-body pt0 pb0">
                <div id="reportdata"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewModalReport" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-toggle="tooltip"
                    title="<?php echo $this->lang->line('clase'); ?>" data-dismiss="modal">&times;</button>
                <div class="modalicon">
                    <div id='edit_deletereport'>
                        <a href="#" data-target="#edit_prescription" data-toggle="modal" title=""
                            data-original-title="<?php echo $this->lang->line('edit'); ?>"><i
                                class="fa fa-pencil"></i></a>

                        <a href="#" data-toggle="tooltip" title=""
                            data-original-title="<?php echo $this->lang->line('delete'); ?>"><i
                                class="fa fa-trash"></i></a>
                    </div>
                </div>
                <h4 class="modal-title"><?php echo $this->lang->line('report_details'); ?></h4>
            </div>
            <div class="modal-body pt0 pb0">
                <div id="reportdatareport"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewDetailReportModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog pup100" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-toggle="tooltip"
                    title="<?php echo $this->lang->line('clase'); ?>" data-dismiss="modal">&times;</button>
                <div class="modalicon">
                    <div id='action_detail_report_modal'>

                    </div>
                </div>
                <h4 class="modal-title"><?php echo $this->lang->line('bill_details'); ?></h4>
            </div>
            <div class="scroll-area">
                <div class="modal-body ptt10 pb0">
                    <div class="scroll-area">
                        <div id="reportbilldata"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="collectionModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-media-content">
            <form method="POST" id="form-sample-collected">
                <div class="modal-header modal-media-header">
                    <button type="button" class="close" data-toggle="tooltip"
                        title="<?php echo $this->lang->line('clase'); ?>" data-dismiss="modal">&times;</button>
                    <div class="modalicon">
                        <div id='collection_modal_header'>

                        </div>
                    </div>
                    <h4 class="modal-title"><?php echo $this->lang->line('sample_collection'); ?></h4>
                </div>
                <div class="modal-body pb0 ptt10">
                    <input type="hidden" name="pathology_report_id" value="0">
                    <input type="hidden" name="pathology_bill_id" value="0">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('sample_collected_person_name'); ?></label><small
                            class="req"> *</small>
                        <select class="form-control" name="collected_by" id="collected_by">
                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                            <?php foreach ($pathologist as $dkey => $dvalue) {
                            ?>
                            <option value="<?php echo $dvalue["id"]; ?>">
                                <?php echo $dvalue["name"] . " " . $dvalue["surname"] . " (" . $dvalue["employee_id"] . ")" ?>
                            </option>
                            <?php } ?>
                        </select>

                    </div>
                    <div class="form-group">
                        <label><?php echo $this->lang->line('collected_date'); ?></label><small class="req"> *</small>
                        <input type="text" class="form-control" name="collected_date" id="collected_date">
                    </div>
                    <div class="form-group">
                        <label><?php echo $this->lang->line('pathology_center'); ?></label><small class="req"> *</small>
                        <input type="text" class="form-control" name="pathology_center" id="pathology_center">
                    </div>
                </div>
                <div class="modal-footer">
                    <?php if ($this->rbac->hasPrivilege('pathology_add_edit_collection_person', 'can_edit')) { ?>
                    <button type="submit" data-loading-text="<?php echo $this->lang->line('processing'); ?>"
                        class="btn btn-info pull-right"><i class="fa fa-check-circle"></i>
                        <?php echo $this->lang->line('save'); ?></button>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="addReportModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <form action="#" method="POST" id="form-report_param">
                <div class="modal-header modal-media-header">
                    <button type="button" class="close" data-toggle="tooltip"
                        title="<?php echo $this->lang->line('clase'); ?>" data-dismiss="modal">&times;</button>
                    <div class="modalicon">
                        <div id='collection_modal_header'>

                        </div>
                    </div>
                    <h4 class="modal-title"><?php echo $this->lang->line('add_edit_report'); ?></h4>
                </div>
                <div class="scroll-area">
                    <div class="modal-body pb0 ptt10">

                    </div>
                </div>

                <div class="modal-footer">
                    <?php if ($this->rbac->hasPrivilege('pathology_add_edit_report', 'can_edit')) { ?>
                    <button type="submit" data-loading-text="<?php echo $this->lang->line('processing'); ?>"
                        class="btn btn-info pull-right"><i class="fa fa-check-circle"></i>
                        <?php echo $this->lang->line('save'); ?></button>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="viewModalbill" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-toggle="tooltip"
                    title="<?php echo $this->lang->line('clase'); ?>" data-dismiss="modal">&times;</button>
                <div class="modalicon">
                    <div id='edit_deletebill'>

                    </div>
                </div>
                <h4 class="modal-title"><?php echo $this->lang->line('bill_details'); ?></h4>
            </div>
            <div class="modal-body pt0 pb0">
                <div id="reportbilldata"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addPaymentModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog pup100" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close pupclose" data-toggle="tooltip"
                    title="<?php echo $this->lang->line('clase'); ?>" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('payments'); ?></h4>
            </div>
            <div class="pup-scroll-area">
                <div class="modal-body ptt10 pb10 min-h-3">
                </div>
            </div>
        </div>
    </div>
</div>

<script id="testpatho-template" type="text/template">
    <?php
    foreach ($testlist as $dkey => $testlist_value) {
    ?>
    <option value='<?php echo $testlist_value["id"]; ?>'>
        <?php echo $testlist_value["test_name"] . " (" . $testlist_value["short_name"] . ")"  ?>
    </option>
    <?php
    }
    ?>
</script>
<script type="text/javascript">
var total_rows = 1;
var date_format_new =
    '<?php echo $result = strtr($this->customlib->getHospitalDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy']) ?>';
var datetime_format =
    '<?php echo $result = strtr($this->customlib->getHospitalDateFormat(true, true), ['d' => 'DD', 'm' => 'MM', 'Y' => 'YYYY', 'H' => 'hh', 'i' => 'mm']) ?>';
$(document).ready(function() {

    $('input[name="collected_date"]').datepicker({
        format: date_format_new,
        autoclose: true,
        todayHighlight: true
    });
});


$(function() {

    $('.select2').select2()
});


function holdModal(modalId) {
    $('#' + modalId).modal({
        backdrop: 'static',
        keyboard: false,
        show: true
    });
}

$(document).on('click', '.assigntest', function() {
    var createModal = $('#assigntestModal');
    var $this = $(this);
    $this.button('loading');
    $.ajax({
        url: '<?php echo base_url(); ?>admin/pathology/assigntestpatho',
        type: "POST",
        dataType: 'json',
        beforeSend: function() {
            $this.button('loading');
            createModal.addClass('modal_loading');
        },
        success: function(res) {
            total_rows = res.total_rows;
            $('#assigntestModal #billno').val(res.bill_no);
            $('#assigntestModal .modal-body').html(res.page);
            $('.filestyle', '#assigntestModal').dropify();
            updateDate();
            $(".test_name").select2();
            $(".consultant_doctor").select2();
            $('#assigntestModal').modal('show');
            createModal.removeClass('modal_loading');
        },
        error: function(xhr) { // if error occured
            alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
            $this.button('reset');
            createModal.removeClass('modal_loading');
        },
        complete: function() {
            $this.button('reset');
            createModal.removeClass('modal_loading');
        }
    });
});



$(document).on('click', '.delete_pathology', function() {
    if (confirm('<?php echo $this->lang->line('delete_confirm') ?>')) {
        var $this = $(this);
        var recordId = $this.data('recordId');
        $this.button('loading');
        $.ajax({
            url: '<?= $api_base_url ?>pathology-generate-bill/' + recordId +
                '?hospital_id=<?= $data['hospital_id'] ?>',
            type: "DELETE",
            data: {
                'id': recordId
            },
            dataType: 'json',
            beforeSend: function() {
                $this.button('loading');

            },
            success: function(res) {
                if (res.status == "fail") {
                    errorMsg(res.message);
                } else {
                    successMsg(res.message);
                    $('#viewDetailReportModal').modal('hide');
                    table.ajax.reload();
                }

                $this.button('reset');
            },
            error: function(xhr) { // if error occured
                alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
                $this.button('reset');
                createModal.removeClass('modal_loading');
            },
            complete: function() {
                $this.button('reset');

            }
        });
    }
});

$(document).on('click', '.edit_pathology', function() {

    var createModal = $('#assigntestModal');
    var $this = $(this);
    var recordId = $this.data('recordId');
    $this.button('loading');
    $.ajax({
        url: base_url + 'admin/pathology/editpathology',
        type: "POST",
        data: {
            'id': recordId
        },
        dataType: 'json',
        beforeSend: function() {
            $this.button('loading');
            createModal.addClass('modal_loading');
        },
        success: function(res) {

            total_rows = res.total_rows;
            $('#assigntestModal #billno').val(res.bill_prefix + res.bill_no);
            $('#case_reference_id').val(res.case_reference_id);
            $('#assigntestModal .modal-body').html(res.page);
            $('.filestyle', '#assigntestModal').dropify();


            $('#txtDate10').data("DateTimePicker").date(new Date(res.pathology_date));

            updateDate();
            $('#viewDetailReportModal').modal('hide');
            $('#assigntestModal').modal('show');
            $('#prescription_no').attr('readonly', 'readonly');
            var option = new Option(res.patient_name, res.patient_id, true, true);
            $("#bill .patient_list_ajax").append(option).trigger('change');
            createModal.removeClass('modal_loading');
        },
        error: function(xhr) { // if error occured
            alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
            $this.button('reset');
            createModal.removeClass('modal_loading');
        },
        complete: function() {
            $this.button('reset');
            createModal.removeClass('modal_loading');
        }
    });
});

$('#load1').click(function() {
    $("#prescription_no").removeAttr("readonly");
});

function gettestpathodetails(testid, id) {
    $.ajax({
        type: "POST",
        url: base_url + "admin/pathology/gettestpathodetails",
        data: {
            'id': testid
        },
        dataType: 'json',
        success: function(res) {
            if (res != null) {
                //console.log(res);
                $('#reportday_' + id).val(res.result.report_days);
                $('#amount_' + id).val(res.result.standard_charge);
                $('#taxpercent_' + id).val(res.result.tax);
                var stnd_amt = $('#amount_' + id).val();
                var tax_per = $('#taxpercent_' + id).val();
                var tax_amount = stnd_amt * tax_per / 100;
                $('#taxamount_' + id).val(tax_amount);
                var day = $('#reportday_' + id).val()
                getdate(day, id)
                addTotal()
            }
        }
    });
}

function getdate(day, id) {
    var report_day = parseInt(day, 10);
    var selected_date = $("#txtDate10").data('DateTimePicker').date().toDate();
    var newdate = new Date(selected_date);
    newdate.setDate(newdate.getDate() + report_day);
    $("#reportdate_" + id).datepicker("update", newdate);
}

$(document).ready(function() {
    $('#assigntestModal').modal({
        backdrop: 'static',
        keyboard: true,
        show: false
    });
    $('.datetime').datetimepicker({
        format: datetime_format,
    });
});


$(document).on('click', '.add-record', function() {
    var table = document.getElementById("tableID");
    total_rows++;
    var template = $("#testpatho-template").html();
    var div = `
        <td>
            <input type='hidden' id='total_rows' name='total_rows[]' value='${total_rows}'>
            <input type='hidden' name='inserted_id_${total_rows}' value='0'>
            <select class='form-control test_name select2' style='width:100%' onchange='gettestpathodetails(this.value, ${total_rows})' name='test_name_${total_rows}'>
                <option value='<?php echo set_value('test_name_id'); ?>'><?php echo $this->lang->line('select') ?></option>
                ${template}
            </select>
        </td>
        <td><input type='text' name='reportday_${total_rows}' id='reportday_${total_rows}' class='form-control text-right days' readonly></td>
        <td><input type='text' name='reportdate_${total_rows}' id='reportdate_${total_rows}' class='form-control text-right report_date'></td>
        <td>
            <div class='input-group'>
                <input type='text' name='taxpercent_${total_rows}' id='taxpercent_${total_rows}' class='form-control text-right right-border-none taxpercent' autocomplete='off' readonly>
                <span class='input-group-addon'>%</span>
            </div>
        </td>
        <td>
            <input type='text' name='amount_${total_rows}' id='amount_${total_rows}' class='form-control text-right amount' readonly>
            <input type='hidden' name='taxamount_${total_rows}' id='taxamount_${total_rows}' class='form-control text-right taxamount' readonly>
        </td>`;
    var row =
        `<tr id='row${total_rows}'>${div}<td><button type='button' data-row-id='${total_rows}' class='closebtn delete_rows'><i class='fa fa-remove'></i></button></td></tr>`;

    $('#tableID').append(row);
    updateDate();
    $('.test_name').select2();
});


$(document).on('click', '.delete_rows', function(e) {
    var modal_ = $(e.target).closest('div.modal');
    var del_row_id = $(this).data('rowId');
    $("#row" + del_row_id).remove();
    addTotal();
});

function addTotal() {
    var total = 0;
    var total_taxamt = 0;
    var medicineTable = $("#assigntestModal .modal-body").find('table.tblProducts');
    medicineTable.find("tbody tr").each(function() {
        total += parseFloat($(this).find("td input.amount").val());
        total_taxamt += parseFloat($(this).find("td input.taxamount").val());
    });
    if (total > 0) {
        var discount_percent = $("#discount_percent").val();
        if (discount_percent != '') {
            var discount = (total * discount_percent) / 100;
            $("#discount").val(discount.toFixed(2));
        } else {
            var discount = $("#discount").val();
        }
        $("#total").val(total.toFixed(2));
        var net_amount = parseFloat(total) + parseFloat(total_taxamt) - parseFloat(discount);
        var cnet_amount = net_amount.toFixed(2)
        $("#net_amount").val(cnet_amount);
        $("#amount").val(cnet_amount);
        $("#tax").val(total_taxamt.toFixed(2));
        $("#payamount").val(cnet_amount);
        $("#billsave").show();
        $(".printsavebtn").show();
    }else{
        errorMsg("Please Select Atleast One Test Name");
        exit();
    }

}

function dateChanged(ev) {
    var $tblrows = $('.tblProducts').find("tbody tr");
    $tblrows.each(function(index) {
        var $tblrow = $(this);
        var _row_day = $tblrow.find(".days").val();
        if (_row_day != "") {

            //==============
            var report_day = parseInt(_row_day, 10);
            var selected_date = $("#txtDate10").data('DateTimePicker').date().toDate();
            var newdate = new Date(selected_date);
            newdate.setDate(newdate.getDate() + report_day);
            $tblrow.find(".report_date")
                .datepicker({
                    format: date_format_new,
                    autoclose: true,
                    todayHighlight: true
                }).datepicker("update", newdate);
            //================            

        }
    });
}


$(document).ready(function () {
    $("form#bill button[type=submit]").click(function () {
        $("button[type=submit]", $(this).parents("form")).removeAttr("clicked");
        $(this).attr("clicked", "true");
    });

    $(document).on('submit', '#bill', function (e) {
        e.preventDefault();
        let submit_button = $("button[type=submit][clicked=true]", this);
        let submit_button_name = submit_button.attr('name');
        let formData = new FormData(this);
        let validationErrors = [];

        let prescriptionNo = formData.get('prescription_no') || '';
        let jsonData = {
            case_reference_id: parseInt(formData.get('case_reference_id')) || undefined,
            ipd_prescription_basic_id: parseInt(prescriptionNo.match(/\d+/)) || undefined,
            patient_id: parseInt(formData.get('patientid')) || 0,
            doctor_id: parseInt(formData.get('consultant_doctor')) || 0,
            doctor_name: formData.get('doctor_name') || '',
            total: formData.get('total') || '0',
            discount_percentage: formData.get('discount_percent') || '0',
            discount: formData.get('discount') || '0',
            tax_percentage: formData.get('tax_percent') || '0',
            tax: formData.get('tax') || '0',
            net_amount: formData.get('net_amount') || '0',
            note: formData.get('note') || '',
            generated_by: <?= $data['id'] ?> || 0,
            payment_mode: formData.get('payment_mode') || '',
            amount: formData.get('amount') || '0',
            cheque_no: formData.get('cheque_no') || '',
            cheque_date: formData.get('cheque_date') || new Date().toISOString().slice(0, 19).replace('T', ' '),
            attachment: "new.jpg",
            attachment_name: "new",
            hospital_id: <?= $data['hospital_id'] ?> || 0
        };

        if (!jsonData.doctor_name) validationErrors.push("Doctor Name is required.");
        if (!jsonData.patient_id) validationErrors.push("Patient ID is required.");

        let pathologyItems = [];
        let totalRows = formData.getAll('total_rows[]');

        totalRows.forEach((_, index) => {
            let test_name = formData.get(`test_name_${index + 1}`);
            let report_date = formData.get(`reportdate_${index + 1}`);
            let amount_inr = formData.get(`amount_${index + 1}`);

            if (!test_name) validationErrors.push(`Test Name is required for row ${index + 1}`);
            if (!report_date) validationErrors.push(`Report Date is required for row ${index + 1}`);
            if (!amount_inr) validationErrors.push(`Amount (INR) is required for row ${index + 1}`);

            if (test_name && report_date && amount_inr) {
                pathologyItems.push({
                    pathology_bill_id: 1,
                    pathology_id: parseInt(test_name),
                    patient_id: jsonData.patient_id,
                    reporting_date: new Date(report_date).toISOString().slice(0, 10) + " 11:11:11",
                    tax_percentage: formData.get(`taxpercent_${index + 1}`),
                    apply_charge: amount_inr,
                    hospital_id: jsonData.hospital_id
                });
            }
        });

        if (validationErrors.length) {
            errorMsg(validationErrors.join("<br>"));
            return;
        }

        if (jsonData.payment_mode === 'Online') {
            handlePayment(jsonData).then((paymentSuccess) => {
                if (paymentSuccess) {
                    Object.assign(jsonData, {
                        payment_gateway: 'razorpay',
                        payment_id: paymentSuccess.payment_id,
                        payment_reference_number: paymentSuccess.reference_id
                    });
                    submitForm();
                } else {
                    errorMsg("Payment failed. Please try again.");
                }
            });
        } else {
            submitForm();
        }

        function submitForm() {
            let editid = $('#pathology_billing_id').val();
            let api1 = editid ? `<?= $api_base_url ?>pathology-generate-bill/${editid}` : '<?= $api_base_url ?>pathology-generate-bill';
            let method = editid ? "PATCH" : "POST";
            let api2 = editid ? '<?= $api_base_url ?>pathology-generate-bill/editpathologyReport' : '<?= $api_base_url ?>pathology-generate-bill/pathologyReport';

            let previousIds = $('[name^="inserted_id_"]').map(function () { return $(this).val(); }).get();
            pathologyItems.forEach((item, index) => item["id"] = previousIds[index] || null);

            let finalData = { ...jsonData, pathology_items: pathologyItems };

            $.ajax({
                url: api1,
                type: method,
                data: JSON.stringify(finalData),
                contentType: "application/json",
                dataType: 'json',
                beforeSend: () => submit_button.prop('disabled', true),
                success: function (data) {
                    let id = data?.[0]?.["data "]?.Pathology_bill_Values?.[0]?.id || data?.[0]?.["data "]?.updated_values?.[0]?.id || null;
                    pathologyItems.forEach(item => item.pathology_bill_id = id);

                    $.ajax({
                        url: api2,
                        type: method,
                        data: JSON.stringify(pathologyItems),
                        contentType: "application/json",
                        dataType: 'json',
                        beforeSend: () => submit_button.prop('disabled', true),
                        success: function (data) {
                            successMsg(data.message);
                            table.ajax.reload();
                            $('#assigntestModal').modal('hide');

                            if (submit_button_name === "save_print") {
                                let insertId = data?.data?.[0]?.pharmacyBillDetail?.id;
                                if (insertId) printData(insertId);
                            }
                        },
                        error: () => errorMsg("An error occurred. Please try again."),
                        complete: () => submit_button.prop('disabled', false)
                    });
                },
                error: () => errorMsg("An error occurred. Please try again."),
                complete: () => submit_button.prop('disabled', false)
            });
        }
    });
});







$(document).ready(function(e) {
    $('#txtDate10').datetimepicker({
        format: datetime_format,
    });
    $('#txtDate10').data("DateTimePicker").date(new Date());

    $('#txtDate10').on('dp.change', dateChanged);

});

function get_Docname(id) {
    //$("#standard_charge").html("standard_charge");
    $.ajax({
        url: '<?php echo base_url(); ?>admin/patient/doctName',
        type: "POST",
        data: {
            doctor: id
        },
        dataType: 'json',
        success: function(res) {
            if (res) {
                $('#doctname').val(res.name + " " + res.surname + " (" + res.employee_id + ")");
                $('#doctorid').val(res.id);
            } else {

            }
        }
    });
}


function viewDetailReport(id, pathology_id) {
    $.ajax({
        url: '<?php echo base_url() ?>admin/pathology/getReportDetails/' + id + '/' + pathology_id,
        type: "GET",
        data: {
            id: id
        },
        success: function(data) {
            $('#reportdatareport').html(data);
            $('#edit_deletereport').html(
                "<?php if ($this->rbac->hasPrivilege('pathology_bill', 'can_view')) { ?><a href='#' data-toggle='tooltip' onclick='printData(" +
                id + "," + pathology_id +
                ")' data-original-title='<?php echo $this->lang->line('print'); ?>'><i class='fa fa-print'></i></a> <?php } ?>"
            );
            holdModal('viewModalReport');
        },
    });
}


$(document).on('click', '.view_detail', function() {
    var id = $(this).data('recordId');
    PatientPathologyDetails(id, $(this));
});

function PatientPathologyDetails(id, btn_obj) {
    var modal_view = $('#viewDetailReportModal');
    var $this = btn_obj;
    $.ajax({
        url: base_url + 'admin/pathology/getPatientPathologyDetails',
        type: "POST",
        data: {
            'id': id
        },
        dataType: 'json',
        beforeSend: function() {
            $this.button('loading');
            modal_view.addClass('modal_loading');

        },
        success: function(data) {

            $('#viewDetailReportModal .modal-body').html(data.page);
            $('#viewDetailReportModal #action_detail_report_modal').html(data.actions);
            // console.log(data.actions);

            $('#viewDetailReportModal').modal('show');
            modal_view.removeClass('modal_loading');
        },

        error: function(xhr) { // if error occured
            alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
            $this.button('reset');
            modal_view.removeClass('modal_loading');
        },
        complete: function() {
            $this.button('reset');
            modal_view.removeClass('modal_loading');

        }
    });
}

$(document).on('click', '.add_collection', function() {
    $('#collected_by').val('');
    var id = $(this).data('recordId');
    var modal_view = $('#collectionModal');
    var $this = $(this);
    $.ajax({
        url: base_url + 'admin/pathology/getReportCollectionDetail',
        type: "POST",
        data: {
            'id': id
        },
        dataType: 'json',
        beforeSend: function() {
            $this.button('loading');
        },
        success: function(data) {

            $("#collected_by").val(data.report.collection_specialist);
            $("#collectionModal .modal-body").find('input[name="pathology_report_id"]').val(data
                .report.id);
            $("#collectionModal .modal-body").find('input[name="pathology_bill_id"]').val(data
                .report.pathology_bill_id);
            $("#collectionModal .modal-body").find('input[name="pathology_center"]').val(data.report
                .pathology_center);
            $("#collectionModal .modal-body").find('input[name="collected_date"]').datepicker(
                "update", new Date(data.report.collection_date));
            $('#collectionModal').modal('show');
        },

        error: function(xhr) { // if error occured
            alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
            $this.button('reset');

        },
        complete: function() {
            $this.button('reset');

        }
    });
});

$(document).on('click', '.add_report', function() {
    var id = $(this).data('recordId');
    var modal_view = $('#addReportModal');
    var $this = $(this);
    $.ajax({
        url: base_url + 'admin/pathology/getPathologyReportDetail',
        type: "POST",
        data: {
            'id': id
        },
        dataType: 'json',
        beforeSend: function() {
            $this.button('loading');
        },
        success: function(data) {
            $('#addReportModal .modal-body').html(data.page);
            $('#addReportModal .filestyle').dropify();
            $('#addReportModal').modal('show');
        },

        error: function(xhr) { // if error occured
            alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
            $this.button('reset');

        },
        complete: function() {
            $this.button('reset');

        }
    });


});

$(document).on('click', '.print_pathology_report', function() {
    var id = $(this).data('recordId');

    var $this = $(this);
    $.ajax({
        url: base_url + 'admin/pathology/printPatientReportDetail',
        type: "POST",
        data: {
            'id': id
        },
        dataType: 'json',
        beforeSend: function() {
            $this.button('loading');
        },
        success: function(data) {
            popup(data.page);
        },

        error: function(xhr) { // if error occured
            alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
            $this.button('reset');

        },
        complete: function() {
            $this.button('reset');

        }
    });
});



$(document).on('click', '.view_bill', function() {
    var id = $(this).data('recordId');
    var modal_view = $('#viewModalbill');
    var $this = $(this);

    $.ajax({
        url: base_url + 'admin/pathology/getBillDetails',
        type: "POST",
        data: {
            'id': id
        },
        dataType: 'json',
        beforeSend: function() {
            $this.button('loading');
        },
        success: function(data) {

            $('#viewModalbill .modal-body').html(data.page);
            $('#edit_deletebill').html(
                "<?php if ($this->rbac->hasPrivilege('pathology_bill', 'can_view')) { ?><a href='javascript:void(0)' data-loading-text='<i class=\"fa fa-circle-o-notch fa-spin\"></i>' class='print_bill' data-toggle='tooltip' data-record-id=" +
                id +
                "   data-original-title='<?php echo $this->lang->line('print'); ?>'><i class='fa fa-print'></i></a> <?php } ?>"
            );
            $('#viewModalbill').modal('show');

        },

        error: function(xhr) { // if error occured
            alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
            $this.button('reset');

        },
        complete: function() {
            $this.button('reset');

        }
    });
});

$(document).on('click', '.print_bill', function() {
    var id = $(this).data('recordId');

    var $this = $(this);

    $.ajax({
        url: base_url + 'admin/pathology/getBillDetails',
        type: "POST",
        data: {
            'id': id
        },
        dataType: 'json',
        beforeSend: function() {
            $this.button('loading');
        },
        success: function(data) {
            popup(data.page);

        },

        error: function(xhr) { // if error occured
            alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
            $this.button('reset');

        },
        complete: function() {
            $this.button('reset');

        }
    });

});

function printData(id) {
    $.ajax({
        url: base_url + 'admin/pathology/getBillDetails',
        type: "POST",
        data: {
            'id': id
        },
        dataType: 'json',
        beforeSend: function() {},
        success: function(data) {
            popup(data.page);

        },

        error: function(xhr) { // if error occured
            alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");


        },
        complete: function() {


        }
    });
}

function deleterecord(id) {
    var url = '<?php echo base_url() ?>admin/pathology/deleteTestReport/' + id;
    var msg = "<?php echo $this->lang->line('delete_message') ?>";
    delete_recordById(url, msg)
}

function editTestReport(id) {
    $.ajax({
        url: '<?php echo base_url(); ?>admin/pathology/getPathologyReport',
        type: "POST",
        data: {
            id: id
        },
        dataType: 'json',
        success: function(data) {

            $("#report_id").val(data.id);
            $("#charge_category_html").val(data.charge_category);
            $("#code_html").val(data.code);
            $("#charge_html").val(data.standard_charge);
            $("#customer_types").val(data.customer_type);
            $("#opdipd").val(data.opd_ipd_no);
            $("#edit_patient_name").val(data.patient_name);
            $("#edit_report_date").val(data.reporting_date);
            if (data.apply_charge == "") {
                $("#apply_charge").val(data.standard_charge);
            } else {
                $("#apply_charge").val(data.apply_charge);
            }
            $('select[id="edit_consultant_doctor"] option[value="' + data.consultant_doctor + '"]').attr(
                "selected", "selected");
            $("#edit_description").val(data.description);
            $(".select2").select2().select2('val', data.patient_id);
            $("#viewModal").modal('hide');
            holdModal('editTestReportModal');


        },
    })
}

$(document).ready(function(e) {
    $("#updatetest").on('submit', (function(e) {
        e.preventDefault();
        $("#updatetestbtn").button('loading');
        $.ajax({
            url: '<?php echo base_url(); ?>admin/pathology/updateTestReport',
            type: "POST",
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data.status == "fail") {
                    var message = "";
                    $.each(data.error, function(index, value) {
                        message += value;
                    });
                    errorMsg(message);
                } else {
                    successMsg(data.message);
                    window.location.reload(true);
                }
                $("#updatetestbtn").button('reset');
            },
            error: function() {}
        });
    }));

    $(document).on('submit', '#form-sample-collected', function(e) {
        e.preventDefault();
        var clicked_btn = $("button[type=submit]", $(this));
        var form = $(this);

        var collectedBy = $('#collected_by').val().trim();
        var collectedDate = $(this).find('input[name="collected_date"]').val().trim();
        var pathologyCenter = $(this).find('input[name="pathology_center"]').val().trim();
        let id = $("input[name='pathology_report_id']").val();

        var missingFields = [];

        if (!collectedBy) missingFields.push("Collection Specialist is required.");
        if (!collectedDate) missingFields.push("Collection Date is required.");
        if (!pathologyCenter) missingFields.push("Pathology Center is required.");
        if (!id) missingFields.push("Pathology Report ID is required.");

        if (missingFields.length > 0) {
            let message = "Please correct the following errors:\n" + missingFields.join("\n");
            errorMsg(message.replace(/\n/g, "<br>")); // Ensure line breaks in error messages
            return;
        }

        var formDataJson = {
            "collection_specialist": collectedBy,
            "collection_date": moment(collectedDate, 'MM/DD/YYYY').format('YYYY-MM-DD'),
            "pathology_center": pathologyCenter,
            "hospital_id": <?= $data['hospital_id'] ?>
        };

        $.ajax({
            url: '<?= $api_base_url ?>pathology-generate-bill/updateCollectedPerson/' + id,
            type: "PATCH",
            data: JSON.stringify(formDataJson),
            contentType: "application/json",
            dataType: 'json',
            beforeSend: function() {
                clicked_btn.button('loading');
            },
            success: function(response) {
                let message = response[0]?. ['data ']?.messege || 'Default success message';
                successMsg(message);
                location.reload();
            },
            error: function(xhr) {
                alert(
                    "<?php echo $this->lang->line('error_occurred_please_try_again'); ?>"
                );
                clicked_btn.button('reset');
            },
            complete: function() {
                clicked_btn.button('reset');
            }
        });
    });


    $(document).on('submit', '#form-report_param', function(e) {
        e.preventDefault();

        var clicked_btn = $("button[type=submit]", $(this));
        var form = $(this);
        var formData = new FormData(this);

        let fileInput = document.getElementById('attachment_report1').files[0];
        var documentUrl = $('#filedataalread').val();

        var approvedBy = formData.get('approved_by') ? formData.get('approved_by').trim() : '';
        if (!approvedBy) {
            errorMsg("Approved By is required.");
            return;
        }

        let pathologyParameterValues = [];
        $("input[name^='pathology_parameter_']").each(function() {
            pathologyParameterValues.push($(this).val());
        });

        function submitSingleValue(value) {
            return new Promise((resolve, reject) => {
                let formattedData = {
                    "parameter_update": (() => {
                        var parts = formData.get('approve_date').split('/');
                        return `${parts[2]}-${parts[0]}-${parts[1]} 11:11:11`;
                    })(),
                    "approved_by": approvedBy,
                    "pathology_report": fileInput ? fileInput.name : '',
                    "report_name": fileInput ? fileInput.name : '',
                    "pathology_result": formData.get('test_result'),
                    "hospital_id": <?= $data['hospital_id'] ?>,
                    "pathology_parameterdetail_id": formData.get('pathology_parameterdetails[]'),
                    "pathology_report_value": value                
                };

                let id = $("#pathology_report_id").val();
                $.ajax({
                    url: '<?= $api_base_url ?>pathology-generate-bill/updateApprovalByPerson/' +
                        id,
                    type: "PATCH",
                    data: JSON.stringify(formattedData),
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function(response) {
                        resolve(response);
                    },
                    error: function(xhr) {
                        reject(xhr);
                    }
                });
            });
        }
        async function submitAllValues() {
            clicked_btn.button('loading');
            let promises = pathologyParameterValues.map(value => submitSingleValue(value));
            try {
                await Promise.all(promises);
                successMsg("Approval updated successfully!"); 
                window.location.reload(true);
            } catch (error) {
                alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
            } finally {
                clicked_btn.button('reset');
            }
        }
        submitAllValues();
    });



});

$(document).ready(function(e) {
    $("#parameteradd").on('submit', (function(e) {
        e.preventDefault();
        $("#parameteraddbtn").button('loading');
        $.ajax({
            url: '<?php echo base_url(); ?>admin/pathology/parameteraddvalue',
            type: "POST",
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data.status == "fail") {
                    var message = "";
                    $.each(data.error, function(index, value) {
                        message += value;
                    });
                    errorMsg(message);
                } else {
                    successMsg(data.message);
                    window.location.reload(true);
                }
                $("#parameteraddbtn").button('reset');
            },
            error: function() {}
        });
    }));
});

function updateDate() {
    $('#tableID').find('.report_date').datepicker({
        format: date_format_new,
        autoclose: true,
        todayHighlight: true
    });
}
</script>

<script type="text/javascript">
$(document).on('click', '#search_prescription', function() {


    $('#addpatient_id.select2-offscreen').empty();

    getPrescriptionData();
});


function getPrescriptionData() {
    var createModal = $('#assigntestModal');
    $.ajax({
        url: '<?php echo base_url(); ?>admin/pathology/prescriptionBill',
        type: "POST",
        data: {
            'prescription_no': $("input[name=prescription_no]").val(),
            'date': $('#txtDate10').val()
        },
        dataType: 'json',
        beforeSend: function() {
            createModal.addClass('modal_loading');
        },
        success: function(res) {
            $('#assigntestModal .modal-body').html(res.page);
            $('#case_reference_id').val(res.case_reference_id);
            $('.filestyle', '#assigntestModal').dropify();
            $("#addpatient_id").select2("val", '');
            $(".test_name").select2();
            updateDate();
            addTotal();
            total_rows = (res.total_rows <= 0) ? 1 : res.total_rows;
            total_rows = res.total_rows;
            if (res.patient_id == 0) {
                errorMsg("<?php echo $this->lang->line('no_prescription_found'); ?>");
            } else {

                addappointmentModal(res.patient_id, 'assigntestModal');
            }
        },
        error: function(xhr) { // if error occured
            alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
            createModal.removeClass('modal_loading');
        },
        complete: function() {
            createModal.removeClass('modal_loading');
        }
    });
}


$(document).on('change', '.payment_mode', function() {
    var mode = $(this).val();
    if (mode == "Cheque") {
        $('.filestyle', '#addPaymentModal').dropify();
        $('.cheque_div').css("display", "block");
    } else {
        $('.cheque_div').css("display", "none");
    }
});
$(document).on('click', '#addpatient_id', function() {

});
$('#addpatient_id').on('select2:select', function(e) {
    $('#case_reference_id').val('');
    $('#prescription_no').val('');
});
</script>

<!-- //========datatable start===== -->
<script type="text/javascript">
$(document).on('click', '.add_payment', function() {
    var record_id = $(this).data('recordId');
    var $add_btn = $(this);
    var payment_modal = $('#addPaymentModal');

    payment_modal.addClass('modal_loading');

    payment_modal.modal('show');

    getPayments(record_id);
});

function getPayments(record_id) {
    var payment_modal = $('#addPaymentModal');
    $.ajax({
        url: '<?php echo base_url() ?>admin/pathology/getPathologyTransaction',
        type: "POST",
        data: {
            'id': record_id
        },
        dataType: "JSON",
        beforeSend: function() {},
        success: function(data) {

            $('.modal-body', payment_modal).html(data.page);
            payment_modal.removeClass('modal_loading');
        },
        error: function() {
            payment_modal.removeClass('modal_loading');
        },
        complete: function() {
            payment_modal.removeClass('modal_loading');
        }
    });

}


$(document).on('submit', '#add_partial_payment', function (e) {
    e.preventDefault();

    let clicked_btn = $("button[type=submit]");
    let formData = new FormData(this);
    let paymentDate = formData.get('payment_date');
    let amount = formData.get('amount');
    let paymentMode = formData.get('payment_mode');
    let caseReferenceId = parseInt(formData.get('case_reference_id')) || 0;
    let errorMessages = [];

    if (!paymentDate) errorMessages.push("Date is required.");
    if (!amount || isNaN(amount) || parseFloat(amount) <= 0) errorMessages.push("Amount (INR) is required and must be a valid number.");

    if (errorMessages.length) {
        errorMsg(errorMessages.join("<br>"));
        clicked_btn.button('reset');
        return;
    }

    let finalData = {
        payment_date: formatDate(paymentDate),
        patient_id: parseInt(formData.get('patient_id')) || 0,
        pathology_billing_id: parseInt($("input[name='pathology_billing_id']", '#add_partial_payment').val()) || 0,
        note: formData.get('note') || '',
        received_by: <?= $data['id'] ?>,
        amount: parseFloat(amount).toFixed(2),
        payment_mode: paymentMode || '',
        attachment: "new.jpg",
        attachment_name: "new",
        hospital_id: <?= $data['hospital_id'] ?>
    };

    if (paymentMode === "Cheque" || paymentMode === "cheque") {
        finalData.cheque_no = formData.get('cheque_no') || "";
        finalData.cheque_date = formatDate(formData.get('cheque_date')) || " ";
    }

    if (caseReferenceId !== 0) {
        finalData.case_reference_id = caseReferenceId;
    }

    if (paymentMode === "Online") {
        handlePayment(finalData).then(paymentSuccess => {
            if (paymentSuccess) {
                Object.assign(finalData, {
                    payment_gateway: 'razorpay',
                    payment_id: paymentSuccess.payment_id,
                    payment_reference_number: paymentSuccess.reference_id
                });
                submitForm();
            } else {
                alert('Payment failed. Please try again.');
            }
        });
    } else {
        submitForm();
    }

    function submitForm() {
        $.ajax({
            url: '<?= $api_base_url ?>pathology-generate-bill/AddPathologyPayment',
            type: "POST",
            data: JSON.stringify(finalData),
            contentType: 'application/json',
            dataType: 'json',
            beforeSend: () => clicked_btn.button('loading'),
            success: function (data) {
                successMsg(data[0]?.['data ']?.messege || "Payment successful.");
                location.reload();
            },
            error: () => errorMsg("An error occurred. Please try again."),
            complete: () => clicked_btn.button('reset')
        });
    }
});




function formatDate(dateString) {
    if (!dateString) {
        console.error("Date string is undefined or empty.");
        return "";
    }
    const [datePart, timePart] = dateString.split(' ');
    if (!timePart) {
        console.error("Time part is missing.");
        return "";
    }
    const [month, day, year] = datePart.split('/');
    let [hour, minute] = timePart.split(':');
    const period = timePart.split(' ')[1];
    if (period === "PM" && hour !== "12") {
        hour = parseInt(hour) + 12;
    } else if (period === "AM" && hour === "12") {
        hour = "00";
    }
    const formattedDate =
        `${year}-${('0' + month).slice(-2)}-${('0' + day).slice(-2)} ${('0' + hour).slice(-2)}:${('0' + minute).slice(-2)}:00`;
    return formattedDate;
}





$(document).on('click', '.print_receipt', function() {
    var $this = $(this);
    var record_id = $this.data('recordId')
    $this.button('loading');
    $.ajax({
        url: '<?php echo base_url(); ?>admin/pathology/printTransaction',
        type: "POST",
        data: {
            'id': record_id
        },
        dataType: 'json',
        beforeSend: function() {
            $this.button('loading');

        },
        success: function(res) {
            popup(res.page);
        },
        error: function(xhr) { // if error occured
            alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
            $this.button('reset');

        },
        complete: function() {
            $this.button('reset');

        }
    });
});

$(document).on('click', '.delete_trans', function(e) {
    if (confirm('<?php echo $this->lang->line('delete_confirm') ?>')) {
        e.preventDefault();
        var record_id = $(this).data('recordId');
        var pathology_billing_id = $("input[name='pathology_billing_id']", '#add_partial_payment').val();
        var btn = $(this);
        btn.button('loading');
        $.ajax({
            url: '<?= $api_base_url ?>pathology-generate-bill/deletePathoPayment/' + record_id +
                '?Hospital_id=<?= $data['hospital_id'] ?>',
            type: "DELETE",
            data: {
                'id': record_id,
                'pathology_billing_id': pathology_billing_id
            },
            dataType: 'JSON',
            success: function(data) {
                successMsg(data.message);
                getPayments(pathology_billing_id);
                btn.button('reset');
                table.ajax.reload();
            },
            error: function() {
                btn.button('reset');
            },
            complete: function() {
                btn.button('reset');
            }
        });
    }

});


function popup(data) {
    var base_url = '<?php echo base_url() ?>';
    var frame1 = $('<iframe />');
    frame1[0].name = "frame1";
    frame1.css({
        "position": "absolute",
        "top": "-1000000px"
    });
    $("body").append(frame1);
    var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0]
        .contentDocument.document : frame1[0].contentDocument;
    frameDoc.document.open();
    //Create a new HTML document.
    frameDoc.document.write('<html>');
    frameDoc.document.write('<head>');
    frameDoc.document.write('<title></title>');
    frameDoc.document.write('</head>');
    frameDoc.document.write('<body >');
    frameDoc.document.write(data);
    frameDoc.document.write('</body>');
    frameDoc.document.write('</html>');
    frameDoc.document.close();
    setTimeout(function() {
        window.frames["frame1"].focus();
        window.frames["frame1"].print();
        frame1.remove();
    }, 500);
    return true;
}

$('#assigntestModal').on('hidden.bs.modal', function() {
    var assigntestModal = $('#assigntestModal');
    $('#addpatient_id').select2("val", "");
    $('#billno,#prescription_no,#case_reference_id', assigntestModal).val("");
    $("#assigntestModal").find('input[name="date"]').data("DateTimePicker").date(new Date());;
});

$(document).ready(function(e) {
    $('#viewDetailReportModal,#addPaymentModal,#collectionModal,#addReportModal').modal({
        backdrop: 'static',
        keyboard: false,
        show: false
    });
});
</script>
<script>
(function($) {
    'use strict';
    $(document).ready(function() {
        initDatatable('ajaxlist', 'admin/pathology/getpathologybillDatatable', [], [], 100,
            [{
                    "bSortable": false,
                    "sWidth": "105px",
                    "aTargets": [-1],
                    'sClass': 'dt-body-right'
                },
                {
                    "sWidth": "105px",
                    "aTargets": [-2, -3],
                    'sClass': 'dt-body-right'
                },
                {
                    "aTargets": [1],
                    'sClass': 'dt-body-center'
                }
            ]
        );
    });
}(jQuery))
</script>
<script>
$(document).on('click', '.print_parameter', function() {
    var id = $(this).data('recordId');

    var $this = $(this);
    $.ajax({
        url: base_url + 'admin/pathology/printtestparameterdetail',
        type: "POST",
        data: {
            'id': id
        },
        dataType: 'json',
        beforeSend: function() {
            $this.button('loading');
        },
        success: function(data) {
            popup(data.page);
        },

        error: function(xhr) { // if error occured
            alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
            $this.button('reset');

        },
        complete: function() {
            $this.button('reset');

        }
    });
});

function get_percentage(discount_amount) {
    var discount_amount = (discount_amount != "") ? discount_amount : 0;
    var total = $('#total').val();
    var tax = $('#tax').val();
    var discount_percent = 0;
    var net_amount = 0;
    discount_percent = ((parseInt(discount_amount) / parseInt(total)) * 100);
    $('#discount_percent').val(discount_percent.toFixed(2));
}
</script>
<script>
function deletePathology(id) {
    console.log(id);
}
</script>
<!-- //========datatable end===== -->
<?php $this->load->view('admin/patient/patientaddmodal') ?>