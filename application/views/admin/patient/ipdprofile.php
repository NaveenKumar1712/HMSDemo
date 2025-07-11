<?php
$currency_symbol = $this->customlib->getHospitalCurrencyFormat();
$genderList = $this->customlib->getGender();
$case_reference_id = $result['case_reference_id'];
$categorylist = $this->operationtheatre_model->category_list();

$data = $this->session->userdata('hospitaladmin');
$api_base_url = $this->config->item('api_base_url');
$patient_id_api = $result['id'];
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>backend/plugins/timepicker/bootstrap-timepicker.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>backend/multiselect/css/jquery.multiselect.css">
<script src="<?php echo base_url(); ?>backend/multiselect/js/jquery.multiselect.js"></script>
<div class="content-wrapper">
    <section class="content">
        <div class="box box-primary">
            <div class="box border0 mb0">
                <div class="nav-tabs-custom border0 mb0" id="tabs">
                    <ul class="nav nav-tabs navlistscroll">
                        <li class="active"><a href="#overview" data-toggle="tab" aria-expanded="true"><i
                                    class="fa fa-th"></i> <?php echo $this->lang->line('overview'); ?></a></li>
                        <?php if ($this->rbac->hasPrivilege('nurse_note', 'can_view')) { ?>
                            <li>
                                <a href="#nurse_note" data-toggle="tab" aria-expanded="true"><i
                                        class="fas fa-sticky-note"></i> <?php echo $this->lang->line('nurse_notes'); ?></a>
                            </li>
                        <?php } ?>
                        <!-- <?php if ($this->rbac->hasPrivilege('ipd_medication', 'can_view')) {  ?>
                            <li>
                                <a href="#medication" class="medication" data-toggle="tab" aria-expanded="true"><i class="fa fa-medkit" aria-hidden="true"></i> <?php echo $this->lang->line("medication"); ?></a>
                            </li>
                        <?php } ?> -->

                        <!-- <?php if ($this->rbac->hasPrivilege('ipd_prescription', 'can_view')) { ?>
                            <li>
                                <a href="#prescription" data-toggle="tab" aria-expanded="true"><i class="far fa-calendar-check"></i> <?php echo $this->lang->line('prescription'); ?></a>
                            </li>
                        <?php } ?> -->
                        <?php if ($this->rbac->hasPrivilege('consultant_register', 'can_view')) { ?>
                            <li class="">
                                <a href="#consultant_register" data-toggle="tab" aria-expanded="true"><i
                                        class="fas fa-file-prescription"></i>
                                    <?php echo $this->lang->line('consultant_register'); ?></a>
                            </li>
                        <?php } ?>
                        <!-- <?php if ($this->rbac->hasPrivilege('ipd_lab_investigation', 'can_view')) { ?>

                            <li>
                                <a href="#labinvestigation" data-toggle="tab" aria-expanded="true"><i class="fas fa-diagnoses"></i> <?php echo $this->lang->line('lab_investigation'); ?></a>
                            </li>
                        <?php } ?> -->
                        <?php if ($this->rbac->hasPrivilege('ipd_operation_theatre', 'can_view')) {  ?>
                            <!-- <li>
                                <a href="#operationtheatre" class="operationtheatre" data-toggle="tab"
                                    aria-expanded="true"><i class="fas fa-cut" aria-hidden="true"></i>
                                    <?php echo $this->lang->line("operations"); ?></a>

                            </li> -->
                        <?php } ?>
                        <?php if ($this->rbac->hasPrivilege('charges', 'can_view')) { ?>

                            <li>
                                <a href="#charges" data-toggle="tab" aria-expanded="true"><i class="fas fa-donate"></i>
                                    <?php echo $this->lang->line('charges'); ?></a>
                            </li>
                        <?php } ?>
                        <?php if ($this->rbac->hasPrivilege('payment', 'can_view')) { ?>

                            <li>
                                <a href="#payment" data-toggle="tab" aria-expanded="true"><i
                                        class="fas fa-hand-holding-usd"></i>
                                    <?php echo $this->lang->line('payments'); ?></a>
                            </li>
                        <?php } ?>
                        <?php if ($this->module_lib->hasActive('live_consultation')) {
                            if ($this->rbac->hasPrivilege('ipd_live_consultation', 'can_view')) {  ?>
                                <li>
                                    <a href="#live_consult" class="live_consult" data-toggle="tab" aria-expanded="true"><i
                                            class="fa fa-video-camera ftlayer"></i>
                                        <?php echo $this->lang->line('live_consultation'); ?></a>
                                </li>
                        <?php }
                        } ?>
                        <?php if ($this->rbac->hasPrivilege('bed_history', 'can_view')) {  ?>
                            <li>
                                <a href="#bed_history" class="bed_history" data-toggle="tab" aria-expanded="true"><i
                                        class="fas fa-procedures"></i> <?php echo $this->lang->line("bed_history"); ?></a>
                            </li>
                        <?php } ?>

                        <?php if ($this->rbac->hasPrivilege('ipd_timeline', 'can_view')) { ?>

                            <li>
                                <a href="#timeline" data-toggle="tab" aria-expanded="true"><i
                                        class="far fa-calendar-check"></i> <?php echo $this->lang->line('timeline'); ?></a>
                            </li>
                        <?php } ?>



                        <?php if ($this->rbac->hasPrivilege('ipd_treatment_history', 'can_view')) { ?>

                            <li>
                                <a href="#treatment_history" data-toggle="tab" aria-expanded="true"><i
                                        class="fas fa-hourglass-half"></i>
                                    <?php echo $this->lang->line('treatment_history'); ?></a>
                            </li>


                        <?php } ?>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane tab-content-height active" id="overview">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 border-r">
                                    <div class="box-header border-b mb10 pl-0 pt0">
                                        <h3 class="text-uppercase bolds mt0 ptt10 pull-left font14">
                                            <?php echo composePatientName($result['patient_name'], $result['patient_id']); ?>
                                        </h3>
                                        <div class="pull-right">
                                            <div class="editviewdelete-icon pt8">
                                                <a class="" href="#" onclick="getRecord('<?php echo $ipdid ?>')"
                                                    data-toggle="tooltip"
                                                    title="<?php echo $this->lang->line('profile') ?>"><i
                                                        class="fa fa-reorder"></i>
                                                </a>
                                                <?php

                                                if ($result['is_active'] != 'no') {
                                                    if ($result['ipd_discharge'] != 'yes') {
                                                        if ($this->rbac->hasPrivilege('ipd_patient', 'can_edit')) {
                                                ?>
                                                            <a class="" href="#" onclick="getEditRecord('<?php echo $ipdid ?>')"
                                                                data-toggle="tooltip"
                                                                title="<?php echo $this->lang->line('edit_profile'); ?>"><i
                                                                    class="fa fa-pencil"></i>
                                                            </a>

                                                        <?php }
                                                    }
                                                    if (!$is_discharge) {
                                                        if ($this->rbac->hasPrivilege('opd_patient_discharge_revert', 'can_view')) { ?>
                                                            <a data-toggle="tooltip" class=""
                                                                onclick="discharge_revert('<?php echo $result['case_reference_id']; ?>')"
                                                                href="#"
                                                                title="<?php echo $this->lang->line('discharge_revert') ?>"><i
                                                                    class="fa fa-undo"> </i></a>
                                                        <?php
                                                        }
                                                    }
                                                    if ($this->rbac->hasPrivilege('ipd_patient_discharge', 'can_view')) { ?>
                                                        <a class="patient_discharge" href="#" data-toggle="tooltip"
                                                            title="<?php echo $this->lang->line('patient_discharge'); ?>"><i
                                                                class="fa fa-hospital-o"></i>
                                                        </a>

                                                        <?php }

                                                    if ($result['ipd_discharge'] != 'yes') {
                                                        if ($this->rbac->hasPrivilege('ipd_patient', 'can_delete')) { ?>
                                                            <a class="" href="#" onclick="deleteIpdPatient('<?php echo $ipdid ?>')"
                                                                data-toggle="tooltip"
                                                                title="<?php echo $this->lang->line('delete_patient'); ?>"><i
                                                                    class="fa fa-trash"></i>
                                                            </a>


                                                <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 col-sm-12 ptt10">
                                            <?php
                                            $default_image = "uploads/staff_images/no_image.png";
                                            $doc_image = !empty($result['image']) ? $result['image'] : "uploads/patient_images/no_image.png";
                                            $base64Image = '';

                                            if (!empty($doc_image)) {
                                                $userdata = $this->session->userdata('hospitaladmin');
                                                $accessToken = $userdata['accessToken'] ?? '';

                                                $url = "https://phr-api.plenome.com/file_upload/getDocs";
                                                $client = curl_init($url);
                                                curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
                                                curl_setopt($client, CURLOPT_POST, true);
                                                curl_setopt($client, CURLOPT_POSTFIELDS, json_encode(['value' => $doc_image]));
                                                curl_setopt($client, CURLOPT_HTTPHEADER, [
                                                    'Content-Type: application/json',
                                                    'Authorization: ' . $accessToken
                                                ]);
                                                $response = curl_exec($client);
                                                curl_close($client);
                                                if ($response !== false && strpos($response, '"NoSuchKey"') === false) {
                                                    $base64Image = "data:image/png;base64," . trim($response);
                                                } else {
                                                    $base64Image = base_url($default_image . img_time());
                                                }
                                            } else {
                                                $base64Image = base_url($default_image . img_time());
                                            }
                                            ?>

                                            <img id="medicine_image" width="115" height="115"
                                                class="profile-user-img img-responsive img-rounded"
                                                src="<?= $base64Image ?>">


                                        </div>
                                        <!--./col-lg-5-->
                                        <div class="col-lg-9 col-md-8 col-sm-12">
                                            <table class="table table-bordered mb0">
                                                <tr>
                                                    <td class="bolds"><?php echo $this->lang->line('gender'); ?></td>
                                                    <td><?php echo trim($result['gender']) !== '' ? $result['gender'] : '-'; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="bolds"><?php echo $this->lang->line('age'); ?></td>
                                                    <td>
                                                        <?php
                                                        $age = $this->customlib->getPatientAge($result['age'], $result['month'], $result['day']);
                                                        echo trim($age) !== '' ? $age : '-';
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="bolds"><?php echo $this->lang->line('guardian_name'); ?>
                                                    </td>
                                                    <td><?php echo trim($result['guardian_name']) !== '' ? $result['guardian_name'] : '-'; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="bolds"><?php echo $this->lang->line('phone'); ?></td>
                                                    <td><?php echo trim($result['mobileno']) !== '' ? $result['mobileno'] : '-'; ?>
                                                    </td>
                                                </tr>
                                            </table>

                                        </div>
                                        <!--./col-lg-7-->
                                    </div>
                                    <!--./row-->
                                    <hr class="hr-panel-heading hr-10">
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-sm-12">
                                            <div class="align-content-center pt25">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <td class="bolds"><?php echo $this->lang->line('case_id'); ?>
                                                        </td>
                                                        <td><?php echo trim($result['case_reference_id']) !== '' ? $result['case_reference_id'] : '-'; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bolds">
                                                            <?php echo $this->lang->line('appointment_no'); ?></td>
                                                        <td>
                                                            <?php if (!empty($result['appointment_id'])) { ?>
                                                                <a href="javascript:void(0);"
                                                                    onclick="viewDetail(<?php echo $result['appointment_id']; ?>)">
                                                                    <?php echo $this->customlib->getSessionPrefixByType('appointment') . $result['appointment_id']; ?>
                                                                </a>
                                                            <?php } else {
                                                                echo '-';
                                                            } ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bolds"><?php echo $this->lang->line('ipd_no'); ?>
                                                        </td>
                                                        <td><?php echo trim($ipdid) !== '' ? $this->customlib->getSessionPrefixByType('ipd_no') . $ipdid : '-'; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="white-space-nowrap bolds" width="40%">
                                                            <?php echo $this->lang->line('admission_date'); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo !empty($result['date']) ? date('d/m/Y', strtotime($result['date'])) : '-'; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="bolds"><?php echo $this->lang->line('bed'); ?></td>
                                                        <td>
                                                            <?php
                                                            $bedDetails = trim($result['bed_name']) . " - " . trim($result['bedgroup_name']) . " - " . trim($result['floor_name']);
                                                            echo $bedDetails !== ' -  - ' ? $bedDetails : '-';
                                                            ?>
                                                        </td>
                                                    </tr>
                                                </table>

                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <div class="chart-responsive text-center">
                                                <div class="chart">
                                                    <canvas id="pieChart" style="height:150px"><span></span></canvas>
                                                </div>
                                                <?php //echo $this->lang->line('credit_limit_utilization');
                                                ?>
                                                <p class="font12 mb0 font-medium">
                                                    <?php echo $this->lang->line('credit_limit'); ?>:
                                                    <?php echo $currency_symbol . $credit_limit; ?></p>
                                                <p class="font12 mb0 font-medium text-danger">
                                                    <?php echo $this->lang->line('used_credit_limit') ?>:
                                                    <?php echo $currency_symbol . $used_credit_limit; ?></p>
                                                <p class="font12 mb0 font-medium text-success-xl">
                                                    <?php echo $this->lang->line('balance_credit_limit') ?>:
                                                    <?php echo $currency_symbol . $balance_credit_limit; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="hr-panel-heading hr-10">
                                    <p><b><i class="fa fa-tag"></i>
                                            <?php echo $this->lang->line('known_allergies'); ?></b></p>

                                    <?php if (!empty($result['known_allergies'])) {
                                    ?>
                                        <ul class="list-pl-3">
                                            <li>
                                                <div><?php echo $result['known_allergies']; ?></div>
                                            </li>
                                        </ul>
                                    <?php
                                    } ?>

                                    <hr class="hr-panel-heading hr-10">
                                    <p><b><i class="fa fa-tag"></i> <?php echo $this->lang->line('finding'); ?></b></p>
                                    <?php if (!empty($prescription_detail)) { ?>
                                        <ul class="list-pl-3">
                                            <?php

                                            for ($i = 0; $i < $recent_record_count; $i++) {
                                                if (!empty($prescription_detail[$i])) {
                                            ?>
                                                    <li>
                                                        <?php echo $prescription_detail[$i]['finding_description']; ?>
                                                    </li>
                                            <?php
                                                }
                                            }
                                            ?>

                                        </ul>
                                    <?php } ?>

                                    <hr class="hr-panel-heading hr-10">
                                    <p><b><i class="fa fa-tag"></i> <?php echo $this->lang->line('symptoms'); ?></b></p>
                                    <?php if (!empty($result['symptoms'])) { ?>
                                        <ul class="list-pl-3">

                                            <li>
                                                <div><?php echo $result['symptoms']; ?></div>
                                            </li>
                                        </ul>
                                    <?php } ?>
                                    <hr class="hr-panel-heading hr-10">
                                    <div class="box-header mb10 pl-0">
                                        <h3 class="text-uppercase bolds mt0 ptt10 pull-left font14">
                                            <?php echo $this->lang->line('consultant_doctor'); ?></h3>
                                        <div class="pull-right">
                                            <div class="editviewdelete-icon pt8">
                                                <?php if ($is_discharge) { ?>
                                                    <a href="#" class=" dropdown-toggle adddoctor"
                                                        onclick="get_doctoripd('<?php echo $ipdid ?>')"
                                                        title="<?php echo $this->lang->line('add_doctor'); ?>"
                                                        data-toggle="tooltip"><i class="fa fa-plus"></i>
                                                    </a>
                                                <?php   } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="staff-members">
                                        <div class="media">
                                            <div class="media-left">
                                                <?php
                                                $defaultImage = "uploads/staff_images/no_image.png";
                                                $doctorImage = $result['doctor_image'];
                                                $file = !empty($doctorImage) ? $doctorImage : $defaultImage;

                                                if ($file !== $defaultImage) {
                                                    $userdata = $this->session->userdata('hospitaladmin');
                                                    $accessToken = $userdata['accessToken'] ?? '';
                                                    $url = "https://phr-api.plenome.com/file_upload/getDocs"; // Replace with your API URL
                                                    $client = curl_init($url);
                                                    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
                                                    curl_setopt($client, CURLOPT_POST, true);
                                                    curl_setopt($client, CURLOPT_POSTFIELDS, json_encode(['value' => $file]));
                                                    curl_setopt($client, CURLOPT_HTTPHEADER, [
                                                        'Content-Type: application/json',
                                                        'Authorization: ' . $accessToken
                                                    ]);
                                                    $response = curl_exec($client);
                                                    curl_close($client);

                                                    if ($response !== false && strpos($response, '"NoSuchKey"') === false) {
                                                        $base64Image = "data:image/png;base64," . trim($response);
                                                    } else {
                                                        $base64Image = base_url($default_image . img_time());
                                                    }
                                                } else {
                                                    $base64Image = base_url($defaultImage . img_time());
                                                }
                                                ?>

                                                <a
                                                    href="<?php echo base_url(); ?>admin/staff/profile/<?php echo base64_encode($result['staff_id']); ?>">
                                                    <img src="<?php echo $base64Image; ?>"
                                                        class="member-profile-small media-object">
                                                </a>


                                            </div>
                                            <div class="media-body">

                                                <h5 class="media-heading">
                                                    <a
                                                        href="<?php echo base_url(); ?>admin/staff/profile/<?php echo base64_encode($result['staff_id']); ?>">
                                                        <?php echo $result['name'] . " " . $result['surname'] . " (" . $result['employee_id'] . ")"; ?>
                                                    </a>
                                                </h5>
                                            </div>
                                        </div>
                                        <!--./media-->
                                        <?php
                                        foreach ($doctors_ipd as $dkey => $dvalue) { ?>
                                            <div class="media">
                                                <div class="media-left">
                                                    <?php
                                                    $defaultImage = "uploads/patient_images/no_image.png";
                                                    $doctorImage = $dvalue['image'];
                                                    $file = !empty($doctorImage) ? $doctorImage : $defaultImage;

                                                    if ($file !== $defaultImage) {
                                                        $userdata = $this->session->userdata('hospitaladmin');
                                                        $accessToken = $userdata['accessToken'] ?? '';

                                                        $url = "https://phr-api.plenome.com/file_upload/getDocs";
                                                        $client = curl_init($url);
                                                        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
                                                        curl_setopt($client, CURLOPT_POST, true);
                                                        curl_setopt($client, CURLOPT_POSTFIELDS, json_encode(['value' => $file]));
                                                        curl_setopt($client, CURLOPT_HTTPHEADER, [
                                                            'Content-Type: application/json',
                                                            'Authorization: ' . $accessToken
                                                        ]);
                                                        $response = curl_exec($client);
                                                        curl_close($client);

                                                        if ($response !== false && !empty($response)) {
                                                            $base64Image = "data:image/png;base64," . trim($response);
                                                        } else {
                                                            $base64Image = base_url($default_image . img_time());
                                                        }
                                                    } else {
                                                        $base64Image = base_url($default_image . img_time());
                                                    }
                                                    ?>

                                                    <a
                                                        href="<?php echo base_url(); ?>admin/staff/profile/<?php echo base64_encode($dvalue['consult_doctor']); ?>">
                                                        <img src="<?php echo $base64Image; ?>"
                                                            class="member-profile-small media-object">
                                                    </a>



                                                </div>
                                                <div class="media-body">
                                                    <a onclick="delete_record('<?php echo base_url(); ?>admin/patient/delete_doctors/<?php echo $result['patient_id']; ?>/<?php echo $ipdid; ?>/<?php echo $dvalue['id']; ?>', '<?php echo $this->lang->line('delete_message'); ?>')"
                                                        data-original-title="<?php echo $this->lang->line('remove'); ?>"
                                                        class="pull-right text-danger pt4" data-toggle="tooltip"
                                                        data-placement="top"
                                                        title="<?php echo $this->lang->line('delete'); ?>"><i
                                                            class="fa fa fa-times"></i></a>
                                                    <h5 class="media-heading"><a
                                                            href="<?php echo base_url(); ?>admin/staff/profile/<?php echo $dvalue['consult_doctor']; ?>"><?php echo  $dvalue['ipd_doctorname'] . " " . $dvalue['ipd_doctorsurname'] . " (" . $dvalue['employee_id'] . ")"; ?></a>

                                                    </h5>
                                                </div>
                                            </div>
                                            <!--./media-->

                                        <?php } ?>

                                    </div>
                                    <!--./staff-members-->

                                    <?php if (!empty($nurse_note)) { ?>
                                        <div class="box-header mb10 pl-0">
                                            <h3 class="text-uppercase bolds mt0 ptt10 pull-left font14">
                                                <?php echo $this->lang->line('nurse_notes'); ?></h3>
                                            <div class="pull-right">

                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="timeline-header no-border pb1">
                                        <div id="timeline_list">
                                            <?php if (empty($nurse_note)) { ?>


                                            <?php } else { ?>
                                                <ul class="timeline timeline-inverse">
                                                    <?php
                                                    for ($i = 0; $i < $recent_record_count; $i++) {
                                                        if (!empty($nurse_note[$i])) {
                                                            $id = $nurse_note[$i]['id'];

                                                    ?>
                                                            <li class="time-label">
                                                                <span class="bg-blue">
                                                                    <?php echo date('d/m/Y', strtotime($nurse_note[$i]['date'])); ?>
                                                                </span>
                                                            </li>
                                                            <li>
                                                                <i class="fa fa-list-alt bg-blue"></i>
                                                                <div class="timeline-item">



                                                                    <h3 class="timeline-header text-aqua">
                                                                        <?php echo $nurse_note[$i]['name'] . ' ' . $nurse_note[$i]['surname'] . " ( " . $nurse_note[$i]['employee_id'] . " )"; ?>
                                                                    </h3>

                                                                    <div class="timeline-body">
                                                                        <?php echo $this->lang->line('note') . "</br>" . nl2br($nurse_note[$i]['note']); ?>
                                                                    </div>

                                                                    <div class="timeline-body">
                                                                        <?php echo $this->lang->line('comment') . "</br> " . nl2br($nurse_note[$i]['comment']); ?>
                                                                    </div>

                                                                    <?php foreach ($nursenote[$id] as $ckey => $cvalue) {
                                                                        if (!empty($cvalue['staffname'])) {
                                                                            $comment_by =  " (" . $cvalue['staffname'] . " " . $cvalue['staffsurname'] . ": " . $cvalue['employee_id'] . ")";
                                                                            $comment_date = date('d/m/Y', strtotime($cvalue['created_at']));
                                                                        }

                                                                    ?>
                                                                        <div class="timeline-body">
                                                                            <?php echo nl2br($cvalue['comment_staff']);
                                                                            if ($is_discharge) {
                                                                                if ($this->rbac->hasPrivilege('nurse_note', 'can_delete')) { ?>

                                                                            <?php }
                                                                            } ?>
                                                                            <div class="text-right mb0 ptt10">
                                                                                <?php echo $comment_date . " " . $comment_by ?></div>
                                                                        </div>
                                                                    <?php  } ?>

                                                                </div>
                                                            </li>
                                                    <?php }
                                                    } ?>
                                                    <li><i class="fa fa-clock-o bg-gray"></i></li>
                                                <?php } ?>
                                                </ul>
                                        </div>
                                    </div>
                                    <hr>
                                    <?php if (!empty($timeline_list)) { ?>
                                        <div class="box-header mb10 pl-0">
                                            <h3 class="text-uppercase bolds mt0 ptt10 pull-left font14">
                                                <?php echo $this->lang->line('timeline'); ?></h3>
                                            <div class="pull-right">
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="timeline-header no-border">
                                        <div id="timeline_list">
                                            <?php

                                            if (empty($timeline_list)) { ?>
                                                <br />

                                            <?php } else { ?>
                                                <ul class="timeline timeline-inverse">
                                                    <?php

                                                    for ($i = 0; $i < $recent_record_count; $i++) {
                                                        if (!empty($timeline_list[$i])) {
                                                    ?>
                                                            <li class="time-label">
                                                                <span class="bg-blue">
                                                                    <?php echo date('d/m/Y', strtotime($timeline_list[$i]['timeline_date'])); ?>
                                                                </span>
                                                            </li>
                                                            <li>
                                                                <i class="fa fa-list-alt bg-blue"></i>
                                                                <div class="timeline-item">
                                                                    <?php if ($is_discharge) {
                                                                        if ($this->rbac->hasPrivilege('ipd_timeline', 'can_delete')) {
                                                                            if ($timeline_list[$i]['generated_users_type'] != 'patient') {
                                                                    ?>
                                                                                <span class="time"></span>
                                                                    <?php }
                                                                        }
                                                                    } ?>
                                                                    <?php if ($is_discharge) {
                                                                        if ($this->rbac->hasPrivilege('ipd_timeline', 'can_edit')) {
                                                                            if ($timeline_list[$i]['generated_users_type'] != 'patient') {
                                                                    ?><span class="time"></span>

                                                                    <?php }
                                                                        }
                                                                    } ?>

                                                                    <?php
                                                                    if (!empty($timeline_list[$i]["document"]) && $timeline_list[$i]["document"] != "None") {
                                                                        $userdata = $this->session->userdata('hospitaladmin');
                                                                        $accessToken = $userdata['accessToken'] ?? '';

                                                                        $document = $timeline_list[$i]["document"];
                                                                        $url = "https://phr-api.plenome.com/file_upload/getDocs";

                                                                        $client = curl_init($url);
                                                                        curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
                                                                        curl_setopt($client, CURLOPT_POST, true);
                                                                        curl_setopt($client, CURLOPT_POSTFIELDS, json_encode(['value' => $document]));
                                                                        curl_setopt($client, CURLOPT_HTTPHEADER, [
                                                                            'Content-Type: application/json',
                                                                            'Authorization: ' . $accessToken
                                                                        ]);

                                                                        $response = curl_exec($client);
                                                                        curl_close($client);

                                                                        if ($response !== false) {
                                                                            $base64File = trim($response);
                                                                            $fileData = base64_decode($base64File);

                                                                            if ($fileData !== false) {
                                                                                $fileInfo = pathinfo($document);
                                                                                $fileExtension = strtolower($fileInfo['extension'] ?? 'bin');

                                                                                $mimeTypes = [
                                                                                    'jpg' => 'image/jpeg',
                                                                                    'jpeg' => 'image/jpeg',
                                                                                    'png' => 'image/png',
                                                                                    'gif' => 'image/gif',
                                                                                    'pdf' => 'application/pdf',
                                                                                    'txt' => 'text/plain',
                                                                                    'doc' => 'application/msword',
                                                                                    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                                                                    'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                                                                    'xls' => 'application/vnd.ms-excel',
                                                                                    'csv' => 'text/csv',
                                                                                    'zip' => 'application/zip',
                                                                                ];

                                                                                $mimeType = $mimeTypes[$fileExtension] ?? 'application/octet-stream';
                                                                                $downloadUrl = "data:$mimeType;base64,$base64File";
                                                                    ?>

                                                                                <span class="time">
                                                                                    <a class="defaults-c text-right" data-toggle="tooltip"
                                                                                        href="<?= $downloadUrl; ?>"
                                                                                        download="<?= urlencode($fileInfo['basename']); ?>"
                                                                                        data-original-title="<?= $this->lang->line('download'); ?>">
                                                                                        <i class="fa fa-download"></i>
                                                                                    </a>
                                                                                </span>

                                                                    <?php
                                                                            }
                                                                        }
                                                                    }
                                                                    ?>

                                                                    <h3 class="timeline-header text-aqua">
                                                                        <?php echo $timeline_list[$i]['title']; ?> </h3>
                                                                    <div class="timeline-body">
                                                                        <?php echo $timeline_list[$i]['description']; ?>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                    <?php }
                                                    } ?>
                                                    <li><i class="fa fa-clock-o bg-gray"></i></li>
                                                <?php } ?>
                                                </ul>
                                        </div>
                                    </div>
                                </div>
                                <!--./col-lg-6-->
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="row">
                                        <div class="col-md-6 project-progress-bars">
                                            <div class="row">
                                                <div class="col-md-12 mtop5">
                                                    <div class="topprograssstart">
                                                        <h5 class="text-uppercase mt5 bolds">
                                                            <?php echo $this->lang->line('ipd_billing_payment_graph'); ?><span
                                                                class="pull-right text-gray-light"><i
                                                                    class="fas fa-procedures"></i></span>
                                                        </h5>
                                                        <p class="text-muted bolds mb4">
                                                            <?php echo $graph['ipd']['ipd_bill_payment_ratio']; ?>%<span
                                                                class="pull-right">
                                                                <?php echo $this->customlib->get_payment_bill($graph['ipd']['payment']['total_payment'], $graph['ipd']['bill']['total_bill']); ?></span>
                                                        </p>
                                                        <div class="progress-group">
                                                            <div class="progress progress-minibar">
                                                                <div class="progress-bar progress-bar-aqua"
                                                                    style="width: <?php echo $graph['ipd']['ipd_bill_payment_ratio']; ?>%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--./row-->
                                        </div>
                                        <!--./col-lg-6-->
                                        <div class="col-md-6 project-progress-bars">
                                            <div class="row">
                                                <div class="col-md-12 mtop5">
                                                    <div class="topprograssstart">
                                                        <h5 class="text-uppercase mt5 bolds">
                                                            <?php echo $this->lang->line('pharmacy_billing_payment_graph'); ?><span
                                                                class="pull-right text-gray-light"><i
                                                                    class="fas fa-mortar-pestle"></i></span>
                                                        </h5>
                                                        <p class="text-muted bolds mb4">
                                                            <?php echo $graph['pharmacy']['pharmacy_bill_payment_ratio']; ?>%<span
                                                                class="pull-right">
                                                                <?php echo $this->customlib->get_payment_bill(($graph['pharmacy']['payment']['total_payment'] - $graph['pharmacy']['payment_refund']['total_payment']), $graph['pharmacy']['bill']['total_bill']); ?></span>
                                                        </p>
                                                        <div class="progress-group">
                                                            <div class="progress progress-minibar">
                                                                <div class="progress-bar progress-bar-aqua"
                                                                    style="width: <?php echo $graph['pharmacy']['pharmacy_bill_payment_ratio']; ?>%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--./col-lg-6-->

                                    </div>
                                    <!--./row-->
                                    <div class="row">
                                        <div class="col-md-6 project-progress-bars">
                                            <div class="row">
                                                <div class="col-md-12 mtop5">
                                                    <div class="topprograssstart">
                                                        <h5 class="text-uppercase mt5 bolds">
                                                            <?php echo $this->lang->line('pathology_billing_payment_graph'); ?><span
                                                                class="pull-right text-gray-light"><i
                                                                    class="fas fa-flask"></i></span>
                                                        </h5>
                                                        <p class="text-muted bolds mb4">
                                                            <?php echo $graph['pathology']['pathology_bill_payment_ratio']; ?>%<span
                                                                class="pull-right">
                                                                <?php echo $this->customlib->get_payment_bill($graph['pathology']['payment']['total_payment'], $graph['pathology']['bill']['total_bill']); ?></span>
                                                        </p>
                                                        <div class="progress-group">
                                                            <div class="progress progress-minibar">
                                                                <div class="progress-bar progress-bar-aqua"
                                                                    style="width: <?php echo $graph['pathology']['pathology_bill_payment_ratio']; ?>%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--./row-->
                                        </div>
                                        <!--./col-lg-6-->
                                        <div class="col-md-6 project-progress-bars">
                                            <div class="row">
                                                <div class="col-md-12 mtop5">
                                                    <div class="topprograssstart">
                                                        <h5 class="text-uppercase mt5 bolds">
                                                            <?php echo $this->lang->line('radiology_billing_payment_graph'); ?><span
                                                                class="pull-right text-gray-light"><i
                                                                    class="fas fa-microscope"></i></span>
                                                        </h5>
                                                        <p class="text-muted bolds mb4">
                                                            <?php echo $graph['radiology']['radiology_bill_payment_ratio']; ?>%<span
                                                                class="pull-right">
                                                                <?php echo $this->customlib->get_payment_bill($graph['radiology']['payment']['total_payment'], $graph['radiology']['bill']['total_bill']); ?></span>
                                                        </p>
                                                        <div class="progress-group">
                                                            <div class="progress progress-minibar">
                                                                <div class="progress-bar progress-bar-aqua"
                                                                    style="width: <?php echo $graph['radiology']['radiology_bill_payment_ratio']; ?>%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--./col-lg-6-->

                                    </div>
                                    <!--./row-->
                                    <div class="row">
                                        <div class="col-md-6 project-progress-bars">
                                            <div class="row">
                                                <div class="col-md-12 mtop5">
                                                    <div class="topprograssstart">
                                                        <h5 class="text-uppercase mt5 bolds">
                                                            <?php echo $this->lang->line('blood_bank_billing_payment_graph'); ?><span
                                                                class="pull-right text-gray-light"><i
                                                                    class="fas fa-tint"></i></span>
                                                        </h5>
                                                        <p class="text-muted bolds mb4">
                                                            <?php echo $graph['blood_bank']['blood_bank_bill_payment_ratio']; ?>%<span
                                                                class="pull-right">
                                                                <?php echo $this->customlib->get_payment_bill($graph['blood_bank']['payment']['total_payment'], $graph['blood_bank']['bill']['total_bill']); ?></span>
                                                        </p>
                                                        <div class="progress-group">
                                                            <div class="progress progress-minibar">
                                                                <div class="progress-bar progress-bar-aqua"
                                                                    style="width: <?php echo $graph['blood_bank']['blood_bank_bill_payment_ratio']; ?>%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--./row-->
                                        </div>
                                        <!--./col-lg-6-->
                                        <div class="col-md-6 project-progress-bars">
                                            <div class="row">
                                                <div class="col-md-12 mtop5">
                                                    <div class="topprograssstart">
                                                        <h5 class="text-uppercase mt5 bolds">
                                                            <?php echo $this->lang->line('ambulance_billing_payment_graph'); ?><span
                                                                class="pull-right text-gray-light"><i
                                                                    class="fas fa-ambulance"></i></span>
                                                        </h5>
                                                        <p class="text-muted bolds mb4">
                                                            <?php echo $graph['ambulance']['ambulance_bill_payment_ratio']; ?>%<span
                                                                class="pull-right">
                                                                <?php echo $this->customlib->get_payment_bill($graph['ambulance']['payment']['total_payment'], $graph['ambulance']['bill']['total_bill']); ?></span>
                                                        </p>
                                                        <div class="progress-group">
                                                            <div class="progress progress-minibar">
                                                                <div class="progress-bar progress-bar-aqua"
                                                                    style="width: <?php echo $graph['ambulance']['ambulance_bill_payment_ratio']; ?>%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--./col-lg-6-->

                                    </div>
                                    <!--./row-->
                                    <?php if (!empty($medicationreport_overview)) { ?>
                                        <div class="box-header pl-0">
                                            <h3 class="text-uppercase bolds mt0 mb0 ptt10 pull-left font14">
                                                <?php echo $this->lang->line('medication'); ?></h3>
                                            <div class="pull-right">
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <div class="box-header pl-0">
                                        <div class="table-responsive">
                                            <?php
                                            if (!empty($medicationreport_overview)) {
                                            ?>
                                                <table class="table table-striped table-bordered mb0">
                                                    <thead>
                                                        <tr>
                                                            <th><?php echo $this->lang->line('date'); ?></th>
                                                            <th><?php echo $this->lang->line('medicine_name'); ?></th>
                                                            <th><?php echo $this->lang->line('dose'); ?></th>
                                                            <th><?php echo $this->lang->line('time'); ?></th>
                                                            <th><?php echo $this->lang->line('remark'); ?></th>
                                                        <tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        for ($i = 0; $i < $recent_record_count; $i++) {
                                                            if (!empty($medicationreport_overview[$i])) {
                                                        ?>
                                                                <tr>
                                                                    <td><?php echo date('d/m/Y', strtotime($medicationreport_overview[$i]['date'])); ?>
                                                                    </td>
                                                                    <td><?php echo $medicationreport_overview[$i]['medicine_name'] ?>
                                                                    </td>
                                                                    <td><?php echo $medicationreport_overview[$i]['medicine_dosage'] . " (" . $medicationreport_overview[$i]['unit'] . ")"; ?>
                                                                    </td>
                                                                    <td><?php echo $this->customlib->getHospitalTime_Format($medicationreport_overview[$i]['time']); ?>
                                                                    </td>
                                                                    <td><?php echo $medicationreport_overview[$i]['remark']; ?></td>
                                                                </tr>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            <?php } ?>
                                        </div>

                                    </div>
                                    <?php if (!empty($prescription_detail)) { ?>
                                        <hr class="hr-panel-heading hr-10">
                                        <div class="box-header pl-0">
                                            <h3 class="text-uppercase bolds mt0 mb0 ptt10 pull-left font14">
                                                <?php echo $this->lang->line('prescription'); ?></h3>
                                            <div class="pull-right">
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="box-header pl-0">
                                        <div class="table-responsive">
                                            <?php if (!empty($prescription_detail)) { ?>
                                                <table class="table table-striped table-bordered   mb0">
                                                    <thead>
                                                        <th><?php echo $this->lang->line('prescription_no'); ?></th>
                                                        <th><?php echo $this->lang->line('date'); ?></th>
                                                        <th><?php echo $this->lang->line('finding'); ?></th>

                                                    </thead>
                                                    <tbody>
                                                        <?php

                                                        for ($i = 0; $i < $recent_record_count; $i++) {
                                                            if (!empty($prescription_detail[$i])) {
                                                        ?>
                                                                <tr>
                                                                    <td><?php echo $this->customlib->getSessionPrefixByType('ipd_prescription') . $prescription_detail[$i]["id"] ?>
                                                                    </td>
                                                                    <td><?php echo date($this->customlib->getHospitalDateFormat(), strtotime($prescription_detail[$i]['date'])); ?>
                                                                    </td>
                                                                    <td><?php echo $prescription_detail[$i]['finding_description']; ?>
                                                                    </td>

                                                                </tr>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php if (!empty($consultant_register)) {   ?>
                                        <hr class="hr-panel-heading hr-10">
                                        <div class="box-header pl-0">
                                            <h3 class="text-uppercase bolds mt0 ptt10 mb0 pull-left font14">
                                                <?php echo $this->lang->line('consultant_register'); ?></h3>
                                            <div class="pull-right">
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="box-header pl-0">
                                        <div class="table-responsive">
                                            <?php
                                            if (!empty($consultant_register)) {
                                            ?>
                                                <table class="table table-striped table-bordered  mb0">
                                                    <thead>
                                                        <th><?php echo $this->lang->line('applied_date'); ?></th>
                                                        <th><?php echo $this->lang->line('consultant_doctor'); ?></th>
                                                        <th><?php echo $this->lang->line('instruction'); ?></th>
                                                        <th><?php echo $this->lang->line('instruction_date'); ?></th>


                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        for ($i = 0; $i < $recent_record_count; $i++) {
                                                            if (!empty($consultant_register[$i])) {
                                                        ?>
                                                                <tr>
                                                                    <td><?php echo date('d/m/Y', strtotime($consultant_register[$i]['date'])); ?>
                                                                    </td>
                                                                    <td><?php echo $consultant_register[$i]["name"] . " " . $consultant_register[$i]["surname"] . " (" . $consultant_register[$i]["employee_id"] . ")" ?>
                                                                    </td>
                                                                    <td><?php echo nl2br($consultant_register[$i]["instruction"]); ?>
                                                                    </td>
                                                                    <td><?php echo date('d/m/Y', strtotime($consultant_register[$i]['ins_date'])); ?>

                                                                    </td>
                                                                </tr>
                                                        <?php
                                                            }
                                                        }
                                                        ?>

                                                    </tbody>
                                                </table>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php if (!empty($investigations)) { ?>
                                        <div class="box-header pl-0">
                                            <h3 class="text-uppercase bolds mt0 mb0 ptt10 pull-left font14">
                                                <?php echo $this->lang->line('lab_investigation'); ?></h3>
                                            <div class="pull-right">
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="box-header pl-0">
                                        <div class="table-responsive">
                                            <?php if (!empty($investigations)) { ?>
                                                <table class="table table-striped table-bordered  mb0"
                                                    data-export-title="<?php echo $this->lang->line('lab_investigation'); ?>">
                                                    <thead>
                                                        <th><?php echo $this->lang->line('test_name'); ?></th>
                                                        <th><?php echo $this->lang->line('lab'); ?></th>
                                                        <th><?php echo $this->lang->line('sample_collected'); ?></th>
                                                        <td><strong><?php echo $this->lang->line('expected_date'); ?></strong>
                                                        </td>
                                                        <th><?php echo $this->lang->line('approved_by'); ?></th>

                                                    </thead>
                                                    <tbody id="">
                                                        <?php



                                                        for ($i = 0; $i < $recent_record_count; $i++) {
                                                            if (!empty($investigations[$i])) {
                                                        ?>
                                                                <tr>
                                                                    <td><?php echo $investigations[$i]['test_name']; ?><br />
                                                                        <?php echo "(" . $investigations[$i]['short_name'] . ")"; ?>
                                                                    </td>
                                                                    <td><?php echo $this->lang->line($investigations[$i]['type']); ?>
                                                                    </td>
                                                                    <td><label>
                                                                            <?php echo composeStaffNameByString($investigations[$i]['collection_specialist_staff_name'], $investigations[$i]['collection_specialist_staff_surname'], $investigations[$i]['collection_specialist_staff_employee_id']); ?>
                                                                        </label>

                                                                        <br />
                                                                        <?php if ($investigations[$i]['test_center'] != "") { ?>
                                                                            <label for=""><?php if ($investigations[$i]['type'] == 'pathology') {
                                                                                                echo $this->lang->line('pathology');
                                                                                            } else {
                                                                                                echo $this->lang->line('radiology');
                                                                                            }  ?> : </label><?php } ?>

                                                                        <?php
                                                                        echo $investigations[$i]['test_center'];
                                                                        ?>
                                                                        <br />
                                                                        <?php echo date('d/m/Y', strtotime($investigations[$i]['collection_date'])); ?>
                                                                    </td>

                                                                    <td>
                                                                        <?php echo date('d/m/Y', strtotime($investigations[$i]['reporting_date'])); ?>

                                                                    </td>
                                                                    <td class="text-left">
                                                                        <?php if ($investigations[$i]['approved_by_staff_name'] != "") { ?>
                                                                            <label
                                                                                for=""><?php echo $this->lang->line('approved_by'); ?> :
                                                                            </label>
                                                                        <?php
                                                                            echo composeStaffNameByString($investigations[$i]['approved_by_staff_name'], $investigations[$i]['approved_by_staff_surname'], $investigations[$i]['approved_by_staff_employee_id']);
                                                                        }
                                                                        ?>
                                                                        <br />
                                                                        <?php echo date('d/m/Y', strtotime($investigations[$i]['parameter_update'])); ?>
                                                                    </td>

                                                                </tr>
                                                        <?php }
                                                        } ?>
                                                    </tbody>
                                                </table>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php if (!empty($operation_theatre)) { ?>
                                        <hr class="hr-panel-heading hr-10">
                                        <div class="box-header mb10 pl-0">
                                            <h3 class="text-uppercase bolds mt0 mb0 ptt10 pull-left font14">
                                                <?php echo $this->lang->line('operation'); ?></h3>
                                            <div class="pull-right">

                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="box-header mb10 pl-0">
                                        <div class="table-responsive">
                                            <?php
                                            if (!empty($operation_theatre)) {
                                            ?>
                                                <table class="table table-striped table-bordered  mb0">
                                                    <thead>
                                                        <th><?php echo $this->lang->line("reference_no"); ?></th>
                                                        <th><?php echo $this->lang->line("operation_date"); ?></th>
                                                        <th><?php echo $this->lang->line("operation_name"); ?></th>
                                                        <th><?php echo $this->lang->line("operation_category"); ?></th>
                                                        <th><?php echo $this->lang->line("ot_technician"); ?></th>
                                                    </thead>
                                                    <tbody>
                                                        <?php

                                                        for ($i = 0; $i < $recent_record_count; $i++) {
                                                            if (!empty($operation_theatre[$i])) {

                                                        ?>
                                                                <tr>
                                                                    <td><?php echo $this->customlib->getSessionPrefixByType('operation_theater_reference_no') . $operation_theatre[$i]["id"] ?>
                                                                    </td>
                                                                    <td><?php echo date('d/m/Y', strtotime($operation_theatre[$i]["date"])); ?>
                                                                    </td>
                                                                    <td><?php echo $operation_theatre[$i]["operation"] ?></td>
                                                                    <td><?php echo $operation_theatre[$i]["category"] ?></td>
                                                                    <td><?php echo $operation_theatre[$i]['ot_technician'] ?></td>
                                                                </tr>

                                                        <?php }
                                                        } ?>
                                                    </tbody>
                                                </table>
                                            <?php } ?>
                                        </div>

                                    </div>
                                    <?php if (!empty($charges)) { ?>
                                        <hr class="hr-panel-heading hr-10">
                                        <div class="box-header mb10 pl-0">
                                            <h3 class="text-uppercase bolds mt0 mb0 ptt10 pull-left font14">
                                                <?php echo $this->lang->line('charges'); ?></h3>
                                            <div class="pull-right">

                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="box-header mb10 pl-0">
                                        <div class="table-responsive">
                                            <?php if (!empty($charges)) { ?>
                                                <table class="table table-striped table-bordered  mb0">
                                                    <thead class="white-space-nowrap">
                                                        <th><?php echo $this->lang->line('date'); ?></th>
                                                        <th><?php echo $this->lang->line('name'); ?></th>
                                                        <th><?php echo $this->lang->line('charge_type'); ?></th>
                                                        <th><?php echo $this->lang->line('charge_category'); ?></th>
                                                        <th><?php echo $this->lang->line('qty'); ?></th>

                                                        <th class="text-right">
                                                            <?php echo $this->lang->line('amount') . ' (' . $currency_symbol . ')'; ?>
                                                        </th>

                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $total = 0;
                                                        for ($i = 0; $i < $recent_record_count; $i++) {
                                                            if (!empty($charges[$i])) {
                                                                $total += $charges[$i]["amount"];
                                                                $tax_amount = calculatePercent($charges[$i]['apply_charge'], $charges[$i]['tax']);
                                                                $taxamount = amountFormat($tax_amount);
                                                        ?>
                                                                <tr>
                                                                    <td><?php echo date('d/m/Y', strtotime($charges[$i]['date'])); ?>
                                                                    </td>
                                                                    <td style="text-transform: capitalize;">
                                                                        <?php echo $charges[$i]["name"] ?>
                                                                        <div class="bill_item_footer text-muted">
                                                                            <label><?php if ($charges[$i]["note"] != '') {
                                                                                        echo $this->lang->line('charge_note') . ': ';
                                                                                    } ?>
                                                                            </label>
                                                                            <?php echo $charges[$i]["note"] ?>
                                                                        </div>
                                                                    </td>
                                                                    <td style="text-transform: capitalize;">
                                                                        <?php echo $charges[$i]["charge_type"] ?></td>
                                                                    <td style="text-transform: capitalize;">
                                                                        <?php echo $charges[$i]["charge_category_name"] ?>

                                                                    </td>
                                                                    <td style="text-transform: capitalize;">
                                                                        <?php echo $charges[$i]['qty'] . " " . $charges[$i]["unit"]; ?>
                                                                    </td>

                                                                    <td class="text-right">
                                                                        <?php echo number_format($charges[$i]["amount"], 2) ?></td>

                                                                </tr>
                                                            <?php } ?>

                                                        <?php } ?>
                                                    </tbody>



                                                </table>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php if (!empty($payment_details)) { ?>
                                        <div class="box-header mb10 pl-0">
                                            <h3 class="text-uppercase bolds mt0 mb0 ptt10 mb0 pull-left font14">
                                                <?php echo $this->lang->line('payment'); ?></h3>
                                            <div class="pull-right">

                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="box-header mb10 pl-0">
                                        <div class="table-responsive">
                                            <?php if (!empty($payment_details)) { ?>
                                                <table class="table table-striped table-bordered  mb0">
                                                    <thead>
                                                        <th><?php echo $this->lang->line('transaction_id'); ?></th>
                                                        <th><?php echo $this->lang->line('date'); ?></th>
                                                        <th><?php echo $this->lang->line('note'); ?></th>
                                                        <th><?php echo $this->lang->line('payment_mode'); ?></th>
                                                        <th class="text-right">
                                                            <?php echo $this->lang->line('paid_amount') . " (" . $currency_symbol . ")"; ?>
                                                        </th>

                                                    </thead>
                                                    <tbody>

                                                        <?php
                                                        $total_payment = 0;


                                                        for ($i = 0; $i < $recent_record_count; $i++) {
                                                            if (!empty($payment_details[$i])) {
                                                                if (!empty($payment_details[$i]['amount'])) {
                                                                    $total_payment += $payment_details[$i]['amount'];
                                                                }
                                                        ?>
                                                                <tr>
                                                                    <td><?php echo $this->customlib->getSessionPrefixByType('transaction_id') . $payment_details[$i]['id']; ?>
                                                                    </td>
                                                                    <td><?php echo date('d/m/Y', strtotime($payment_details[$i]['payment_date'])); ?>

                                                                    </td>
                                                                    <td><?php echo $payment_details[$i]["note"] ?></td>
                                                                    <td style="text-transform: capitalize;"><?php echo $this->lang->line(strtolower($payment_details[$i]["payment_mode"])) . "<br>";

                                                                                                            if ($payment_details[$i]['payment_mode'] == "Cheque") {
                                                                                                                if ($payment_details[$i]['cheque_no'] != '') {
                                                                                                                    echo $this->lang->line("cheque_no") . ": " . $payment_details[$i]['cheque_no'];
                                                                                                                    echo "<br>";
                                                                                                                }
                                                                                                                if ($payment_details[$i]['cheque_date'] != '' && $payment_details[$i]['cheque_date'] != '0000-00-00') {
                                                                                                                    echo $this->lang->line("cheque_date") . ": " . date('d/m/Y', strtotime($payment_details[$i]['cheque_date']));
                                                                                                                }
                                                                                                            }
                                                                                                            ?>
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <?php echo $payment_details[$i]["amount"] ?></td>


                                                                </tr>

                                                            <?php } ?>
                                                    </tbody>

                                                <?php } ?>
                                                </table>
                                            <?php } ?>
                                        </div>
                                        <!--./table-responsive-->
                                    </div>
                                    <?php if (!empty($ipdconferences)) { ?>
                                        <div class="box-header mb10 pl-0">
                                            <h3 class="text-uppercase bolds mt0 mb0 ptt10 pull-left font14">
                                                <?php echo $this->lang->line('live_consultation'); ?></h3>
                                            <div class="pull-right">
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="box-header mb10 pl-0">
                                        <div class="table-responsive">
                                            <?php

                                            if (!empty($ipdconferences)) {

                                            ?>
                                                <table class="table table-striped table-bordered  mb0">
                                                    <thead>
                                                        <th><?php echo $this->lang->line('consultation_title'); ?></th>
                                                        <th><?php echo $this->lang->line('date'); ?></th>
                                                        <th><?php echo $this->lang->line('created_by'); ?> </th>
                                                        <th><?php echo $this->lang->line('created_for'); ?></th>
                                                        <th><?php echo $this->lang->line('patient'); ?></th>


                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if (empty($ipdconferences)) {
                                                        ?>

                                                            <?php
                                                        } else {
                                                            for ($i = 0; $i < $recent_record_count; $i++) {
                                                                if (!empty($ipdconferences[$i])) {

                                                                    $return_response = json_decode($ipdconferences[$i]->return_response);
                                                            ?>
                                                                    <tr>
                                                                        <td class="mailbox-name">
                                                                            <?php echo $ipdconferences[$i]->title; ?>


                                                                        </td>

                                                                        <td class="mailbox-name">
                                                                            <?php echo date($this->customlib->getHospitalDateFormat(true, true), strtotime($ipdconferences[$i]->date)) ?>

                                                                        <td class="mailbox-name">

                                                                            <?php
                                                                            if ($ipdconferences[$i]->created_id == $logged_staff_id) {
                                                                                echo $this->lang->line('self');
                                                                            } else {
                                                                                $name = ($ipdconferences[$i]->create_by_surname == "") ? $ipdconferences[$i]->create_by_name : $ipdconferences[$i]->create_by_name . " " . $ipdconferences[$i]->create_by_surname;
                                                                                echo  $name . " (" . $ipdconferences[$i]->create_by_role_name . ": " . $ipdconferences[$i]->create_by_employee_id . ")";
                                                                            }
                                                                            ?></td>
                                                                        <td class="mailbox-name">
                                                                            <?php
                                                                            $name = ($ipdconferences[$i]->create_for_surname == "") ? $ipdconferences[$i]->create_for_name : $ipdconferences[$i]->create_for_name . " " . $ipdconferences[$i]->create_for_surname;
                                                                            echo  $name . " (" . $ipdconferences[$i]->create_for_role_name . ": " . $ipdconferences[$i]->create_for_employee_id . ")";
                                                                            ?>
                                                                        </td>

                                                                        <td class="mailbox-name">
                                                                            <?php

                                                                            $name = ($ipdconferences[$i]->patient_name == "") ? $ipdconferences[$i]->patient_name : $ipdconferences[$i]->patient_name;
                                                                            echo  $name . " (" . $ipdconferences[$i]->patient_unique_id . ")";
                                                                            ?>

                                                                        </td>


                                                                    </tr>
                                                        <?php
                                                                }
                                                            }
                                                        }
                                                        ?>

                                                    </tbody>
                                                </table>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php if (!empty($getipdoverviewtreatment)) { ?>

                                        <div class="box-header mb10 pl-0">
                                            <h3 class="text-uppercase bolds mt0 ptt10 pull-left font14">
                                                <?php echo $this->lang->line('treatment_history'); ?></h3>
                                            <div class="pull-right">
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="box-header mb10 pl-0">
                                        <div class="table-responsive">
                                            <?php if (!empty($getipdoverviewtreatment)) { ?>
                                                <table class="table table-striped table-bordered  mb0"
                                                    data-export-title="<?php echo $this->lang->line('treatment_history'); ?>">
                                                    <thead>
                                                        <th><?php echo $this->lang->line('ipd_no'); ?></th>
                                                        <th><?php echo $this->lang->line('symptoms'); ?></th>
                                                        <th><?php echo $this->lang->line('consultant'); ?></th>
                                                        <th class="text-right"><?php echo $this->lang->line('bed'); ?></th>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        //echo "<pre>"; print_r($getipdoverviewtreatment);die;
                                                        for ($i = 0; $i < $recent_record_count; $i++) {
                                                            if (!empty($getipdoverviewtreatment[$i])) {
                                                        ?>
                                                                <tr>
                                                                    <td><?php echo $this->customlib->getSessionPrefixByType('ipd_no') . $getipdoverviewtreatment[$i]['ipdid']; ?>
                                                                    </td>
                                                                    <td><?php echo $getipdoverviewtreatment[$i]['symptoms']; ?></td>
                                                                    <td><?php echo composeStaffNameByString($getipdoverviewtreatment[$i]['name'], $getipdoverviewtreatment[$i]['surname'], $getipdoverviewtreatment[$i]['employee_id']); ?>
                                                                    </td>
                                                                    <td><?php echo $getipdoverviewtreatment[$i]['bed_name'] . "-" . $getipdoverviewtreatment[$i]['bedgroup_name'] . "-" . $getipdoverviewtreatment[$i]['floor_name']; ?>
                                                                    </td>
                                                                </tr>
                                                        <?php }
                                                        } ?>
                                                    </tbody>
                                                </table>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php
                                    if (!empty($bed_history)) {
                                    ?>
                                        <div class="box-header mb10 pl-0">
                                            <h3 class="text-uppercase bolds mt0 ptt10 pull-left font14">
                                                <?php echo $this->lang->line('bed_history'); ?></h3>
                                            <div class="pull-right">
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="box-header mb10 pl-0">
                                        <div class="table-responsive">
                                            <?php
                                            if (!empty($bed_history)) {
                                            ?>
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">
                                                                <?php echo $this->lang->line('bed_group'); ?></th>
                                                            <th class="text-center"><?php echo $this->lang->line('bed'); ?>
                                                            </th>
                                                            <th class="text-center">
                                                                <?php echo $this->lang->line('from_date'); ?></th>
                                                            <th class="text-center">
                                                                <?php echo $this->lang->line('to_date'); ?></th>
                                                            <th class="text-center">
                                                                <?php echo $this->lang->line("active_bed"); ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        for ($i = 0; $i < $recent_record_count; $i++) {
                                                            if (!empty($bed_history[$i])) {
                                                        ?>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <?php echo !empty($bed_history[$i]->bed_group) ? $bed_history[$i]->bed_group : '-'; ?>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <?php echo !empty($bed_history[$i]->bed) ? $bed_history[$i]->bed : '-'; ?>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <?php
                                                                        if (!empty($bed_history[$i]->from_date)) {
                                                                            echo date('d/m/Y', strtotime($bed_history[$i]->from_date));
                                                                        } else {
                                                                            echo '-';
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <?php
                                                                        if (!empty($bed_history[$i]->to_date)) {
                                                                            echo date('d/m/Y', strtotime($bed_history[$i]->to_date));
                                                                        } else {
                                                                            echo '-';
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <?php echo !empty($bed_history[$i]->is_active) ? $this->lang->line($bed_history[$i]->is_active) : '-'; ?>
                                                                    </td>
                                                                </tr>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>

                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <!--./col-lg-6-->
                            </div>
                            <!--./row-->
                        </div>
                        <!--#/overview-->


                        <?php if ($this->rbac->hasPrivilege('nurse_note', 'can_view')) { ?>
                            <div class="tab-pane tab-content-height " id="nurse_note">
                                <div class="box-tab-header">
                                    <h3 class="box-tab-title"><?php echo $this->lang->line('nurse_notes'); ?></h3>
                                    <div class="box-tab-tools">

                                        <?php
                                        if ($this->rbac->hasPrivilege('nurse_note', 'can_add')) {

                                            if ($is_discharge) {
                                        ?>
                                                <a href="#" class="btn btn-sm btn-primary dropdown-toggle addnursenote"
                                                    onclick="holdModal('add_nurse_note')" data-toggle="modal"><i
                                                        class="fas fa-plus"></i>
                                                    <?php echo $this->lang->line('add_nurse_note'); ?></a>
                                        <?php
                                            }
                                        }
                                        ?>

                                    </div>
                                </div>
                                <!--./box-tab-header-->


                                <div class="download_label">
                                    <?php echo composePatientName($result['patient_name'], $result['patient_id']) . " " . $this->lang->line('ipd_details'); ?>
                                </div>

                                <div id="">
                                    <?php if (empty($nurse_note)) { ?>

                                        <div class="alert alert-info"><?php echo $this->lang->line('no_record_found'); ?></div>
                                    <?php } else { ?>
                                        <ul class="timeline timeline-inverse">
                                            <?php
                                            foreach ($nurse_note as $key => $value) {
                                                $id = $value['id'];

                                            ?>
                                                <li class="time-label">
                                                    <span class="bg-blue">
                                                        <?php echo date('d/m/Y', strtotime($value['date'])); ?>
                                                    </span>
                                                </li>
                                                <li>
                                                    <i class="fa fa-list-alt bg-blue"></i>
                                                    <div class="timeline-item">
                                                        <?php if ($is_discharge) {
                                                            if ($this->rbac->hasPrivilege('nurse_note', 'can_delete')) { ?>
                                                                <span class="time">

                                                                    <a class="btn btn-default btn-xs" data-toggle="tooltip" title=""
                                                                        onclick="delete_recordcommend('<?php echo $value['id']; ?>', '<?php echo $this->lang->line('delete_message'); ?>')"
                                                                        data-original-title="<?php echo $this->lang->line('delete'); ?>">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                </span>

                                                        <?php }
                                                        } ?>

                                                        <?php if ($is_discharge) {
                                                            if ($this->rbac->hasPrivilege('nurse_note', 'can_edit')) {
                                                        ?>
                                                                <span class="time">
                                                                    <a onclick="addcommentNursenote('<?php echo $value['id']; ?>',<?php echo $value['ipd_id']; ?>)"
                                                                        class="defaults-c text-right" data-toggle="tooltip" title=""
                                                                        data-original-title="<?php echo $this->lang->line('comment'); ?>">
                                                                        <i class="fa fa-comment"></i>
                                                                    </a>
                                                                </span>
                                                                <span class="time">
                                                                    <a onclick="editNursenote('<?php echo $value['id']; ?>')"
                                                                        class="defaults-c text-right" data-toggle="tooltip" title=""
                                                                        data-original-title="<?php echo $this->lang->line('edit'); ?>">
                                                                        <i class="fa fa-pencil"></i>
                                                                    </a>
                                                                </span>

                                                        <?php }
                                                        } ?>


                                                        <h3 class="timeline-header text-aqua">
                                                            <?php echo $value['name'] . ' ' . $value['surname'] . " ( " . $value['employee_id'] . " )"; ?>
                                                        </h3>

                                                        <div class="timeline-body">
                                                            <?php echo "<b>" . $this->lang->line('note') . "</b>" . "</br>" . nl2br($value['note']); ?>
                                                        </div>
                                                        <?php
                                                        if (!empty($fields_nurse)) {
                                                            foreach ($fields_nurse as $fields_key => $fields_value) {
                                                                if (!empty($fields_value->name)) {
                                                                    $display_field = $value[$fields_value->name];
                                                                    $fields = $fields_value->name;
                                                                } else {
                                                                    $display_field = '';
                                                                    $fields = '';
                                                                }

                                                        ?>
                                                                <div class="timeline-body">
                                                                    <?php if ($fields != null) {
                                                                        echo $fields . "</br> " . $display_field;
                                                                    }
                                                                    ?>
                                                                </div>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                        <div class="timeline-body">
                                                            <?php echo "<b>" . $this->lang->line('comment') . "</b>" . "</br> " . nl2br($value['comment']); ?>
                                                        </div>

                                                        <?php foreach ($nursenote[$id] as $ckey => $cvalue) {
                                                            if (!empty($cvalue['staffname'])) {
                                                                $comment_by =  " (" . $cvalue['staffname'] . " " . $cvalue['staffsurname'] . ": " . $cvalue['employee_id'] . ")";
                                                                $comment_date = date('d/m/Y', strtotime($cvalue['created_at']));
                                                            }

                                                        ?>
                                                            <div class="timeline-body">
                                                                <?php echo nl2br($cvalue['comment_staff']);
                                                                if ($is_discharge) {
                                                                    if ($this->rbac->hasPrivilege('nurse_note', 'can_delete')) { ?>
                                                                        <a class="btn btn-default btn-xs" data-toggle="tooltip" title=""
                                                                            onclick="delete_recordnotecommend('<?php echo $cvalue['id']; ?>', '<?php echo $this->lang->line('delete_message'); ?>')"
                                                                            data-original-title="<?php echo $this->lang->line('delete'); ?>">
                                                                            <i class="fa fa-trash"></i>
                                                                        </a>
                                                                <?php }
                                                                } ?>
                                                                <span class="pull-right">
                                                                    <?php echo $comment_date . " " . $comment_by ?></span>
                                                            </div>
                                                        <?php  } ?>

                                                    </div>
                                                </li>
                                            <?php } ?>
                                            <li><i class="fa fa-clock-o bg-gray"></i></li>
                                        <?php } ?>
                                        </ul>
                                </div>
                            </div>
                        <?php }
                        if ($this->rbac->hasPrivilege('consultant_register', 'can_view')) { ?>
                            <div class="tab-pane tab-content-height" id="consultant_register">
                                <div class="box-tab-header">
                                    <h3 class="box-tab-title"><?php echo $this->lang->line('consultant_register'); ?></h3>
                                    <div class="box-tab-tools">
                                        <?php
                                        if ($this->rbac->hasPrivilege('consultant_register', 'can_add')) {

                                            if ($is_discharge) {
                                        ?>
                                                <a href="#" class="btn btn-sm btn-primary dropdown-toggle addconsultant"
                                                    onclick="holdModal('add_instruction')" data-toggle="modal"><i
                                                        class="fas fa-plus"></i>
                                                    <?php echo $this->lang->line('consultant_register'); ?></a>

                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <!--./box-tab-header-->


                                <div class="download_label">
                                    <?php echo $result['patient_name'] . " " . $this->lang->line('consultant_register'); ?>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover ipdcharged" id="ipddoctorslist">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th><?php echo $this->lang->line('applied_date'); ?></th>
                                                <th><?php echo $this->lang->line('consultant_doctor'); ?></th>
                                                <th><?php echo $this->lang->line('instruction'); ?></th>
                                                <th><?php echo $this->lang->line('instruction_date'); ?></th>
                                                <?php if (is_array($fields_consultant) || is_object($fields_consultant)) {
                                                    foreach ($fields_consultant as $fields_key => $fields_value) { ?>
                                                        <th><?php echo ucfirst($fields_value->name); ?></th>
                                                <?php }
                                                }

                                                ?>
                                                <th class="text-right noExport"><?php echo $this->lang->line('action') ?>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body"></tbody>
                                    </table>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($this->rbac->hasPrivilege('ipd_prescription ', 'can_view')) { ?>
                            <div class="tab-pane tab-content-height" id="prescription">
                                <div class="box-tab-header">
                                    <h3 class="box-tab-title"><?php echo $this->lang->line('prescription'); ?></h3>
                                    <div class="box-tab-tools">
                                        <?php if ($this->rbac->hasPrivilege('ipd_prescription ', 'can_add')) {
                                            if ($is_discharge) {
                                        ?>
                                                <a href="#" class="btn btn-sm btn-primary dropdown-toggle addprescription"
                                                    data-toggle="modal"><i class="fas fa-plus"></i>
                                                    <?php echo $this->lang->line('add_prescription'); ?></a>
                                        <?php }
                                        } ?>
                                    </div>
                                </div>
                                <!--./box-tab-header-->

                                <div class="download_label">
                                    <?php echo $result['patient_name'] . " " . $this->lang->line('ipd_details'); ?></div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered  example">
                                        <thead>
                                            <th><?php echo $this->lang->line('prescription_no'); ?></th>
                                            <th><?php echo $this->lang->line('date'); ?></th>
                                            <th><?php echo $this->lang->line('finding'); ?></th>
                                            <th class="text-right noExport"><?php echo $this->lang->line('action') ?></th>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($prescription_detail)) {
                                                foreach ($prescription_detail as $prescription_key => $prescription_value) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo $this->customlib->getSessionPrefixByType('ipd_prescription') . $prescription_value["id"] ?>
                                                        </td>
                                                        <td><?php echo date($this->customlib->getHospitalDateFormat(), strtotime($prescription_value['date'])); ?>
                                                        </td>
                                                        <td><?php echo $prescription_value['finding_description']; ?></td>
                                                        <td class="text-right">
                                                            <a href="#prescription" class="btn btn-default btn-xs"
                                                                onclick="view_prescription('<?php echo $prescription_value["id"] ?>', '<?php echo $prescription_value["ipd_id"] ?>','<?php echo $result["ipd_discharge"] ?>')"
                                                                data-toggle="tooltip"
                                                                title="<?php echo $this->lang->line('view') . " " . $this->lang->line('prescription'); ?>">
                                                                <i class="fas fa-file-prescription"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- -->
                        <!-- diagnosis -->

                        <?php if ($this->rbac->hasPrivilege('ipd_lab_investigation ', 'can_view')) { ?>
                            <div class="tab-pane tab-content-height" id="labinvestigation">
                                <div class="box-tab-header">
                                    <h3 class="box-tab-title"><?php echo $this->lang->line('lab_investigation'); ?></h3>
                                    <div class="box-tab-tools">

                                    </div>
                                </div>
                                <!--./box-tab-header-->

                                <div class="download_label">
                                    <?php echo $result['patient_name'] . " " . $this->lang->line('lab_investigation'); ?>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered  example"
                                        data-export-title="<?php echo $this->lang->line('lab_investigation'); ?>">
                                        <thead>
                                            <th><?php echo $this->lang->line('test_name'); ?></th>
                                            <th><?php echo $this->lang->line('lab'); ?></th>
                                            <th><?php echo $this->lang->line('sample_collected'); ?></th>
                                            <td><strong><?php echo $this->lang->line('expected_date'); ?></strong></td>
                                            <th><?php echo $this->lang->line('approved_by'); ?></th>
                                            <th class="text-right noExport"><?php echo $this->lang->line('action'); ?></th>
                                        </thead>
                                        <tbody id="">
                                            <?php foreach ($investigations as $row) { ?>
                                                <tr>
                                                    <td><?php echo $row['test_name']; ?><br />
                                                        <?php echo "(" . $row['short_name'] . ")"; ?></td>
                                                    <td><?php echo $this->lang->line($row['type']); ?></td>
                                                    <td><label>
                                                            <?php echo composeStaffNameByString($row['collection_specialist_staff_name'], $row['collection_specialist_staff_surname'], $row['collection_specialist_staff_employee_id']); ?>
                                                        </label>

                                                        <br />
                                                        <label for=""><?php if ($row['type'] == 'pathology') {
                                                                            echo $this->lang->line('pathology');
                                                                        } else {
                                                                            echo $this->lang->line('radiology');
                                                                        }  ?> : </label>

                                                        <?php
                                                        echo $row['test_center'];
                                                        ?>
                                                        <br />
                                                        <?php echo date('d/m/Y', strtotime($row['collection_date'])); ?>
                                                    </td>

                                                    <td>
                                                        <?php echo date('d/m/Y', strtotime($row['reporting_date'])); ?>

                                                    </td>
                                                    <td class="text-left">
                                                        <label for=""><?php echo $this->lang->line('approved_by'); ?> : </label>
                                                        <?php
                                                        echo composeStaffNameByString($row['approved_by_staff_name'], $row['approved_by_staff_surname'], $row['approved_by_staff_employee_id']);
                                                        ?>
                                                        <br />
                                                        <?php echo date('d/m/Y', strtotime($row['parameter_update'])); ?>
                                                        ?>
                                                    </td>
                                                    <td class="text-right"><a href='javascript:void(0)'
                                                            data-loading-text='<i class="fa fa-reorder"></i>'
                                                            data-record-id='<?php echo $row['report_id']; ?>'
                                                            data-type-id='<?php echo $row['type']; ?>'
                                                            class='btn btn-default btn-xs view_report' data-toggle='tooltip'
                                                            title='<?php echo $this->lang->line("show"); ?>'><i
                                                                class='fa fa-reorder'></i></a></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- Timeline -->
                        <?php if ($this->rbac->hasPrivilege('ipd_timeline', 'can_view')) { ?>
                            <div class="tab-pane tab-content-height" id="timeline">
                                <div class="box-tab-header">
                                    <h3 class="box-tab-title"><?php echo $this->lang->line('timeline'); ?></h3>
                                    <div class="box-tab-tools">
                                        <?php if ($result['ipd_discharge'] != 'yes') {
                                            if ($this->rbac->hasPrivilege('ipd_timeline', 'can_add')) { ?>
                                                <a href="#" class="btn btn-sm btn-primary dropdown-toggle addtimeline"
                                                    onclick="holdModal('myTimelineModal')" data-toggle='modal'><i
                                                        class="fa fa-plus"></i> <?php echo $this->lang->line('add_timeline'); ?></a>
                                        <?php }
                                        } ?>
                                    </div>
                                </div>
                                <!--./box-tab-header-->

                                <div class="download_label">
                                    <?php echo $result['patient_name'] . " " . $this->lang->line('ipd_details'); ?></div>
                                <div class="timeline-header no-border">
                                    <div id="timeline_list">
                                        <?php if (empty($timeline_list)) { ?>
                                            <br />
                                            <div class="alert alert-info"><?php echo $this->lang->line('no_record_found'); ?>
                                            </div>
                                        <?php } else { ?>
                                            <ul class="timeline timeline-inverse">
                                                <?php
                                                foreach ($timeline_list as $key => $value) {

                                                ?>
                                                    <li class="time-label">
                                                        <span class="bg-blue">
                                                            <?php echo date('d/m/Y', strtotime($value['timeline_date'])); ?>
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <i class="fa fa-list-alt bg-blue"></i>
                                                        <div class="timeline-item">
                                                            <?php if ($is_discharge) {
                                                                if ($this->rbac->hasPrivilege('ipd_timeline', 'can_delete')) {
                                                                    if ($value['generated_users_type'] != 'patient') {
                                                            ?>
                                                                        <span class="time"><a class="defaults-c text-right"
                                                                                data-toggle="tooltip" title=""
                                                                                onclick="delete_timeline('<?php echo $value['id']; ?>')"
                                                                                data-original-title="<?php echo $this->lang->line('delete'); ?>"><i
                                                                                    class="fa fa-trash"></i></a></span>
                                                            <?php }
                                                                }
                                                            } ?>
                                                            <?php if ($is_discharge) {
                                                                if ($this->rbac->hasPrivilege('ipd_timeline', 'can_edit')) {
                                                                    if ($value['generated_users_type'] != 'patient') {
                                                            ?><span class="time"><a
                                                                                onclick="editTimeline('<?php echo $value['id']; ?>')"
                                                                                class="defaults-c text-right" data-toggle="tooltip" title=""
                                                                                data-original-title="<?php echo $this->lang->line('edit'); ?>">
                                                                                <i class="fa fa-pencil"></i>
                                                                            </a></span>

                                                            <?php }
                                                                }
                                                            } ?>

                                                            <?php
                                                            if ($value["document"] != "None" && $value["document"] != "") {

                                                                $userdata = $this->session->userdata('hospitaladmin');
                                                                $accessToken = $userdata['accessToken'] ?? '';

                                                                $otherDocument = $value["document"];
                                                                $url = "https://phr-api.plenome.com/file_upload/getDocs";
                                                                $client = curl_init($url);

                                                                curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
                                                                curl_setopt($client, CURLOPT_POST, true);
                                                                curl_setopt($client, CURLOPT_POSTFIELDS, json_encode(['value' => $otherDocument]));
                                                                curl_setopt($client, CURLOPT_HTTPHEADER, [
                                                                    'Content-Type: application/json',
                                                                    'Authorization: ' . $accessToken
                                                                ]);

                                                                $response = curl_exec($client);
                                                                curl_close($client);

                                                                if ($response === false) {
                                                                    echo json_encode(["error" => "No response from server."]);
                                                                    return;
                                                                }

                                                                $base64File = trim($response);
                                                                $fileData = base64_decode($base64File);

                                                                if ($fileData === false) {
                                                                    echo json_encode(["error" => "Failed to decode base64 file data."]);
                                                                    return;
                                                                }

                                                                $fileInfo = pathinfo($otherDocument);
                                                                $fileExtension = strtolower($fileInfo['extension'] ?? 'bin');
                                                                $fileName = preg_replace('/[_\s-]*\d+$/', '', $fileInfo['basename']);

                                                                $mimeTypes = [
                                                                    'jpg' => 'image/jpeg',
                                                                    'jpeg' => 'image/jpeg',
                                                                    'png' => 'image/png',
                                                                    'gif' => 'image/gif',
                                                                    'pdf' => 'application/pdf',
                                                                    'txt' => 'text/plain',
                                                                    'doc' => 'application/msword',
                                                                    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                                                    'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                                                    'xls' => 'application/vnd.ms-excel',
                                                                    'csv' => 'text/csv',
                                                                    'zip' => 'application/zip',
                                                                ];

                                                                $mimeType = $mimeTypes[$fileExtension] ?? 'application/octet-stream';
                                                                $dataUrl = "data:$mimeType;base64,$base64File";
                                                            }
                                                            ?>

                                                            <?php if (!empty($value["document"]) && $value["document"] != "None") { ?>
                                                                <span class="time">
                                                                    <a class="defaults-c text-right" data-toggle="tooltip"
                                                                        href="<?= $dataUrl; ?>" download="<?= $fileName; ?>"
                                                                        data-original-title="<?= $this->lang->line('download'); ?>">
                                                                        <i class="fa fa-download"></i>
                                                                    </a>
                                                                </span>
                                                            <?php } ?>




                                                            <h3 class="timeline-header text-aqua"> <?php echo $value['title']; ?>
                                                            </h3>
                                                            <div class="timeline-body">
                                                                <?php echo $value['description']; ?>
                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php } ?>
                                                <li><i class="fa fa-clock-o bg-gray"></i></li>
                                            <?php } ?>
                                            </ul>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if ($this->rbac->hasPrivilege('ipd_live_consultation', 'can_view')) { ?>
                            <div class="tab-pane tab-content-height" id="live_consult">
                                <div class="box-tab-header">
                                    <h3 class="box-tab-title"><?php echo $this->lang->line('live_consultation'); ?></h3>
                                    <div class="box-tab-tools">

                                    </div>
                                </div>
                                <!--./box-tab-header-->
                                <div class="download_label">
                                    <?php echo $result['patient_name'] . " " . $this->lang->line('ipd_details'); ?></div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered  example">
                                        <thead>
                                            <th><?php echo $this->lang->line('consultation_title'); ?></th>
                                            <th><?php echo $this->lang->line('date'); ?></th>
                                            <th><?php echo $this->lang->line('created_by'); ?> </th>
                                            <th><?php echo $this->lang->line('created_for'); ?></th>
                                            <th><?php echo $this->lang->line('patient'); ?></th>
                                            <th><?php echo $this->lang->line('status'); ?></th>
                                            <th class="text-right noExport"><?php echo $this->lang->line('action'); ?></th>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (empty($ipdconferences)) {
                                            ?>

                                                <?php
                                            } else {
                                                foreach ($ipdconferences as $conference_key => $conference_value) {

                                                    $return_response = json_decode($conference_value->return_response);
                                                ?>
                                                    <tr>
                                                        <td class="mailbox-name">
                                                            <?php echo $conference_value->title; ?>


                                                        </td>

                                                        <td class="mailbox-name">
                                                            <?php echo date($this->customlib->getHospitalDateFormat(true, true), strtotime($conference_value->date)) ?>

                                                        <td class="mailbox-name">

                                                            <?php
                                                            if ($conference_value->created_id == $logged_staff_id) {
                                                                echo $this->lang->line('self');
                                                            } else {
                                                                $name = ($conference_value->create_by_surname == "") ? $conference_value->create_by_name : $conference_value->create_by_name . " " . $conference_value->create_by_surname;
                                                                echo  $name . " (" . $conference_value->create_by_role_name . ": " . $conference_value->create_by_employee_id . ")";
                                                            }
                                                            ?></td>
                                                        <td class="mailbox-name">
                                                            <?php
                                                            $name = ($conference_value->create_for_surname == "") ? $conference_value->create_for_name : $conference_value->create_for_name . " " . $conference_value->create_for_surname;
                                                            echo  $name . " (" . $conference_value->create_for_role_name . ": " . $conference_value->create_for_employee_id . ")";
                                                            ?>
                                                        </td>

                                                        <td class="mailbox-name">
                                                            <?php

                                                            $name = ($conference_value->patient_name == "") ? $conference_value->patient_name : $conference_value->patient_name;
                                                            echo  $name . " (" . $conference_value->patient_unique_id . ")";
                                                            ?>

                                                        </td>
                                                        <td class="mailbox-name">
                                                            <form class="chgstatus_form" method="POST"
                                                                action="<?php echo site_url('admin/zoom_conference/chgstatus') ?>">
                                                                <input type="hidden" name="conference_id"
                                                                    value="<?php echo $conference_value->id; ?>">
                                                                <select class="form-control chgstatus_dropdown" name="chg_status">
                                                                    <option value="0"
                                                                        <?php if ($conference_value->status == 0) echo "selected='selected'" ?>>
                                                                        <?php echo $this->lang->line('awaited'); ?></option>
                                                                    <option value="1"
                                                                        <?php if ($conference_value->status == 1) echo "selected='selected'" ?>>
                                                                        <?php echo $this->lang->line('cancelled'); ?> </option>
                                                                    <option value="2"
                                                                        <?php if ($conference_value->status == 2) echo "selected='selected'" ?>>
                                                                        <?php echo $this->lang->line('finished'); ?> </option>
                                                                </select>
                                                            </form>
                                                        </td>
                                                        <td class="mailbox-date relative text-right" width="90">
                                                            <?php
                                                            if ($conference_value->status == 0) {
                                                            ?>
                                                                <a href="#" class="btn btn-sm label-success start-mr-20"
                                                                    data-toggle="modal" data-target="#modal-chkstatus"
                                                                    data-id="<?php echo $conference_value->id; ?>">
                                                                    <span class="label"><i class="fa fa-video-camera"></i>
                                                                        <?php echo $this->lang->line('start') ?></span></a>
                                                            <?php
                                                            }
                                                            ?>
                                                            <?php

                                                            if ($conference_value->api_type != 'self') {
                                                            ?>
                                                                <?php
                                                                if ($is_discharge) {
                                                                    if ($this->rbac->hasPrivilege('live_classes', 'can_delete')) {
                                                                ?>
                                                                        <a href="<?php echo base_url(); ?>admin/zoom_conference/delete_consult/<?php echo $conference_value->id . "/" . $return_response->id; ?>"
                                                                            class="btn btn-default btn-xs" data-toggle="tooltip"
                                                                            title="<?php echo $this->lang->line('delete'); ?>"
                                                                            onclick="return confirm('<?php echo $this->lang->line('delete_confirm') ?>');">
                                                                            <i class="fa fa-remove"></i>
                                                                        </a>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>

                                                            <?php
                                                            }
                                                            ?>

                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($this->rbac->hasPrivilege('bed_history', 'can_view')) {  ?>
                            <div class="tab-pane tab-content-height" id="bed_history">
                                <div class="box-tab-header">
                                    <h3 class="box-tab-title"><?php echo $this->lang->line("bed_history"); ?></h3>
                                    <div class="box-tab-tools">
                                    </div>
                                </div>
                                <div class="download_label"></div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered  example">
                                        <thead>
                                            <th><?php echo $this->lang->line('bed_group'); ?></th>
                                            <th><?php echo $this->lang->line('bed'); ?> </th>
                                            <th><?php echo $this->lang->line('from_date'); ?></th>
                                            <th><?php echo $this->lang->line('to_date'); ?></th>
                                            <th><?php echo $this->lang->line("active_bed"); ?></th>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($bed_history as $history) { ?>
                                                <tr>
                                                    <td class="mailbox-name">
                                                        <?php echo !empty($history->bed_group) ? $history->bed_group : '-'; ?>
                                                    </td>
                                                    <td class="mailbox-name">
                                                        <?php echo !empty($history->bed) ? $history->bed : '-'; ?></td>
                                                    <td class="mailbox-name">
                                                        <?php echo !empty($history->from_date) ? date('d/m/Y', strtotime($history->from_date)) : '-'; ?>
                                                    </td>
                                                    <td class="mailbox-name">
                                                        <?php echo !empty($history->to_date) ? date('d/m/Y', strtotime($history->to_date)) : '-'; ?>
                                                    </td>
                                                    <td class="mailbox-name">
                                                        <?php echo !empty($history->is_active) ? $this->lang->line($history->is_active) : '-'; ?>
                                                    </td>
                                                </tr>

                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($this->rbac->hasPrivilege('ipd_medication', 'can_view')) {  ?>
                            <div class="tab-pane tab-content-height" id="medication">
                                <div class="box-tab-header">
                                    <h3 class="box-tab-title"><?php echo $this->lang->line('medication'); ?></h3>
                                    <div class="box-tab-tools">
                                        <?php if ($is_discharge) {
                                            if ($this->rbac->hasPrivilege('ipd_medication', 'can_add')) {  ?>
                                                <a href="#" class="btn btn-sm btn-primary dropdown-toggle addmedication"
                                                    onclick="addmedicationModal()" data-toggle='modal'><i class="fa fa-plus"></i>
                                                    <?php echo $this->lang->line("add_medication_dose"); ?></a>
                                        <?php }
                                        } ?>
                                    </div>
                                </div>
                                <!--./box-tab-header-->

                                <div class="download_label">
                                    <?php echo $result['patient_name'] . " " . $this->lang->line('ipd_details'); ?></div>
                                <div class="table_inner">
                                    <?php if (!empty($medication)) { ?>
                                        <table class="table table-striped table-bordered  mb0">
                                            <thead>
                                                <th class="hard_left"><?php echo $this->lang->line("date"); ?> </th>
                                                <th class="next_left table_inner_tdwidth">
                                                    <?php echo $this->lang->line("medicine_name"); ?></th>
                                                <?php
                                                if (!empty($max_dose)) {
                                                    $dosage_count = $max_dose;
                                                } else {
                                                    $dosage_count = 0;
                                                }

                                                for ($x = 1; $x <= $dosage_count; $x++) { ?>

                                                    <th class="table_inner_tdwidth"><?php echo $this->lang->line("dose") . $x; ?>
                                                    </th>
                                                <?php }
                                                ?>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $count = 1;
                                                foreach ($medication as $medication_key => $medication_value) {
                                                    $pharmacy_id = $medication_value['pharmacy_id'];
                                                    $date = $medication_value['date'];
                                                ?>
                                                    <tr>
                                                        <?php
                                                        $subcount = 1;
                                                        foreach ($medication_value['dosage'][$date] as $mkey => $mvalue) {
                                                            $date = date('d/m/Y', strtotime($medication_value['date']));
                                                        ?>
                                                            <td class="hard_left"><?php if ($subcount == 1) {
                                                                                        echo $date . "<br>(" . date('l', strtotime($medication_value['date'])) . ")";
                                                                                    } else {
                                                                                        echo "<span class='fa-level-span'><i class='fa fa-level-up fa-level-roated' aria-hidden='true'></i></span>";
                                                                                    } ?></td>
                                                            <td class="next_left"><?php echo $mvalue['name'] ?></td>
                                                            <?php
                                                            for ($x = 0; $x <= $dosage_count; $x++) {
                                                                if (array_key_exists($x, $mvalue['dose_list'])) {
                                                                    $medicine_id = $mvalue['dose_list'][$x]['pharmacy_id'];
                                                                    $medicine_category_id = $mvalue['dose_list'][$x]['medicine_category_id'];
                                                                    $add_index = $x;
                                                                    if ($this->rbac->hasPrivilege('ipd_medication', 'can_edit')) {
                                                                        $medication_edit = "<a href='#' class='btn btn-default btn-xs' data-toggle='tooltip' data-original-title='" . $this->lang->line('edit') . "' onclick='medicationDoseModal(" . $mvalue['dose_list'][$x]['id'] . ")'><i class='fa fa-pencil'></i></a>";
                                                                    } else {
                                                                        $medication_edit = "";
                                                                    }

                                                                    if ($this->rbac->hasPrivilege('ipd_medication', 'can_delete')) {
                                                                        $medication_delete = "<a class='btn btn-default btn-xs delete_record_dosage' data-toggle='tooltip' data-original-title='" . $this->lang->line('delete') . "' data-record-id='" . $mvalue['dose_list'][$x]['id'] . "'><i class='fa fa-trash'></i></a>";
                                                                    } else {
                                                                        $medication_delete = "";
                                                                    }
                                                            ?>
                                                                    <td class="dosehover">
                                                                        <?php echo $this->lang->line('time') . ": " . $this->customlib->getHospitalTime_Format($mvalue['dose_list'][$x]['time']) . "<span>" . $medication_edit . "</span><span>" . $medication_delete . "</span><br>" . $mvalue['dose_list'][$x]['medicine_dosage'] . " " . $mvalue['dose_list'][$x]['unit'];
                                                                        if ($mvalue['dose_list'][$x]['remark'] != '') {
                                                                            echo "<br>" . $this->lang->line('remark') . ": " . $mvalue['dose_list'][$x]['remark'];
                                                                        } ?>
                                                                    </td>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <td class="dosehover"><?php
                                                                                            if ($add_index + 1 == $x) {
                                                                                                if ($this->rbac->hasPrivilege('ipd_medication', 'can_add')) {
                                                                                                    if ($is_discharge) {
                                                                                            ?>
                                                                                    <a href="#" class="btn btn-sm btn-primary dropdown-toggle addmedication"
                                                                                        onclick="medicationModal('<?php echo $medicine_category_id; ?>','<?php echo $medicine_id; ?>','<?php echo $date; ?>')"
                                                                                        data-toggle='modal'><i class="fa fa-plus"></i></a>
                                                                        <?php
                                                                                                    }
                                                                                                }
                                                                                            }
                                                                        ?>
                                                                    </td>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                    </tr>
                                            <?php
                                                            $subcount++;
                                                        }
                                                    }
                                            ?>

                                            </tbody>

                                        </table>

                                    <?php } else { ?>

                                        <div class="alert alert-danger"><?php echo $this->lang->line('no_record_found'); ?>
                                        </div>

                                    <?php } ?>

                                </div>

                            </div>
                        <?php } ?>
                        <?php if ($this->rbac->hasPrivilege('ipd_operation_theatre', 'can_view')) {  ?>
                            <div class="tab-pane tab-content-height" id="operationtheatre">
                                <div class="box-tab-header">
                                    <h3 class="box-tab-title"><?php echo $this->lang->line("operations"); ?></h3>
                                    <div class="box-tab-tools">
                                        <?php
                                        if ($is_discharge) {
                                            if ($this->rbac->hasPrivilege('ipd_operation_theatre', 'can_add')) { ?>
                                                <a data-toggle="modal" onclick="holdModal('add_operationtheatre')"
                                                    class="btn btn-primary btn-sm addoperationtheatre"><i class="fa fa-plus"></i>
                                                    <?php echo $this->lang->line("add_operation"); ?></a>
                                        <?php }
                                        } ?>
                                    </div>
                                </div>
                                <!--./box-tab-header-->
                                <div class="download_label">
                                    <?php echo $result['patient_name'] . " " . $this->lang->line('ipd_details'); ?></div>
                                <div class="table_inner">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <th><?php echo $this->lang->line("reference_no"); ?></th>
                                            <th><?php echo $this->lang->line("operation_date"); ?></th>
                                            <th><?php echo $this->lang->line("operation_name"); ?></th>
                                            <th><?php echo $this->lang->line("operation_category"); ?></th>
                                            <th><?php echo $this->lang->line("ot_technician"); ?></th>
                                            <?php if (is_array($fields_ot) || is_object($fields)) {
                                                foreach ($fields_ot as $fields_key => $fields_value) { ?>
                                                    <th><?php echo ucfirst($fields_value->name); ?></th>
                                            <?php }
                                            }

                                            ?>

                                            <th class="text-right noExport"><?php echo $this->lang->line('action'); ?></th>

                                        </thead>
                                        <tbody>
                                            <?php if (!empty($operation_theatre)) {
                                                foreach ($operation_theatre as $ot_key => $ot_value) { ?>
                                                    <tr>
                                                        <td><?php echo $this->customlib->getSessionPrefixByType('operation_theater_reference_no') . ($ot_value["id"] ?? '-'); ?>
                                                        </td>
                                                        <td><?php echo !empty($ot_value["date"]) ? date('d/m/Y', strtotime($ot_value["date"])) : '-'; ?>
                                                        </td>
                                                        <td><?php echo !empty($ot_value["operation"]) ? $ot_value["operation"] : '-'; ?>
                                                        </td>
                                                        <td><?php echo !empty($ot_value["category"]) ? $ot_value["category"] : '-'; ?>
                                                        </td>
                                                        <td><?php echo !empty($ot_value['ot_technician']) ? $ot_value['ot_technician'] : '-'; ?>
                                                        </td>

                                                        <?php if (!empty($fields_ot)) {
                                                            foreach ($fields_ot as $fields_key => $fields_value) {
                                                                $display_field = !empty($ot_value[$fields_value->name]) ? $ot_value[$fields_value->name] : '-';
                                                                if ($fields_value->type == "link" && !empty($ot_value[$fields_value->name])) {
                                                                    $display_field = "<a href='" . $ot_value[$fields_value->name] . "' target='_blank'>" . $ot_value[$fields_value->name] . "</a>";
                                                                } ?>
                                                                <td><?php echo $display_field; ?></td>
                                                        <?php }
                                                        } ?>

                                                        <td class="text-right">
                                                            <a href='#' data-toggle='tooltip'
                                                                title="<?php echo $this->lang->line('show'); ?>"
                                                                class='btn btn-default btn-xs' data-target='#view_ot_modal'
                                                                onclick='viewdetail("<?php echo $ot_value['id']; ?>")'>
                                                                <i class='fa fa-reorder'></i>
                                                            </a>
                                                            <?php if ($is_discharge) {
                                                                if ($this->rbac->hasPrivilege('ipd_operation_theatre', 'can_edit')) { ?>
                                                                    <a onclick="editot('<?php echo $ot_value['id']; ?>')"
                                                                        class="btn btn-default btn-xs" data-toggle="tooltip"
                                                                        title="<?php echo $this->lang->line('edit'); ?>">
                                                                        <i class="fa fa-pencil"></i>
                                                                    </a>
                                                                <?php }
                                                                if ($this->rbac->hasPrivilege('ipd_operation_theatre', 'can_delete')) { ?>
                                                                    <a onclick="deleteot('<?php echo $ot_value['id']; ?>')"
                                                                        class="btn btn-default btn-xs" data-toggle="tooltip"
                                                                        title="<?php echo $this->lang->line('delete'); ?>">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                            <?php }
                                                            } ?>
                                                        </td>
                                                    </tr>
                                                <?php }
                                            } else { ?>
                                                <tr>
                                                    <td colspan="100%" class="text-center">-</td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>


                                    </table>

                                </div>
                            </div>

                            <!--Charges-->
                        <?php }
                        if ($this->rbac->hasPrivilege('charges', 'can_view')) { ?>
                            <div class="tab-pane tab-content-height" id="charges">
                                <div class="box-tab-header">
                                    <h3 class="box-tab-title"><?php echo $this->lang->line('charges'); ?></h3>
                                    <div class="box-tab-tools">
                                        <?php
                                        if ($this->rbac->hasPrivilege('charges', 'can_add')) {
                                            if ($is_discharge) {
                                        ?>
                                                <a href="#" class="btn btn-sm btn-primary dropdown-toggle addcharges"
                                                    onclick="holdModal('myChargesModal')" data-toggle='modal'><i
                                                        class="fa fa-plus"></i> <?php echo $this->lang->line('add_charges'); ?></a>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <!--./box-tab-header-->
                                <div class="download_label"><?php echo $this->lang->line('charges'); ?></div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover ipdcharged" id="ipdcharged"
                                        data-export-title="<?php echo composePatientName($result['patient_name'], $result['id']) . " " . $this->lang->line('opd_details'); ?>">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="text-center">S.No</th>
                                                <th class="text-center">Date</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Charge Type</th>
                                                <th class="text-center">Charge Category</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-center">Standard Charge (INR)</th>
                                                <th class="text-center">TPA Charge (INR)</th>
                                                <th class="text-center">Tax</th>
                                                <th class="text-center">Applied Charge (INR)</th>
                                                <th class="text-center">Amount (INR)</th>
                                                <th class="text-center">Payment Status</th>
                                                <th class="text-center noExport">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body"></tbody>
                                    </table>
                                </div>
                            </div>
                        <?php }
                        if ($this->rbac->hasPrivilege('payment', 'can_view')) { ?>
                            <div class="tab-pane tab-content-height" id="payment">
                                <div class="box-tab-header">
                                    <h3 class="box-tab-title"><?php echo $this->lang->line('payment'); ?></h3>
                                    <div class="box-tab-tools">
                                        <?php
                                        if ($this->rbac->hasPrivilege('payment', 'can_add')) {
                                        ?>
                                            <a href="#" class="btn btn-sm btn-primary dropdown-toggle addpayment"
                                                onclick="addpaymentModal()" data-toggle='modal'><i class="fa fa-plus"></i>
                                                <?php echo $this->lang->line('add_payment'); ?></a>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <!--./box-tab-header-->

                                <div class="download_label"><?php echo $this->lang->line('payment'); ?></div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover ipdcharged" id="ipdpayment"
                                        data-export-title="<?php echo composePatientName($result['patient_name'], $result['id']) . " " . $this->lang->line('opd_details'); ?>">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>S.No</th>
                                                <th><?php echo $this->lang->line('transaction_id'); ?></th>
                                                <th><?php echo $this->lang->line('date'); ?></th>
                                                <th><?php echo $this->lang->line('note'); ?></th>
                                                <th><?php echo $this->lang->line('payment_mode'); ?></th>
                                                <th class="text-right">
                                                    <?php echo $this->lang->line('paid_amount') . " (" . $currency_symbol . ")"; ?>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body"></tbody>
                                    </table>
                                </div>
                                <!--./table-responsive-->
                            </div>
                            <!--#/Bill payment -->
                        <?php } ?>
                        <?php if ($this->rbac->hasPrivilege('ipd_treatment_history', 'can_view')) { ?>
                            <!--- treatment history tab---->
                            <div class="tab-pane tab-content-height" id="treatment_history">
                                <div class="box-tab-header">
                                    <h3 class="box-tab-title"><?php echo $this->lang->line('treatment_history'); ?></h3>
                                    <div class="box-tab-tools">

                                    </div>
                                </div>
                                <!--./box-tab-header-->

                                <div class="download_label"><?php echo $this->lang->line('treatment_history'); ?></div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered  treatmentlist"
                                        data-export-title="<?php echo $this->lang->line('treatment_history'); ?>">
                                        <thead>
                                            <th><?php echo $this->lang->line('ipd_no'); ?></th>
                                            <th><?php echo $this->lang->line('symptoms'); ?></th>
                                            <th><?php echo $this->lang->line('consultant'); ?></th>
                                            <th class="text-right"><?php echo $this->lang->line('bed'); ?></th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <!--./table-responsive-->
                            </div>
                            <!--#/Bill payment -->
                        <?php } ?>
                        <!--- end treatmenthistory tab-->
                    </div>
                </div>
            </div> <!-- /.box-body -->
        </div>
        <!--./box box-primary-->

    </section>
</div>

<div id="modal-chkstatus" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog2 modal-lg">
        <form id="form-chkstatus" action="" method="POST">
            <div class="modal-content">
                <div class="">
                    <button type="button" class="close modalclosezoom" data-dismiss="modal">&times;</button>

                </div>
                <div class="modal-body" id="zoom_details">

                </div>
            </div>
        </form>
    </div>
</div>

<!-- Add Doctors -->
<div class="modal fade" id="add_doctor" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('add_doctor'); ?> </h4>
            </div>
            <form id="form_doctor" accept-charset="utf-8" enctype="multipart/form-data" method="post">
                <input type="hidden" name="ipdid_doctor" id="ipdid_doctor" value="<?php echo $result['ipdid'] ?>">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php
                            $ipdarray[] = '';
                            $doctors_ipd_array[] = '';
                            foreach ($doctors_ipd as $doctors_ipd_value) {
                                $doctors_ipd_array[] = $doctors_ipd_value['consult_doctor'];
                            }
                            $ipdarray[] = $doctors_ipd_array;  ?>

                            <select placeholder="select" name="doctorOpt[]" class="doctorinput select2"
                                style="width: 100%" multiple id="doctorOpt">
                                <?php foreach ($doctorsipd as $dkey => $dvalue) {   ?>

                                    <option value="<?php echo $dvalue["id"]; ?>" <?php
                                                                                    if ((isset($doctors_ipd)) && (in_array($dvalue["id"], $ipdarray[1]))) {
                                                                                        echo "selected";
                                                                                    } ?>>
                                        <?php echo $dvalue["name"] . " " . $dvalue["surname"] . " (" . $dvalue["employee_id"] . ")" ?>
                                    </option>
                                <?php } ?>

                            </select>
                            <span class="text-danger"><?php echo form_error('doctorOpt[]'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="form_doctorbtn"
                        data-loading-text="<?php echo $this->lang->line('processing'); ?>"
                        class="btn btn-info pull-right"> <i class="fa fa-check-circle"></i>
                        <?php echo $this->lang->line('save'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="discharge_revert" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('discharge_revert'); ?> </h4>
            </div>
            <form id="form_discharge_revert" accept-charset="utf-8" enctype="multipart/form-data" method="post">
                <input type="hidden" name="ipd_details_id" id="ipd_details_id" value="<?php echo $result['ipdid'] ?>">
                <input type="hidden" name="opd_details_id" id="opd_details_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="exampleInputFile">
                                    <?php echo $this->lang->line('bed_group'); ?></label>
                                <div>
                                    <select class="form-control" name='bed_group_id' id='bed_group_id'
                                        onchange="getBed(this.value, '', 'yes')">
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        <?php foreach ($bedgroup_list as $key => $bedgroup) {
                                        ?>
                                            <option value="<?php echo $bedgroup["id"] ?>">
                                                <?php echo $bedgroup["name"] . " - " . $bedgroup["floor_name"] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="exampleInputFile">
                                    <?php echo $this->lang->line('bed_no'); ?></label><small class="req"> *</small>
                                <div><select class="form-control select2" style="width:100%" name='bed_no' id='bed_nos'>
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>

                                    </select>
                                </div>
                                <span class="text-danger"><?php echo form_error('bed_no'); ?></span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="exampleInputFile">
                                    <?php echo $this->lang->line('revert_reason'); ?></label><small class="req">
                                    *</small>
                                <div>
                                    <textarea name="discharge_revert_reason" rows="3" class="form-control"></textarea>
                                </div>
                                <span class="text-danger"><?php echo form_error('bed_no'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="submit_discharge_revert"
                        data-loading-text="<?php echo $this->lang->line('processing'); ?>"
                        class="btn btn-info pull-right"> <i class="fa fa-check-circle"></i>
                        <?php echo $this->lang->line('save'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Timeline -->
<div class="modal fade" id="myTimelineModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('add_timeline'); ?></h4>
            </div>
            <form id="add_timeline" accept-charset="utf-8" enctype="multipart/form-data" method="post">
                <div class="scroll-area">
                    <div class="modal-body pb0 ptt10">
                        <div class="row">
                            <div class=" col-md-12">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('title'); ?></label><small class="req">
                                        *</small>
                                    <input type="hidden" name="patient_id" id="patient_id"
                                        value="<?php echo $result['patient_id'] ?>">
                                    <input id="timeline_title" name="timeline_title" placeholder="" type="text"
                                        class="form-control" onkeyup="this.value=this.value.replace(/[^a-zA-Z]/g,'')" />
                                    <span class="text-danger"><?php echo form_error('timeline_title'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('date'); ?>
                                        <small class="req"> *</small>
                                    </label>
                                    <input id="timeline_date" name="timeline_date"
                                        value="<?php echo date('d/m/Y');//set_value('timeline_date', date($this->customlib->getHospitalDateFormat())); ?>"
                                        placeholder="" type="text" class="form-control date" />
                                    <span class="text-danger"><?php echo form_error('timeline_date'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('description'); ?></label>
                                    <textarea id="timeline_desc" name="timeline_desc" placeholder=""
                                        class="form-control" rows=6></textarea>
                                    <span class="text-danger"><?php echo form_error('description'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('attach_document'); ?></label>
                                    <div>
                                        <input id="timeline_doc_id" name="timeline_doc" placeholder="" type="file"
                                            class="filestyle form-control" data-height="40"
                                            value="<?php echo set_value('timeline_doc'); ?>" />
                                        <span class="text-danger"><?php echo form_error('timeline_doc'); ?></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label
                                        class="align-top"><?php echo $this->lang->line('visible_to_this_person'); ?></label>
                                    <input id="visible_check" checked="checked" name="visible_check" value="yes"
                                        placeholder="" type="checkbox" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="add_timelinebtn"
                        data-loading-text="<?php echo $this->lang->line('processing'); ?>"
                        class="btn btn-info pull-right"><i class="fa fa-check-circle"></i>
                        <?php echo $this->lang->line('save'); ?></button>
                </div>
            </form>


        </div>
    </div>
</div>

<div class="modal fade" id="nursenoteEditModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('edit_nurse_note'); ?></h4>
            </div>
            <form id="edit_nursenote" accept-charset="utf-8" enctype="multipart/form-data" method="post" class="">
                <div class="scroll-area">
                    <div class="modal-body pt0 pb0">
                        <div class="ptt10">
                            <div class="row">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('date'); ?>
                                            <small class="req"> *</small>
                                        </label>
                                        <input type="text" name="date" id="endate" value=""
                                            class="form-control">
                                        <input type="hidden" name="nurseid" id="nurse_id">

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('nurse'); ?><small class="req"> *</small>
                                        </label>

                                        <select name="nurse" style="width: 100%" id="edit_nurse"
                                            class="form-control select2">
                                            <option value=""><?php echo $this->lang->line('select') ?></option>
                                            <?php foreach ($nurse as $value) { ?>
                                                <option <?php if ((isset($nurse_select)) && ($nurse_select == $value["id"])) {
                                                            echo "selected";
                                                        } ?> value="<?php echo $value["id"] ?>">
                                                    <?php echo composeStaffNameByString($value["name"], $value["surname"], $value["employee_id"]); ?>

                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('note') ?> <small class="req"> *</small>
                                        </label>
                                        <textarea name="note" id="enote" style="height:50px"
                                            class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('comment') ?> <small class="req"> *</small>
                                        </label>
                                        <textarea name="comment" id="ecomment" style="height:50px"
                                            class="form-control"></textarea>
                                    </div>
                                </div>

                                <div class="" id="customfieldnurse"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="pull-right">
                        <button type="submit" data-loading-text="<?php echo $this->lang->line('processing') ?>"
                            id="edit_nursenotebtn" class="btn btn-info"><i class="fa fa-check-circle"></i>
                            <?php echo $this->lang->line('save'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="nursenoteCommentModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close close_btn" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> <?php echo $this->lang->line('add') . " " . $this->lang->line('comment'); ?>
                </h4>
            </div>
            <form id="comment_nursenote" accept-charset="utf-8" enctype="multipart/form-data" method="post" class="">
                <div class="modal-body pt0 pb0">
                    <div class="ptt10">
                        <div class="row">
                            <!-- <input type="hidden" name="nurseid" id="enurse_id"> -->
                            <input type="hidden" name="nurseid" id="nurse_noteid">
                            <!--  <input type="hidden" name="ipd_id" id="nurse_ipdid"> -->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('comment') ?> <small class="req"> *</small>
                                    </label>
                                    <textarea name="comment_staff" id="comment_staff" style="height:100px"
                                        class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="pull-right">
                        <button type="submit" data-loading-text="<?php echo $this->lang->line('processing') ?>"
                            id="comment_nursenotebtn" class="btn btn-info"><i class="fa fa-check-circle"></i>
                            <?php echo $this->lang->line('save'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="patient_discharge" role="dialog" aria-labelledby="follow_up">
    <div class="modal-dialog modal-mid modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="modalicon">
                    <div id='allpayments_print'>
                    </div>
                </div>
                <h4 class="modal-title"><?php echo $this->lang->line('patient_discharge'); ?></h4>
            </div>
            <div class="modal-body pb0" id="patient_discharge_result">

            </div>
        </div>
    </div>
</div>
<!-- Add OT -->
<div class="modal fade" id="add_operationtheatre" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line("add_operation"); ?></h4>
            </div>
            <div class="scroll-area">
                <form id="form_operationtheatre" accept-charset="utf-8" enctype="multipart/form-data" method="post">
                    <div class="modal-body pb0 ptt10">
                        <input type="hidden" value="<?php echo $ipdid ?>" name="ipdid" class="form-control"
                            id="ipdid" />
                        <input type="hidden" value="<?php echo $result['case_reference_id']; ?>" name="case_id" />
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('operation_category'); ?></label><small
                                        class="req"> *</small>
                                    <select name="operation_category" id="operation_category"
                                        class="form-control select2" onchange="getcategory(this.value)"
                                        style="width:100%">
                                        <option value=""><?php echo $this->lang->line('select') ?></option>
                                        <?php foreach ($categorylist as $operation) { ?>
                                            <option value="<?php echo $operation['id']; ?>">
                                                <?php echo $operation['category']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('operation_category'); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label
                                        for="operation_name"><?php echo $this->lang->line('operation_name'); ?></label>
                                    <small class="req"> *</small>
                                    <div>
                                        <select name="operation_name" id="operation_name" class="form-control select2"
                                            style="width:100%">

                                        </select>
                                    </div>
                                    <span class="text-danger"><?php echo form_error('operation_name'); ?></span>
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('operation_date'); ?></label>
                                    <small class="req"> *</small>
                                    <input type="text" value="<?php //echo set_value('email');     
                                                                ?>" id="date" name="date"
                                        class="form-control datetime">
                                    <span class="text-danger"><?php echo form_error('date'); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="exampleInputFile">
                                        <?php echo $this->lang->line('consultant_doctor'); ?></label>
                                    <small class="req"> *</small>
                                    <div><select class="form-control select2" <?php
                                                                                if ($disable_option == true) {
                                                                                    echo "disabled";
                                                                                }
                                                                                ?> style="width:100%"
                                            id='consultant_doctorid' name='consultant_doctor'>
                                            <option value="<?php echo set_value('consultant_doctor'); ?>">
                                                <?php echo $this->lang->line('select'); ?></option>
                                            <?php foreach ($doctors as $dkey => $dvalue) {
                                            ?>
                                                <option value="<?php echo $dvalue["id"]; ?>" <?php
                                                                                                if ((isset($doctor_select)) && ($doctor_select == $dvalue["id"])) {
                                                                                                    echo "selected";
                                                                                                }
                                                                                                ?>>
                                                    <?php echo composeStaffNameByString($dvalue["name"], $dvalue["surname"], $dvalue["employee_id"]); ?>
                                                </option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                    <span class="text-danger"><?php echo form_error('consultant_doctor'); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('assistant_consultant') . " " . '1'; ?></label>
                                    <input type="text" name="ass_consultant_1" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('assistant_consultant') . " " . '2'; ?></label>
                                    <input type="text" name="ass_consultant_2" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('anesthetist'); ?></label>
                                    <input type="text" name="anesthetist" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('anesthesia_type'); ?></label>
                                    <input type="text" name="anaethesia_type" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('ot_technician'); ?></label>
                                    <input type="text" name="ot_technician" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('ot_assistant'); ?></label>
                                    <input type="text" value="<?php //echo set_value('email');     
                                                                ?>" name="ot_assistant" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('remark'); ?></label>
                                    <textarea name="ot_remark" id="ot_remark" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('result'); ?></label>
                                    <textarea name="ot_result" id="ot_result" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="">
                                <?php echo display_custom_fields('operationtheatre'); ?>
                            </div>


                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="pull-right">
                            <button type="submit" id="form_addoperationtheatrbtn"
                                data-loading-text="<?php echo $this->lang->line('processing'); ?>"
                                class="btn btn-info"><i class="fa fa-check-circle"></i>
                                <?php echo $this->lang->line('save'); ?></button>
                        </div>
                    </div>
                </form>

            </div> <!-- scroll-area -->
        </div>
    </div>
</div>
<!-- Edit Operation Theatre -->

<div class="modal fade" id="edit_operationtheatre" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line("edit_operation"); ?></h4>
            </div>
            <form id="form_editoperationtheatre" accept-charset="utf-8" enctype="multipart/form-data" method="post"
                class="ptt10">
                <div class="scroll-area">
                    <div class="modal-body pt0 pb0">
                        <div class="row">
                            <input type="hidden" value="<?php echo $ipdid ?>" name="opdid" class="form-control"
                                id="opdid" />
                            <input type="hidden" value="" name="otid" class="form-control" id="otid" />
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('operation_category'); ?></label> <small
                                        class="req"> *</small>

                                    <select name="eoperation_category" id="eoperation_category"
                                        class="form-control select2" onchange="getcategory(this.value)"
                                        style="width:100%">
                                        <option value=""><?php echo $this->lang->line('select') ?></option>
                                        <?php foreach ($categorylist as $operation) { ?>
                                            <option value="<?php echo $operation['id']; ?>">
                                                <?php echo $operation['category']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('eoperation_category'); ?></span>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label
                                        for="operation_name"><?php echo $this->lang->line('operation_name'); ?></label>
                                    <small class="req"> *</small>

                                    <select name="eoperation_name" id="eoperation_name" class="form-control select2"
                                        style="width:100%">
                                        <option value=""><?php echo $this->lang->line('select') ?></option>
                                        <?php foreach ($operation_list as $operation_list) { ?>
                                            <option value="<?php echo $operation_list['id']; ?>">
                                                <?php echo $operation_list['operation']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('operation_name'); ?></span>
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('operation_date'); ?></label>
                                    <small class="req"> *</small>
                                    <input type="text" value="" id="edate" name="date" class="form-control datetime">
                                    <span class="text-danger"><?php echo form_error('date'); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="exampleInputFile">
                                        <?php echo $this->lang->line('consultant_doctor'); ?></label> <small
                                        class="req"> *</small>
                                    <div><select class="form-control select2" <?php
                                                                                if ($disable_option == true) {
                                                                                    echo "disabled";
                                                                                }
                                                                                ?> style="width:100%"
                                            id='econsultant_doctorid' name='consultant_doctor'>
                                            <option value="<?php echo set_value('consultant_doctor'); ?>">
                                                <?php echo $this->lang->line('select') ?></option>
                                            <?php foreach ($doctors as $dkey => $dvalue) {
                                            ?>
                                                <option value="<?php echo $dvalue["id"]; ?>" <?php
                                                                                                if ((isset($doctor_select)) && ($doctor_select == $dvalue["id"])) {
                                                                                                    echo "selected";
                                                                                                }
                                                                                                ?>>
                                                    <?php echo composeStaffNameByString($dvalue["name"], $dvalue["surname"], $dvalue["employee_id"]); ?>
                                                </option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                    <span class="text-danger"><?php echo form_error('consultant_doctor'); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('assistant_consultant') . " " . '1'; ?></label>
                                    <input type="text" name="ass_consultant_1" id="eass_consultant_1"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('assistant_consultant') . " " . '2'; ?></label>
                                    <input type="text" name="ass_consultant_2" id="eass_consultant_2"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('anesthetist'); ?></label>
                                    <input type="text" name="anesthetist" id="eanesthetist" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('anaethesia_type'); ?></label>
                                    <input type="text" name="anaethesia_type" id="eanaethesia_type"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('ot_technician'); ?></label>
                                    <input type="text" name="ot_technician" id="eot_technician" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('ot_assistant'); ?></label>
                                    <input type="text" value="" name="ot_assistant" id="eot_assistant"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('remark'); ?></label>
                                    <textarea name="eot_remark" id="eot_remark" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('result'); ?></label>
                                    <textarea name="eot_result" id="eot_result" class="form-control"></textarea>
                                </div>
                            </div>
                            <div id="custom_field_ot">

                            </div>

                        </div>
                    </div>
                </div><!-- scroll-area -->
                <div class="modal-footer">
                    <div class="pull-right">
                        <button type="submit" id="form_editoperationtheatrebtn"
                            data-loading-text="<?php echo $this->lang->line('processing') ?>" class="btn btn-info"><i
                                class="fa fa-check-circle"></i> <?php echo $this->lang->line('save'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Edit Timeline -->
<div class="modal fade" id="myTimelineEditModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('edit_timeline'); ?></h4>
            </div>
            <form id="edit_timeline" accept-charset="utf-8" enctype="multipart/form-data" method="post">
                <div class="scroll-area">
                    <div class="modal-body pb0">
                        <div class="row">
                            <div class=" col-md-12">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('title'); ?></label><small class="req">
                                        *</small>
                                    <input type="hidden" name="patient_id" id="epatientid" value="">
                                    <input type="hidden" name="timeline_id" id="etimelineid" value="">
                                    <input type="hidden" name="oldfiles" id="oldfiles" value="">
                                    <input id="etimelinetitle" name="timeline_title" placeholder="" type="text"
                                        class="form-control" onkeyup="this.value=this.value.replace(/[^a-zA-Z]/g,'')" />
                                    <span class="text-danger"><?php echo form_error('timeline_title'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('date'); ?></label><small class="req"> *</small>

                                    <input type="text" name="timeline_date" class="form-control date"
                                        id="etimelinedate" />
                                    <span class="text-danger"><?php echo form_error('timeline_date'); ?></span>
                                </div>
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('description'); ?></label>
                                    <textarea id="timelineedesc" name="timeline_desc" placeholder=""
                                        class="form-control"></textarea>
                                    <span class="text-danger"><?php echo form_error('description'); ?></span>
                                </div>

                                <div class="form-group">
                                    <label><?php echo $this->lang->line('attach_document'); ?></label>
                                    <div><input id="etimeline_doc_id" name="timeline_doc" placeholder="" type="file"
                                            class="filestyle form-control" data-height="40"
                                            value="<?php echo set_value('timeline_doc'); ?>" />
                                        <span class="text-danger"><?php echo form_error('timeline_doc'); ?></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label
                                        class="align-top"><?php echo $this->lang->line('visible_to_this_person'); ?></label>
                                    <input id="evisible_check" name="visible_check" value="yes" placeholder=""
                                        type="checkbox" />

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="pull-right">
                        <button type="submit" data-loading-text="<?php echo $this->lang->line('processing'); ?>"
                            id="edit_timelinebtn" class="btn btn-info pull-right"><i class="fa fa-check-circle"></i>
                            <?php echo $this->lang->line('save'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Edit Diagnosis -->
<div class="modal fade" id="edit_diagnosis" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('edit_diagnosis'); ?></h4>
            </div>
            <form id="form_editdiagnosis" accept-charset="utf-8" enctype="multipart/form-data" method="post"
                class="ptt10">
                <div class="modal-body pt0 pb0">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>
                                    <?php echo $this->lang->line('report_type'); ?></label><small class="req"> *</small>
                                <input type="text" name="report_type" class="form-control" id="ereporttype" />
                                <input type="hidden" value="" name="diagnosis_id" class="form-control" id="eid" />
                                <input type="hidden" value="" name="diagnosispatient_id" class="form-control"
                                    id="epatient_id" />
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>
                                    <?php echo $this->lang->line('report_date'); ?></label><small class="req"> *</small>
                                <input type="text" name="report_date" class="form-control date" id="ereportdate" />
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="align-top"><?php echo $this->lang->line('document'); ?></label> <input
                                    type="file" class="form-control filestyle" name="report_document"
                                    id="ereportdocument" />
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="align-top"><?php echo $this->lang->line("report_center_name"); ?></label>
                                <input type="text" class="form-control" name="report_center" id="ereportcenter" />
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('description'); ?></label>
                                <textarea name="description" class="form-control" id="edescription"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="pull-right">
                        <button type="submit" id="form_editdiagnosisbtn"
                            data-loading-text="<?php echo $this->lang->line('processing'); ?>"
                            class="btn btn-info"><?php echo $this->lang->line('save'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Prescription -->
<div class="modal fade" id="add_prescription" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog pup100" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close pupclose" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="edit_prescription_title">
                    <?php echo $this->lang->line('add_prescription'); ?></h4>
            </div>
            <form id="form_prescription" accept-charset="utf-8" enctype="multipart/form-data" method="post">
                <div class="pup-scroll-area">
                    <div class="modal-body pt0 pb0">

                    </div>
                    <!--./modal-body-->
                </div>
                <div class="box-footer sticky-footer">
                    <div class="pull-right">


                        <button type="submit" name="save_print" value="save_print"
                            data-loading-text="<?php echo $this->lang->line('processing'); ?>" class="btn btn-info"><i
                                class="fa fa-print"></i> <?php echo $this->lang->line('save_print'); ?>
                        </button>
                        <button type="submit" name="save" value="save"
                            data-loading-text="<?php echo $this->lang->line('processing'); ?>" class="btn btn-info"><i
                                class="fa fa-check-circle"></i> <?php echo $this->lang->line('save'); ?>
                        </button>


                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- -->
<div class="modal fade" id="viewModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('patient_details'); ?></h4>
            </div>
            <form id="formrevisit" accept-charset="utf-8" enctype="multipart/form-data" method="post" class="ptt10">
                <div class="modal-body pt0 ">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table mb0 table-striped table-bordered examples">
                                    <tr>
                                        <th width="15%"><?php echo $this->lang->line('patient_name'); ?></th>
                                        <td width="35%"><span id="patient_name"></span> (<span id='patients_id'></span>)
                                        </td>
                                        <th width="15%"><?php echo $this->lang->line('guardian_name'); ?></th>
                                        <td width="35%"><span id='guardian_name'></span></td>
                                    </tr>
                                    <tr>
                                        <th width="15%"><?php echo $this->lang->line('gender'); ?></th>
                                        <td width="35%"><span id='gen'></span></td>
                                        <th width="15%"><?php echo $this->lang->line('marital_status'); ?></th>
                                        <td width="35%"><span id="marital_status"></span></td>
                                    </tr>
                                    <tr>
                                        <th width="15%"><?php echo $this->lang->line('phone'); ?></th>
                                        <td width="35%"><span id="contact"></span></td>
                                        <th width="15%"><?php echo $this->lang->line('email'); ?></th>
                                        <td width="35%"><span id='email' style="text-transform: none"></span></td>
                                    </tr>
                                    <tr>
                                        <th width="15%"><?php echo $this->lang->line('address'); ?></th>
                                        <td width="35%"><span id='patient_address'></span></td>
                                        <th width="15%"><?php echo $this->lang->line('age'); ?></th>
                                        <td width="35%"><span id="age"></span></td>
                                    </tr>
                                    <tr>
                                        <th width="15%"><?php echo $this->lang->line('blood_group'); ?></th>
                                        <td width="35%"><span id="blood_group"></span></td>
                                        <th width="15%"><?php echo $this->lang->line('height'); ?></th>
                                        <td width="35%"><span id='height'></span></td>
                                    </tr>
                                    <tr>
                                        <th width="15%"><?php echo $this->lang->line('weight'); ?></th>
                                        <td width="35%"><span id="weight"></span></td>
                                        <th width="15%"><?php echo $this->lang->line('temperature'); ?></th>
                                        <td width="35%"><span id='temperature'></span></td>
                                    </tr>
                                    <tr>
                                        <th width="15%"><?php echo $this->lang->line('respiration'); ?></th>
                                        <td width="35%"><span id="respiration"></span></td>
                                        <th width="15%"><?php echo $this->lang->line('pulse'); ?></th>
                                        <td width="35%"><span id='pulse'></span></td>
                                    </tr>
                                    <tr>
                                        <th width="15%"><?php echo $this->lang->line('bp'); ?></th>
                                        <td width="35%"><span id='patient_bp'></span></td>
                                        <th width="15%"><?php echo $this->lang->line('symptoms'); ?></th>
                                        <td width="35%"><span id='symptoms'></span></td>
                                    </tr>
                                    <tr>
                                        <th width="15%">SPO2</th>
                                        <td width="35%"><span id="spo2"></span></td>
                                        <th width="15%"><?php echo $this->lang->line('admission_date'); ?></th>
                                        <td width="35%"><span id="admission_date"></span></td>
                                    </tr>
                                    <tr>
                                        <th width="15%"><?php echo $this->lang->line('case'); ?></th>
                                        <td width="35%"><span id='case'></span></td>
                                        <th width="15%"><?php echo $this->lang->line('old_patient'); ?></th>
                                        <td width="35%"><span id='old_patient'></span></td>
                                    </tr>
                                    <tr>
                                        <th width="15%"><?php echo $this->lang->line('casualty'); ?></th>
                                        <td width="35%"><span id="casualty"></span></td>
                                        <th width="15%"><?php echo $this->lang->line('reference'); ?></th>
                                        <td width="35%"><span id="refference"></span></td>
                                    </tr>
                                    <tr>
                                        <th width="15%"><?php echo $this->lang->line('tpa'); ?></th>
                                        <td width="35%"><span id="organisation"></span></td>
                                        <th width="15%"><?php echo $this->lang->line('bed_group'); ?></th>
                                        <td width="35%"><span id="bed_group"></span></td>
                                    </tr>
                                    <tr>
                                        <th width="15%"><?php echo $this->lang->line('consultant_doctor'); ?></th>
                                        <td width="35%"><span id='doc'></span></td>
                                        <th width="15%"><?php echo $this->lang->line('bed_number'); ?></th>
                                        <td width="35%"><span id='bed_name'></span></td>
                                    </tr>

                                </table>
                            </div>
                            <div id="field_data">
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>
</div>

<!-- -->
<div class="modal fade" id="prescriptionview" role="dialog" aria-labelledby="follow_up">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close sss" data-dismiss="modal">&times;</button>
                <div class="modalicon">
                    <div id='edit_deleteprescription'>
                    </div>
                </div>
                <h4 class="modal-title"><?php echo $this->lang->line('prescription'); ?></h4>
            </div>
            <div class="modal-body pt0 pb0" id="getdetails_prescription"></div>
        </div>
    </div>
</div>

<!-- -->
<div class="modal fade" id="myPaymentModal" role="dialog" aria-labelledby="myModalLabel">
    <form id="add_payment" accept-charset="utf-8" method="post" class="ptt10">
        <div class="modal-dialog modal-mid" role="document">
            <div class="modal-content modal-media-content">
                <div class="modal-header modal-media-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo $this->lang->line('add_payment'); ?></h4>
                </div>
                <!-- <div class="scroll-area"> -->
                <div class="modal-body pb0 ptt10">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('date'); ?></label><small class="req"> *</small>
                                <input type="text" name="payment_date" id="date" value="<?= date('d/m/Y'); ?>" autocomplete="off" readonly class="form-control">
                                <span class="text-danger"><?php echo form_error('apply_charge'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('amount') . " (" . $currency_symbol . ")"; ?></label><small
                                    class="req"> *</small>
                                <input type="text" name="amount" id="amount" class="form-control"
                                    value="<?php echo number_format($total - $total_payment, 2); ?>" readonly>
                                <input type="hidden" name="net_amount" class="form-control"
                                    value="<?php echo number_format($total - $total_payment, 2); ?>">
                                <input type="hidden" name="case_reference_id" id="case_reference_id"
                                    class="form-control" value="<?php echo $result['case_reference_id']; ?>">
                                <input type="hidden" name="patient_id" class="form-control"
                                    value="<?php echo $result['id']; ?>">
                                <input type="hidden" name="ipdid" value="<?php echo $ipdid ?>">
                                <input type="hidden" name="total" id="total" class="form-control">
                                <span class="text-danger"><?php echo form_error('amount'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('payment_mode'); ?></label>
                                <select class="form-control payment_mode" name="payment_mode">
                                    <?php foreach ($payment_mode as $key => $value) {
                                         if($key != 'Paylater') { 
                                    ?>
                                        <option value="<?php echo $key ?>" <?php
                                                                            if ($key == 'cash') {
                                                                                echo "selected";
                                                                            }
                                                                            ?>><?php echo $value ?></option>
                                    <?php }
                                    } ?>
                                </select>
                                <span class="text-danger"><?php echo form_error('apply_charge'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row cheque_div" style="display: none;">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('cheque_no'); ?></label><small class="req">
                                    *</small>
                                <input type="text" name="cheque_no" id="cheque_no" class="form-control">
                                <span class="text-danger"><?php echo form_error('cheque_no'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('cheque_date'); ?></label> <small class="req">
                                    *</small>
                                <input type="text" name="cheque_date" id="cheque_date" class="form-control date">
                                <span class="text-danger"><?php echo form_error('cheque_date'); ?></span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('attach_document'); ?></label>
                                <input type="file" id="payment_file" class="filestyle form-control" name="document">
                                <span class="text-danger"><?php echo form_error('document'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('note'); ?></label>
                                <textarea name="note" id="note" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="add_paymentbtn"
                        data-loading-text="<?php echo $this->lang->line('processing'); ?>"
                        class="btn btn-info pull-right"><i class="fa fa-check-circle"></i>
                        <?php echo $this->lang->line('save'); ?></button>
                </div>
                <!-- </div> -->
            </div>
        </div>

    </form>
</div>
<!-- -->

<!-- -->
<div class="modal fade" id="myMedicationModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <?php if ($this->rbac->hasPrivilege('ipd_medication', 'can_add')) { ?>
                    <h4 class="modal-title"><?php echo $this->lang->line("add_medication_dose"); ?></h4>
                <?php } ?>
            </div>
            <form id="add_medicationdose" accept-charset="utf-8" method="post" class="ptt10">
                <div class="scroll-area">
                    <div class="modal-body pt0 pb0">
                        <div class="row">
                            <input type="hidden" name="ipdid" id="mipdid" value="<?php echo $ipdid ?>">
                            <input type="hidden" name="medicine_name_id" id="mpharmacy_id" value="">
                            <input type="hidden" name="date" id="mdate" value="">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('date'); ?></label><small class="req"> *</small>
                                    <input type="text" name="date" id="add_dose_date" class="form-control date">
                                    <span class="text-danger"><?php echo form_error('date'); ?></span>
                                    <input type="hidden" name="ipdid" value="<?php echo $ipdid ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd"><?php echo $this->lang->line("time"); ?></label>
                                    <div class="bootstrap-timepicker">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" name="time" class="form-control timepicker"
                                                    id="add_dose_time" value="<?php echo set_value('time'); ?>">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-clock-o"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-danger"><?php echo form_error('time'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("medicine_category"); ?></label> <small
                                        class="req"> *</small>
                                    <select class="form-control medicine_category_medication select2" style="width:100%"
                                        id="add_dose_medicine_category" name='medicine_category_id'>
                                        <option value="<?php echo set_value('medicine_category_id'); ?>">
                                            <?php echo $this->lang->line('select'); ?>
                                        </option>
                                        <?php foreach ($medicineCategory as $dkey => $dvalue) {
                                        ?>
                                            <option value="<?php echo $dvalue["id"]; ?>">
                                                <?php echo $dvalue["medicine_category"] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('medicine_category_id'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("medicine_name"); ?></label> <small class="req">
                                        *</small>
                                    <select class="form-control select2 medicine_name_medication" style="width:100%"
                                        id="add_dose_medicine_id" name='medicine_name_id'>
                                        <option value=""><?php echo $this->lang->line('select'); ?>
                                        </option>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('medicine_name_id'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("dosage"); ?></label> <small class="req">
                                        *</small>
                                    <select class="form-control select2 dosage_medication" style="width:100%"
                                        id="mdosage" onchange="" name='dosage'>
                                        <option value=""><?php echo $this->lang->line('select'); ?>
                                        </option>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('dosage'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("remarks"); ?></label>
                                    <textarea name="remark" id="remark" class="form-control"></textarea>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" id="add_medicationdosebtn"
                        data-loading-text="<?php echo $this->lang->line('processing'); ?>"
                        class="btn btn-info pull-right"><i class="fa fa-check-circle"></i>
                        <?php echo $this->lang->line('save'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- -->


<div class="modal fade" id="myaddMedicationModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line("add_medication_dose"); ?></h4>
            </div>
            <form id="add_medication" accept-charset="utf-8" method="post" class="ptt10">
                <div class="scroll-area">
                    <div class="modal-body pt0 pb0">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('date'); ?></label><small class="req"> *</small>
                                    <input type="text" name="date" id="date" class="form-control date">
                                    <span class="text-danger"><?php echo form_error('date'); ?></span>
                                    <input type="hidden" name="ipdid" value="<?php echo $ipdid ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pwd"><?php echo $this->lang->line("time"); ?></label>
                                    <div class="bootstrap-timepicker">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" name="time" class="form-control timepicker"
                                                    id="mtime" value="<?php echo set_value('time'); ?>">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-clock-o"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-danger"><?php echo form_error('time'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("medicine_category"); ?></label> <small
                                        class="req"> *</small>
                                    <select class="form-control medicine_category_medication select2" style="width:100%"
                                        id="mmedicine_category_id" name='medicine_category_id'>
                                        <option value="<?php echo set_value('medicine_category_id'); ?>">
                                            <?php echo $this->lang->line('select'); ?>
                                        </option>
                                        <?php foreach ($medicineCategory as $dkey => $dvalue) {
                                        ?>
                                            <option value="<?php echo $dvalue["id"]; ?>">
                                                <?php echo $dvalue["medicine_category"] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('medicine_category_id'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("medicine_name"); ?></label> <small class="req">
                                        *</small>
                                    <select class="form-control select2 medicine_name_medication" style="width:100%"
                                        id="mmedicine_id" name='medicine_name_id'>
                                        <option value=""><?php echo $this->lang->line('select'); ?>
                                        </option>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('medicine_name_id'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("dosage"); ?></label> <small class="req">
                                        *</small>
                                    <select class="form-control select2 dosage_medication" style="width:100%"
                                        id="dosage" onchange="get_dosagename(this.value)" name='dosage'>
                                        <option value=""><?php echo $this->lang->line('select'); ?>
                                        </option>
                                    </select>
                                    <span class="text-danger"><?php echo form_error('dosage'); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("remarks"); ?></label>
                                    <textarea name="remark" id="remark" class="form-control"></textarea>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" id="add_medicationbtn"
                        data-loading-text="<?php echo $this->lang->line('processing'); ?>"
                        class="btn btn-info pull-right"><i class="fa fa-check-circle"></i>
                        <?php echo $this->lang->line('save'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- -->

<!-- -->
<div class="modal fade" id="myMedicationDoseModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="modalicon">
                    <div id='edit_delete'></div>
                </div>
                <h4 class="modal-title"><?php echo $this->lang->line('edit_medication_dose'); ?></h4>
            </div>

            <form id="update_medication" accept-charset="utf-8" method="post" class="ptt10">
                <div class="modal-body pt0 pb0">
                    <input type="hidden" name="medication_id" class="" id="medication_id" value="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo $this->lang->line('date'); ?></label><small class="req"> *</small>
                                <input type="text" name="date" id="date_edit_medication" class="form-control date">
                                <span class="text-danger"><?php echo form_error('date'); ?></span>
                                <input type="hidden" name="ipdid" value="<?php echo $ipdid ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pwd"><?php echo $this->lang->line("time"); ?></label>
                                <div class="bootstrap-timepicker">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" name="time" class="form-control timepicker"
                                                id="dosagetime" value="<?php echo set_value('time'); ?>">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <span class="text-danger"><?php echo form_error('time'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo $this->lang->line("medicine_category"); ?></label> <small class="req">
                                    *</small>
                                <select class="form-control medicine_category_medication select2" style="width:100%"
                                    id="mmedicine_category_edit_id" name='medicine_category_id'>
                                    <option value="<?php echo set_value('medicine_category_id'); ?>">
                                        <?php echo $this->lang->line('select'); ?>
                                    </option>
                                    <?php foreach ($medicineCategory as $dkey => $dvalue) {
                                    ?>
                                        <option value="<?php echo $dvalue["id"]; ?>">
                                            <?php echo $dvalue["medicine_category"] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <span class="text-danger"><?php echo form_error('medicine_category_id'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo $this->lang->line("medicine_name"); ?></label> <small class="req">
                                    *</small>
                                <select class="form-control select2 medicine_name_medication" style="width:100%"
                                    id="mmedicine_edit_id" name='medicine_name_id'>
                                    <option value=""><?php echo $this->lang->line('select'); ?>
                                    </option>
                                </select>
                                <span class="text-danger"><?php echo form_error('medicine_name_id'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><?php echo $this->lang->line("dosage"); ?></label> <small class="req"> *</small>
                                <select class="form-control  select2" style="width:100%" id="medicine_dose_edit_id"
                                    name='dosage_id'>
                                    <option value="<?php echo set_value('dosage_id'); ?>">
                                        <?php echo $this->lang->line('select'); ?>
                                    </option>
                                    <?php foreach ($dosage as $key => $value) { ?>
                                        <option value="<?php echo $value["id"]; ?>">
                                            <?php echo $value["dosage"] . " " . $value['unit']; ?>
                                        </option>

                                    <?php } ?>
                                </select>
                                <span class="text-danger"><?php echo form_error('dosage_id'); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line("remarks"); ?></label>
                                <textarea name="remark" id="medicine_dosage_remark" class="form-control"></textarea>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" id="update_medicationbtn"
                        data-loading-text="<?php echo $this->lang->line('processing'); ?>"
                        class="btn btn-info pull-right"><i class="fa fa-check-circle"></i>
                        <?php echo $this->lang->line('save'); ?></button>
                </div>

            </form>
        </div>
    </div>
</div>
<!-- -->

<!--Add Charges-->
<div class="modal fade" id="myChargesModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog pup100">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close pupclose" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('add_charges'); ?></h4>
            </div>
            <form id="add_charges" accept-charset="utf-8" method="post" class="ptt10">
                <div class="pup-scroll-area">
                    <div class="modal-body pb0 pt0">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <input type="hidden" name="patient_id" value="<?php echo $result["patient_id"] ?>">
                                <input type="hidden" name="ipdid" value="<?php echo $ipdid ?>">
                                <input type="hidden" name="patient_charge_id" id="editpatient_charge_id" value="0">
                                <input type="hidden" name="organisation_id" id="organisation_id"
                                    value="<?php echo $result["organisation_id"] ?>">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('charge_type'); ?></label><small
                                                class="req"> *</small>
                                            <select name="charge_type" id="add_charge_type" style="width: 100%"
                                                class="form-control charge_type select2">
                                                <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                <?php foreach ($charge_type as $key => $value) {
                                                ?>
                                                    <option value="<?php echo $value->id; ?>">
                                                        <?php echo $value->charge_type; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                            <span class="text-danger"><?php echo form_error('charge_type'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('charge_category'); ?></label><small
                                                class="req"> *</small>
                                            <select name="charge_category" id="charge_category" style="width: 100%"
                                                class="form-control charge_category select2">
                                                <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            </select>
                                            <span
                                                class="text-danger"><?php echo form_error('charge_category'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('charge_name'); ?></label><small
                                                class="req"> *</small>
                                            <select name="charge_id" id="charge_id" style="width: 100%"
                                                class="form-control charge select2">
                                                <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            </select>
                                            <span class="text-danger"><?php echo form_error('code'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('standard_charge') . " (" . $currency_symbol . ")" ?></label>
                                            <input type="text" readonly name="standard_charge" id="standard_charge"
                                                class="form-control"
                                                value="<?php echo set_value('standard_charge'); ?>">
                                            <span
                                                class="text-danger"><?php echo form_error('standard_charge'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('tpa_charge') . " (" . $currency_symbol . ")" ?></label>
                                            <input type="text" readonly name="schedule_charge" id="schedule_charge"
                                                placeholder="" class="form-control" value="">
                                            <span
                                                class="text-danger"><?php echo form_error('schedule_charge'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('qty'); ?></label><small class="req">
                                                *</small>
                                            <input type="text" name="qty" id="qty" class="form-control"
                                                onkeyup="this.value=this.value.replace(/[^0-9]/g,'')">
                                            <span class="text-danger"><?php echo form_error('qty'); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="divider"></div>
                                <div class="row">
                                    <div class="col-sm-5 mb10">
                                        <table class="printablea4">
                                            <tr>
                                                <th width="40%">
                                                    <?php echo $this->lang->line('total') . " (" . $currency_symbol . ")"; ?>
                                                </th>
                                                <td width="60%" colspan="2" class="text-right ipdbilltable">
                                                    <input type="text" placeholder="Total" value="0" name="apply_charge"
                                                        id="apply_charge" style="width: 30%; float: right"
                                                        class="form-control total" readonly />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('tax') . " (" . $currency_symbol . ")"; ?>
                                                </th>
                                                <td class="text-right ipdbilltable">
                                                    <h4 style="float: right;font-size: 12px; padding-left: 5px;"> %</h4>
                                                    <input type="text"
                                                        placeholder="<?php echo $this->lang->line('tax'); ?>"
                                                        name="charge_tax" id="charge_tax"
                                                        class="form-control charge_tax" readonly
                                                        style="width: 70%; float: right;font-size: 12px;" />
                                                </td>
                                                <td class="text-right ipdbilltable">
                                                    <input type="text" placeholder="Tax" name="tax" value="0" id="ipd_tax"
                                                        style="width: 50%; float: right" class="form-control tax"
                                                        readonly />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('net_amount') . " (" . $currency_symbol . ")"; ?>
                                                </th>
                                                <td colspan="2" class="text-right ipdbilltable">
                                                    <input type="text" placeholder="Net Amount" value="0" name="amount"
                                                        id="final_amount" style="width: 30%; float: right"
                                                        class="form-control net_amount" readonly />
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('charge_note'); ?></label>
                                                    <textarea name="note" id="edit_note" rows="3"
                                                        class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--./col-sm-6-->

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('date'); ?></label> <small class="req">
                                                *</small>
                                            <input id="charge_date" name="date" placeholder="" type="text"
                                                class="form-control" />
                                        </div>
                                        <button type="submit"
                                            data-loading-text="<?php echo $this->lang->line('processing') ?>"
                                            name="charge_data" value="add" class="btn btn-info pull-right"><i
                                                class="fa fa-check-circle"></i>
                                            <?php echo $this->lang->line('add') ?></button>
                                    </div>

                                </div>
                                <!--./row-->

                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12" class="table-responsive">
                                <table class="table table-striped table-bordered ">
                                    <tr>
                                        <th><?php echo $this->lang->line('date') ?></th>
                                        <th><?php echo $this->lang->line('charge_type') ?></th>
                                        <th><?php echo $this->lang->line('charge_category') ?></th>
                                        <th><?php echo $this->lang->line('charge_name') ?></th>
                                        <th><?php echo $this->lang->line('standard_charge') . ' (' . $currency_symbol . ')'; ?>
                                        </th>
                                        <th><?php echo $this->lang->line('tpa_charge') . ' (' . $currency_symbol . ')'; ?>
                                        </th>
                                        <th><?php echo $this->lang->line('qty') ?></th>
                                        <th><?php echo $this->lang->line('total') . ' (' . $currency_symbol . ')'; ?>
                                        </th>
                                        <th><?php echo $this->lang->line('tax') . ' (' . $currency_symbol . ')'; ?></th>
                                        <th><?php echo $this->lang->line('net_amount') . ' (' . $currency_symbol . ')'; ?>
                                        </th>
                                        <th class="text-right"><?php echo $this->lang->line('action') ?></th>
                                    </tr>
                                    <tbody id="preview_charges">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--./scroll-area-->
                <div class="modal-footer sticky-footer">
                    <div class="pull-right">


                        <button type="submit" data-loading-text="<?php echo $this->lang->line('processing') ?>"
                            value="save" name="charge_data" class="btn btn-info"><i class="fa fa-check-circle"></i>
                            <?php echo $this->lang->line('save') ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="myChargeseditModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('edit_charges'); ?></h4>
            </div>
            <form id="edit_charges" accept-charset="utf-8" method="post" class="ptt10">
                <div class="scroll-area">
                    <div class="modal-body pb0 pt0">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <input type="hidden" name="patient_id" value="<?php echo $result["patient_id"] ?>">
                                <!-- <input type="hidden" name="org_id" id="org_id" value="0"> -->
                                <input type="hidden" name="ipdid" value="<?php echo $ipdid ?>">
                                <input type="hidden" name="patient_charge_id" id="patient_charge_id" value="0">
                                <input type="hidden" name="organisation_id" id="organisation_id"
                                    value="<?php echo $result["organisation_id"] ?>">
                                <div class="row">

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('charge_type'); ?></label><small
                                                class="req"> *</small>

                                            <select name="charge_type" id="edit_charge_type"
                                                class="form-control charge_type select2">
                                                <option value=""><?php echo $this->lang->line('select'); ?></option>
                                                <?php foreach ($charge_type as $key => $value) {
                                                ?>
                                                    <option value="<?php echo $value->id; ?>">
                                                        <?php echo $value->charge_type; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                            <span class="text-danger"><?php echo form_error('charge_type'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('charge_category'); ?></label><small
                                                class="req"> *</small>
                                            <select name="charge_category" id="editcharge_category" style="width: 100%"
                                                class="form-control charge_category select2">
                                                <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            </select>
                                            <span
                                                class="text-danger"><?php echo form_error('charge_category'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('charge_name'); ?></label><small
                                                class="req"> *</small>
                                            <select name="charge_id" id="editcharge_id" style="width: 100%"
                                                class="form-control charge select2">
                                                <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            </select>
                                            <span class="text-danger"><?php echo form_error('code'); ?></span>
                                        </div>
                                    </div>


                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('standard_charge') . " (" . $currency_symbol . ")" ?></label>
                                            <input type="text" readonly name="standard_charge" id="editstandard_charge"
                                                class="form-control"
                                                value="<?php echo set_value('standard_charge'); ?>">
                                            <span
                                                class="text-danger"><?php echo form_error('standard_charge'); ?></span>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('tpa_charge') . " (" . $currency_symbol . ")" ?></label>
                                            <input type="text" readonly name="schedule_charge" id="editschedule_charge"
                                                placeholder="" class="form-control" value="">
                                            <span
                                                class="text-danger"><?php echo form_error('schedule_charge'); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('qty'); ?></label><small class="req">
                                                *</small>
                                            <input type="text" name="qty" id="editqty" class="form-control">
                                            <span class="text-danger"><?php echo form_error('qty'); ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="divider"></div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('date'); ?></label> <small class="req">
                                                *</small>
                                            <input id="editcharge_date" name="date" placeholder="" type="text"
                                                class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="row">

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('charge_note'); ?></label>

                                                    <textarea name="note" id="enote" rows="3"
                                                        class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--./col-sm-6-->


                                    <div class="col-sm-6 mb10">

                                        <table class="printablea4">


                                            <tr>
                                                <th width="40%">
                                                    <?php echo $this->lang->line('total') . " (" . $currency_symbol . ")"; ?>
                                                </th>
                                                <td width="60%" colspan="2" class="text-right ipdbilltable">
                                                    <input type="text" placeholder="Total" value="0" name="apply_charge"
                                                        id="editapply_charge" style="width: 30%; float: right"
                                                        class="form-control total" readonly />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('tax') . " (" . $currency_symbol . ")"; ?>
                                                </th>
                                                <td class="text-right ipdbilltable">
                                                    <h4 style="float: right;font-size: 12px; padding-left: 5px;"> %</h4>
                                                    <input type="text"
                                                        placeholder="<?php echo $this->lang->line('tax'); ?>"
                                                        name="charge_tax" id="editcharge_tax"
                                                        class="form-control charge_tax" readonly
                                                        style="width: 70%; float: right;font-size: 12px;" />
                                                </td>

                                                <td class="text-right ipdbilltable">
                                                    <input type="text" placeholder="Tax" name="tax" value="0"
                                                        id="edittax" style="width: 50%; float: right"
                                                        class="form-control tax" readonly />

                                                </td>
                                            </tr>
                                            <tr>
                                                <th><?php echo $this->lang->line('net_amount') . " (" . $currency_symbol . ")"; ?>
                                                </th>
                                                <td colspan="2" class="text-right ipdbilltable">
                                                    <input type="text" placeholder="Net Amount" value="0" name="amount"
                                                        id="editfinal_amount" style="width: 30%; float: right"
                                                        class="form-control net_amount" readonly />
                                                </td>
                                            </tr>
                                        </table>


                                    </div>

                                </div>
                                <!--./row-->
                            </div>

                        </div>
                    </div>
                </div>
                <!--./scroll-area-->
                <div class="box-footer">


                    <button type="submit" data-loading-text="<?php echo $this->lang->line('processing') ?>"
                        name="charge_data" value="add" class="btn btn-info pull-right"><i
                            class="fa fa-check-circle"></i> <?php echo $this->lang->line('save') ?></button>
                </div>

            </form>

        </div>
    </div>
</div>
<!-- -->
<div class="modal fade" id="myModaledit" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog pup100 modalfullmobile" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="row">
                    <div class="col-sm-6 col-xs-8">
                        <div class="form-group15">
                            <div>
                                <select onchange="get_ePatientDetails(this.value)" disabled class="form-control select2"
                                    style="width:100%" id="evaddpatient_id" name=''>
                                    <option value=""><?php echo $this->lang->line('select'); ?></option>
                                    <?php foreach ($patients as $dkey => $dvalue) { ?>
                                        <option value="<?php echo $dvalue["id"]; ?>" <?php
                                                                                        if ((isset($patient_select)) && ($patient_select == $dvalue["id"])) {
                                                                                            echo "selected";
                                                                                        }
                                                                                        ?>>
                                            <?php echo $dvalue["patient_name"] . " (" . $dvalue["id"] . ")" ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <span class="text-danger"><?php echo form_error('refference'); ?></span>
                        </div>
                    </div>
                    <!--./col-sm-6 col-xs-8 -->
                </div>
                <!--./row-->
            </div>
            <form id="formeditrecord" accept-charset="utf-8" enctype="multipart/form-data" method="post">
                <div class="pup-scroll-area">
                    <div class="modal-body pt0 pb0">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="row row-eq">
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <div class="ptt10">
                                            <div id="evajax_load"></div>
                                            <div class="row" id="evpatientDetails" style="display:none">
                                                <div class="col-md-9 col-sm-9 col-xs-9">
                                                    <ul class="singlelist">
                                                        <li class="singlelist24bold">
                                                            <span id="evlistname"></span>
                                                        </li>
                                                        <li>
                                                            <i class="fas fa-user-secret" data-toggle="tooltip"
                                                                data-placement="top"
                                                                title="<?php echo $this->lang->line('guardian'); ?>"></i>
                                                            <span id="evguardian"></span>
                                                        </li>
                                                    </ul>
                                                    <ul class="multilinelist">
                                                        <li>
                                                            <i class="fas fa-venus-mars" data-toggle="tooltip"
                                                                data-placement="top"
                                                                title="<?php echo $this->lang->line('gender'); ?>"></i>
                                                            <span id="evgenders"></span>
                                                        </li>
                                                        <li>
                                                            <i class="fas fa-tint" data-toggle="tooltip"
                                                                data-placement="top"
                                                                title="<?php echo $this->lang->line('blood_group'); ?>"></i>
                                                            <span id="evblood_group"></span>
                                                        </li>
                                                        <li>
                                                            <i class="fas fa-ring" data-toggle="tooltip"
                                                                data-placement="top"
                                                                title="<?php echo $this->lang->line('marital_status'); ?>"></i>
                                                            <span id="evmarital_status"></span>
                                                        </li>
                                                    </ul>
                                                    <ul class="singlelist">
                                                        <li>
                                                            <i class="fas fa-hourglass-half" data-toggle="tooltip"
                                                                data-placement="top"
                                                                title="<?php echo $this->lang->line('age'); ?>"></i>
                                                            <span id="evage"></span>
                                                        </li>
                                                        <li>
                                                            <i class="fa fa-phone-square" data-toggle="tooltip"
                                                                data-placement="top"
                                                                title="<?php echo $this->lang->line('phone'); ?>"></i>
                                                            <span id="evlistnumber"></span>
                                                        </li>
                                                        <li>
                                                            <i class="fa fa-envelope" data-toggle="tooltip"
                                                                data-placement="top"
                                                                title="<?php echo $this->lang->line('email'); ?>"></i>
                                                            <span id="evemail"></span>
                                                        </li>
                                                        <li>
                                                            <i class="fas fa-street-view" data-toggle="tooltip"
                                                                data-placement="top"
                                                                title="<?php echo $this->lang->line('address'); ?>"></i>
                                                            <span id="evaddress"></span>
                                                        </li>
                                                        <li>
                                                            <b><?php echo $this->lang->line('any_known_allergies') ?>
                                                            </b>
                                                            <span id="evallergies"></span>
                                                        </li>
                                                        <li>
                                                            <b><?php echo $this->lang->line('remarks') ?> </b>
                                                            <span id="evnote"></span>
                                                        </li>
                                                        <li>
                                                            <b><?php echo $this->lang->line('tpa_id') ?> </b>
                                                            <span id="etpa_id"></span>
                                                        </li>
                                                        <li>
                                                            <b><?php echo $this->lang->line('tpa_validity') ?> </b>
                                                            <span id="etpa_validity"></span>
                                                        </li>
                                                        <li>
                                                            <b><?php echo $this->lang->line('national_identification_number') ?>
                                                            </b>
                                                            <span id="eidentification_number"></span>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-3 col-sm-3 col-xs-3">
                                                    <div class="pull-right">
                                                        <?php
                                                        $file = "uploads/patient_images/no_image.png";
                                                        ?>
                                                        <img class="profile-user-img img-responsive"
                                                            src="<?php echo base_url() . $file . img_time() ?>"
                                                            id="evimage" alt="User profile picture">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="dividerhr"></div>
                                                </div>
                                                <!--./col-md-12-->
                                                <div class="col-sm-2 col-xs-4">
                                                    <div class="form-group">
                                                        <label
                                                            for="pwd"><?php echo $this->lang->line('height'); ?></label>
                                                        <input name="height" id="evheight" type="text"
                                                            class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-2 col-xs-4">
                                                    <div class="form-group">
                                                        <label
                                                            for="pwd"><?php echo $this->lang->line('weight'); ?></label>
                                                        <input name="weight" id="evweight" type="text"
                                                            class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-2 col-xs-4">
                                                    <div class="form-group">
                                                        <label for="pwd"><?php echo $this->lang->line('bp'); ?></label>
                                                        <input name="bp" id="evbp" type="text" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-2 col-xs-4">
                                                    <div class="form-group">
                                                        <label
                                                            for="pwd"><?php echo $this->lang->line('pulse'); ?></label>
                                                        <input name="pulse" id="evpulse" type="text"
                                                            class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-2 col-xs-4">
                                                    <div class="form-group">
                                                        <label
                                                            for="pwd"><?php echo $this->lang->line('temperature'); ?></label>
                                                        <input name="temperature" id="evtemperature" type="text"
                                                            class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-2 col-xs-4">
                                                    <div class="form-group">
                                                        <label
                                                            for="pwd"><?php echo $this->lang->line('respiration'); ?></label>
                                                        <input name="respiration" id="evrespiration" type="text"
                                                            class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-3 col-xs-4">
                                                    <div class="form-group">
                                                        <label for="exampleInputFile">
                                                            <?php echo $this->lang->line('symptoms_type'); ?></label>
                                                        <div><select name='symptoms_type' id="act"
                                                                class="form-control select2 act" style="width:100%">
                                                                <option value="">
                                                                    <?php echo $this->lang->line('select'); ?></option>
                                                                <?php foreach ($symptomsresulttype as $dkey => $dvalue) {
                                                                ?>
                                                                    <option value="<?php echo $dvalue["id"]; ?>">
                                                                        <?php echo $dvalue["symptoms_type"]; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <span
                                                            class="text-danger"><?php echo form_error('symptoms_type'); ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="exampleInputFile">
                                                        <?php echo $this->lang->line('symptoms_title'); ?></label>
                                                    <div id="dd" class="wrapper-dropdown-3">
                                                        <input class="form-control filterinput" type="text">
                                                        <ul class="dropdown scroll150 section_ul">
                                                            <li><label
                                                                    class="checkbox"><?php echo $this->lang->line('select'); ?></label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label
                                                            for="email"><?php echo $this->lang->line('symptoms_description'); ?></label>
                                                        <textarea row="3" name="symptoms" id="symptoms_description"
                                                            class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label
                                                            for="pwd"><?php echo $this->lang->line('note'); ?></label>
                                                        <textarea name="note" id='evnoteipd' rows="3"
                                                            class="form-control"><?php echo set_value('note'); ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="" id="customfield">

                                                </div>
                                            </div>
                                            <input name="patient_id" id="evpatients_id" type="hidden"
                                                class="form-control" value="<?php echo set_value('id'); ?>" />
                                            <input name="otid" id="otid" type="hidden" class="form-control"
                                                value="<?php echo set_value('id'); ?>" />
                                            <input type="hidden" id="updateid" name="updateid">
                                            <input type="hidden" id="ipdid_edit" name="ipdid">
                                            <input type="hidden" id="previous_bed_id" name="previous_bed_id">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-eq ptt10">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('admission_date'); ?><small
                                                            class="req"> *</small> </label>
                                                    <input id="edit_admission_date" name="appointment_date"
                                                        placeholder="" type="text" class="form-control datetime" />
                                                    <span
                                                        class="text-danger"><?php echo form_error('appointment_date'); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('case'); ?></label>
                                                    <div><input class="form-control" type='text' id="patient_case"
                                                            name='case_type' />
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('case'); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('casualty'); ?></label>
                                                    <div>
                                                        <select name="casualty" id="patient_casualty"
                                                            class="form-control">
                                                            <option value="<?php echo $this->lang->line('yes') ?>">
                                                                <?php echo $this->lang->line('yes') ?></option>
                                                            <option value="<?php echo $this->lang->line('no') ?>"
                                                                selected><?php echo $this->lang->line('no') ?></option>
                                                        </select>
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('case'); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="exampleInputFile">
                                                        <?php echo $this->lang->line('old_patient'); ?></label>
                                                    <div>
                                                        <select name="old_patient" id="old" class="form-control">
                                                            <option value="<?php echo $this->lang->line('yes') ?>">
                                                                <?php echo $this->lang->line('yes') ?></option>
                                                            <option value="<?php echo $this->lang->line('no') ?>">
                                                                <?php echo $this->lang->line('no') ?></option>
                                                        </select>
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('case'); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label><?php echo $this->lang->line('credit_limit') . " (" . $currency_symbol . ")"; ?></label>
                                                    <input type="text" id="credits_limits"
                                                        value="<?php echo set_value('credit_limit'); ?>"
                                                        name="credit_limit" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="exampleInputFile">
                                                        <?php echo $this->lang->line('tpa'); ?></label>
                                                    <div><select class="form-control" name='organisation'
                                                            id="edit_organisations">
                                                            <option value=""><?php echo $this->lang->line('select'); ?>
                                                            </option>
                                                            <?php foreach ($organisation as $orgkey => $orgvalue) {
                                                            ?>
                                                                <option value="<?php echo $orgvalue["id"]; ?>">
                                                                    <?php echo $orgvalue["organisation_name"] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <span
                                                        class="text-danger"><?php echo form_error('organisation'); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="exampleInputFile">
                                                        <?php echo $this->lang->line('reference'); ?></label>
                                                    <div><input class="form-control" type='text' name='refference'
                                                            id="patient_refference" />
                                                    </div>
                                                    <span
                                                        class="text-danger"><?php echo form_error('refference'); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="exampleInputFile">
                                                        <?php echo $this->lang->line('consultant_doctor'); ?> <small
                                                            class="req"> *</small> </label>
                                                    <div>
                                                        <select class="form-control select2" style="width: 100%;" <?php
                                                                                                                    if ($disable_option == true) {
                                                                                                                        echo "disabled";
                                                                                                                    }
                                                                                                                    ?>
                                                            name='cons_doctor' id="patient_consultant">
                                                            <option value=""><?php echo $this->lang->line('select') ?>
                                                            </option>
                                                            <?php foreach ($doctors as $dkey => $dvalue) {
                                                            ?>
                                                                <option value="<?php echo $dvalue["id"]; ?>" <?php
                                                                                                                if ((isset($doctor_select)) && ($doctor_select == $dvalue["id"])) {
                                                                                                                    echo "selected";
                                                                                                                }
                                                                                                                ?>>
                                                                    <?php echo composeStaffNameByString($dvalue["name"], $dvalue["surname"], $dvalue["employee_id"]); ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                        <?php if ($disable_option == true) { ?>
                                                            <input type="hidden" name="cons_doctor"
                                                                value="<?php echo $doctor_select ?>">
                                                        <?php } ?>
                                                    </div>
                                                    <span
                                                        class="text-danger"><?php echo form_error('cons_doctor'); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="exampleInputFile">
                                                        <?php echo $this->lang->line('bed_group'); ?></label>
                                                    <div>
                                                        <select class="form-control" name='bed_group_id'
                                                            id='ebed_group_id' onchange="getBed(this.value, '', 'yes')">
                                                            <option value=""><?php echo $this->lang->line('select'); ?>
                                                            </option>
                                                            <?php foreach ($bedgroup_list as $key => $bedgroup) {
                                                            ?>
                                                                <option value="<?php echo $bedgroup["id"] ?>">
                                                                    <?php echo $bedgroup["name"] . " - " . $bedgroup["floor_name"] ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="exampleInputFile">
                                                        <?php echo $this->lang->line('bed_no'); ?></label><small
                                                        class="req"> *</small>
                                                    <div><select class="form-control select2" style="width:100%"
                                                            name='bed_no' id='ebed_nos'>
                                                            <option value=""><?php echo $this->lang->line('select'); ?>
                                                            </option>

                                                        </select>
                                                    </div>
                                                    <span class="text-danger"><?php echo form_error('bed_no'); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--./row-->
                                    </div>
                                    <!--./col-md-4-->
                                </div>
                                <!--./row-->
                            </div>
                            <!--./col-md-12-->
                        </div>
                        <!--./row-->
                    </div>
                </div>
                <div class="modal-footer sticky-footer">
                    <div class="pull-right">
                        <button type="submit" id="formeditrecordbtn"
                            data-loading-text="<?php echo $this->lang->line('processing'); ?>"
                            class="btn btn-info pull-right"><i class="fa fa-check-circle"></i>
                            <?php echo $this->lang->line('save'); ?></button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- discharged summary   -->
<div class="modal fade" id="myModaldischarged" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="modalicon">
                    <div id='summary_print'>
                    </div>
                </div>
                <h4 class="modal-title"><?php echo $this->lang->line('discharged_summary'); ?></h4>
                <div class="row">
                </div>
                <!--./row-->
            </div>
            <form id="formdishrecord" accept-charset="utf-8" enctype="multipart/form-data" method="post">
                <div class="modal-body pt0 pb0">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="row row-eq">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="ptt10">
                                        <div id="evajax_load"></div>
                                        <div class="row" id="">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <ul class="multilinelist">
                                                    <li> <label
                                                            for="pwd"><?php echo $this->lang->line('name'); ?></label>
                                                        <span id="disevlistname"></span>
                                                    </li>
                                                    <li>
                                                        <label for="pwd"><?php echo $this->lang->line('age'); ?></label>
                                                        <span id="disevage"></span>
                                                    </li>
                                                    <li>
                                                        <label
                                                            for="pwd"><?php echo $this->lang->line('gender'); ?></label>
                                                        <span id="disevgenders"></span>
                                                    </li>
                                                </ul>
                                                <ul class="multilinelist">
                                                    <li>
                                                        <label><?php echo $this->lang->line('admission_date'); ?></label>
                                                        <span id="disedit_admission_date"></span>
                                                    </li>
                                                    <li>
                                                        <label><?php echo $this->lang->line('discharged_date'); ?></label>
                                                        <span id="disedit_discharge_date"></span>
                                                    </li>
                                                </ul>
                                                <ul class="singlelist">
                                                    <li>
                                                        <label><?php echo $this->lang->line('address') ?></label>
                                                        <span id="disevaddress"></span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label
                                                        for="pwd"><?php echo $this->lang->line('diagnosis'); ?></label>
                                                    <input name="diagnosis" id='disdiagnosis' rows="3"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label
                                                        for="pwd"><?php echo $this->lang->line('operation'); ?></label>
                                                    <input name="operation" id='disoperation' class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="pwd"><?php echo $this->lang->line('note'); ?></label>
                                                    <textarea name="note" id='disevnoteipd' rows="3"
                                                        class="form-control"><?php echo set_value('note'); ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="dividerhr"></div>
                                            </div>
                                            <!--./col-md-12-->
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label
                                                        for="pwd"><?php echo $this->lang->line('investigation'); ?></label>
                                                    <textarea name="investigations" id='disinvestigations' rows="3"
                                                        class="form-control"><?php echo set_value('note'); ?></textarea>
                                                </div>
                                            </div>

                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <label
                                                        for="pwd"><?php echo $this->lang->line('treatment_at_home'); ?></label>
                                                    <textarea name="treatment_at_home" id='distreatment_at_home'
                                                        rows="3"
                                                        class="form-control"><?php echo set_value('note'); ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <input name="patient_id" id="disevpatients_id" type="hidden">
                                        <input type="hidden" id="disupdateid" name="updateid">
                                        <input type="hidden" id="disipdid" name="ipdid">
                                    </div>
                                </div>
                            </div>
                            <!--./row-->
                        </div>
                        <!--./col-md-12-->
                    </div>
                    <!--./row-->
                </div>
                <div class="modal-footer">
                    <div class="pull-right">
                        <button type="submit" id="formdishrecordbtn"
                            data-loading-text="<?php echo $this->lang->line('processing') ?>"
                            class="btn btn-info pull-right"> <?php echo $this->lang->line('save'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- discharged summary   -->

<!-- Add Instruction -->
<div class="modal fade" id="add_instruction" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close close_button" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('add_consultant_register'); ?> </h4>
            </div>

            <form id="consultant_register_form" accept-charset="utf-8" enctype="multipart/form-data" method="post">
                <input name="patient_id" placeholder="" id="ins_patient_id" value="<?php echo $result["id"] ?>"
                    type="hidden" class="form-control" />
                <div class="scroll-area">
                    <div class="modal-body pb0 ptt10">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('applied_date'); ?><small class="req"> *</small>
                                    </label>
                                    <input type="text" name="date" value="" class="form-control" id="applied_date">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('instruction_date'); ?> <small class="req">
                                            *</small> </label>
                                    <input type="text" id="instruction_date" name="insdate"
                                        value="<?php echo date('d/m/Y')//set_value('date', date($this->customlib->getHospitalDateFormat())); ?>"
                                        class="form-control date">
                                    <input type="hidden" name="ipdid" value="<?php echo $ipdid ?>">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('consultant_doctor'); ?><small class="req">
                                            *</small> </label>
                                    <input type="hidden" name="doctor" id="doctor_set">
                                    <select name="doctor_field" <?php
                                                                if ($disable_option == true) {
                                                                    echo "disabled";
                                                                } ?> style="width: 100%" id="doctor_field"
                                        class="form-control select2">
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        <?php foreach ($doctors as $key => $value) { ?>
                                            <option <?php if ((isset($doctor_select)) && ($doctor_select == $dvalue["id"])) {
                                                        echo "selected";
                                                    } ?> value="<?php echo $value["id"] ?>">
                                                <?php echo $value["name"] . " " . $value["surname"] . " (" . $value["employee_id"] . ")" ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('instruction'); ?> <small class="req"> *</small>
                                    </label>
                                    <textarea name="instruction" rows="5" class="form-control"></textarea>
                                </div>
                            </div>

                            <div class="">
                                <?php echo display_custom_fields('ipdconsultinstruction'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="pull-right">
                        <button type="submit" id="consultant_registerbtn"
                            data-loading-text="<?php echo $this->lang->line('processing'); ?>" class="btn btn-info"><i
                                class="fa fa-check-circle"></i> <?php echo $this->lang->line('save'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_instruction" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('edit_consultant_register'); ?> </h4>
            </div>

            <form id="editconsultant_register_form" accept-charset="utf-8" enctype="multipart/form-data" method="post"
                class="ptt10">
                <div class="scroll-area">
                    <div class="modal-body pt0 pb0">
                        <div class="row">
                            <input type="hidden" name="instruction_id" value="" id="instruction_id">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('applied_date'); ?>
                                        <small class="req"> *</small>
                                    </label>
                                    <input type="text" name="date" id="ecdate" value="" class="form-control datetime">

                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('instruction_date'); ?> <small class="req">
                                            *</small> </label>
                                    <input type="text" id="ecinsdate" name="insdate"
                                        value="<?php echo set_value('date', date($this->customlib->getHospitalDateFormat())); ?>"
                                        class="form-control date">
                                    <input type="hidden" name="ipdid" value="<?php echo $ipdid ?>">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('consultant_doctor'); ?><small class="req">
                                            *</small> </label>
                                    <input type="hidden" name="doctor" id="editdoctor_set">
                                    <select name="doctor_field" <?php
                                                                if ($disable_option == true) {
                                                                    echo "disabled";
                                                                } ?> style="width: 100%" id="editdoctor_field"
                                        class="form-control select2">
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        <?php foreach ($doctors as $key => $value) { ?>
                                            <option <?php if ((isset($doctor_select)) && ($doctor_select == $dvalue["id"])) {
                                                        echo "selected";
                                                    } ?> value="<?php echo $value["id"] ?>">
                                                <?php echo $value["name"] . " " . $value["surname"] . " (" . $value["employee_id"] . ")" ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('instruction'); ?> <small class="req"> *</small>
                                    </label>
                                    <textarea name="instruction" id="ecinstruction" rows="5"
                                        class="form-control"></textarea>
                                </div>
                            </div>

                            <div class="" id="customfieldconsult">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="editconsultant_registerbtn"
                        data-loading-text="<?php echo $this->lang->line('processing'); ?>"
                        class="btn btn-info pull-right"><i class="fa fa-check-circle"></i>
                        <?php echo $this->lang->line('save'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="add_nurse_note" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close close_button" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('add_nurse_note'); ?> </h4>
            </div>

            <form id="nurse_note_form" accept-charset="utf-8" enctype="multipart/form-data" method="post">
                <input name="patient_id" placeholder="" id="nurse_patient_id" value="<?php echo $result["id"] ?>"
                    type="hidden" class="form-control" />
                <input type="hidden" name="ipdid" value="<?php echo $ipdid ?>" id='ipdid'>
                <div class="scroll-area">
                    <div class="modal-body pb0 ptt10">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('date'); ?>
                                        <small class="req"> *</small>
                                    </label>
                                    <input type="text" name="date" value="" id="nurse_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('nurse'); ?><small class="req"> *</small>
                                    </label>
                                    <input type="hidden" name="nurse" id="nurse_set">
                                    <select name="nurse_field" <?php
                                                                if ($disable_option == true) {
                                                                    echo "disabled";
                                                                } ?> style="width: 100%" id="nurse_field"
                                        class="form-control select2">
                                        <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        <?php foreach ($nurse as $key => $value) { ?>
                                            <option <?php if ((isset($nurse_select)) && ($nurse_select == $dvalue["id"])) {
                                                        echo "selected";
                                                    } ?> value="<?php echo $value["id"] ?>">
                                                <?php echo composeStaffNameByString($value["name"], $value["surname"], $value["employee_id"]); ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('note') ?> <small class="req"> *</small>
                                    </label>
                                    <textarea name="note" style="height:50px" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('comment'); ?> <small class="req"> *</small>
                                    </label>
                                    <textarea name="comment" style="height:50px" class="form-control"></textarea>
                                </div>
                            </div>

                            <div class="">
                                <?php echo display_custom_fields('ipdnursenote'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="nurse_notebtn"
                        data-loading-text="<?php echo $this->lang->line('processing'); ?>"
                        class="btn btn-info pull-right"><i class="fa fa-check-circle"></i>
                        <?php echo $this->lang->line('save'); ?></button>
                </div>
            </form>


        </div>
    </div>

</div>


<!-- change bed -->
<div class="modal fade" id="alot_bed" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('bed'); ?></h4>
            </div>
            <form id="alot_bed_form" accept-charset="utf-8" enctype="multipart/form-data" method="post" class="ptt10">
                <div class="modal-body pt0 pb0">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">

                            <div class="alert alert-info">
                                <?php echo $this->lang->line('bed_alot_message') ?>
                            </div>
                            <div class="row">
                                <input name="patient_id" placeholder="" value="<?php echo $result["id"] ?>"
                                    type="hidden" class="form-control" />

                                <div class="col-md-12">
                                    <label><?php echo $this->lang->line('bed') . " " . $this->lang->line('group'); ?><small
                                            class="req"> *</small></label>
                                    <select class="form-control"
                                        onchange="getBed(this.value, '', 'yes', 'alotbedoption')" name="bedgroup">
                                        <option value=""><?php echo $this->lang->line('select') ?></option>
                                        <?php foreach ($bedgroup_list as $key => $bedgroup) {
                                        ?>
                                            <option value="<?php echo $bedgroup["id"] ?>">
                                                <?php echo $bedgroup["name"] . " - " . $bedgroup["floor_name"] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-12" style="margin-top: 10px;">
                                    <label><?php echo $this->lang->line('bed') . " " . $this->lang->line('no'); ?><small
                                            class="req"> *</small></label>
                                    <select class="form-control select2" style="width: 100%" id="alotbedoption"
                                        name="bedno">
                                    </select>
                                </div>
                                <div class="col-md-12" style="margin-top: 10px;">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="pull-right">
                                    <button type="submit" id="alotbedbtn"
                                        data-loading-text="<?php echo $this->lang->line('processing') ?>"
                                        class="btn btn-info"><?php echo $this->lang->line('save'); ?></button>
                                </div>
                            </div>

                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>
</div>


<div class="modal fade" id="view_ot_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="modalicon">
                    <div id='action_detail_modal'>

                    </div>


                </div>

                <h4 class="modal-title"><?php echo $this->lang->line('operation_details'); ?></h4>
            </div>
            <div class="modal-body min-h-3">
                <div id="show_ot_data"></div>
            </div>
        </div>
    </div>
</div>

<!--lab investigation modal-->
<div class="modal fade" id="viewDetailReportModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-media-content">
            <div class="modal-header modal-media-header">
                <button type="button" class="close" data-toggle="tooltip"
                    title="<?php echo $this->lang->line('clase'); ?>" data-dismiss="modal">&times;</button>
                <div class="modalicon">
                    <div id='action_detail_report_modal'>

                    </div>
                </div>
                <h4 class="modal-title" id="modal_head"></h4>
            </div>
            <div class="modal-body ptt10 pb0">
                <div id="reportbilldata"></div>
            </div>
        </div>
    </div>
</div>
<!-- end lab investigation modal-->

<div class="modal fade" id="editpayment_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-mid" role="document">
        <div class="modal-content modal-media-content">
            <form id="editpaymentform" accept-charset="utf-8" method="post">
                <div class="modal-header modal-media-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div class="modalicon">
                    </div>

                    <h4 class="modal-title"><?php echo $this->lang->line('payment_details'); ?></h4>
                </div>
                <div class="modal-body ">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('date'); ?></label><small class="req">
                                            *</small>


                                        <input type="text" name="payment_date" id="payment_date"
                                            class="form-control datetime" autocomplete="off">
                                        <input type="hidden" class="form-control" id="edit_payment_id"
                                            name="edit_payment_id">
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('amount') . " (" . $currency_symbol . ")"; ?></label><small
                                            class="req"> *</small>

                                        <input type="text" name="amount" id="edit_payment" class="form-control"
                                            value="">

                                        <span class="text-danger"><?php echo form_error('amount'); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('payment_mode'); ?></label>
                                        <select class="form-control payment_mode" name="payment_mode" id="payment_mode">

                                            <?php foreach ($payment_mode as $key => $value) {
                                            ?>
                                                <option value="<?php echo $key ?>" <?php
                                                                                    if ($key == 'cash') {
                                                                                        echo "selected";
                                                                                    }
                                                                                    ?>><?php echo $value ?></option>
                                            <?php } ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('apply_charge'); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row cheque_div" style="display: none;">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('cheque_no'); ?></label><small class="req">
                                            *</small>
                                        <input type="text" name="cheque_no" id="edit_cheque_no" class="form-control">
                                        <span class="text-danger"><?php echo form_error('cheque_no'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('cheque_date'); ?></label><small
                                            class="req"> *</small>
                                        <input type="text" name="cheque_date" id="edit_cheque_date"
                                            class="form-control date">
                                        <span class="text-danger"><?php echo form_error('cheque_date'); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('attach_document'); ?></label>
                                        <input type="file" class="filestyle form-control" name="document">
                                        <span class="text-danger"><?php echo form_error('document'); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line('note'); ?></label>
                                        <input type="text" name="note" id="edit_payment_note" class="form-control" />
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="editpaymentbtn" data-loading-text="Processing..."
                        class="btn btn-info pull-right"><i class="fa fa-check-circle"></i>
                        <?php echo $this->lang->line('save'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
$data = $this->session->userdata('hospitaladmin');
$api_base_url = $this->config->item('api_base_url');
?>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script type="text/javascript">
    var date_format =
        '<?php echo strtr($this->customlib->getHospitalDateFormat(), ['d' => 'dd', 'm' => 'MM', 'Y' => 'yyyy',]) ?>';

    $(document).on('click', '.print_ot_bill', function() {
        var $this = $(this);
        var record_id = $this.data('recordId');
        $this.button('loading');
        $.ajax({
            url: '<?php echo base_url(); ?>admin/operationtheatre/print_otdetails',
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
</script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    });
</script>
<script>
    var orgid = "<?php echo $result['organisation_id'] ?>";
    var prescription_rows = 2;
    var selected_medicine_category_id = 1;

    $(function() {
        $('.select2').select2();
    });
</script>
<script>
    var ipd_id = "<?php echo $ipdid ?>";
    $(document).on('change', '.act', function() {
        $this = $(this);
        var sys_val = $(this).val();
        var section_ul = $(this).closest('div.row').find('ul.section_ul');
        $.ajax({
            type: 'POST',
            url: base_url + 'admin/patient/getPartialsymptoms',
            data: {
                'sys_id': sys_val
            },
            dataType: 'JSON',
            beforeSend: function() {
                // setting a timeout
                $('ul.section_ul').find('li:not(:first-child)').remove();
            },
            success: function(data) {
                section_ul.append(data.record);
            },
            error: function(xhr) { // if error occured
                alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
            },
            complete: function() {

            }
        });
    });
</script>
<script type="text/javascript">
    $(document).on('click', '.remove_row', function() {
        $this = $(this);
        $this.closest('.row').remove();
    });

    $(document).mouseup(function(e) {
        var container = $(".wrapper-dropdown-3"); // YOUR CONTAINER SELECTOR
        if (!container.is(e.target) // if the target of the click isn't the container...
            &&
            container.has(e.target).length === 0) // ... nor a descendant of the container
        {
            $("div.wrapper-dropdown-3").removeClass('active');
        }
    });

    $(document).on('click', '.filterinput', function() {
        if (!$(this).closest('.wrapper-dropdown-3').hasClass("active")) {
            $(".wrapper-dropdown-3").not($(this)).removeClass('active');
            $(this).closest("div.wrapper-dropdown-3").addClass('active');
        }
    });

    $(document).on('click', 'input[name="section[]"]', function() {
        $(this).closest('label').toggleClass('active_section');
    });

    $(document).on('keyup', '.filterinput', function() {
        var valThis = $(this).val().toLowerCase();
        var closer_section = $(this).closest('div').find('.section_ul > li');
        var noresult = 0;
        if (valThis == "") {
            closer_section.show();
            noresult = 1;
            $('.no-results-found').remove();
        } else {
            closer_section.each(function() {
                var text = $(this).text().toLowerCase();
                var match = text.indexOf(valThis);
                if (match >= 0) {
                    $(this).show();
                    noresult = 1;
                    $('.no-results-found').remove();
                } else {
                    $(this).hide();
                }
            });
        };
        if (noresult == 0) {
            closer_section.append('<li class="no-results-found">No results found.</li>');
        }
    });
</script>
<script type="text/javascript">
     $("body").delegate("#applied_date,#instruction_date,#charge_date,#editcharge_date,#timeline_date,#etimelinedate,#nurse_date,#endate", "focusin", function() {
        var date_format = 'dd/mm/yyyy';

        $(this).datepicker({
            todayHighlight: true,
            format: date_format,
            autoclose: true,
        });
    });
    function addpaymentModal() {
        var total = $("#charge_total").val();
        var patient_id = '<?php echo $result["id"] ?>';
        $("#total").val(total);
        $("#payment_file").dropify();
        $("#payment_patient_id").val(patient_id);
        holdModal('myPaymentModal');
    }

    function addmedicationModal() {
        holdModal('myaddMedicationModal');
    }

    function medicationModal(medicine_category_id, pharmacy_id, date) {
        var div_data = "<option value=''><?php echo $this->lang->line('select'); ?></option>";
        if (medicine_category_id != "") {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/getMedicineDoseDetails',
                type: "POST",
                data: {
                    medicine_category_id: medicine_category_id
                },
                dataType: 'json',
                success: function(res) {
                    $.each(res, function(i, obj) {
                        var sel = "";
                        div_data += "<option value='" + obj.id + "'>" + obj.dosage + " " + obj.unit +
                            "</option>";

                    });

                    $("#mdosage").html(div_data);
                    $("#mdosage").select2("val", '');
                    $("#add_dose_medicine_category").select2("val", medicine_category_id);
                    getMedicineForMedication(medicine_category_id, pharmacy_id);
                    $("#add_dose_date").val(date);
                    $("#mpharmacy_id").val(pharmacy_id);
                    $("#mdate").val(date);

                    holdModal('myMedicationModal');
                },
            });
        }
    }

    function medicationDoseModal(medication_id) {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/getMedicationDoseDetails',
            type: "POST",
            data: {
                medication_id: medication_id
            },
            dataType: 'json',
            success: function(data) {
                $("#date_edit_medication").val(data.date);
                $("#dosagetime").val(data.dosagetime);
                $('select[id="medicine_dose_id"] option[value="' + data.medicine_dosage_id + '"]').attr(
                    "selected", "selected");
                $("#medicine_dose_edit_id").select2().select2('val', data.medicine_dosage_id);
                $("#mmedicine_category_edit_id ").val(data.medicine_category_id).trigger('change');
                getMedicineForMedication(data.medicine_category_id, data.pharmacy_id);
                $("#medicine_dosage_remark").val(data.remark);
                $("#medication_id").val(data.id);
                <?php if ($this->rbac->hasPrivilege('ipd_medication', 'can_delete')) {  ?>
                    $('#edit_delete').html("<a href='#' class='delete_record_dosage' data-record-id='" +
                        medication_id +
                        "' data-toggle='tooltip' title='<?php echo $this->lang->line('delete'); ?>' data-target='' data-toggle='modal'  data-original-title='<?php echo $this->lang->line('delete'); ?>'><i class='fa fa-trash'></i></a>"
                    );
                <?php } ?>
                holdModal('myMedicationDoseModal');
            },
        });
    }


    $('#myChargesModal').on('hidden.bs.modal', function(e) {
        $('.charge_type ', $(this)).select2('val', '');
        $('.charge_category', $(this)).html('').select2();
        $('.charge', $(this)).html('').select2();
    });


    $("#add_instruction").on('hidden.bs.modal', function(e) {
        $(".filestyle").next(".dropify-clear").trigger("click");
        $('#consultant_register_form #doctor_field').select2("val", "");
        $('form#consultant_register_form').find('input:text, input:password, input:file, textarea').val('');
        $('form#consultant_register_form').find('select option:selected').removeAttr('selected');
        $('form#consultant_register_form').find('input:checkbox, input:radio').removeAttr('checked');
    });



    $("#add_operationtheatre").on('hidden.bs.modal', function(e) {
        $(".filestyle").next(".dropify-clear").trigger("click");
        $('#form_operationtheatre #operation_category').select2("val", "");
        $('#form_operationtheatre #operation_name').select2("val", "");
        $('#form_operationtheatre #consultant_doctorid').select2("val", "");
        $('form#form_operationtheatre').find('input:text, input:password, input:file, textarea').val('');
        $('form#form_operationtheatre').find('select option:selected').removeAttr('selected');
        $('form#form_operationtheatre').find('input:checkbox, input:radio').removeAttr('checked');
    });

    $('#modal-chkstatus').on('shown.bs.modal', function(e) {
        var $modalDiv = $(e.delegateTarget);
        var id = $(e.relatedTarget).data('id');

        $.ajax({
            type: "POST",
            url: base_url + 'admin/zoom_conference/getlivestatus',
            data: {
                'id': id
            },
            dataType: "JSON",
            beforeSend: function() {
                $('#zoom_details').html("");
                $modalDiv.addClass('modal_loading');
            },
            success: function(data) {
                $('#zoom_details').html(data.page);
                $modalDiv.removeClass('modal_loading');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $modalDiv.removeClass('modal_loading');
            },
            complete: function(data) {
                $modalDiv.removeClass('modal_loading');
            }
        });
    })


    function getRecord(ipdid) {

        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/getIpdDetails',
            type: "POST",
            data: {
                ipdid: ipdid
            },
            dataType: 'json',
            success: function(data) {
                var table_html = '';
                $.each(data.field_data, function(i, obj) {
                    if (obj.field_value == null) {
                        var field_value = "";
                    } else {
                        var field_value = obj.field_value;
                    }
                    var name = obj.name;
                    table_html +=
                        "<div class='row'><div class='col-lg-2 col-md-2 col-sm-2'><span ><b>" +
                        capitalizeFirstLetter(name) +
                        "</b></span></div></div> <div class='row'><div class='col-lg-10 col-md-10 col-sm-10'><span >" +
                        field_value + "</span></div></div><br>";
                });
                $("#field_data").html(table_html);
                $("#patients_id").html(data.patient_id);
                $("#patient_name").html(data.patient_name);
                $("#contact").html(data.mobileno);
                $("#email").html(data.email);
                $("#age").html(data.age);
                $("#gen").html(data.gender);
                $("#guardian_name").html(data.guardian_name);
                $("#admission_date").html(data.date);
                $("#case").html(data.case_type);
                $("#casualty").html(data.casualty);
                $("#symptoms").html(data.symptoms);
                $("#spo2").html(data.spo2);
                $("#refference").html(data.refference);
                $("#doc").html(data.name + ' ' + data.surname + ' (' + data.employee_id + ')');
                $("#amount").html(data.amount);
                $("#tax").html(data.tax);
                $("#height").html(data.height);
                $("#weight").html(data.weight);
                $("#temperature").html(data.temperature);
                $("#respiration").html(data.respiration);
                $("#pulse").html(data.pulse);
                $("#patient_bp").html(data.bp);
                $("#blood_group").html(data.blood_group_name);
                $("#old_patient").html(data.patient_old);
                $("#payment_mode").html(data.payment_mode);
                $("#organisation").html(data.organisation_name);
                $("#opdid").val(data.opdid);
                $("#patient_address").html(data.address);
                $("#marital_status").html(data.marital_status);
                $("#note").val(data.note);
                $("#bed_group").html(data.bedgroup_name + '-' + data.floor_name);
                $("#bed_name").html(data.bed_name);
                $("#etpa_id").html(data.insurance_id);
                $("#etpa_validity").html(data.insurance_validity);
                $("#eidentification_number").html(data.identification_number);
                $("#evblood_group").html(data.blood_group_name);
                holdModal('viewModal');
            },
        });
    }

    function getEditRecord(ipdid) {

        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/getIpdDetails',
            type: "POST",
            data: {
                ipdid: ipdid
            },
            dataType: 'json',
            success: function(data) {
                $('#customfield').html(data.custom_fields_value);
                $('#evlistname').html(data.patient_name + " (" + data.patient_id + ")");
                $('#evguardian').html(data.guardian_name);
                $('#evlistnumber').html(data.mobileno);
                $('#evemail').html(data.email);
                $("#etpa_id").html(data.insurance_id);
                $("#etpa_validity").html(data.einsurance_validity);
                $("#eidentification_number").html(data.identification_number);
                $("#evaddress").html(data.address);
                $("#enote").html(data.note);
                $("#evgenders").html(data.gender);
                $("#evmarital_status").html(data.marital_status);
                $("#evblood_group").html(data.blood_group_name);
                $("#evallergies").html(data.known_allergies);
                $("#patients_ids").val(data.patient_unique_id);
                $("#patient_names").val(data.patient_name);
                $("#edit_admission_date").val(data.date);
                $("#contacts").val(data.mobileno);
                $("#patient_image").val(data.image);
                $("#emails").val(data.email);
                $("#ages").val(data.age);
                $("#months").val(data.month);
                $("#evheight").val(data.height);
                $("#evweight").val(data.weight);
                $("#evbp").val(data.bp);
                $("#evpulse").val(data.pulse);
                $("#evtemperature").val(data.temperature);
                $("#evrespiration").val(data.respiration);
                $("#edit_patient_address").val(data.address);
                $("#patient_case").val(data.case_type);
                $("#symptoms_description").val(data.symptoms);
                $("#patient_allergies").val(data.known_allergies);
                $("#evnoteipd").val(data.ipdnote);
                $("#patient_refference").val(data.refference);
                $("#guardian_names").val(data.guardian_name);
                $("#credits_limits").val(data.ipdcredit_limit);
                $("#ipdid_edit").val(data.ipdid);
                $("#ipdid").val(data.ipdid);
                $("#previous_bed_id").val(data.bed);
                $("#ebed_group_id").val(data.bed_group_id).attr('selected', true);

                getBed(data.bed_group_id, data.bed, 'yes', 'ebed_nos');
                $('select[id="patient_consultant"] option[value="' + data.cons_doctor + '"]').attr("selected",
                    "selected");
                $('select[id="patient_casualty"] option[value="' + data.casualty + '"]').attr("selected",
                    "selected");
                $('select[id="old"] option[value="' + data.patient_old + '"]').attr("selected", "selected");
                $('select[id="genders"] option[value="' + data.gender + '"]').attr("selected", "selected");
                $('select[id="marital_statuss"] option[value="' + data.marital_status + '"]').attr("selected",
                    "selected");
                $('select[id="edit_organisations"] option[value="' + data.organisation_id + '"]').attr(
                    "selected", "selected");
                $("#patient_consultant").select2().select2('val', data.cons_doctor);
                $("#evaddpatient_id").select2().select2('val', data.patient_id);
                $('.select2').select2();
                holdModal('myModaledit');
            },
        });
    }

    function get_doctoripd(ipdid) {
        holdModal('add_doctor');
    }

    function getEditRecordDischarged(id, ipdid) {
        var active = '<?php echo $result['is_active'] ?>';
        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/getIpdDetails',
            type: "POST",
            data: {
                recordid: id,
                ipdid: ipdid,
                active: active
            },
            dataType: 'json',
            success: function(data) {
                $('#disevlistname').html(data.patient_name);
                $('#disevguardian').html(data.guardian_name);
                $('#disevlistnumber').html(data.mobileno);
                $('#disevemail').html(data.email);
                if (data.age == "") {
                    $("#disevage").html("");
                } else {
                    if (data.age) {
                        var age = data.age + " " + "Years";
                    } else {
                        var age = '';
                    }
                    if (data.month) {
                        var month = data.month + " " + "Month";
                    } else {
                        var month = '';
                    }
                    if (data.dob) {
                        var dob = "(" + data.dob + ")";
                    } else {
                        var dob = '';
                    }

                    $("#disevage").html(age + "," + month + " " + dob);
                }
                $("#disevaddress").html(data.address);
                $("#disenote").html(data.note);
                $("#disevgenders").html(data.gender);
                $("#disevmarital_status").html(data.marital_status);
                $("#disedit_admission_date").html(data.date);
                $("#disedit_discharge_date").html(data.discharge_date);
                $("#disipdid").val(data.ipdid);
                $("#disupdateid").val(data.summary_id);
                $("#disevpatients_id").val(data.patient_id);
                $("#disinvestigations").val(data.summary_investigations);
                $("#disevnoteipd").val(data.summary_note);
                $("#disdiagnosis").val(data.disdiagnosis);
                $("#disoperation").val(data.disoperation);
                $("#distreatment_at_home").val(data.summary_treatment_home);
                $('#summary_print').html(
                    "<?php if ($this->rbac->hasPrivilege('discharged_summary', 'can_view')) { ?><a href='#' data-toggle='tooltip' onclick='printData(" +
                    data.summary_id +
                    ")'   data-original-title='<?php echo $this->lang->line('print'); ?>'><i class='fa fa-print'></i></a> <?php } ?>"
                );
                holdModal('myModaldischarged');
            },
        });
    }

    function printData(insert_id) {
        var base_url = '<?php echo base_url() ?>';
        $.ajax({
            url: base_url + 'admin/patient/getsummaryDetails/' + insert_id,
            type: 'POST',
            data: {
                id: insert_id,
                print: 'yes'
            },
            success: function(result) {
                popup(result);
            }
        });
    }

    function get_ePatientDetails(id) {
        var base_url = "<?php echo base_url(); ?>";
        $("#ajax_load").html("<center><img src='" + base_url + "'/>");
        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/patientDetails',
            type: "POST",
            data: {
                id: id
            },
            dataType: 'json',
            success: function(res) {
                if (res) {
                    console.log(res);
                    $("#evajax_load").html("");
                    $("#evpatientDetails").show();
                    $('#evpatient_unique_id').html(res.patient_unique_id);
                    $('#evlistname').html(res.patient_name + " (" + res.id + ")");
                    $('#evpatients_id').val(res.id);
                    $('#evguardian').html(res.guardian_name);
                    $('#evlistnumber').html(res.mobileno);
                    $('#evemail').html(res.email);
                    $("#evage").html(res.patient_age);
                    $('#evdoctname').val(res.name + " " + res.surname);
                    $("#evbp").html(res.bp);
                    $("#esymptoms").html(res.symptoms);
                    $("#evknown_allergies").html(res.known_allergies);
                    $("#evaddress").html(res.address);
                    $("#evnote").html(res.note);
                    $("#evgenders").html(res.gender);
                    $("#evmarital_status").html(res.marital_status);
                    $("#evblood_group").html(res.blood_group_name);
                    $("#evallergies").html(res.known_allergies);
                    $.ajax({
                        url: 'https://phr-api.plenome.com/file_upload/getDocs',
                        type: "POST",
                        contentType: "application/json",
                        data: JSON.stringify({
                            value: res.image
                        }),
                        success: function(decryptResponse) {
                            let base64Image = "data:image/png;base64," + decryptResponse;
                            if (decryptResponse && typeof decryptResponse === 'string' &&
                                decryptResponse.length > 0) {
                                $("#evimage").attr("src", base64Image);
                            } else {
                                $("#evimage").attr("src", base_url +
                                    'uploads/staff_images/no_image.png');
                            }
                        },
                        error: function() {
                            $("#evimage").attr("src", base_url +
                                'uploads/staff_images/no_image.png');
                        }
                    });
                } else {
                    $("#evajax_load").html("");
                    $("#evpatientDetails").hide();
                }
            }
        });
    }

    $(document).ready(function(e) {
        $('#add_prescription,#patient_discharge').modal({
            backdrop: 'static',
            keyboard: false,
            show: false
        });

        $("#formeditrecord").on('submit', function(e) {
            $("#formeditrecordbtn").button('loading');
            e.preventDefault();

            var formData = {};
            $(this).find(':input').each(function() {
                var input = $(this);
                if (input.attr('name')) {
                    formData[input.attr('name')] = input.val();
                }
            });

            var transformedData = {
                "height": formData.height || "",
                "weight": formData.weight || "",
                "pulse": formData.pulse || "",
                "temperature": formData.temperature || "",
                "respiration": formData.respiration || "",
                "bp": formData.bp || "",
                "bed": parseInt(formData.bed_no) || 0,
                "bed_group_id": parseInt(formData.bed_group_id) || 0,
                "case_type": formData.case_type || "",
                "casualty": formData.casualty || "",
                "symptoms": formData.symptoms || "",
                "known_allergies": "none",
                "patient_old": formData.old_patient || "",
                "note": formData.note || "",
                "refference": formData.refference || "",
                "cons_doctor": parseInt(formData.cons_doctor) || 0,
                "organisation_id": parseInt(formData.organisation) || 0,
                "credit_limit": formData.credit_limit || "",
                "payment_mode": "cash",
                "date": (() => {
                    const [month, day, year] = formData.appointment_date.split(" ")[0].split(
                        "/");
                    return `${year}-${month}-${day}`;
                })(),
                "discharged": "no",
                "live_consult": "no",
                "is_active": "yes",
                "revert_reason": "none",
                "hospital_id": <?= $data['hospital_id'] ?>
            };

            // console.log(JSON.stringify(transformedData));
            let editid = $('#ipdid_edit').val();
             sendAjaxRequest(
                    '<?= $api_base_url ?>ipd-main-module/' + editid,
                    'PATCH',
                    transformedData,
                    function(response) {
                        handleResponse(response);
                    }
                );
        });
    });


    $(document).ready(function(e) {
        $("#formdishrecord").on('submit', (function(e) {
            $("#formdishrecordbtn").button('loading');
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/add_discharged_summary',
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
                    $("#formdishrecordbtn").button('reset');
                },
                error: function() {

                }
            });
        }));
    });

    $(document).ready(function(e) {
        $("#alot_bed_form").on('submit', (function(e) {
            $("#alotbedbtn").button('loading');

            e.preventDefault();
            var bedid = $("#alotbedoption").val();

            var ipdid = '<?php echo $ipdid ?>';
            var patient_id = '<?php echo $result["id"] ?>';
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/updatebed',
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
                        revert(patient_id, bedid, ipdid);
                    }
                    $("#alotbedbtn").button('reset');
                },
                error: function() {

                }
            });
        }));
    });

    function editRecord(id, opdid) {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/opd_details',
            type: "POST",
            data: {
                recordid: id,
                opdid: opdid
            },
            dataType: 'json',
            success: function(data) {
                $("#patientid").val(data.patient_unique_id);
                $("#patientname").val(data.patient_name);
                $("#appointmentdate").val(data.appointment_date);
                $("#edit_case").val(data.case_type);
                $("#edit_symptoms").val(data.symptoms);
                $("#edit_casualty").val(data.casualty);
                $("#edit_knownallergies").val(data.known_allergies);
                $("#edit_refference").val(data.refference);
                $("#edit_consdoctor").val(data.cons_doctor);
                $("#edit_amount").val(data.amount);
                $("#edit_tax").val(data.tax);
                $("#edit_paymentmode").val(data.payment_mode);
                $("#edit_opdid").val(opdid);
            },
        });
    }

    //payment system///////////////////////////////////////
    $(document).ready(function() {
        $("#add_payment").on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            var dataObject = {};
            formData.forEach(function(value, key) {
                dataObject[key] = value;
            });
            errorMessage = [];
            if (!dataObject["payment_date"]) {
                errorMessage.push("Payment Date is required");
            }
            if (!dataObject["amount"]) {
                errorMessage.push("Amount is required");
            }
            if ((dataObject["amount"]) <= 0) {
                errorMessage.push("Amount should be greater than zero");
            }

            if (errorMessage.length > 0) {
                errorMsg(errorMessage.join("<br>"));
                $("#add_paymentbtn").button('reset');
                return false;
            }
            var transformedData = {
                ipd_id: parseInt(dataObject["ipdid"], 10),
                payment_date: moment(dataObject["payment_date"], "DD/MM/YYYY hh:mm A").format("YYYY-MM-DD HH:mm:ss") || "",//formatDate(dataObject["payment_date"]),
                amount: parseFloat(dataObject["amount"]),
                payment_mode: dataObject["payment_mode"],
                note: dataObject["note"],
                Hospital_id: <?= $data['hospital_id'] ?>,
                received_by_name:'<?=$data['username'] ?>',
            };
            let jsonData = {};
            jsonData["amount"] = parseFloat(dataObject["amount"]);
            jsonData["patient_id"] = 1;
            if (transformedData.payment_mode === 'Online') {
                handlePayment(jsonData).then((paymentSuccess) => {
                    if (paymentSuccess) {
                        transformedData["payment_gateway"] = 'razorpay';
                        transformedData["payment_id"] = paymentSuccess.payment_id;
                        transformedData["payment_reference_number"] = paymentSuccess.reference_id;
                        submitForm(transformedData);
                    } else {
                        errorMsg("Payment failed. Please try again.");
                    }
                });
            } else {
                submitForm(transformedData);
            }
            $("#add_paymentbtn").button('loading');
        });

        function formatDate(dateStr) {
            var date = new Date(dateStr);
            return date.toISOString().slice(0, 19).replace('T', ' ');
        }

        function submitForm(transformedData) {
            try {
                 sendAjaxRequest(
                    `<?= $api_base_url ?>internal-ipd-payment`,
                    'POST',
                    transformedData,
                    function(response) {
                        handleResponse(response);
                    }
                );

            } catch (error) {
                console.error("AJAX request failed:", error);
                errorMsg("Unexpected error. Please try again.");
            }

        }
    });



    $(document).ready(function() {
        $("#add_medication").on('submit', function(e) {
            e.preventDefault();
            $("#add_medicationbtn").button('loading');
            var formData = new FormData(this);
            var dataObject = {};
            var dateStr = formData.get("date");
            var hour = parseInt(formData.get("hour"));
            var minute = formData.get("minute");
            var meridian = formData.get("meridian");
            var dateParts = dateStr.split('/');
            var formattedDate = `${dateParts[2]}-${dateParts[0]}-${dateParts[1]}`;
            if (meridian === "PM" && hour !== 12) {
                hour += 12;
            }
            if (meridian === "AM" && hour === 12) {
                hour = 0;
            }
            var formattedHour = ('0' + hour).slice(-2);
            var formattedMinute = ('0' + minute).slice(-2);
            var formattedTime = `${formattedHour}:${formattedMinute}:00`;
            dataObject = {
                "medicine_dosage_id": formData.get("medicine_name_id"),
                "pharmacy_id": formData.get("medicine_category_id"),
                "medicine_dosage_id": formData.get("dosage"),
                "ipd_id": formData.get("ipdid"),
                "date": `${formattedDate} ${formattedTime}`,
                "time": formattedTime,
                "remark": formData.get("remark"),
                "generated_by": <?= $data['id'] ?>,
                "Hospital_id": <?= $data['hospital_id'] ?>
            };
            let errormessage = [];
            if (!dataObject.medicine_dosage_id) {
                errormessage.push("Please select medicine");
            }
            if (!dataObject.pharmacy_id) {
                errormessage.push("Please select medicine category");
            }
            if (!dataObject.medicine_dosage_id) {
                errormessage.push("Please select dosage");
            }
            if (!dataObject.ipd_id) {
                errormessage.push("IPD ID is required");
            }
            if (errormessage.length > 0) {
                errorMsg(errormessage.join("<br>"));
                $("#add_medicationbtn").button('reset');
                return;
            }

             sendAjaxRequest(
                    `<?= $api_base_url ?>medication-ipd`,
                    'POST',
                    dataObject,
                    function(response) {
                        handleResponse(response);
                    }
                );

        });
    });





    $(document).ready(function() {
        $("#add_medicationdose").on('submit', function(e) {
            e.preventDefault();
            $("#add_medicationdosebtn").button('loading');

            var formData = new FormData(this);
            var dateStr = formData.get("date");
            var hour = parseInt(formData.get("hour"));
            var minute = parseInt(formData.get("minute"));
            var meridian = formData.get("meridian");

            var dateParts = dateStr.split('/');
            var formattedDate = `${dateParts[2]}-${dateParts[0]}-${dateParts[1]}`;

            if (meridian === "PM" && hour !== 12) {
                hour += 12;
            }
            if (meridian === "AM" && hour === 12) {
                hour = 0;
            }

            var formattedHour = ('0' + hour).slice(-2);
            var formattedMinute = ('0' + minute).slice(-2);
            var formattedTime = `${formattedHour}:${formattedMinute}:00`;

            var dataObject = {
                "medicine_dosage_id": formData.get("dosage"),
                "pharmacy_id": formData.get("medicine_name_id"),
                "ipd_id": formData.get("ipdid"),
                "date": `${formattedDate} ${formattedTime}`,
                "time": formattedTime,
                "remark": formData.get("remark"),
                "generated_by": <?= $data['id'] ?>,
                "Hospital_id": <?= $data['hospital_id'] ?>
            };
            let errormessage = [];
            if (!dataObject.medicine_dosage_id) {
                errormessage.push("Please select dosage");
            }
            if (!dataObject.pharmacy_id) {
                errormessage.push("Please select medicine name");
            }
            if (!dataObject.ipd_id) {
                errormessage.push("IPD ID is required");
            }
            if (errormessage.length > 0) {
                errorMsg(errormessage.join("<br>"));
                $("#add_medicationdosebtn").button('reset');
                return;
            }
            // console.log(JSON.stringify(dataObject));

            sendAjaxRequest(
                    `<?= $api_base_url ?>medication-ipd`,
                    'POST',
                    dataObject,
                    function(response) {
                        handleResponse(response);
                    }
                );
        });
    });

    $(document).ready(function() {
        $("#update_medication").on('submit', function(e) {
            e.preventDefault();
            $("#update_medicationbtn").button('loading');

            var formData = new FormData(this);

            // Convert FormData to a plain object
            var formObject = {};
            formData.forEach(function(value, key) {
                formObject[key] = value;
            });

            // Format date and time
            var dateParts = formObject["date"].split('/');
            var formattedDate = `${dateParts[2]}-${dateParts[0]}-${dateParts[1]}`;

            var hour = parseInt(formObject["hour"]);
            var minute = ('0' + parseInt(formObject["minute"])).slice(-2);
            var meridian = formObject["meridian"];

            // Convert hour to 24-hour format
            if (meridian === "PM" && hour !== 12) {
                hour += 12;
            }
            if (meridian === "AM" && hour === 12) {
                hour = 0;
            }

            var formattedHour = ('0' + hour).slice(-2);
            var formattedTime = `${formattedHour}:${minute}:00`;

            // Construct the new data object
            var dataObject = {
                "medicine_dosage_id": formObject["dosage_id"],
                "pharmacy_id": formObject["medicine_category_id"],
                // "pharmacy_id": 47,
                "date": `${formattedDate} ${formattedTime}`,
                "time": formattedTime,
                "remark": formObject["remark"],
                "Hospital_id": <?= $data['hospital_id'] ?>
            };

            let editid = $('#medication_id').val()

            // console.log(JSON.stringify(dataObject, null, 2)); 

            sendAjaxRequest(
                    '<?= $api_base_url ?>medication-ipd/' + editid,
                    'PATCH',
                    dataObject,
                    function(response) {
                        handleResponse(response);
                    }
                );
        });
    });

    $(document).ready(function(e) {
        $("#formedit").on('submit', (function(e) {
            e.preventDefault();
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/opd_detail_update',
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
                },
                error: function() {}
            });
        }));
    });

    function getBed(bed_group, bed = '', active, htmlid = null) {

        if (htmlid != null) {
            htmlid = htmlid;
        } else {
            htmlid = 'bed_nos';
        }

        var div_data = "";
        $('#' + htmlid).html("<option value='l'><?php echo $this->lang->line('loading') ?></option>");
        $("#" + htmlid).select2("val", 'l');
        $.ajax({
            url: '<?php echo base_url(); ?>admin/setup/bed/getbedbybedgroup',
            type: "POST",
            data: {
                bed_group: bed_group,
                bed_id: bed,
                active: active
            },
            dataType: 'json',
            success: function(res) {
                $.each(res, function(i, obj) {
                    var sel = "";
                    if (bed == obj.id) {
                        sel = "selected";
                    }
                    div_data += "<option " + sel + " value=" + obj.id + ">" + obj.name + "</option>";
                });
                $("#" + htmlid).html("<option value=''><?php echo $this->lang->line('select') ?></option>");
                $('#' + htmlid).append(div_data);
                $("#" + htmlid).select2().select2('val', bed);
            }
        });
    }

    $(document).ready(function() {
        $("form#form_prescription button[type=submit]").click(function() {
            $("button[type=submit]", $(this).parents("form")).removeAttr("clicked");
            $(this).attr("clicked", "true");
        });

        $("#form_prescription").on('submit', function(e) {
            e.preventDefault();
            var sub_btn_clicked = $("button[type=submit][clicked=true]");
            var formData = new FormData(this);
            var prescriptions = [];
            // var Pathology= [];
            // var Radiology = [];
            let index = 0;
            let rowcount = $("input[name='rows[]']");
            rowcount.each(function(index) {
                prescriptions.push({
                    "pharmacy_id": parseInt(formData.get('medicine_' + (index + 1)), 10),
                    "dosage": formData.get('dosage_' + (index + 1)),
                    "dose_interval_id": parseInt(formData.get('interval_dosage_' + (index +
                        1)), 10),
                    "dose_duration_id": parseInt(formData.get('duration_dosage_' + (index +
                        1)), 10),
                    "instruction": formData.get('instruction_' + (index + 1)),
                });
            });
            // const selectedValues = ;
            var mappedData = {
                "ipd_id": parseInt(formData.get('ipd_id'), 10),
                "header_note": formData.get('header_note'),
                "footer_note": formData.get('footer_note'),
                "finding_description": formData.get('finding_description'),
                "is_finding_print": formData.get('finding_print') === 'yes' ? 'yes' : 'no',
                "prescribe_by": parseInt(formData.get('prescribe_by'), 10),
                "prescriptions": prescriptions,
                "Hospital_id": parseInt('<?= $data['hospital_id'] ?>', 10),
                "Pathology": $('#pathologyOpt').val(),
                "Radiology": $('#radiologyOpt').val(),
            };

            var url = '<?= $api_base_url ?>prescription-ipd';
            var method = 'POST';

            let ipd_prescription_basic_id = $("input[name='ipd_prescription_basic_id']").val();
            if (ipd_prescription_basic_id != 0) {
                url += '/' + ipd_prescription_basic_id;
                method = 'PATCH';
            }
            console.log(JSON.stringify(mappedData, null, 2));
            // $.ajax({
            //     url: url,
            //     type: method,
            //     data: JSON.stringify(mappedData),
            //     contentType: 'application/json',
            //     beforeSend: function() {
            //         sub_btn_clicked.button('loading');
            //     },
            //     success: function(response) {
            //         sub_btn_clicked.button('reset');
            //         let data = response;
            //         successMsg(data[0]?.data?.messege || 'Successfully submitted');
            //     },
            //     error: function() {
            //         sub_btn_clicked.button('reset');
            //         errorMsg("An error occurred. Please try again.");
            //     },
            //     complete: function() {
            //         sub_btn_clicked.button('reset');
            //     }
            // });
        });
    });



    $(document).ready(function(e) {
        $("#form_diagnosis").on('submit', (function(e) {
            e.preventDefault();
            $("#form_diagnosisbtn").button('loading');
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/add_diagnosis',
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
                    $("#form_diagnosisbtn").button('reset');
                },
                error: function() {}
            });
        }));
    });

    $(document).ready(function(e) {
        $("#form_doctor").on('submit', (function(e) {
            e.preventDefault();
            $("#form_doctorbtn").button('loading');
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/addipddoctor',
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
                    $("#form_doctorbtn").button('reset');
                },
                error: function() {}
            });
        }));
    });

    $(document).ready(function(e) {
        $("#form_editdiagnosis").on('submit', (function(e) {
            e.preventDefault();
            $("#form_editdiagnosisbtn").button('loading');
            $.ajax({
                url: '<?php echo base_url(); ?>admin/patient/update_diagnosis',
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
                    $("#form_diagnosisbtn").button('reset');
                },
                error: function() {}
            });
        }));
    });

    $(document).on('select2:select', '.medicine_category', function() {
        getMedicine($(this), $(this).val(), 0);
        selected_medicine_category_id = $(this).val();
        var medicine_dosage = getDosages(selected_medicine_category_id);
        $(this).closest('tr').find('.medicine_dosage').html(medicine_dosage);

    });

    $(document).on('select2:select', '.medicine_category_medication', function() {

        var medicine_category = $(this).val();

        $('.medicine_name_medication').html("<option value=''><?php echo $this->lang->line('loading') ?></option>");
        getMedicineForMedication(medicine_category, "");
        getMedicineDosageForMedication(medicine_category);
    });

    function getMedicineForMedication(medicine_category, medicine_id) {
        var div_data = "<option value=''>Select</option>";
        if (medicine_category != "") {
            $.ajax({
                url: base_url + 'admin/pharmacy/get_medicine_name',
                type: "POST",
                data: {
                    medicine_category_id: medicine_category
                },
                dataType: 'json',
                success: function(res) {

                    $.each(res, function(i, obj) {
                        var sel = "";
                        div_data += "<option value='" + obj.id + "'>" + obj.medicine_name + "</option>";

                    });
                    $('.medicine_name_medication').html(div_data);
                    $(".medicine_name_medication").select2("val", medicine_id);
                    $("#mmedicine_edit_id").val(medicine_id).trigger("change");
                }
            });
        }
    }


    function getMedicineDosageForMedication(medicine_category) {

        var div_data = "<option value=''>Select</option>";
        if (medicine_category != "") {
            $.ajax({
                url: base_url + 'admin/pharmacy/get_medicine_dosage',
                type: "POST",
                data: {
                    medicine_category_id: medicine_category
                },
                dataType: 'json',
                success: function(res) {

                    $.each(res, function(i, obj) {
                        var sel = "";
                        div_data += "<option value='" + obj.id + "'>" + obj.dosage + " " + obj.unit +
                            "</option>";

                    });
                    $('.dosage_medication').html(div_data);
                    $(".dosage_medication").select2("val", '');

                }
            });
        }
    }

    function get_dosagename(id) {
        $.ajax({
            url: '<?php echo base_url(); ?>admin/pharmacy/get_dosagename',
            type: "POST",
            data: {
                dosage_id: id
            },
            dataType: 'json',
            success: function(res) {
                if (res) {
                    $('#medicine_dosage_medication').val(res.dosage_unit);
                } else {

                }
            }
        });
    }

    function getMedicine(med_cat_obj, val, medicine_id) {
        var medicine_colomn = med_cat_obj.closest('tr').find('.medicine_name');
        medicine_colomn.html("");
        $.ajax({
            url: '<?php echo base_url(); ?>admin/pharmacy/get_medicine_name',
            type: "POST",
            data: {
                medicine_category_id: val
            },
            dataType: 'json',
            beforeSend: function() {
                medicine_colomn.html("<option value=''><?php echo $this->lang->line('loading') ?></option>");

            },
            success: function(res) {
                var div_data = "<option value=''>Select</option>";
                $.each(res, function(i, obj) {
                    var sel = "";
                    if (medicine_id == obj.id) {
                        sel = "selected";
                    }
                    div_data += "<option value=" + obj.id + " " + sel + ">" + obj.medicine_name +
                        "</option>";

                });

                medicine_colomn.html(div_data);
                medicine_colomn.select2("val", medicine_id);

            }


        });
    }



    function getMedicineDosage(id) {

        var category_selected = $("#medicine_cat" + id).val();
        var arr = category_selected.split('-');
        var category_set = arr[0];
        div_data = '';

        $("#search-dosage" + id).html("<option value='l'><?php echo $this->lang->line('loading') ?></option>");
        $('#search-dosage' + id).select2("val", +id);

        $.ajax({
            type: "POST",
            url: base_url + "admin/pharmacy/get_medicine_dosage",
            data: {
                'medicine_category_id': category_selected
            },
            dataType: 'json',
            success: function(res) {

                $.each(res, function(i, obj) {
                    var sel = "";
                    div_data += "<option value='" + obj.dosage + "'>" + obj.dosage + "</option>";

                });
                $("#search-dosage" + id).html("<option value=''>Select</option>");
                $('#search-dosage' + id).append(div_data);
                $('#search-dosage' + id).select2("val", '');

            }
        });

    }

    function editDiagnosis(id) {

        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/editDiagnosis',
            type: "POST",
            data: {
                id: id
            },
            dataType: 'json',
            success: function(data) {
                // console.log(data);
                $("#eid").val(data.id);
                $("#epatient_id").val(data.patient_id);
                $("#ereporttype").val(data.report_type);
                $("#ereportcenter").val(data.report_center);
                $("#ereportdate").val(data.report_date);
                $("#edescription").val(data.description);
                holdModal('edit_diagnosis');

            },
        });
    }
    var prescription_rows = 2;
    /*$(document).on('click','.add-record',function(){
            var table = document.getElementById("tableID");
            var table_len = (table.rows.length);
            var id = parseInt(table_len);

            var rowCount = $('#tableID tr').length;
            var cat_row="" ;
            var medicine_row="";
            var dose_row="";
            var dose_interval_row="" ;
            var dose_duration_row="";
            var instruction_row="" ;

                if(table_len==0)
                {
                   cat_row ="<label><?php echo $this->lang->line('medicine_category'); ?></label>";
                   medicine_row ="<label><?php echo $this->lang->line('medicine'); ?></label>";
                   dose_row =" <label><?php echo $this->lang->line("dose"); ?></label>";
                   dose_interval_row =" <label><?php echo $this->lang->line("dose_interval"); ?></label>";
                   dose_duration_row =" <label><?php echo $this->lang->line("dose_duration"); ?></label>";
                   instruction_row =" <label><?php echo $this->lang->line("instruction"); ?></label>";
                }

            var div = "<input type='hidden' name='rows[]' value='"+prescription_rows+"' autocomplete='off'><div id=row1><div class='col-lg-2 col-md-4 col-sm-6 col-xs-6'><div'>"+cat_row+"<select class='form-control select2 medicine_category'  name='medicine_cat_"+prescription_rows+"'  id='medicine_cat" + prescription_rows + "'><option value='<?php echo set_value('medicine_category_id'); ?>'><?php echo $this->lang->line('select'); ?></option><?php foreach ($medicineCategory as $dkey => $dvalue) { ?><option value='<?php echo $dvalue["id"]; ?>'><?php echo $dvalue["medicine_category"] ?></option><?php } ?></select></div></div><div class='col-lg-2 col-md-4 col-sm-6 col-xs-6'><div>"+medicine_row+"<select class='form-control select2 medicine_name' data-rowId='"+prescription_rows+"'  name='medicine_"+prescription_rows+"' id='search-query" + prescription_rows + "'><option value='l'><?php echo $this->lang->line('select') ?></option></select><small id='stock_info_"+prescription_rows+"''> </small></div></div><div class='col-lg-2 col-md-4 col-sm-6 col-xs-6'><div>"+dose_row+" <select  class='form-control select2 medicine_dosage' name='dosage_"+prescription_rows+"' id='search-dosage" + prescription_rows + "'><option value='l'><?php echo $this->lang->line('select'); ?></option></select></div></div><div class='col-lg-2 col-md-4 col-sm-6 col-xs-6'><div>"+dose_interval_row+" <select  class='form-control select2 interval_dosage' name='interval_dosage_"+prescription_rows+"' id='search-interval-dosage" + prescription_rows + "'><option value='<?php echo set_value('interval_dosage_id'); ?>'><?php echo $this->lang->line('select'); ?></option><?php foreach ($intervaldosage as $dkey => $dvalue) { ?><option value='<?php echo $dvalue["id"]; ?>'><?php echo $dvalue["name"] ?></option><?php } ?></select></div></div><div class='col-lg-2 col-md-4 col-sm-6 col-xs-6'><div>"+dose_duration_row+"<select class='form-control select2 duration_dosage' name='duration_dosage_"+prescription_rows+"' id='search-duration-dosage" + prescription_rows + "'><option value='<?php echo set_value('duration_dosage_id'); ?>'><?php echo $this->lang->line('select') ?></option><?php foreach ($durationdosage as $dkey => $dvalue) { ?><option value='<?php echo $dvalue["id"]; ?>'><?php echo $dvalue["name"] ?></option><?php } ?></select></div></div><div class='col-lg-2 col-md-4 col-sm-6 col-xs-6'><div>"+instruction_row+"<textarea style='height:28px' name='instruction_"+prescription_rows+"' class=form-control id=description></textarea></div></div></div>";
               var table_row= "<tr id='row" + prescription_rows + "'><td>" + div + "</td><td><label class='displayblock'>&nbsp;</label><button type='button' data-row-id='"+prescription_rows+"' class='closebtn delete_row'><i class='fa fa-remove'></i></button></td></tr>";
            //$(table).append(table_row);
             $('#tableID').append(table_row).
          
     $('.modal-body',"#add_prescription").find('table#tableID').find('.select2').select2();
            prescription_rows++;
        });*/


    $(document).on('click', '.add-record', function() {

        var rowCount = $('#tableID tr').length;
        var cat_row = "";
        var medicine_row = "";
        var dose_row = "";
        var dose_interval_row = "";
        var dose_duration_row = "";
        var instruction_row = "";
        var closebtn_row = "";
        if (rowCount == 0) {
            cat_row = "<label><?php echo $this->lang->line('medicine_category'); ?></label>";
            medicine_row = "<label><?php echo $this->lang->line('medicine'); ?></label> ";
            dose_row = " <label><?php echo $this->lang->line("dose"); ?></label>";
            dose_interval_row = " <label><?php echo $this->lang->line("dose_interval"); ?></label>";
            dose_duration_row = " <label><?php echo $this->lang->line("dose_duration"); ?></label>";
            instruction_row = " <label><?php echo $this->lang->line("instruction"); ?></label>";
            closebtn_row = " <label>&nbsp;</label>";
        }

        var div = "<input type='hidden' name='rows[]' value='" + prescription_rows +
            "' autocomplete='off'><div id=row1><div class='col-lg-2 col-md-4 col-sm-6 col-xs-6'><div col-sm-2 col-xs-6 '>" +
            cat_row + " <select class='form-control select2 medicine_category'  name='medicine_cat_" +
            prescription_rows + "'  id='medicine_cat" + prescription_rows +
            "'><option value='<?php echo set_value('medicine_category_id'); ?>'><?php echo $this->lang->line('select'); ?></option><?php foreach ($medicineCategory as $dkey => $dvalue) { ?><option value='<?php echo $dvalue["id"]; ?>'><?php echo $dvalue["medicine_category"] ?></option><?php } ?></select></div></div><div class='col-lg-2 col-md-4 col-sm-6 col-xs-6'><div>" +
            medicine_row + " <select class='form-control select2 medicine_name' data-rowId='" + prescription_rows +
            "'  name='medicine_" + prescription_rows + "' id='search-query" + prescription_rows +
            "'><option value='l'><?php echo $this->lang->line('select') ?></option></select><small id='stock_info_" +
            prescription_rows + "''> </small></div></div><div class='col-lg-2 col-md-4 col-sm-6 col-xs-6'><div>" +
            dose_row + "<select  class='form-control select2 medicine_dosage' name='dosage_" + prescription_rows +
            "' id='search-dosage" + prescription_rows +
            "'><option value='l'><?php echo $this->lang->line('select'); ?></option></select></div></div><div class='col-lg-2 col-md-4 col-sm-6 col-xs-6'><div>" +
            dose_interval_row + "<select  class='form-control select2 interval_dosage' name='interval_dosage_" +
            prescription_rows + "' id='search-interval-dosage" + prescription_rows +
            "'><option value='<?php echo set_value('interval_dosage_id'); ?>'><?php echo $this->lang->line('select'); ?></option><?php foreach ($intervaldosage as $dkey => $dvalue) { ?><option value='<?php echo $dvalue["id"]; ?>'><?php echo $dvalue["name"] ?></option><?php } ?></select></div></div><div class='col-lg-2 col-md-4 col-sm-6 col-xs-6'><div> " +
            dose_duration_row + "<select class='form-control select2 duration_dosage' name='duration_dosage_" +
            prescription_rows + "' id='search-duration-dosage" + prescription_rows +
            "'><option value='<?php echo set_value('duration_dosage_id'); ?>'><?php echo $this->lang->line('select') ?></option><?php foreach ($durationdosage as $dkey => $dvalue) { ?><option value='<?php echo $dvalue["id"]; ?>'><?php echo $dvalue["name"] ?></option><?php } ?></select></div></div><div class='col-lg-2 col-md-4 col-sm-6 col-xs-6'><div>" +
            instruction_row + "<textarea style='height:28px' name='instruction_" + prescription_rows +
            "' class=form-control id=description></textarea></div></div></div>";

        var row = "<tr id='row" + prescription_rows + "'><td>" + div + "</td><td>" + closebtn_row +
            "<button type='button' onclick='delete_row(" + prescription_rows + ")' data-row-id='" +
            prescription_rows + "' class='closebtn delete_row'><i class='fa fa-remove'></i></button></td></tr>";
        $('#tableID').append(row).find('.select2').select2();
        prescription_rows++;
    });


    $(document).on('click', '.delete_row', function(e) {

        var del_row_id = $(this).data('rowId');
        $("#row" + del_row_id).remove();



    });


    $(document).ready(function(e) {
        $("#add_timeline").on('submit', function(e) {
            e.preventDefault();
            $("#add_timelinebtn").button('loading');

            var formElement = $(this);
            var fileInput = formElement.find('#timeline_doc_id')[0];
            var fileUploadUrl = 'https://phr-api.plenome.com/file_upload';

            if (fileInput && fileInput.files.length > 0) {
                var fileSize = fileInput.files[0].size / (1024 * 1024);
                if (fileSize > 10) {
                    errorMsg("File size must be less than 10MB.");
                    $("#add_timelinebtn").button('reset');
                    return;
                }
            }

            uploadFile(formElement, fileUploadUrl, function(result) {
                var formData = new FormData(formElement[0]);
                var dataObject = {};
                formData.forEach(function(value, key) {
                    dataObject[key] = value;
                });

                let errorMessage = [];
                if (!dataObject["timeline_title"]) {
                    errorMessage.push("Title is required");
                }

                if (errorMessage.length > 0) {
                    errorMsg(errorMessage.join("\n"));
                    $("#add_timelinebtn").button('reset');
                    return;
                }

                var transformedData = {
                    patient_id: parseInt(dataObject["patient_id"]),
                    title: dataObject["timeline_title"] || " ",
                    timeline_date: moment(dataObject["timeline_date"], "DD/MM/YYYY").format("YYYY-MM-DD HH:mm:ss") || "",//formatDate(dataObject["timeline_date"]),
                    description: dataObject["timeline_desc"] || "",
                    document: result?.data || "",
                    status: dataObject["visible_check"] || "yes",
                    generated_users_type: "staff",
                    hospital_id: <?= $data['hospital_id'] ?>
                };

                 sendAjaxRequest(
                    `<?= $api_base_url ?>timeline-ipd`,
                    'POST',
                    transformedData,
                    function(response) {
                        handleResponse(response);
                    }
                );
            });
        });

        function uploadFile(formElement, apiUrl, callback) {
            var clicked_submit_btn = formElement.find(':submit');
            var formData = new FormData();
            var fileInput = formElement.find('#timeline_doc_id')[0];

            if (fileInput && fileInput.files.length > 0) {
                formData.append('file', fileInput.files[0]);

                $.ajax({
                    url: apiUrl,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: function() {
                        clicked_submit_btn.button('loading');
                    },
                    success: function(response) {
                        callback({
                            status: response.status,
                            message: response.message,
                            data: response.data
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        callback({
                            status: 'error',
                            error: error
                        });
                    },
                    complete: function() {
                        setTimeout(function() {
                            clicked_submit_btn.button('reset');
                        }, 3000);
                    }
                });
            } else {
                callback({
                    status: 'success',
                    data: "None"
                });
            }
        }

        function formatDate(dateStr) {
            var date = new Date(dateStr);
            return date.toISOString().slice(0, 19).replace('T', ' ');
        }
    });





    $(document).ready(function(e) {
        $("#add_bill").on('submit', (function(e) {
            if (confirm('<?php echo $this->lang->line('confirm') ?>')) {
                $("#save_button").button('loading');
                e.preventDefault();
                $.ajax({
                    url: "<?php echo site_url("admin/payment/addbill") ?>",
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
                            window.location.href =
                                '<?php echo base_url(); ?>admin/patient/discharged_patients';
                        }
                        $("#save_button").button('reset');

                    },
                    error: function(e) {
                        alert("Fail");

                    }
                });
            } else {
                return false;
            }

        }));
    });


    function delete_timeline(id) {
        var patient_id = $("#patient_id").val();
        if (confirm('<?php echo $this->lang->line("delete_confirm") ?>')) {
            
                     sendAjaxRequest(
                        '<?= $api_base_url ?>timeline-ipd/' + id +
                                '?hospital_id=<?= $data['hospital_id'] ?>',
                        'DELETE',
                        {},
                        function(response) {
                            handleResponse(response,false);
                        }
                    );                    
                
        }
    }
    $(document).ready(function(e) {

        $(function() {
            var hash = window.location.hash;
            hash && $('ul.nav-tabs a[href="' + hash + '"]').tab('show');

            $('.nav-tabs a').click(function(e) {
                $(this).tab('show');
                var scrollmem = $('body').scrollTop();
                window.location.hash = this.hash;
                $('html,body').scrollTop(scrollmem);
            });
        });


    });

    function editTimeline(id) {

        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/editTimeline',
            type: "POST",
            data: {
                id: id
            },
            dataType: 'json',
            success: function(data) {
                const datestr = data.timeline_date;
                const [year, month, day] = datestr.split('-');
                var dt = `${day}/${month}/${year}`;
                
                console.log(data);
                $("#etimelineid").val(data.id);
                $("#epatientid").val(data.patient_id);
                $("#etimelinetitle").val(data.title);
                $("#oldfiles").val(data.document);
                $("#etimelinedate").val(dt);

                $("#timelineedesc").val(data.description);
                if (data.status == '') {

                } else {
                    $("#evisible_check").attr('checked', true);
                }

                holdModal('myTimelineEditModal');

            },
        });
    }

    function editNursenote(id) {

        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/editNursenote',
            type: "POST",
            data: {
                id: id
            },
            dataType: 'json',
            success: function(data) {
                console.log(data);
                var notedate = moment(data.note_date, "MM/DD/YYYY HH:mm").format("DD/MM/YYYY") || "";//formatDate(data.note_date);
                $("#nurse_id").val(data.nid);
                $("#endate").val(notedate);
                $("#enote").val(data.note);
                $("#ecomment").val(data.comment);
                $('select[id="edit_nurse"] option[value="' + data.staff_id + '"]').attr("selected", "selected");
                $("#edit_nurse").select2().select2('val', data.staff_id);
                $('#customfieldnurse').html(data.custom_fields_value);
                holdModal('nursenoteEditModal');
            },
        });
    }

    function editConsultantRegister(id) {

        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/editConsultantRegister',
            type: "POST",
            data: {
                id: id
            },
            dataType: 'json',
            success: function(data) {
                $("#instruction_id").val(data.id);
                // $("#ecpatient_id").val(data.patient_id);
                $("#ecdate").val(data.date);
                $("#ecinsdate").val(data.ins_date);
                $("#ecinstruction").val(data.instruction);
                $('select[id="editdoctor_field"] option[value="' + data.cons_doctor + '"]').attr("selected",
                    "selected");
                $("#editdoctor_field").select2().select2('val', data.cons_doctor);
                $('#customfieldconsult').html(data.custom_fields_value);
                holdModal('edit_instruction');
            },
        });
    }

    function addcommentNursenote(id, ipdid) {
        $("#nurse_noteid").val(id);
        holdModal('nursenoteCommentModal');
    }

    $(document).ready(function() {
        $("#form_operationtheatre").on('submit', function(e) {
            e.preventDefault();
            var doctorId = $("#consultant_doctorid").val();
            $("#consultant_doctorname").val(doctorId);
            $("#form_operationtheatrebtn").button('loading');
            var formData = new FormData(this);
            let errorMessage = [];
            if (!formData.get('operation_name')) {
                errorMessage.push('Please enter operation name.');
            }
            if (!formData.get('date')) {
                errorMessage.push('Please select date.');
            }
            if (!formData.get('consultant_doctor')) {
                errorMessage.push('Please select consultant doctor.');
            }
            if (errorMessage.length > 0) {
                errorMsg(errorMessage.join("<br>"));
                $("#form_operationtheatrebtn").button('reset');
                return false;
            }
            var dataObject = {
                "ipd_details_id": formData.get('ipdid'),
                "operation_id": formData.get('operation_name'),
                "date": convertDateFormat(formData.get('date')),
                "consultant_doctor": parseInt(formData.get('consultant_doctor'), 10),
                "ass_consultant_1": formData.get('ass_consultant_1') || '',
                "ass_consultant_2": formData.get('ass_consultant_2') || '',
                "anesthetist": formData.get('anesthetist') || '',
                "anaethesia_type": formData.get('anaethesia_type') || '',
                "ot_technician": formData.get('ot_technician') || '',
                "ot_assistant": formData.get('ot_assistant') || '',
                "result": formData.get('ot_result') || '',
                "remark": formData.get('ot_remark') || '',
                "Hospital_id": <?= $data['hospital_id'] ?>
            };

             sendAjaxRequest(
                    `<?= $api_base_url ?>operation-ipd/`,
                    'POST',
                    dataObject,
                    function(response) {
                        handleResponse(response);
                    }
                );

        });
    });


    function convertDateFormat(dateString) {
        // Convert date format to 'YYYY-MM-DD HH:mm:ss'
        let [date, time] = dateString.split(' ');
        let [month, day, year] = date.split('/');
        return `${year}-${month}-${day} ${time}`;
    }

    $(document).ready(function() {
        $("#edit_timeline").on("submit", function(e) {
            e.preventDefault();
            $("#edit_timelinebtn").button("loading");

            var patient_id = $("#etimelineid").val();
            var formElement = $(this);
            var fileUploadUrl = "https://phr-api.plenome.com/file_upload";

            uploadFile(formElement, fileUploadUrl, function(result) {
                try {
                    var fileDocument = result.status == "success" ? result.data : $("#oldfiles")
                        .val();
                    var formData = new FormData(formElement[0]);
                    var dataObject = {};

                    formData.forEach(function(value, key) {
                        dataObject[key] = value;
                    });

                    var transformedData = {
                        patient_id: parseInt(dataObject["patient_id"]),
                        title: dataObject["timeline_title"] || "Normal",
                        timeline_date: moment(dataObject["timeline_date"], "DD/MM/YYYY").format("YYYY-MM-DD HH:mm:ss") || "",//formatDate(dataObject["timeline_date"]),
                        description: dataObject["timeline_desc"] || "None",
                        document: fileDocument || "None",
                        status: dataObject["visible_check"] || "none",
                        generated_users_type: "staff",
                        hospital_id: <?= $data['hospital_id'] ?>
                    };

                     sendAjaxRequest(
                        "<?= $api_base_url ?>timeline-ipd/" + patient_id,
                        'PATCH',
                        transformedData,
                        function(response) {
                            handleResponse(response);
                        }
                    );
                    
                } catch (error) {
                    console.error("Unexpected error:", error);
                    errorMsg("An unexpected error occurred. Please try again.");
                    $("#edit_timelinebtn").button("reset");
                }
            });

            function uploadFile(formElement, apiUrl, callback) {
                var clicked_submit_btn = formElement.find(":submit");
                var formData = new FormData();
                var fileInput = formElement.find("#etimeline_doc_id")[0];

                if (fileInput && fileInput.files.length > 0) {
                    var file = fileInput.files[0];
                    if (file.size > 10 * 1024 * 1024) {
                        errorMsg("File size exceeds 10MB. Please select a smaller file.");
                        $("#edit_timelinebtn").button("reset");
                        return;
                    }

                    formData.append("file", file);
                } else {
                    callback({
                        status: "success",
                        data: $("#oldfiles").val(),
                    });
                    return;
                }

                $.ajax({
                    url: apiUrl,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    beforeSend: function() {
                        clicked_submit_btn.button("loading");
                    },
                    success: function(response) {
                        callback({
                            status: response.status,
                            data: response.data,
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Upload Error:", error);
                        alert("File upload failed. Please try again.");
                        callback({
                            status: "error",
                            error: error,
                        });
                    },
                    complete: function() {
                        setTimeout(() => {
                            clicked_submit_btn.button("reset");
                        }, 3000);
                    },
                });
            }

            function formatDate(dateStr) {
                try {
                    var date = new Date(dateStr);
                    return date.toISOString().slice(0, 19).replace("T", " ");
                } catch (error) {
                    console.error("Date formatting error:", error);
                    return "";
                }
            }
        });
    });






    function editot(id) {
        var date_format =
            '<?php echo $result = strtr($this->customlib->getHospitalDateFormat(), ['d' => 'dd', 'm' => 'mm', 'Y' => 'yyyy',]) ?>';
        $.ajax({
            url: '<?php echo base_url(); ?>admin/operationtheatre/getotDetails',
            type: "POST",
            data: {
                id: id
            },
            dataType: 'json',
            success: function(data) {
                console.log(data);
                $("#otid").val(data.id);
                $('#eoperation_category').select2().select2('val', data.category_id);

                getcategory(data.category_id, data.operation_id);
                $("#edate").val(data.otdate);
                $("#eass_consultant_1").val(data.ass_consultant_1);
                $("#eass_consultant_2").val(data.ass_consultant_2);
                $("#eanesthetist").val(data.anesthetist);
                $("#eanaethesia_type").val(data.anaethesia_type);
                $("#eot_technician").val(data.ot_technician);
                $("#eot_assistant").val(data.ot_assistant);
                $("#custom_field_ot").html(data.custom_fields_value);
                $("#eot_remark").val(data.remark);
                $("#eot_result").val(data.result);
                $("#edit_operationtheatre #econsultant_doctorid").select2().select2('val', data
                    .consultant_doctor);
                $("#edit_operationtheatre #eoperation_name").select2().select2('val', data.operation_id);

                holdModal('edit_operationtheatre');

            },
        });
    }

    $(document).ready(function() {
        $("#form_editoperationtheatre").on('submit', function(e) {
            e.preventDefault();

            $("#form_editoperationtheatrebtn").button('loading');

            var doctorId = $("#cons_doctor").val();
            $("#cons_name").val(doctorId);

            var formData = new FormData(this);
            let errorMessage = [];
            if (!formData.get('eoperation_name')) {
                errorMessage.push("Operation Name is required");
            }
            if (!formData.get('date')) {
                errorMessage.push("Date is required");
            }
            if (!formData.get('consultant_doctor')) {
                errorMessage.push("Consultant Doctor is required");
            }
            if (errorMessage.length > 0) {
                errorMsg(errorMessage.join('<br>'));
                $("#form_editoperationtheatrebtn").button('reset');
                return false;
            }
            var dataObject = {
                "operation_id": formData.get('eoperation_name'),
                "date": convertDateFormat(formData.get('date')),
                "consultant_doctor": parseInt(formData.get('consultant_doctor'), 10),
                "ass_consultant_1": formData.get('ass_consultant_1'),
                "ass_consultant_2": formData.get('ass_consultant_2'),
                "anesthetist": formData.get('anesthetist'),
                "anaethesia_type": formData.get('anaethesia_type'),
                "ot_technician": formData.get('ot_technician'),
                "ot_assistant": formData.get('ot_assistant'),
                "result": formData.get('eot_result'),
                "remark": formData.get('eot_remark'),
                "Hospital_id": <?= $data['hospital_id'] ?>
            };

            let opdid = $('#otid').val();

             sendAjaxRequest(
                    '<?= $api_base_url ?>operation-ipd/' + opdid,
                    'PATCH',
                    dataObject,
                    function(response) {
                        handleResponse(response);
                    }
                );
        });
    });

    function convertDateFormat(dateString) {
        let [date, time] = dateString.split(' ');
        let [month, day, year] = date.split('/');
        return `${year}-${month}-${day} ${time}`;
    }


    $(document).ready(function() {
        $("#edit_nursenote").on('submit', function(e) {
            e.preventDefault();
            $("#edit_nursenotebtn").button('loading');

            var formData = new FormData(this);
            var date = moment(formData.get("date"), "DD/MM/YYYY hh:mm A").format("YYYY-MM-DD HH:mm:ss") || "";//formatDate(formData.get("date"));
            var note = formData.get("note") || "";
            var comment = formData.get("comment") || "";

            var data = {
                "date": date || "",
                "ipd_id": $('#ipdid').val() || "",
                "staff_id": $('#edit_nurse').val() || "",
                "note": note,
                "comment": comment,
                "Hospital_id": <?= $data['hospital_id'] ?> || ""
            };

            var errorMessages = [];
            if (!date) errorMessages.push('Date is required');
            if (!note) errorMessages.push('Note is required');
            if (!/^[a-zA-Z0-9\s]+$/.test(note)) errorMessages.push(
                'Note must only contain letters and numbers');
            if (!/^[a-zA-Z0-9\s]+$/.test(comment)) errorMessages.push(
                'Comment must only contain letters and numbers');

            if (errorMessages.length > 0) {
                errorMsg(errorMessages.join('<br>'));
                setTimeout(() => {
                    $("#edit_nursenotebtn").button('reset');
                }, 3000);
                return;
            }

            let editid = $('#nurse_id').val();

             sendAjaxRequest(
                    "<?= $api_base_url ?>nurse-notes-ipd/" + editid,
                    'PATCH',
                    data,
                    function(response) {
                        handleResponse(response);
                    }
                );

        });

        function formatDate(dateString) {
            if (!dateString) return "";
            var date = new Date(dateString);
            var year = date.getFullYear();
            var month = ('0' + (date.getMonth() + 1)).slice(-2);
            var day = ('0' + date.getDate()).slice(-2);
            var hours = ('0' + date.getHours()).slice(-2);
            var minutes = ('0' + date.getMinutes()).slice(-2);
            var seconds = ('0' + date.getSeconds()).slice(-2);
            return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
        }
    });




    $(document).ready(function() {
        $("#comment_nursenote").on('submit', function(e) {
            e.preventDefault();
            $("#comment_nursenotebtn").button('loading');

            var formData = new FormData(this);

            var data = {
                "nurse_note_id": formData.get("nurseid") || 11,
                "comment_staffid": <?= $data['id'] ?>,
                "comment_staff": formData.get("comment_staff"),
                "Hospital_id": <?= $data['hospital_id'] ?>
            };
            var errorMessages = [];
            if (!/^[a-zA-Z0-9\s]+$/.test(data.comment_staff)) errorMessages.push(
                'Comment staff must only contain letters and numbers');
            if (errorMessages.length > 0) {
                errorMsg(errorMessages.join('<br>'));
                $("#edit_nursenotebtn").button('reset');
                return;
            }
            
             sendAjaxRequest(
                    "<?= $api_base_url ?>nurse-notes-ipd/comment",
                    'POST',
                    data,
                    function(response) {
                        handleResponse(response);
                    }
                );
        });
    });

    function edit_prescription(id) {
        $('#edit_prescription_title').html('<?php echo $this->lang->line('edit_prescription'); ?>');
        $.ajax({
            url: base_url + 'admin/prescription/editipdPrescription',
            dataType: 'JSON',
            data: {
                'prescription_id': id
            },
            type: "POST",
            beforeSend: function() {

            },
            success: function(res) {
                $('#prescriptionview').modal('hide');
                $('.modal-body', "#add_prescription").html(res.page);
                var medicineTable = $('.modal-body', "#add_prescription").find('table#tableID');
                $('.select2').select2();
                medicineTable.find('.select2').select2();
                $('.modal-body', "#add_prescription").find('.multiselect2').select2({
                    placeholder: 'Select',
                    allowClear: false,
                    minimumResultsForSearch: 2
                });

                prescription_rows = medicineTable.find('tr').length + 1;

                medicineTable.find("tbody tr").each(function() {

                    var medicine_category_obj = $(this).find("td select.medicine_category");
                    var post_medicine_category_id = $(this).find("td input.post_medicine_category_id")
                        .val();
                    var post_medicine_id = $(this).find("td input.post_medicine_id").val();
                    var dosage_id = $(this).find("td input.post_dosage_id").val();
                    var medicine_dosage = getDosages(post_medicine_category_id, dosage_id);

                    $(this).find('.medicine_dosage').html(medicine_dosage);
                    $(this).find('.medicine_dosage').select2().select2('val', dosage_id);

                    getMedicine(medicine_category_obj, post_medicine_category_id, post_medicine_id);

                });
                $('#add_prescription').modal('show');
            },

            complete: function() {
                $(function() {
                    $("#compose-textareas,#compose-textareanew").wysihtml5({
                        toolbar: {
                            "image": false,
                        }
                    });
                });

            },
            error: function(xhr) { // if error occured
                alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");


            }
        });
    }

    function view_prescription(id, ipdid, discharged = '') {

        $.ajax({
            url: base_url + 'admin/prescription/getIPDPrescription/',
            dataType: 'JSON',
            data: {
                'prescription_id': id
            },
            type: "POST",
            beforeSend: function() {


            },
            success: function(res) {
                $("#getdetails_prescription").html(res.page);
            },
            error: function(xhr) { // if error occured
                alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");


            },
            complete: function() {

            }
        });

        if (discharged !== "yes") {
            $('#edit_deleteprescription').html(`
                <?php if ($this->rbac->hasPrivilege('ipd_prescription', 'can_view')) { ?>
                    <a href='#prescription' onclick='printprescription(${id})' data-toggle='tooltip' data-original-title='<?php echo $this->lang->line('print'); ?>'>
                        <i class='fa fa-print'></i>
                    </a>
                <?php } ?>
                <?php if ($this->rbac->hasPrivilege('ipd_prescription', 'can_edit')) { ?>
                    <a href='#prescription' onclick='edit_prescription(${id})' data-target='#edit_prescription' data-toggle='tooltip' data-original-title='<?php echo $this->lang->line('edit'); ?>'>
                        <i class='fa fa-pencil'></i>
                    </a>
                <?php } ?>
                <?php if ($this->rbac->hasPrivilege('ipd_prescription', 'can_delete')) { ?>
                    <a onclick='delete_prescription(${id})' data-toggle='tooltip' data-original-title='<?php echo $this->lang->line('delete'); ?>'>
                        <i class='fa fa-trash'></i>
                    </a>
                <?php } ?>
            `);
        } else {
            $('#edit_deleteprescription').html(`
                <?php if ($this->rbac->hasPrivilege('ipd_prescription', 'can_view')) { ?>
                    <a href='#prescription' onclick='printprescription(${id})' data-toggle='tooltip' data-original-title='<?php echo $this->lang->line('print'); ?>'>
                        <i class='fa fa-print'></i>
                    </a>
                <?php } ?>
            `);
        }



        holdModal('prescriptionview');
    }


    $(document).on('change', '.charge_type', function() {
        var charge_type = $(this).val();

        $('.charge_category').html("<option value=''><?php echo $this->lang->line('loading') ?></option>");

        getcharge_category(charge_type, "");

    });


    function getcharge_category(charge_type, charge_category) {

        var div_data = "";
        if (charge_type != "") {

            $.ajax({
                url: base_url + 'admin/charges/get_charge_category',
                type: "POST",
                data: {
                    charge_type: charge_type
                },
                dataType: 'json',
                success: function(res) {
                    $.each(res, function(i, obj) {
                        var sel = "";
                        div_data += "<option value='" + obj.id + "'>" + obj.name + "</option>";
                    });
                    $('.charge_category').html(
                        "<option value=''><?php echo $this->lang->line('select'); ?></option>");
                    $('.charge_category').append(div_data);
                    $('.charge_category').select2("val", charge_category);
                    $('#editcharge_category').select2("val", charge_category);
                }
            });
        }
    }

    $(document).on('select2:select', '.charge_category', function() {

        var charge_category = $(this).val();

        $('.charge').html("<option value=''><?php echo $this->lang->line('loading'); ?></option>");
        getchargecode(charge_category, "");
    });

    $(document).on('select2:select', '.medicine_name', function() {

        var row_id_val = $(this).data('rowid');
        $.ajax({
            type: "POST",
            url: base_url + "admin/pharmacy/get_medicine_stockinfo",
            data: {
                'pharmacy_id': $(this).val()
            },
            dataType: 'json',
            success: function(res) {
                $('#stock_info_' + row_id_val).html(res);
            }
        });

    });

    function delete_prescription(prescription_id) {

        if (confirm('<?php echo $this->lang->line("are_you_sure_you_want_to_delete_this"); ?>')) {

            sendAjaxRequest(
                    '<?= $api_base_url ?>prescription-ipd/' + prescription_id +
                        '?Hospital_id=<?= $data['hospital_id'] ?>',
                    'DELETE',
                    {},
                    function(response) {
                        handleResponse(response);
                    }
                );

        }
    }

    function getchargecode(charge_category, charge_id) {
        // console.log(charge_id);
        var div_data = "<option value=''><?php echo $this->lang->line('select'); ?></option>";
        if (charge_category != "") {
            $.ajax({
                url: base_url + 'admin/charges/getchargeDetails',
                type: "POST",
                data: {
                    charge_category: charge_category
                },
                dataType: 'json',
                success: function(res) {

                    $.each(res, function(i, obj) {
                        var sel = "";
                        div_data += "<option value='" + obj.id + "'>" + obj.name + "</option>";

                    });
                    $('.charge').html(div_data);
                    $(".charge").select2("val", charge_id);
                    $("#editcharge_id").select2("val", charge_id);

                }
            });
        }
    }

    $(document).on('click', '.print_charge', function() {


        var $this = $(this);
        var record_id = $this.data('recordId')
        $this.button('loading');
        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/printCharge',
            type: "POST",
            data: {
                'id': record_id,
                'type': 'ipd'
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

    $(document).on('select2:select', '.charge', function() {
        var charge = $(this).val();
        var orgid = $('#organisation_id').val();
        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/getChargeById',
            type: "POST",
            data: {
                charge_id: charge,
                organisation_id: orgid
            },
            dataType: 'json',
            success: function(res) {

                if (res) {
                    var quantity = $('#qty').val();
                    $('#apply_charge').val(parseFloat(res.standard_charge) * quantity);
                    $('#standard_charge').val(res.standard_charge);
                    $('#schedule_charge').val(res.org_charge);
                    $('#charge_tax').val(res.percentage);
                    var standard_charge = res.standard_charge;
                    var schedule_charge = res.org_charge;
                    var discount_percent = 0;
                    var total_charge = (schedule_charge == "" || schedule_charge == "0.00") ?
                        standard_charge : schedule_charge;
                    var apply_charge = isNaN(parseFloat(total_charge) * parseFloat(quantity)) ? 0 :
                        parseFloat(total_charge) * parseFloat(quantity);
                    var discount_amount = (apply_charge * discount_percent) / 100;
                    // $('#discount').val(discount_amount);
                    $('#apply_charge').val(apply_charge);
                    var final_amount = apply_charge - discount_amount;
                    $('#ipd_tax').val(((final_amount * res.percentage) / 100));

                    $('#final_amount').val(final_amount + ((final_amount * res.percentage) / 100));


                }
            }
        });
    });



    $(document).on('change keyup input paste', '#qty', function() {
        var quantity = $(this).val();
        var standard_charge = $('#standard_charge').val();
        var schedule_charge = $('#schedule_charge').val();
        var tax_percent = $('#charge_tax').val();
        var total_charge = (schedule_charge == "") ? standard_charge : schedule_charge;
        var apply_charge = isNaN(parseFloat(total_charge) * parseFloat(quantity)) ? 0 : parseFloat(total_charge) *
            parseFloat(quantity);
        $('#apply_charge').val(apply_charge.toFixed(2));
        var discount_percent = 0;
        var discount_amount = isNaN((apply_charge * discount_percent) / 100) ? 0 : (apply_charge *
            discount_percent) / 100;
        var final_amount = apply_charge - discount_amount;
        $('#discount').val(discount_amount);
        $('#ipd_tax').val(((final_amount * tax_percent) / 100).toFixed(2));
        $('#final_amount').val((final_amount + ((final_amount * tax_percent) / 100)).toFixed(2));
    });
    $(document).on('change keyup input paste', '#editqty', function() {
        var quantity = $(this).val();
        var standard_charge = $('#editstandard_charge').val();
        var schedule_charge = $('#editschedule_charge').val();
        var tax_percent = $('#editcharge_tax').val();
        var total_charge = (schedule_charge == "") ? standard_charge : schedule_charge;
        var apply_charge = isNaN(parseFloat(total_charge) * parseFloat(quantity)) ? 0 : parseFloat(total_charge) *
            parseFloat(quantity);
        $('#editapply_charge').val(apply_charge.toFixed(2));

        var discount_percent = 0;
        var discount_amount = isNaN((apply_charge * discount_percent) / 100) ? 0 : (apply_charge *
            discount_percent) / 100;
        var final_amount = apply_charge - discount_amount;

        $('#discount').val(discount_amount);
        $('#edittax').val(((final_amount * tax_percent) / 100).toFixed(2));
        $('#editfinal_amount').val((final_amount + ((final_amount * tax_percent) / 100)).toFixed(2));
    });

    function calculate() {

        var discount_percent = $("#discount_percent").val();
        var tax_percent = $("#tax_percent").val();
        var other_charge = $("#other_charge").val();
        var paid_amount = $("#paid_amountpa").val();

        var total_amount = $("#total_amount").val();

        var subtotal_amount = parseFloat(total_amount) + parseFloat(other_charge);
        if (discount_percent != '') {
            var discount = (subtotal_amount * discount_percent) / 100;
            $("#discount").val(discount.toFixed(2));
        } else {
            var discount = $("#discount").val();

        }

        if (tax_percent != '') {
            var tax = ((subtotal_amount - discount) * tax_percent) / 100;
            $("#tax").val(tax.toFixed(2));
        } else {
            var tax = $("#tax").val();
        }

        var gross_total = parseFloat(total_amount) + parseFloat(other_charge) + parseFloat(tax) - parseFloat(discount);
        var net_amount = parseFloat(total_amount) + parseFloat(other_charge) + parseFloat(tax) - parseFloat(discount);
        var net_amount_payble = parseFloat(net_amount) - parseFloat(paid_amount);
        $("#gross_total").val(gross_total.toFixed(2));

        $("#grass_amount").val(net_amount.toFixed(2));
        $("#grass_amount_span").html(net_amount.toFixed(2));
        $("#net_amount").val(net_amount_payble.toFixed(2));
        $("#net_amount_span").html(net_amount_payble.toFixed(2));
        $("#net_amount_payble").val(net_amount_payble.toFixed(2));
        $("#save_button").show();
        $("#printBill").show();
    }

    function revert(patient_id, billid, bedid, ipdid) {


        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/revertBill',
            type: "POST",
            data: {
                patient_id: patient_id,
                bill_id: billid,
                bed_id: bedid,
                ipdid: ipdid
            },
            dataType: 'json',
            success: function(res) {
                if (res.status == "fail") {
                    var message = "";
                    errorMsg(res.message);
                } else {
                    successMsg(res.message);
                    window.location.href = '<?php echo base_url() ?>admin/patient/ipdsearch';
                }
            }
        });

    }



    function checkbed(patient_id, billid, bedid, ipdid) {
        var v = 'false';
        if (confirm('<?php echo $this->lang->line('are_you_sure') ?>')) {
            $.ajax({
                url: '<?php echo base_url(); ?>admin/setup/bed/checkbed',
                type: "POST",
                data: {
                    bed_id: bedid
                },
                dataType: 'json',
                success: function(res) {

                    if (res.status == "fail") {
                        $("#alot_bed").modal('show');
                    } else {
                        revert(patient_id, billid, bedid, ipdid)
                    }

                }
            });

        }

    }

    $(document).ready(function() {
        $("#consultant_register_form").on('submit', function(e) {
            e.preventDefault();
            $('#consultant_registerbtn').button('loading');
            var doctor_id = $("#doctor_field").val();
            $("#doctor_set").val(doctor_id);

            var formData = new FormData(this);
            errorMessages = [];
            if (!formData.get('date')) {
                errorMessages.push("Please enter a date");
            }
            if (!formData.get('insdate')) {
                errorMessages.push("Please enter an insurance date");
            }
            if (!formData.get('doctor')) {
                errorMessages.push("Please select a doctor");
            }
            if (!formData.get('instruction')) {
                errorMessages.push("Please enter consultation instruction");
            }
            if (errorMessages.length > 0) {
                errorMsg(errorMessages.join("<br>"));
                setTimeout(() => {
                    $("#consultant_registerbtn").button('reset');
                }, 3000);
                return false;
            }
            var dataObject = {
                "ipd_id": formData.get('ipdid'),
                "date": formatDate(formData.get('date')),
                "ins_date": formatDate(formData.get('insdate')),
                "cons_doctor": parseInt(formData.get('doctor'), 10),
                "instruction": formData.get('instruction'),
                "Hospital_id": parseInt(formData.get('hospital_id'), 10),
                "patient_id": formData.get('patient_id'),
                'Hospital_id': <?= $data['hospital_id'] ?>,
            };

            $("#consultant_registerbtn").button('loading');
            console.log(JSON.stringify(dataObject));

             sendAjaxRequest(
                    `<?= $api_base_url ?>consultant-register-ipd`,
                    'POST',
                    dataObject,
                    function(response) {
                        handleResponse(response);
                    }
                );

        });

        function formatDateTime(dateTime) {
            var date = new Date(dateTime);
            return date.toISOString().slice(0, 19).replace('T', ' ');
        }

        function formatDate(date) {
            // var dateObj = new Date(date);
            var parts = date.split('/');
            var day = parseInt(parts[0], 10);
            var month = parseInt(parts[1], 10) - 1;
            var year = parseInt(parts[2], 10);

            var dateObj = new Date(year, month, day);
            const yyyy = dateObj.getFullYear();
            const mm = String(dateObj.getMonth() + 1).padStart(2, '0');
            const dd = String(dateObj.getDate()).padStart(2, '0');

            return `${yyyy}-${mm}-${dd}`;
        }
    });


    $(document).ready(function() {
        $("#editconsultant_register_form").on('submit', function(e) {
            e.preventDefault();

            var doctor_id = $("#editdoctor_field").val();
            $("#editdoctor_set").val(doctor_id);
            // $('#editconsultant_registerbtn').button('loading');

            var formData = new FormData(this);
            var dataObject = {};
            formData.forEach(function(value, key) {
                dataObject[key] = value;
            });

            var errorMessages = [];
            if (!dataObject["date"]) errorMessages.push("Please enter a date");
            if (!dataObject["insdate"]) errorMessages.push("Please enter an insurance date");
            if (!dataObject["doctor"]) errorMessages.push("Please select a doctor");
            if (!dataObject["instruction"]) errorMessages.push("Please enter consultation instruction");

            if (errorMessages.length > 0) {
                errorMsg(errorMessages.join("<br>"));
                setTimeout(() => {
                    $("#editconsultant_registerbtn").button('reset');
                }, 3000);
                return;
            }

            var formattedData = {
                "date": formatDateTime(dataObject["date"]) || "",
                "ins_date": formatDate(dataObject["insdate"]) || "",
                "cons_doctor": parseInt(dataObject["doctor"], 10) || 0,
                "instruction": dataObject["instruction"] || "No instruction",
                "Hospital_id": <?= $data['hospital_id'] ?> || ""
            };

            sendAjaxRequest(
                    '<?= $api_base_url ?>consultant-register-ipd/' + dataObject["instruction_id"],
                    'PATCH',
                    formattedData,
                    function(response) {
                        handleResponse(response);
                    }
                );
        });

        function formatDateTime(dateTimeStr) {
            if (!dateTimeStr) return "";
            var date = new Date(dateTimeStr);
            return date.toISOString().slice(0, 19).replace('T', ' ');
        }

        function formatDate(dateStr) {
            if (!dateStr) return "";
            var date = new Date(dateStr);
            return date.toISOString().slice(0, 10);
        }
    });


    $(document).ready(function() {
        $("#nurse_note_form").on('submit', function(e) {
            e.preventDefault();
            var nurse_id = $("#nurse_field").val();
            $("#nurse_set").val(nurse_id);
            $("#nurse_notebtn").button('loading');

            var formData = new FormData(this);
            var date = formData.get("date");
            var formattedDate = moment(date, "DD/MM/YYYY").format("YYYY-MM-DD HH:mm:ss") || "";//formatDate(date);
            var note = formData.get("note") || "";
            var comment = formData.get("comment") || "";

            var data = {
                "date": formattedDate || "",
                "ipd_id": $('#ipdid').val(),
                "staff_id": $('#nurse_field').val(),
                "note": note,
                "comment": comment,
                "Hospital_id": <?= $data['hospital_id'] ?>
            };

            var errorMessages = [];
            if (!formattedDate) errorMessages.push('Date is required');
            if (!note) errorMessages.push('Note is required');
            if (!/^[a-zA-Z0-9\s]+$/.test(note)) errorMessages.push(
                'Note must only contain letters and numbers');
            if (!/^[a-zA-Z0-9\s]+$/.test(comment)) errorMessages.push(
                'Comment must only contain letters and numbers');

            if (errorMessages.length > 0) {
                errorMsg(errorMessages.join('<br>'));
                setTimeout(() => {
                    $("#nurse_notebtn").button('reset');
                }, 3000);
                return;
            }

             sendAjaxRequest(
                    `<?= $api_base_url ?>nurse-notes-ipd`,
                    'POST',
                    data,
                    function(response) {
                        handleResponse(response);
                    }
                );
        });

        function formatDate(dateString) {
            if (!dateString) return "";
            var date = new Date(dateString);
            var year = date.getFullYear();
            var month = ('0' + (date.getMonth() + 1)).slice(-2);
            var day = ('0' + date.getDate()).slice(-2);
            var hours = ('0' + date.getHours()).slice(-2);
            var minutes = ('0' + date.getMinutes()).slice(-2);
            var seconds = ('0' + date.getSeconds()).slice(-2);
            return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
        }
    });

    function delete_consultant_row(id) {
        var table = document.getElementById("constableID");
        $("#row" + id).html("");
    }
</script>
<script type="text/javascript">
    function deleteIpdPatient(ipdid) {
        if (confirm('<?php echo $this->lang->line('delete_confirm') ?>')) {

             sendAjaxRequest(
                    '<?= $api_base_url ?>ipd-main-module/' + ipdid + '?hospital_id=<?= $data['hospital_id'] ?>',
                    'DELETE',
                    {ipdid: ipdid},
                    function(response) {
                        handleResponse(response);
                    }
                );
        }
    }

    function printBill(patientid, ipdid) {
        var total_amount = $("#total_amount").val();
        var discount = $("#discount").val();
        var other_charge = $("#other_charge").val();
        var gross_total = $("#gross_total").val();
        var tax = $("#tax").val();
        var net_amount = $("#net_amount").val();
        var status = $("#status").val();
        var base_url = '<?php echo base_url() ?>';
        $.ajax({
            url: base_url + 'admin/payment/getBill/',
            type: 'POST',
            data: {
                patient_id: patientid,
                ipdid: ipdid,
                total_amount: total_amount,
                discount: discount,
                other_charge: other_charge,
                gross_total: gross_total,
                tax: tax,
                net_amount: net_amount,
                status: status
            },
            success: function(result) {
                $("#testdata").html(result);
                popup(result);
            }
        });
    }

    function popup(data, print = false) {
        var base_url = base_url;
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
        frameDoc.document.write('<body>');
        frameDoc.document.write(data);
        frameDoc.document.write('</body>');
        frameDoc.document.write('</html>');
        frameDoc.document.close();
        setTimeout(function() {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
            if (print) {
                window.location.reload(true);
            }
        }, 500);
        return true;
    }

    function holdModal(modalId) {
        $('#' + modalId).modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });
    }

    function delete_record(id, Msg) {
        if (confirm(<?php echo "'" . $this->lang->line('delete_confirm') . "'"; ?>)) {

             sendAjaxRequest(
                    '<?= $api_base_url ?>nurse-notes-ipd/' + id + '?Hospital_id=<?= $data['hospital_id'] ?>',
                    'DELETE',
                    {},
                    function(response) {
                        handleResponse(response);
                    }
                );
        }
    }

    function delete_recordconsulatant(id, Msg) {
        if (confirm("<?php echo $this->lang->line('delete_confirm'); ?>")) {

            sendAjaxRequest(
                    '<?= $api_base_url ?>consultant-register-ipd/' + id +
                                '?Hospital_id=<?= $data['hospital_id'] ?>',
                    'DELETE',
                    {},
                    function(response) {
                        handleResponse(response);
                    }
                );
        }
    }

    function delete_recordcommend(id, Msg) {
        if (confirm("<?php echo $this->lang->line('delete_confirm'); ?>")) {

            sendAjaxRequest(
                    '<?= $api_base_url ?>nurse-notes-ipd/' + id + '?Hospital_id=<?= $data['hospital_id'] ?>',
                    'DELETE',
                    {},
                    function(response) {
                        handleResponse(response);
                    }
                );

        }
    }

    function delete_recordnotecommend(id, Msg) {
        if (confirm("<?php echo $this->lang->line('delete_confirm'); ?>")) {

                sendAjaxRequest(
                    '<?= $api_base_url ?>nurse-notes-ipd/deleteComment/' + id +
                             '?Hospital_id=<?= $data['hospital_id'] ?>',
                    'DELETE',
                    {},
                    function(response) {
                        handleResponse(response);
                    }
                );
        }
    }

    //function delete_record_dosage(id) {
    $(document).on('click', '.delete_record_dosage', function() {

        if (confirm(<?php echo "'" . $this->lang->line('delete_confirm') . "'"; ?>)) {
            var id = $(this).data('recordId');

            sendAjaxRequest(
                    '<?= $api_base_url ?>medication-ipd/' + id +
                             '?Hospital_id=<?= $data['hospital_id'] ?>',
                    'DELETE',
                    { medication_id: id},
                    function(response) {
                        handleResponse(response);
                    }
                );
        }
    });

    function printprescription(id, print_status = false) {
        var base_url = '<?php echo base_url() ?>';
        $.ajax({
            url: base_url + 'admin/prescription/printIPDPrescription/' + id,
            type: 'POST',
            data: {
                prescription_id: id,
                print: 'yes'
            },
            dataType: "json",
            success: function(result) {
                $("#testdata").html(result.page);
                popup(result.page, print_status);
            }
        });
    }

    $(function() {
        $("#compose-textareas,#compose-textareanew").wysihtml5({
            toolbar: {
                "image": false,
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).on('change', '.chgstatus_dropdown', function() {
        $(this).parent('form.chgstatus_form').submit()

    });

    $("form.chgstatus_form").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            dataType: "JSON",
            success: function(data) {
                if (data.status == 0) {
                    var message = "";
                    $.each(data.error, function(index, value) {

                        message += value;
                    });
                    errorMsg(message);
                } else {

                    successMsg(data.message);

                    window.location.reload(true);
                }
            }
        });
    });


    $('#myaddMedicationModal').on('hidden.bs.modal', function() {
        $('#add_medication').find('input:text, input:password, input:file, textarea').val('');
        $('#add_medication').find('select option:selected').removeAttr('selected');
        $('#add_medication').find('input:checkbox, input:radio').removeAttr('checked');
        $('.medicine_category_medication').select2("val", "");;
        $('.medicine_name_medication').select2("val", "");;
        $('.dosage_medication').select2("val", "");;
        $('#mtime').val('12:00 PM');
    });



    $(".addnursenote").click(function() {
        $('#nurse_note_form').trigger("reset");

    });


    $(".adddiagnosis").click(function() {
        $('#form_diagnosis').trigger("reset");
        //$(".dropify-clear").trigger("click");
        $('#add_diagnosis .filestyle').dropify();
    });

    $(".addtimeline").click(function() {
        $('#add_timeline').trigger("reset");
        $(".dropify-clear").trigger("click");
    });

    $(".addpayment").click(function() {
        $('#add_payment').trigger("reset");
        $(".dropify-clear").trigger("click");
    });


    $(".addcharges").click(function() {
        $('#add_charges').trigger("reset");
        $('#select2-charge_category-container').html("");
        $('#select2-code-container').html("");
    });

    $(document).on('click', '.addprescription', function() {
        $.ajax({
            url: base_url + 'admin/prescription/addipdPrescription',
            dataType: 'JSON',
            data: {
                'ipd_id': ipd_id
            },
            type: "POST",
            beforeSend: function() {},
            success: function(res) {
                $('#edit_prescription_title').html(
                    '<?php echo $this->lang->line('add_prescription'); ?>');
                $('.modal-body', "#add_prescription").html(res.page);
                $('.modal-body', "#add_prescription").find('table').find('.select2').select2();
                $('.select2').select2();
                $('.modal-body', "#add_prescription").find('.multiselect2').select2({
                    placeholder: 'Select',
                    allowClear: false,
                    minimumResultsForSearch: 2
                });

                $('#add_prescription').modal('show');
            },
            complete: function() {
                $("#compose-textareasadd,#compose-textareanewadd").wysihtml5({
                    toolbar: {
                        "image": false,
                    }
                });
            },
            error: function(xhr) { // if error occured
                alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");


            }
        });
    });

    function deleteot(id) {
        if (confirm(<?php echo "'" . $this->lang->line('delete_confirm') . "'"; ?>)) {

             sendAjaxRequest(
                    '<?= $api_base_url ?>operation-ipd/deleteOperation/' + id +
                            '?Hospital_id=<?= $data['hospital_id'] ?>',
                    'DELETE',
                    { id: id},
                    function(response) {
                        handleResponse(response);
                    }
                );
        }
    }


    $(document).on('change', '.payment_mode', function() {
        var mode = $(this).val();
        if (mode == "Cheque") {
            $('.cheque_div').css("display", "block");
        } else {
            $('.cheque_div').css("display", "none");
        }
    });
</script>

<script type="text/javascript">
    $(document).on('click', '.edit_charge', function() {
        var edit_charge_id = $(this).data('recordId');
        var createModal = $('#myChargeseditModal');
        var $this = $(this);
        $this.button('loading');
        $.ajax({
            url: base_url + 'admin/patient/getCharge',
            type: "POST",
            data: {
                'id': edit_charge_id
            },
            dataType: 'json',
            beforeSend: function() {
                $this.button('loading');
            },
            success: function(res) {

                $('#editstandard_charge').val(res.result.standard_charge);
                if (res.result.tpa_charge > 0) {
                    $('#editschedule_charge').val(res.result.tpa_charge);
                }

                $('#patient_charge_id').val(res.result.id);
                $('#editqty').val(res.result.qty);
                $('#editapply_charge').val(res.result.apply_charge);
                $('#editfinal_amount').val(res.result.amount);
                $('#editcharge_date').val('');
                if(res.result.charge_date != "" || res.result.charge_date != null){
                    const date = new Date(res.result.charge_date);
                    const day = String(date.getDate()).padStart(2, '0');
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const year = date.getFullYear();

                    var chargedate = `${day}/${month}/${year}`;
                    $('#editcharge_date').val(chargedate);
                }

                $('#editcharge_tax').val(res.result.percentage);
                var tax_charge = (res.result.apply_charge * res.result.percentage) / 100;
                $('#edittax').val(tax_charge.toFixed(2));
                $('#editpatient_charge_id').val(res.result.id);
                $('textarea#enote').val(res.result.note);

                $('#edit_charge_type').select2('val', res.result.charge_type_master_id);
                $('#myChargeseditModal').modal({
                    backdrop: 'static'
                });
                getcharge_category(res.result.charge_type_master_id, res.result.charge_category_id);
                getchargecode(res.result.charge_category_id, res.result.charge_id);

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


    $(document).ready(function() {
        $("#add_charges button[type=submit]").click(function() {
            $("button[type=submit]", $(this).parents("form")).removeAttr("clicked");
            $(this).attr("clicked", "true");
        });
        $("#add_charges").on("submit", function(e) {
            e.preventDefault();

            var $this = $("button[type=submit][clicked=true]");
            var buttonVal = $this.attr("value");
            var formData = $(this).serializeArray();
            formData.push({
                name: "add_type",
                value: buttonVal
            });
            var dataObject = {};
            $.each(formData, function(index, field) {
                dataObject[field.name] = field.value;
            });
            var mappedData = {
                date: formatDate(dataObject["date"]),
                ipd_id: parseInt(dataObject["ipdid"]),
                qty: parseInt(dataObject["qty"]),
                charge_id: parseInt(dataObject["charge_id"]),
                standard_charge: parseFloat(dataObject["standard_charge"]),
                tpa_charge: parseFloat(dataObject["schedule_charge"]) || 0.0,
                tax: parseFloat(dataObject["tax"]),
                apply_charge: parseFloat(dataObject["apply_charge"]),
                amount: parseFloat(dataObject["amount"]),
                note: dataObject["note"] || '',
                Hospital_id: <?= $data["hospital_id"] ?>,
            };
            if (dataObject["add_type"] === "add") {
                errorMessage = [];
                if (!dataObject["charge_id"]) {
                    errorMessage.push("Charge Name is requried");
                }
                if (!dataObject["standard_charge"]) {
                    errorMessage.push("Standard Charge is requried");
                }
                if (!dataObject["date"]) {
                    errorMessage.push("Date is requried");
                }
                if (!dataObject["qty"]) {
                    errorMessage.push("Qty is requried");
                }
                if (errorMessage.length > 0) {
                    errorMsg(errorMessage.join("<br>"));
                    return false;
                }
                $.ajax({
                    url: '<?php echo base_url(); ?>admin/charges/add_ipdcharges',
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    beforeSend: function() {
                        $("#add_chargesbtn").button("loading");
                    },
                    success: function(res) {
                        if (res.status === "fail") {
                            errorMsg(res.error.join(" "));
                        } else if (res.status === "new_charge") {
                            var data = res.data;
                            var row_id = makeid(8);
                            var charge = `
                            <tr id="${row_id}">
                                <td>${data.date}<input type="hidden" name="pre_date[]" value="${data.date}"></td>
                                <td>${data.charge_type_name}</td>
                                <td>${data.charge_category}</td>
                                <td>${data.charge_name}
                                    <input type="hidden" name="pre_tax_percentage[]" value="${data.tax_percentage}">
                                    <input type="hidden" name="pre_charge_id[]" value="${data.charge_id}"><br><h6>${data.note}
                                    <input type="hidden" name="pre_note[]" value="${data.note}"></h6>
                                </td>
                                <td>${data.standard_charge}<input type="hidden" name="pre_standard_charge[]" value="${data.standard_charge}"></td>
                                <td>${data.tpa_charge}<input type="hidden" name="pre_tpa_charges[]" value="${data.tpa_charge}"></td>
                                <td>${data.qty}<input type="hidden" name="pre_qty[]" value="${data.qty}"></td>
                                <td>${data.amount}<input type="hidden" name="pre_total[]" value="${data.amount}"></td>
                                <td>${data.tax}<input type="hidden" name="pre_tax[]" value="${data.tax}">
                                    <input type="hidden" name="pre_apply_charge[]" value="${data.apply_charge}"></td>
                                <td>${data.net_amount}<input type="hidden" name="pre_net_amount[]" value="${data.net_amount}"></td>
                                <td>
                                    <button type="button" class="closebtn delete_row" data-row-id="${row_id}" autocomplete="off">
                                        <i class="fa fa-remove"></i>
                                    </button>
                                </td>
                            </tr>`;
                            $("#preview_charges").append(charge);
                            charge_reset();
                        } else {
                            successMsg(res.message);
                            window.location.reload(true);
                        }
                    },
                    error: function() {
                        errorMsg("An error occurred. Please try again.");
                    },
                    complete: function() {
                        $("#add_chargesbtn").button("reset");
                    },
                });
            } else {
                var allRowsData = [];
                $("#preview_charges tr").each(function() {
                    var row = $(this);
                    var rowData = {
                        date: formatDate(row.find("input[name='pre_date[]']").val()),
                        ipd_id: parseInt(dataObject["ipdid"]),
                        qty: parseInt(row.find("input[name='pre_qty[]']").val()),
                        charge_id: parseInt(row.find("input[name='pre_charge_id[]']").val()),
                        standard_charge: parseFloat(row.find(
                            "input[name='pre_standard_charge[]']").val()),
                        tpa_charge: parseFloat(row.find("input[name='pre_tpa_charges[]']")
                            .val())?.toFixed(2) || "0.00",
                        tax: parseFloat(row.find("input[name='pre_tax_percentage[]']").val()),
                        apply_charge: parseFloat(row.find("input[name='pre_apply_charge[]']")
                            .val()),
                        amount: parseFloat(row.find("input[name='pre_net_amount[]']").val()),
                        note: row.find("input[name='pre_note[]']").val(),
                        Hospital_id: <?= $data["hospital_id"] ?>,
                    };
                    if (rowData.tpa_charge == '0') {
                        rowData.tpa_charge = '0.00';
                    } else if (rowData.tpa_charge == 'NaN') {
                        rowData.tpa_charge = '0.00';
                    }
                    allRowsData.push(rowData);
                });
                if (allRowsData.length === 0) {
                    errorMsg(
                        "No charges have been added. Please add at least one charge before proceeding.");
                    return;
                }

                sendAjaxRequest(
                    "<?= $api_base_url ?>internal-ipd-charges",
                    'POST',
                    allRowsData,
                    function(response) {
                        handleResponse(response);
                    }
                );
            }
        });

        function formatDate(date) {
            // var dateObj = new Date(date);
            var parts = date.split('/');
            var day = parseInt(parts[0], 10);
            var month = parseInt(parts[1], 10) - 1;
            var year = parseInt(parts[2], 10);

            var dateObj = new Date(year, month, day);
            const yyyy = dateObj.getFullYear();
            const mm = String(dateObj.getMonth() + 1).padStart(2, '0');
            const dd = String(dateObj.getDate()).padStart(2, '0');

            return `${yyyy}-${mm}-${dd}`;
        }
        // function formatDate(dateStr) {
        //     if (!dateStr) return "";
        //     try {
        //         var [date, time, period] = dateStr.split(" ");
        //         var [month, day, year] = date.split("/");
        //         var [hours, minutes] = time.split(":");
        //         if (period === "PM" && hours < 12) hours = parseInt(hours) + 12;
        //         if (period === "AM" && hours === "12") hours = 0;
        //         return `${year}-${String(month).padStart(2, "0")}-${String(day).padStart(2, "0")} ${String(hours).padStart(2, "0")}:${String(minutes).padStart(2, "0")}:00`;
        //     } catch (error) {
        //         console.error("Error formatting date:", dateStr, error);
        //         return "";
        //     }
        // }

    });



    $(document).on('click', '.delete_row', function(e) {

        var del_row_id = $(this).data('rowId');
        var del_record_id = $(this).data('recordId');
        var result = confirm("<?php echo $this->lang->line('delete_confirm') ?>");
        if (result) {
            $('#' + del_row_id).remove();
        }
    });

    function makeid(length) {
        var result = '';
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for (var i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() *
                charactersLength));
        }
        return result;
    }

    function charge_reset() {
        $("#charge_category").select2("val", '');
        $("#add_charge_type").select2("val", '');
        $("#charge_id").select2("val", '');
        $("#standard_charge").val('');
        $("#schedule_charge").val('');
        $("#qty").val('');
        $("#charge_date").val('');
        $("#edit_note").val('');
        $("#charge_tax").val('');
        $("#ipd_tax").val('');
        $("#final_amount").val('');
        $("#apply_charge").val('');

    }
</script>
<script type="text/javascript">
    var hidWidth;
    var scrollBarWidths = 20;

    var widthOfList = function() {
        var itemsWidth = 0;
        $('.list li').each(function() {
            var itemWidth = $(this).outerWidth();
            itemsWidth += itemWidth;
        });
        return itemsWidth;
    };

    var widthOfHidden = function() {
        return (($('.wrappernav').outerWidth()) - widthOfList() - getLeftPosi()) - scrollBarWidths;
    };

    var getLeftPosi = function() {
        return $('.list').position().left;
    };

    var reAdjust = function() {
        if (($('.wrappernav').outerWidth()) < widthOfList()) {
            $('.scroller-right').show();
        } else {
            $('.scroller-right').hide();
        }

        if (getLeftPosi() < 0) {
            $('.scroller-left').show();
        } else {
            $('.item').animate({
                left: "-=" + getLeftPosi() + "px"
            }, 'slow');
            $('.scroller-left').hide();
        }
    }

    reAdjust();

    $(window).on('resize', function(e) {
        reAdjust();
    });

    $('.scroller-right').click(function() {

        $('.scroller-left').fadeIn('slow');
        $('.scroller-right').fadeOut('slow');

        $('.list').animate({
            left: "+=" + widthOfHidden() + "px"
        }, 'slow', function() {

        });
    });

    $('.scroller-left').click(function() {

        $('.scroller-right').fadeIn('slow');
        $('.scroller-left').fadeOut('slow');

        $('.list').animate({
            left: "-=" + getLeftPosi() + "px"
        }, 'slow', function() {

        });
    });
</script>
<script type="text/javascript">
    function getDosages(medicine_category_id, selected_dosage = "") {

        var dosage_opt = "<option value=''><?php echo $this->lang->line('select') ?></option>";
        var category_dosage_json = '<?php echo json_encode($category_dosage); ?>';
        var category_dosage_array = JSON.parse(category_dosage_json);

        if (category_dosage_array[medicine_category_id]) {
            $.each(category_dosage_array[medicine_category_id], function(key, item) {
                var sel = "";
                if (selected_dosage == item.id) {
                    sel = "selected";
                }

                dosage_opt += "<option value='" + item.id + "' " + sel + ">" + item.dosage + "" + item.unit +
                    "</option>";
            });

        }
        return dosage_opt;
    }
</script>
<script type="text/javascript">
    $(function() {
        $(".timepicker").timepicker({
            defaultTime: '12:00 PM'
        });
    });

    $(document).on('click', '.print_trans', function() {
        var $this = $(this);
        var record_id = $this.data('recordId')
        $this.button('loading');
        $.ajax({
            url: '<?php echo base_url(); ?>admin/transaction/printTransaction',
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
    $(document).on('change', '.death_status', function() {
        var status = $(this).val();
        if (status == "1") {
            $('.filestyle', '#addPaymentModal').dropify();
            $('.filestyle', '#add_refund').dropify();
            $('.death_status_div').css("display", "block");
            $('.reffer_div').css("display", "none");
        } else if (status == "2") {
            $('.reffer_div').css("display", "block");
            $('.death_status_div').css("display", "none");
        } else {
            $('.reffer_div').css("display", "none");
            $('.death_status_div').css("display", "none");
        }
    });

    $(document).on('click', '.patient_discharge', function() {


        var case_reference_id = "<?php echo $case_reference_id; ?>";
        var payment_modal = $('#patient_discharge');
        payment_modal.addClass('modal_loading');
        payment_modal.modal('show');
        $.ajax({
            url: base_url + 'admin/bill/patient_discharge/' + case_reference_id,
            type: "POST",
            data: {
                'module_type': 'ipd'
            },
            dataType: 'json',
            beforeSend: function() {},
            success: function(data) {


                $('.modal-body', payment_modal).html(data.page);
                $('.filestyle', '#patient_discharge').dropify();
                $('.date', '#patient_discharge').trigger("change");
                payment_modal.removeClass('modal_loading');
            },

            error: function(xhr) { // if error occured
                alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");


            },
            complete: function() {
                payment_modal.removeClass('modal_loading');

            }
        });

    });







    $(document).on('click', '.print_dischargecard', function() {
        var $this = $(this);
        var record_id = $this.data('recordId');
        var case_id = $this.data('case_id');
        $this.button('loading');
        $.ajax({
            url: '<?php echo base_url(); ?>admin/bill/print_dischargecard',
            type: "POST",
            data: {
                'id': record_id,
                'case_id': case_id,
                'module_type': 'ipd'
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

    function viewdetail(ot_id) {
        $('#view_ot_modal').modal('show');
        $.ajax({
            url: '<?php echo base_url(); ?>admin/operationtheatre/otdetails',
            type: "POST",
            data: {
                ot_id: ot_id
            },
            dataType: 'json',
            success: function(data) {
                $('#view_ot_modal').modal('show');
                $('#show_ot_data').html(data.page);
                $('#action_detail_modal').html(data.actions);
            },
        });
    }

    $(document).ready(function(e) {
        $('#view_ot_modal,#viewDetailReportModal').modal({
            backdrop: 'static',
            keyboard: false,
            show: false
        });
    });
</script>
<script>
    function getcategory(id, operation = null) {
        var div_data = "";
        $('#operation_name').html("<option value='l'><?php echo $this->lang->line('loading') ?></option>");
        $.ajax({
            url: '<?php echo base_url(); ?>admin/operationtheatre/getoperationbycategory',
            type: "POST",
            data: {
                id: id
            },
            dataType: 'json',
            async: false,
            success: function(res) {
                $.each(res, function(i, obj) {
                    var sel = "";
                    if ((operation != '') && (operation == obj.id)) {
                        sel = "selected";
                    }
                    div_data += "<option value=" + obj.id + " " + sel + ">" + obj.operation +
                        "</option>";
                });
                $("#operation_name").html("<option value=''>Select</option>");
                $('#operation_name').append(div_data);
                $("#operation_name").select2().select2('val', operation);

                if (operation != "") {
                    $("#eoperation_name").html("<option value=''>Select</option>");
                    $('#eoperation_name').append(div_data);
                    $("#eoperation_name").select2().select2('val', operation);
                }
            }
        });
    }
</script>
<script>
    $(document).on('change', '.findingtype', function() {

        $this = $(this);
        var section_ul = $(this).closest('div.row').find('ul.section_ul');
        var finding_id = $(this).val();
        div_data = "";
        $.ajax({
            type: 'POST',
            url: base_url + 'admin/patient/findingbycategory',
            data: {
                'finding_id': finding_id
            },
            dataType: 'JSON',
            beforeSend: function() {
                // setting a timeout
                $('ul.section_ul').find('li:not(:first-child)').remove();
            },
            success: function(data) {
                section_ul.append(data.record);

            },
            error: function(xhr) { // if error occured
                alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");

            },
            complete: function() {

            }
        });
    });

    $(document).on('change', '.findinghead', function() {
        $this = $(this);
        var head_id = $(this).val();
        div_data = "";
        $.ajax({
            type: 'POST',
            url: base_url + 'admin/patient/getfinding',
            data: {
                'head_id': head_id
            },

            success: function(res) {
                $("#finding_description").val(res);
            },
        });
    });
</script>
<!-- //========datatable end===== -->

<script>
    $(document).on('click', '.view_report', function() {
        var id = $(this).data('recordId');
        var lab = $(this).data('typeId');
        getinvestigationparameter(id, $(this), lab);
    });

    function getinvestigationparameter(id, btn_obj, lab) {
        var modal_view = $('#viewDetailReportModal');
        var $this = btn_obj;
        $.ajax({
            url: base_url + 'admin/patient/getinvestigationparameter',
            type: "POST",
            data: {
                'id': id,
                'lab': lab
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
</script>
<script type="text/javascript">
    $(document).on('click', '.print_bill', function() {
        var id = $(this).data('recordId');

        var $this = $(this);
        var lab = $(this).data('typeId');
        $.ajax({
            url: base_url + 'admin/patient/printpathoparameter',
            type: "POST",
            data: {
                'id': id,
                'lab': lab
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
</script>
<!-- //========datatable start===== -->
<script type="text/javascript">
    (function($) {
        var id = "<?php echo $patient_id; ?>";

        'use strict';
        $(document).ready(function() {
            initDatatable('treatmentlist', 'admin/patient/getipdtreatmenthistory/' + id);
        });
    }(jQuery))
</script>

<script src="<?php echo base_url() ?>backend/js/Chart.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust()
                .responsive.recalc();
        });

    });
    $(document).ready(function(e) {
        $(document).on('click', '.delete-charge', function(e) {
            e.preventDefault();
            let recordId = $(this).data('record-id');

            if (confirm('<?php echo $this->lang->line("delete_confirm") ?>')) {

                 sendAjaxRequest(
                    '<?= $api_base_url ?>internal-ipd-charges/' + recordId +
                             '?Hospital_id=<?= $data['hospital_id'] ?>',
                    'DELETE',
                    {},
                    function(response) {
                        handleResponse(response);
                    }
                );
            }
        });

        $("#edit_charges").on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            var dataObject = {};
            formData.forEach(function(value, key) {
                dataObject[key] = value;
            });
            // let date = new Date(dataObject.date);
            
            let formattedDate = moment(dataObject.date, "DD/MM/YYYY").format("YYYY-MM-DD HH:mm:ss") || "";
            // date.getFullYear() + "-" +
            //     ("0" + (date.getMonth() + 1)).slice(-2) + "-" +
            //     ("0" + date.getDate()).slice(-2) + " " +
            //     ("0" + date.getHours()).slice(-2) + ":" +
            //     ("0" + date.getMinutes()).slice(-2) + ":" +
            //     ("0" + date.getSeconds()).slice(-2);
            var formattedData = {
                "date": formattedDate,
                "qty": parseInt(dataObject.qty),
                "standard_charge": parseFloat(dataObject.standard_charge),
                "tpa_charge": 0.00,
                "tax": parseFloat(dataObject.tax),
                "apply_charge": parseFloat(dataObject.apply_charge),
                "amount": parseFloat(dataObject.amount),
                "note": dataObject.note || "nonee",
                "Hospital_id": <?= $data['hospital_id'] ?>
            };

            sendAjaxRequest(
                        '<?= $api_base_url ?>internal-ipd-charges/' + dataObject.patient_charge_id,
                        'PATCH',
                        formattedData,
                        function(response) {
                            handleResponse(response);
                        }
                );

    });

    function formatDate(date) {
            // var dateObj = new Date(date);
            var parts = date.split('/');
            var day = parseInt(parts[0], 10);
            var month = parseInt(parts[1], 10) - 1;
            var year = parseInt(parts[2], 10);

            var dateObj = new Date(year, month, day);
            const yyyy = dateObj.getFullYear();
            const mm = String(dateObj.getMonth() + 1).padStart(2, '0');
            const dd = String(dateObj.getDate()).padStart(2, '0');

            return `${yyyy}-${mm}-${dd}`;
        }

    $('.close_button').click(function() {
        $("#nurse_field").select2().select2('val', '');
        $("#doctor_field").select2().select2('val', '');
    })

    });
</script>
<script type="text/javascript">
    function discharge_revert(case_id) {
        $('#discharge_revert').modal('show');
        var base_url = '<?php echo base_url() ?>';
        $.ajax({
            type: 'POST',
            url: base_url + 'admin/bill/discharge_revert',
            data: {
                'module_type': 'ipd',
                'case_id': case_id
            },
            dataType: 'json',

            success: function(res) {
                if (res.status == 'success') {
                    $('#bed_group_id').val(res.data.bed_group_id);
                    $('#opd_details_id').val(res.data.opd_details_id);
                    getBed(res.data.bed_group_id, res.data.bed, 'yes');
                } else {
                    errorMsg(res.message);
                }
            },
        });
    }

    $("#form_discharge_revert").on('submit', (function(e) {
        e.preventDefault();

        $.ajax({
            url: base_url + 'admin/bill/discharged_bed_revert',
            type: "POST",
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,

            beforeSend: function() {
                $("#submit_discharge_revert").button("loading");
            },
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
                $("#submit_discharge_revert").button("reset");
            },
            error: function() {
                $("#submit_discharge_revert").button('reset');
            },

            complete: function() {
                $("#submit_discharge_revert").button('reset');
            }
        });
    }));

    $('.close_btn').click(function() {
        $('#comment_staff').val('');
    })

    function deletePayment(id) {
        if (confirm(<?php echo "'" . $this->lang->line('delete_confirm') . "'"; ?>)) {

            sendAjaxRequest(
                    '<?= $api_base_url ?>internal-ipd-payment/' + id + '?hos_id=<?= $data['hospital_id'] ?>',
                    'DELETE',
                    {},
                    function(response) {
                        handleResponse(response);
                    }
                );

            // $.ajax({
            //     url: '<?= $api_base_url ?>internal-ipd-payment/' + id + '?hos_id=<?= $data['hospital_id'] ?>',
            //     type: 'DELETE',
            //     success: function(res) {
            //         successMsg(<?php echo "'" . $this->lang->line('delete_message') . "'"; ?>);
            //         window.location.reload(true);
            //     }
            // })
        }
    }
</script>
<script type="text/javascript">
    Chart.types.Doughnut.extend({
        name: "DoughnutTextInside",
        showTooltip: function() {
            this.chart.ctx.save();
            Chart.types.Doughnut.prototype.showTooltip.apply(this, arguments);
            this.chart.ctx.restore();
        },
        draw: function() {
            Chart.types.Doughnut.prototype.draw.apply(this, arguments);

            var width = this.chart.width,
                height = this.chart.height;

            var fontSize = (height / 190).toFixed(2);
            this.chart.ctx.font = fontSize + "em Verdana";
            this.chart.ctx.textBaseline = "middle";

            var text = "<?php echo $donut_graph_percentage; ?>%",
                textX = Math.round((width - this.chart.ctx.measureText(text).width) / 2),
                textY = height / 2;

            this.chart.ctx.fillText(text, textX, textY);
        }
    });

    var data = [{
        lebel: 'complete',
        value: <?php echo round($used_credit_limit); ?>,
        color: "#f40000"
    }, {
        value: <?php echo round($balance_credit_limit); ?>,
        color: "#4CAF50"
    }];

    var DoughnutTextInsideChart = new Chart($('#pieChart')[0].getContext('2d')).DoughnutTextInside(data, {
        responsive: true
    });
</script>

<script>
    $(document).on('click', '.editpayment', function() {
        var $this = $(this);
        var record_id = $this.data('recordId');
        var amount = $this.data('paymentAmount');
        $("#edit_payment").val(amount);
        $("#edit_payment_id").val(record_id);
        $.ajax({
            url: '<?php echo base_url(); ?>admin/patient/getopdpaymentdetails',
            type: 'post',
            data: {
                'payment_id': record_id
            },
            dataType: 'json',
            success: function(data) {
                $("#payment_mode").val(data.payment_mode).prop('selected');

                $(".payment_mode").trigger('change');
                $("#edit_cheque_no").val(data.cheque_no);
                $("#edit_cheque_date").val(data.cheque_date);
                $("#payment_date").val(data.payment_date);
                $("#edit_payment_note").val(data.note);
            }
        });

        $('#editpayment_modal').modal('show');
        //$this.button('loading');

    });
</script>
<script>
    $(document).ready(function(e) {
        $("#editpaymentform").on('submit', function(e) {
            e.preventDefault();
            $("#editpaymentbtn").button('loading');

            var formData = new FormData(this);
            var dataObject = {};
            formData.forEach(function(value, key) {
                dataObject[key] = value;
            });

            var transformedData = {
                payment_date: formatDate(dataObject["payment_date"]),
                amount: dataObject["amount"] ? parseFloat(dataObject["amount"]) : 0,
                payment_mode: dataObject["payment_mode"] || "",
                note: dataObject["note"] || "",
                Hospital_id: <?= $data['hospital_id'] ?>,
                received_by_name:'<?=$data['username'] ?>',
            };

            console.log(JSON.stringify(transformedData, null, 2));

            let edit_payment_id = $('#edit_payment_id').val();

             sendAjaxRequest(
                    '<?= $api_base_url ?>internal-ipd-payment/' + edit_payment_id,
                    'PATCH',
                    transformedData,
                    function(response) {
                        handleResponse(response);
                    }
                );

            // $.ajax({
            //     url: '<?= $api_base_url ?>internal-ipd-payment/' + edit_payment_id,
            //     type: "PATCH",
            //     data: JSON.stringify(transformedData),
            //     dataType: 'json',
            //     contentType: 'application/json',
            //     cache: false,
            //     processData: false,
            //     beforeSend: function() {
            //         $("#editpaymentbtn").button('loading');
            //     },
            //     success: function(data) {
            //         successMsg(data[0]["data"].message || 'successfully');
            //         location.reload();
            //     },
            //     error: function() {
            //         $("#editpaymentbtn").button('reset');
            //         errorMsg("An error occurred. Please try again.");
            //     },
            //     complete: function() {
            //         $("#editpaymentbtn").button('reset');
            //     }
            // });
        });

        function formatDate(dateStr) {
            var date = new Date(dateStr);
            return date.toISOString().slice(0, 19).replace('T', ' ');
        }
    });
</script>
<script>
    function printAppointment(id) {
        $('#myModal').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');
            $("#global_shift").select2().select2("val", '');
        });
        $.ajax({
            url: base_url + 'admin/appointment/printAppointmentBill',
            type: "POST",
            data: {
                'appointment_id': id
            },
            dataType: 'json',
            success: function(data) {
                popup(data.page);
            },
            error: function(xhr) {
                alert("<?php echo $this->lang->line('error_occurred_please_try_again'); ?>");
            }
        });
    }
</script>
<script>
    const initialDataCharged = <?= json_encode($ipdcharges['data']) ?>;
    const totalRecordsCharged = <?= $ipdcharges['recordsFiltered'] ?>;
    let isFirstLoadCharged = true;
    $(document).ready(function() {

        const patientid = <?= $patient_id_api ?>;
        const ipd_id = '<?= $ipdid ?>';

        initSummaryDataTable(
            '',
            '',
            '#ipdcharged',
            '',
            'renderChargedTable',
            `${baseurl}admin/patient/ipdchargedlist?ipd_id=${ipd_id}&patientid=${patientid}`
        );
        
    });

    function renderChargedTable(dataArray) {
        let count = 0;
        let totalampuntpaid = 0;
        let rows = (dataArray || []).map(item => {
            let date = formatDateCharged(item.date);
            let ChargeName = item.ChargeName;
            let ChargeType = item.ChargeType;
            let ChargeCategory = item.ChargeCategory;
            let qty = item.qty;
            let standard_charge = item.standard_charge;
            let tpa_charge = item.tpa_charge;
            let tax1 = item.tax1;
            let apply_charge = item.apply_charge;
            let amount = parseFloat(item.amount) || 0;
            let recordid = item.id;
            totalampuntpaid += amount;
            const isPaid = (item.payment_status || "").toUpperCase() === "PAID";
             const disableAction = isPaid;
            let action = `
            <a href="javascript:void(0);" class="btn btn-default btn-xs print_charge" data-toggle="tooltip" title="Print" data-record-id="${recordid}" data-loading-text="Please Wait..">
                <i class="fa fa-print"></i>
            </a>
            <a href="javascript:void(0);" class="btn btn-default btn-xs edit_charge ${disableAction ? 'no-drop disabled' : ''}" data-loading-text="Please Wait.." data-toggle="tooltip" data-record-id="${recordid}" title="Edit">
                <i class="fa fa-pencil"></i> 
            </a>
            <a href="javascript:void(0);" data-record-id="${recordid}" class="btn btn-default btn-xs delete-charge ${disableAction ? 'no-drop disabled' : ''}" data-toggle="tooltip" title="Delete">
                <i class="fa fa-trash"></i>
            </a>
        `;
            return [
                ++count,
                date,
                ChargeName,
                ChargeType,
                ChargeCategory,
                qty,
                parseFloat(standard_charge).toFixed(2),
                parseFloat(tpa_charge).toFixed(2),
                tax1,
                parseFloat(apply_charge).toFixed(2),
                parseFloat(amount).toFixed(2),
                item.payment_status.toUpperCase(),
                action,
            ];
        });
        rows.push([
            "", "", "", "", "", "", "", "", "", "<strong>Total</strong>", `<strong>${totalampuntpaid.toFixed(2)}</strong>`, "",""
        ]);

        return rows;
    }


    function formatDateCharged(dateStr) {
        const date = new Date(dateStr);
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        return `${day}/${month}/${year}`;
    }
</script>
<script>
    const initialDataPayment = <?= json_encode($paymentdoneapi['data']) ?>;
    const totalRecordsPayment = <?= $paymentdoneapi['recordsFiltered'] ?>;
    let isFirstLoadPayment = true;
    $(document).ready(function() {

        const patientid = <?= $patient_id_api ?>;
        const ipd_id = '<?= $ipdid ?>';
        initSummaryDataTable(
            '',
            '',
            '#ipdpayment',
            '',
            'renderPaymentTable',
            `${baseurl}admin/patient/ipdpaymentlist?ipd_id=${ipd_id}&patientid=${patientid}`
        );
    });

    function renderPaymentTable(dataArray) {
        let count = 0;
        return (dataArray || []).map(item => {
            let transaction_id = item.transaction_ID;
            let payment_date = formatDatePayment(item.payment_date);
            let note = item.note || "-";
            let payment_mode = item.payment_mode;
            let amount = item.amount;
            let recordid = item.id;
            return [
                ++count,
                transaction_id,
                payment_date,
                note,
                payment_mode,
                parseFloat(amount).toFixed(2)
            
            ];
        });
    }

    function formatDatePayment(dateStr) {
        const date = new Date(dateStr);
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        return `${day}/${month}/${year}`;
    }
</script>
<script>
    const initialDataDoctors = <?= json_encode($doctordetails['data']) ?>;
    const totalRecordsDoctors = <?= $doctordetails['recordsFiltered'] ?>;
    let isFirstLoadDoctors = true;

    $(document).ready(function() {
        const ipd_id = '<?= $ipdid ?>';
        initSummaryDataTable(
            '',
            '',
            '#ipddoctorslist',
            '',
            'renderDoctorTable',
            `${baseurl}admin/patient/ipddoctorslist?ipd_id=${ipd_id}`
        );
    });

    function renderDoctorTable(dataArray) {
        let count = 0;
        return (dataArray || []).map(item => {
            let appliedDate = formatDateDoctor(item.AppliedDate);
            let consultantDoctor = item.ConsultantDoctor || "-";
            let instruction = item.Instruction || "-";
            let instructionDate = formatDateDoctor(item.InstructionDate);
            let action = '';
            if (item.discharged === "yes") {
                action = `<a onclick="editConsultantRegister(${item.id})" class="btn btn-default btn-xs" data-toggle="tooltip" title="<?= $this->lang->line('edit'); ?>">
                <i class="fa fa-pencil"></i>
              </a>`;
                action += `<a class="btn btn-default btn-xs" data-toggle="tooltip" onclick="delete_recordconsulatant('${item.id}', '<?= $this->lang->line('delete_message'); ?>')" title="<?= $this->lang->line('delete'); ?>">
                 <i class="fa fa-trash"></i>
               </a>`;
            } 
            let dynamicFields = [];
            
            <?php if (is_array($fields_consultant) || is_object($fields_consultant)) {
                foreach ($fields_consultant as $fields_key => $fields_value) { ?>
                    dynamicFields.push('');
            <?php }
            } ?>

            return [
                ++count,
                appliedDate,
                consultantDoctor,
                instruction,
                instructionDate,
                ...dynamicFields,
                action
            ];
        });
    }

    function formatDateDoctor(dateStr) {
        if (!dateStr) return "-";
        const date = new Date(dateStr);
        if (isNaN(date.getTime())) return "-";
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        return `${day}/${month}/${year}`;
    }
</script>





<!-- //========datatable end===== -->