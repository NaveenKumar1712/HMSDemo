<?php
$currency_symbol = $this->customlib->getHospitalCurrencyFormat();
?>
<style type="text/css">
    .printablea4{width: 100%;}
    .printablea4>tbody>tr>th,
    .printablea4>tbody>tr>td{padding:2px 0; line-height: 1.42857143;vertical-align: top; font-size: 12px;}
</style>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo $this->lang->line('bill'); ?></title>
    </head>
    <div id="html-2-pdfwrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="">
                    <div class="pprinta4">
                        <?php if (!empty($print_details[0]['print_header'])) { ?>
                            <img style="height:100px" class="img-responsive" src="<?php echo base_url() . $print_details[0]["print_header"].img_time() ?>">
                        <?php } ?>
                        <div style="height: 10px; clear: both;"></div>
                    </div>
                    <table width="100%" class="printablea4">
                        <tr>
                            <td align="text-left"><h5><?php echo $this->lang->line('bill') . " #" ?><?php echo $result["opdid"] ?></h5></td>
                            <td align="right"><h5><?php echo $this->lang->line('date') . " : " ?><?php if (!empty($result['date'])) { echo date($this->customlib->getHospitalDateFormat(true, true), strtotime($result['date'])); } ?></h5></td>
                        </tr>
                    </table>
                    <hr style="height: 1px; clear: both;margin-bottom: 10px; margin-top: 10px">
                    <table class="printablea4" cellspacing="0" width="100%">
                        <tr>
                            <th width="25%"><?php echo $this->lang->line('name'); ?></th>
                            <td width="25%"><?php echo $result["patient_name"]; ?></td>
                            <th width="25%"><?php echo $this->lang->line('doctor'); ?></th>
                            <td width="25%" align="right"><?php echo $result["name"] . " " . $result["surname"]; ?></td>
                        </tr>
                        <tr>
                            <th><?php echo $this->lang->line('opd') . " " . $this->lang->line('no'); ?></th>
                            <td><?php echo $this->customlib->getPatientSessionPrefixByType('opd_no').$result["opdid"]; ?></td>
                            <th><?php echo $this->lang->line('organisation'); ?></th>
                            <td align="right"><?php echo $result['organisation_name']; ?></td>
                        </tr>
                    </table>
                    <hr style="height: 1px; clear: both;margin-bottom: 10px; margin-top: 10px">
                    <table class="printablea4" width="100%">
                        <tr>
                            <th width="25%" ><?php echo $this->lang->line('charges') . ' (' . $currency_symbol . ')'; ?> </th>
                            <th width="25%" ><?php echo $this->lang->line('category'); ?></th>
                            <th width="25%"><?php echo $this->lang->line('date'); ?></th>
                            <th width="25%" class="pttright reborder text-right"><?php echo $this->lang->line('amount') . ' (' . $currency_symbol . ')'; ?> </th>
                        </tr>
                        <?php
                        $j     = 0;
                        $total = 0;
                        foreach ($charges as $key => $charge) {
                        ?>
                            <tr>
                                <td><?php echo $charge["charge_type"]; ?></td>
                                <td><?php echo $charge["charge_category"]; ?></td>
                                <td><?php echo date("m/d/Y", strtotime($charge["created_at"])); ?></td>
                                <td align="right"><?php echo $charge["apply_charge"]; ?></td>
                            </tr>
                        <?php
                        $total += $charge["apply_charge"];
                        }
                        ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td align="right"><?php echo $this->lang->line('total') . " : " ?>  <?php echo $currency_symbol . $total ?></td>
                        </tr>
                    </table>
                    <hr style="height: 1px; clear: both;margin-bottom: 10px; margin-top: 10px">
                    <table class="printablea4" width="100%">
                        <tr>
                            <th width="25%" class=""><?php echo $this->lang->line('payment') . " " . $this->lang->line('mode'); ?></th>
                            <th width="25%" class=""><?php echo $this->lang->line('payment') . " " . $this->lang->line('date'); ?></th>
                            <th width="50%" align="right" style="text-align: right;"><?php echo $this->lang->line('paid') . " " . $this->lang->line('amount') . ' (' . $currency_symbol . ')'; ?></th>
                        </tr>
                        <?php
                        $k          = 0;
                        $total_paid = 0;
                        if ($result['status'] != 'paid') {
                            $status = $this->lang->line('unpaid');
                        } else {
                            $status = $this->lang->line('paid');
                        }
                        foreach ($payment_details as $key => $payment) {
                        ?>
                            <tr>
                                <td width="25%"><?php echo $payment["payment_mode"]; ?></td>
                                <td width="25%"><?php echo date($this->customlib->getHospitalDateFormat(), $this->customlib->dateyyyymmddTodateformat($payment['date'])); ?></td>
                                <td width="50%" align="right"><?php echo $payment["paid_amount"]; ?></td>
                            </tr>
                        <?php
                        $total_paid += $payment["paid_amount"];
                        }
                        ?>
                        <tr>
                            <td  width="25%"></td>
                            <td  width="25%"></td>
                            <td  width="50%" align="right"><?php echo $this->lang->line('total') . " : " ?> <?php echo $currency_symbol . $total_paid ?></td>
                        </tr>
                    </table>
                    <hr style="height: 1px; clear: both;margin-bottom: 10px; margin-top: 10px">
                    <table class="printablea4" width="100%">
                        <tr>
                            <th width="20%"><?php echo $this->lang->line('total') . " " . $this->lang->line('charges') . " (" . $currency_symbol . ")" ?> </th>
                            <td align="right"><?php echo $total; ?></td>
                        </tr>
                        <tr>
                            <th width="20%"><?php echo $this->lang->line('total') . " " . $this->lang->line('payment') . " (" . $currency_symbol . ")" ?> </th>
                            <td align="right" width=""><?php echo empty($result['paid_amount']) ? $paid_amount : $result['paid_amount']; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <hr style="height: 1px; clear: both;margin-bottom: 10px; margin-top: 10px">
                            </td>
                        </tr>
                        <tr>
                            <th width="20%"><?php echo $this->lang->line('gross') . " " . $this->lang->line('total') . " (" . $currency_symbol . ")" ?> </th>
                            <td align="right" width=""><?php echo empty($result['gross_total']) ? $total - $paid_amount : $result['gross_total']; ?></td>
                        </tr>
                        <tr>
                            <th width="20%"><?php echo $this->lang->line('discount') . " (" . $currency_symbol . ")"; ?></th>
                            <td align="right"><?php echo !empty($result["discount"]) || $result["discount"] == 0 ? $result["discount"] : $discount; ?></td>
                        </tr>
                        <tr>
                            <th width="30%"><?php echo $this->lang->line('any_other_charges') . " (" . $currency_symbol . ")"; ?></th>
                            <td align="right"><?php echo !empty($result["other_charge"]) || $result["other_charge"] == 0 ? $result["other_charge"] : $other_charge; ?></td>
                        </tr>
                        <tr>
                            <th width="20%"><?php echo $this->lang->line('tax') . " (" . $currency_symbol . ")" ?></th>
                            <td align="right"><?php echo !empty($result['tax']) || $result["tax"] == 0 ? $result['tax'] : $tax; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <hr style="height: 1px; clear: both;margin-bottom: 10px; margin-top: 10px">
                            </td>
                        </tr>
                        <tr>
                            <th width="50%"><?php echo $this->lang->line('net_payable') . " " . $this->lang->line('amount') . " (" . $status . ")" ?></th>
                            <td align="right"><?php echo empty($result['net_amount']) ? $total - $paid_amount : $result['net_amount']; ?></td>
                        </tr>
                    </table>
                    <hr style="height: 1px; clear: both;margin-bottom: 10px; margin-top: 10px">
                    <?php if (!empty($print_details[0]['print_footer'])) { ?>
                        <p class="ptt10"><?php echo $print_details[0]['print_footer']; ?></p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</html>
