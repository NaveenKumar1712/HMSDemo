<link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/css/sh-print.css">
<?php
if ($transaction->opd_id != "") {
    $patient_name = $transaction->opd_patient_name;
    $patient_id = $transaction->opd_patient_id;
} else {
    $patient_name = $transaction->ipd_patient_name;
    $patient_id = $transaction->ipd_patient_id;
}
?>
<?php
$currency_symbol = $this->customlib->getHospitalCurrencyFormat();
?>
<div class="print-area">
    <div class="row">
        <div class="col-12">
            <?php if (!empty($print_details[0]['print_header'])) { ?>
                <div class="pprinta4">
                    <?php
                    $logo_image = base_url() . "uploads/staff_images/no_image.png";
                    if (!empty($print_details[0]['print_header'])) {
                        $userdata = $this->session->userdata('hospitaladmin');
                        $accessToken = $userdata['accessToken'] ?? '';
                        $url = "https://phr-api.plenome.com/file_upload/getDocs";
                        $payload = json_encode(['value' => $print_details[0]['print_header']]);
                        $client = curl_init($url);
                        curl_setopt_array($client, [
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_POST => true,
                            CURLOPT_POSTFIELDS => $payload,
                            CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Authorization: ' . $accessToken],
                        ]);
                        $response = curl_exec($client);
                        curl_close($client);
                        if ($response && strpos($response, '"NoSuchKey"') === false) {
                            $logo_image = "data:image/png;base64," . trim($response);
                        } elseif (!empty($print_details[0]['print_header'])) {
                            $logo_image = base_url() . $print_details[0]['print_header'];
                        }
                    }
                    ?>
                    <img src="<?= $logo_image ?>" class="img-responsive" style="height:100px; width: 100%;">
                </div>
            <?php } ?>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><?php echo $this->lang->line('patient'); ?>: <?php echo composePatientName($patient_name, $patient_id); ?></p>
                            <p><?php echo $this->lang->line('case_id'); ?>: <?php echo $transaction->case_reference_id; ?></p>
                        </div>
                        <div class="col-md-6 text-right">
                            <p><span class="text-muted"><?php echo $this->lang->line('transaction_id'); ?>: </span> <?php echo $this->customlib->getSessionPrefixByType('transaction_id') . $transaction->id; ?></p>
                            <p><span class="text-muted"><?php echo $this->lang->line('date'); ?>: </span> <?php echo date('d/m/Y', strtotime($transaction->payment_date)); ?>
                            </p>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="print-table">
                                <thead>
                                    <tr class="line">
                                        <td><strong>#</strong></td>
                                        <td><strong><?php echo $this->lang->line('description'); ?></strong></td>
                                        <td class="text-right"><strong><?php echo $this->lang->line('amount'); ?> (<?php echo $currency_symbol; ?>)</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td><strong><?php if ($transaction->type == 'payment') {
                                                        echo $this->lang->line('payment_received');
                                                    } else {
                                                        echo $this->lang->line('payment_refund');
                                                    } ?></strong><br>
                                            <?php

                                            echo $this->lang->line("by") . ": " . $this->lang->line(strtolower($transaction->payment_mode));
                                            if ($transaction->note != '') {
                                                echo "<br/>" . $this->lang->line('note') . ": " . $transaction->note;
                                            }
                                            if ($transaction->payment_mode == "Cheque") {
                                                echo " <br>" . $this->lang->line('cheque_no') . ": " . $transaction->cheque_no;
                                            }
                                            if ($transaction->payment_mode == "Cheque") {
                                                echo "<br>" . $this->lang->line('cheque_date') . ": ";
                                                echo $this->customlib->YYYYMMDDTodateFormat($transaction->cheque_date);
                                            }
                                            ?></td>
                                        <td class="text-right"><?php echo $transaction->amount ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="1"><?php  ?></td>
                                        <td class="text-right"><strong><?php echo $this->lang->line('total'); ?></strong></td>
                                        <td class="text-right"><strong><?php echo $currency_symbol . $transaction->amount ?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear">
                <p>
                    <?php
                    if (!empty($print_details[0]['print_footer'])) {
                        echo $print_details[0]['print_footer'];
                    }
                    ?>
                </p>
            </div>
        </div>
    </div>
</div>