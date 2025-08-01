<style type="text/css">
    @media print {

        .no-print,
        .no-print * {
            display: none !important;
        }
    }
</style>
<?php
$currency_symbol = $this->customlib->getHospitalCurrencyFormat();
?>
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line('transaction_report') ?></h3>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <div class="box-body pb0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <form id="form1">
                                        <div class="box-body row">
                                            <?php echo $this->customlib->getCSRF(); ?>
                                            <div class="col-sm-6 col-md-3">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('search_type'); ?></label><small
                                                        class="req"> *</small>
                                                    <select class="form-control" name="search_type"
                                                        id="search_type_select" onchange="showdate(this.value)">
                                                        <option value="" disabled>
                                                            <?php echo $this->lang->line('select') ?></option>
                                                        <?php
                                                        foreach ($searchlist as $key => $search) { ?>
                                                            <option value="<?php echo $key ?>" <?php
                                                                                                if ((isset($search_type)) && ($search_type == $key)) {
                                                                                                    echo "selected";
                                                                                                }
                                                                                                ?>>
                                                                <?php echo $search ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <span class="text-danger"
                                                        id="error_search_type"><?php echo form_error('search_type'); ?></span>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-3">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('collected_by'); ?></label>
                                                    <select class="form-control select2" name="collect_staff"
                                                        style="width: 100%" id="collect_staff_select">
                                                        <option value="" selected>All</option>
                                                        <?php foreach ($collected_by_list as $item) {
                                                            $name = $item['received_by_name'];
                                                            if (!empty($name)) { ?>
                                                                <option value="<?php echo htmlspecialchars($name); ?>"
                                                                    <?php
                                                                    if (isset($staffsearch_select) && $staffsearch_select == $name) {
                                                                        echo "selected";
                                                                    } ?>>
                                                                    <?php echo htmlspecialchars($name); ?>
                                                                </option>
                                                        <?php }
                                                        } ?>
                                                    </select>

                                                    <span class="text-danger"
                                                        id="error_collect_staff"><?php echo form_error('collect_staff'); ?></span>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-3" id="fromdate" style="display: none">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('date_from'); ?></label><small
                                                        class="req"> *</small>
                                                    <input id="date_from" name="date_from" placeholder="" type="text"
                                                        class="form-control date"
                                                        value="<?php echo set_value('date_from', date($this->customlib->getHospitalDateFormat())); ?>" />
                                                    <span
                                                        class="text-danger"><?php echo form_error('date_from'); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-3" id="todate" style="display: none">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('date_to'); ?></label><small
                                                        class="req"> *</small>
                                                    <input id="date_to" name="date_to" placeholder="" type="text"
                                                        class="form-control date"
                                                        value="<?php echo set_value('date_to', date($this->customlib->getHospitalDateFormat())); ?>" />
                                                    <span
                                                        class="text-danger"><?php echo form_error('date_to'); ?></span>
                                                </div>
                                            </div>

                                            <!-- <div class="col-sm-6 col-md-3">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('select_head'); ?></label>
                                                    <select class="form-control select2" name="modules_select"
                                                        style="width: 100%" id="modules_select">
                                                        <?php foreach ($modules as $key => $search) { ?>
                                                        <option value="<?php echo $key ?>" <?php
                                                                                            if ((isset($modules_type)) && ($modules_type == $key)) {
                                                                                                echo "selected";
                                                                                            }
                                                                                            ?>><?php echo $search ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <span class="text-danger"
                                                        id="error_modules_staff"><?php echo form_error('modules_staff'); ?></span>
                                                </div>
                                            </div> -->

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <button type="submit" name="search" value="search_filter"
                                                        class="btn btn-primary btn-sm pull-right"><i
                                                            class="fa fa-search"></i>
                                                        <?php echo $this->lang->line('search'); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tabsborderbg"></div>
                    <div class="nav-tabs-custom border0">
                        <div class="tab-content">
                            <div class="tab-pane active" id="all">
                                <div class="download_label"><?php echo $this->lang->line('transaction_report'); ?></div>
                                <div id="payment-summary-tags"></div>
                                <div class="box-body table-responsive">
                                    <table class="table table-striped table-bordered ipdcharged" id="summary-table">
                                        <thead>
                                            <th>S.No</th>
                                            <th><?php echo $this->lang->line('transaction_id'); ?></th>
                                            <th>Appointment No</th>
                                            <th id="clmname"></th>
                                            <th><?php echo $this->lang->line('date'); ?></th>
                                            <th><?php echo $this->lang->line('reference'); ?></th>
                                            <th><?php echo $this->lang->line('category'); ?></th>
                                            <th id="collection-generated-clm"></th>
                                            <th><?php echo $this->lang->line('payment_mode'); ?></th>
                                            <th class="text-right">
                                                <?php echo $this->lang->line('amount') . " (" . $currency_symbol . ")"; ?>
                                            </th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- /.row -->
    </section><!-- /.content -->
</div>
<script type="text/javascript">
    function showdate(value) {
        if (value == 'period') {
            $('#fromdate').show();
            $('#todate').show();
        } else {
            $('#fromdate').hide();
            $('#todate').hide();
        }
    }
</script>
<script>
    $(document).ready(function() {
        let baseurl = '<?= base_url() ?>';
        var dataTable = initSummaryDataTable(`${baseurl}/admin/transaction/getalltransationreport`, '#form1', '#summary-table', updatePaymentSummary);
        $('#form1').on('submit', function(e) {
            e.preventDefault();
            dataTable.ajax.reload();
        });
    });

    function renderSummaryTable(dataArray) {
        return (dataArray || []).map(function(row, index) {
            let trans_prefix = '<?= $this->customlib->getSessionPrefixByType("transaction_id") ?>';
            let app_prefix = '<?= $this->customlib->getSessionPrefixByType("appointment") ?>';
            let reference_prefix = '';
            let reference = '-';
            let baseurl = '<?= base_url() ?>';
            if (row.section === "OPD") {
                reference_prefix = '<?= $this->customlib->getSessionPrefixByType("opd_no") ?>';
                if (row.reference) {
                    let patientid = row.patient_id || '';
                    reference =
                        `<span onclick="window.location.href='${baseurl}admin/patient/visitdetails/${btoa(patientid)}/${btoa(row.reference)}'" style="cursor:pointer; color:#0084B4;">${reference_prefix + row.reference}</span>`;
                }
            } else if (row.section === "IPD") {
                reference_prefix = '<?= $this->customlib->getSessionPrefixByType("ipd_no") ?>';
                reference =
                    `<span onclick="window.location.href='${baseurl}admin/patient/ipdprofile/${row.reference}'" style="cursor:pointer; color:#0084B4;">${reference_prefix + row.reference}</span>`;
            } else if (row.section === "Appointment") {
                reference_prefix = '<?= $this->customlib->getSessionPrefixByType("appointment") ?>';
                reference = row.reference ? (reference_prefix + row.appointment_id) : '-';
            } else {
                reference_prefix = '<?= $this->customlib->getSessionPrefixByType("appointment") ?>';
                reference = row.reference ? (reference_prefix + row.reference) : '-';
            }
            return [
                index + 1,
                row.id ? (trans_prefix + row.id) : '-',
                row.appointment_id ?
                `<span onclick="viewDetail(${row.appointment_id})" style="cursor:pointer; color:#0084B4;">${app_prefix + row.appointment_id}</span>` :
                '-',
                row.patient_name ? (row.patient_name + ' (' + row.patient_id + ')') : '-',
                globalformatDate(row.payment_date),
                reference,
                row.section || '-',
                row.received_by_name || '-',
                row.payment_mode || '-',
                row.amount ? "₹" + Number(row.amount).toFixed(2) : '-'
            ];
        });
    }  
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#clmname").html('<?php echo $this->lang->line('patient_name'); ?>');
        $("#collection-generated-clm").html('<?php echo $this->lang->line('collected_by'); ?>');
        var date_format =
            '<?php echo $result = strtr($this->customlib->getHospitalDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy']) ?>';
        $(".date").datepicker({
            format: date_format,
            autoclose: true,
            todayHighlight: true
        });
    });
</script>
<script type="text/javascript">
    var base_url = '<?php echo base_url() ?>';

    function printDiv(elem) {
        Popup(jQuery(elem).html());
    }

    function Popup(data) {
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
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/bootstrap/css/bootstrap.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/font-awesome.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/ionicons.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/AdminLTE.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/skins/_all-skins.min.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/iCheck/flat/blue.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/plugins/morris/morris.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url +
            'backend/plugins/jvectormap/jquery-jvectormap-1.2.2.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url +
            'backend/plugins/datepicker/datepicker3.css">');
        frameDoc.document.write('<link rel="stylesheet" href="' + base_url +
            'backend/plugins/daterangepicker/daterangepicker-bs3.css">');
        frameDoc.document.write('</head>');
        frameDoc.document.write('<body>');
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
</script>